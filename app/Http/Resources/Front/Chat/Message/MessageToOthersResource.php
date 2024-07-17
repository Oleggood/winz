<?php

namespace App\Http\Resources\Front\Chat\Message;

use App\Http\Resources\Front\Chat\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'chat_id' => $this->chat_id,
            'user_name' => $this->user->name,
            'user_lastname' => $this->user->lastname,
            'user_nickname' => $this->user->nickname,
            'target_id' => $this->target_id,
            'target_type' => $this->target_type,
            'text' => $this->text,
            'read' => $this->read,
            'time' => $this->time,
            'is_owner' => $this->is_owner,
        ];
    }
}
