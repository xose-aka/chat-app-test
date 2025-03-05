<?php

namespace App\WebSocket;

use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\User;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class ChatWebSocket implements MessageComponentInterface
{

    protected $clients = [];

    /**
     * @inheritDoc
     */
    function onOpen(ConnectionInterface $conn)
    {
        $this->clients[$conn->resourceId] = $conn;
        echo "New connection ({$conn->resourceId})\n";
    }

    /**
     * @inheritDoc
     */
    function onClose(ConnectionInterface $conn)
    {
        unset($this->clients[$conn->resourceId]);
        echo "Connection closed ({$conn->resourceId})\n";
    }

    /**
     * @inheritDoc
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }

    /**
     * @inheritDoc
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        $room = ChatRoom::query()->where('id', $data['room_id'])->first();
        $user = User::query()->where('id', $data['user_id'])->first();

        $message = Message::create([
            'user_id' => $user->id,
            'chat_room_id' => $room->id,
            'message' => $data['message'],
        ]);

        $response = json_encode([
            'user_name' => $user->name,
            'message' => $message->message,
            'timestamp' => $message->created_at->toDateTimeString()
        ]);

        foreach ($this->clients as $client) {
            $client->send($response);
        }
    }
}
