<?php

namespace App\Http\Resources\Front\Chat;

use App\Http\Resources\Front\Chat\Message\MessageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title ?? $this->chatWith->nickname,
            'users' => $this->users,
            'last_message' => isset($this->lastMessage) ? (MessageResource::make($this->lastMessage)->resolve()) : '',
            'unread_count' => $this->unread_message_statuses_count,
        ];
    }
}
