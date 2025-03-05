@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="bg-white p-6 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Chat Rooms</h1>
        <div class="flex justify-end mb-4">
            <a href="{{ route('chatrooms.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create Chat Room</a>
        </div>
        <ul class="space-y-2">
            @forelse ($chatrooms as $chatroom)
                <li class="bg-gray-100 p-4 rounded shadow-sm">
                    <a href="{{ route('chatrooms.show', $chatroom->id) }}" class="text-blue-500">{{ $chatroom->name }}</a>
                </li>
            @empty
                <li class="text-gray-500">No chat rooms available.</li>
            @endforelse
        </ul>
    </div>
@endsection
