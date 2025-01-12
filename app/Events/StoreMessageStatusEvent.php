<?php

namespace App\Events;

use App\Http\Resources\Front\Chat\Message\MessageResource;
use App\Http\Resources\Front\Chat\Message\MessageToOthersResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreMessageStatusEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

//    private Message $message;
    private $count;
    private $chatId;
    private $userId;
    private $message;

    /**
     * Create a new event instance.
     */
    public function __construct($count, $chatId, $userId, $message)
    {
        $this->count = $count;
        $this->chatId = $chatId;
        $this->userId = $userId;
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
            new PrivateChannel('users.' .  $this->userId),
        ];
    }



    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'store-message-status';
    }



    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'chat_id' => $this->chatId,
            'count' => $this->count,
            'new_message' => MessageResource::make($this->message)->resolve(),
        ];
    }

}
