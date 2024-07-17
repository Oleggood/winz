<?php

namespace App\Http\Resources\Front;

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
            'author_id' => $this->author_id,
            'target_id' => $this->target_id,
            'target_type' => $this->target_type,
            'text' => $this->text,
            'read' => $this->read,
            'time' => $this->created_at->diffForHumans(),
        ];
    }
}
