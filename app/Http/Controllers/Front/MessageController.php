<?php

namespace App\Http\Controllers\Front;

use App\Events\StoreMessageEvent;
use App\Events\StoreMessageStatusEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Message\StoreRequest;
use App\Http\Resources\Front\Chat\Message\MessageResource;
use App\Models\Message;
use App\Models\MessageStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function store(StoreRequest $request)

    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $message = Message::create([
                'user_id' => auth()->user()->id,
                'target_id' => 1,
                'target_type' => 2,
                'text' => $data['text'],
//                'read' => 1,
                'chat_id' => $data['chat_id'],
            ]);

            foreach ($data['user_ids'] as $user_id) {
                MessageStatus::create([
                    'chat_id' => $data['chat_id'],
                    'message_id' => $message->id,
                    'user_id' => $user_id,
                ]);

                $count = MessageStatus::where('chat_id', $data['chat_id'])
                    ->where('user_id', $user_id)
                    ->where('is_read', false)
                    ->count();

                broadcast(new StoreMessageStatusEvent($count, $data['chat_id'], $user_id, $message));

            }

//            StoreMessageStatusJob::dispatch($data, $message)->onQueue('store_messages');  // очереди не подключены, хотя StoreMessageStatusJob создан

            broadcast(new StoreMessageEvent($message))->toOthers();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Error in message store method: '.$exception->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }

        return MessageResource::make($message)->resolve();
    }


}
