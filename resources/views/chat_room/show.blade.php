@extends('layouts.app')

@section('title', 'Chat Room')

@section('content')
    <div class="bg-white p-6 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Chat Room {{ $chatRoom->name }}</h1>

        <div id="chat-box" style="height: 300px; overflow-y: auto;">
            @foreach($messages as $message)
                <p><strong>{{ $message->user->name }}:</strong> {{ $message->message }}</p>
            @endforeach
        </div>

        <input type="text" id="message" class="form-control" placeholder="Type a message">
        <button onclick="sendMessage()" class="btn btn-primary mt-2">Send</button>

    </div>

    <script>
        const ws = new WebSocket("ws://localhost:8080");

        ws.onmessage = function(event) {
            const data = JSON.parse(event.data);
            $("#chat-box").append(`<p><strong>${data.user_name}:</strong> ${data.message} <small>(${data.timestamp})</small></p>`);
        };

        function sendMessage() {
            let message = $("#message").val();
            if (message.trim() === "") return;

            let payload = JSON.stringify({
                user_id: {{ auth()->user()->id }},
                room_id: "{{ $chatRoom->id }}",
                message: message
            });

            ws.send(payload);
            $("#message").val('');
        }
    </script>

@endsection
