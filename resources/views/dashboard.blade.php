@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="bg-white p-6 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Chat Rooms</h1>
            @auth
                <div class="flex justify-end mb-4">
                    <button id="openModal" class="bg-blue-500 text-white px-4 py-2 rounded">Create Chat Room</button>
                </div>
                <ul class="space-y-2">

                @forelse ($chatRooms as $chatroom)
                    <li class="bg-gray-100 p-4 rounded shadow-sm">
                        <a href="{{ route('chat-room.show', $chatroom->id) }}" class="text-blue-500">{{ $chatroom->name }}</a>
                    </li>
                @empty
                    <li class="text-gray-500">No chat rooms available.</li>
                @endforelse
                </ul>

            @else
                <div class="text-gray-500">You haven't authenticate yet</div>
            @endauth
    </div>

    <div id="modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center modal">

        <div class="bg-white p-6 rounded shadow-md w-1/2">
            <h2 class="text-xl font-bold mb-4">Create Chat Room</h2>
            <input type="text" id="chatRoomNameInputForm" class="w-full p-2 border border-gray-300 rounded mb-4" placeholder="Enter chat room name">
            <div class="mt-4">
                <button id="closeModal" class="bg-red-500 text-white px-4 py-2 rounded">Close</button>
                <button id="saveModal" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </div>
    </div>

    <script>


        document.getElementById('openModal').addEventListener('click', function() {
            document.getElementById('modal').classList.add('active');
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('modal').classList.remove('active');
        });

        document.getElementById('saveModal').addEventListener('click', function() {

            const inputData = $('#chatRoomNameInputForm').val();

            if (!inputData) {
                alert('You did not enter anything');
                return;
            }

            $.ajax({
                url: '{{ route("chat.store") }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'chatRoomName': inputData
                },
                success: function(response) {
                    alert('Save successful: ' + response.message);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Something went wrong.');
                }
            });
        });

        window.addEventListener('click', function(event) {
            const modal = document.getElementById('modal');
            if (event.target === modal) {
                modal.classList.remove('active');
            }
        });
    </script>
@endsection
