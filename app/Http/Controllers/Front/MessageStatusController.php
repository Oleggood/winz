<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\MessageStatus\UpdateRequest;
use App\Models\MessageStatus;
use Illuminate\Http\Request;

class MessageStatusController extends Controller
{
    public function update(UpdateRequest $request)
    {
        $data = $request->validated();

        MessageStatus::where('user_id', $data['user_id'])
            ->where('message_id', $data['message_id'])
            ->update(['is_read' => true]);
    }
}
