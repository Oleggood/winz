<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Chat\StoreRequest;
use App\Http\Resources\Front\Chat\ChatResource;
use App\Http\Resources\Front\Chat\Message\MessageResource;
use App\Http\Resources\Front\Chat\User\UserResource;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        $users = UserResource::collection($users)->resolve();

        $chats = auth()->user()
            ->chats()
            ->has('messages')
            ->with(['lastMessage', 'chatWith'])
            ->withCount('unreadMessageStatuses')
            ->get();

        $chats = ChatResource::collection($chats)->resolve();

        return Inertia::render('Front/Chat/Index', [
            'users' => $users,
            'chats' => $chats,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $userIds = array_merge($data['users'], [auth()->id()]);
        sort($userIds);
        $userIdsString = implode('-', $userIds);

        try {
            DB::beginTransaction();

            $chat = Chat::firstOrCreate([
                'users' => $userIdsString
            ], [
                'title' => $data['title']
            ]);
            $chat->users()->sync($userIds);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Error in chat store method: '.$exception->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }

//        $chat = ChatResource::make($chat)->resolve();

        return redirect()->route('chats.show', $chat->id);
    }

    public function show(Chat $chat)
    {
        $page = request('page') ?? 1;

        $users = $chat->users()->get();
        $messages = $chat->messages()->with('user')
            ->orderByDesc('created_at')
            ->paginate(10, '*', 'page', $page);

        $chat->unreadMessageStatuses()->update([
           'is_read' => true,
        ]);

        $isLastPage = (int)$page === (int)$messages->lastPage();

        $messages = MessageResource::collection($messages)->resolve();

        if ($page > 1) {
            return response()->json([
                'is_last_page' => $isLastPage,
                'messages' => $messages,
            ]);
        }

        $users = UserResource::collection($users)->resolve();
        $chat = ChatResource::make($chat)->resolve();
        return Inertia::render('Front/Chat/Show', [
            'chat' => $chat,
            'users' => $users,
            'messages' => $messages,
            'isLastPage' => $isLastPage,
        ]);

    }
}
