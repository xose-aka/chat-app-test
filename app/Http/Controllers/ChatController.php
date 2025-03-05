<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ChatController extends Controller
{
    public function index()
    {
        $chatRooms = ChatRoom::query()->get();

        return view('dashboard', compact('chatRooms'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'chatRoomName' => 'required|string|max:255',
        ]);

        $chatRoom = ChatRoom::create([
            'name' => $request->chatRoomName,
        ]);

        return Response::json([
            'message' => 'Chat Room created successfully!',
            'chatRoom' => $chatRoom,
        ]);
    }

    public function show(ChatRoom $chatRoom)
    {
        $messages = Message::where('chat_room_id', $chatRoom->id)->with('user')->get();

        return view('chat_room.show', compact('chatRoom', 'messages'));
    }
}
