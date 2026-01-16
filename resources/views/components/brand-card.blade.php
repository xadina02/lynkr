<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-48 object-cover">
    <div class="p-4">
        <h2 class="text-xl font-semibold mb-2">{{ $name }}</h2>
        <p class="text-sm text-gray-600">Rating: {{ $rating }}</p>
        @auth
            <div class="mt-4 flex justify-between">
                <a href="{{ url('/brands/' . $id . '/edit') }}" class="text-blue-600 hover:underline">Edit</a>
                <form action="{{ url('/brands/' . $id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                </form>
            </div>
        @endauth
    </div>
</div>
