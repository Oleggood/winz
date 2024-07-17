<?php

namespace App\Events;

use App\Http\Resources\Front\Chat\Message\MessageResource;
use App\Http\Resources\Front\Chat\Message\MessageToOthersResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreMessageEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

//    private User $userId;
    private Message $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('store_message.' .  $this->message->chat_id),
        ];
    }



    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'store-message';
    }



    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'new_message' => MessageToOthersResource::make($this->message)->resolve()
        ];
    }

}
