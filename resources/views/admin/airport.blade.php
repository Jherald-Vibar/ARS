@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Airport List</h1>
        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            + Add Airport
        </button>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">City</th>
                    <th class="px-6 py-3">Country</th>
                    <th class="px-6 py-3">Created At</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($airports as $airport)
                <tr>
                    <td class="px-6 py-4">{{ $airport->id }}</td>
                    <td class="px-6 py-4">{{ $airport->name }}</td>
                    <td class="px-6 py-4">{{ $airport->city }}</td>
                    <td class="px-6 py-4">{{ $airport->country }}</td>
                    <td class="px-6 py-4">{{ $airport->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4">
                        <button class="text-blue-600 hover:underline">Edit</button>
                        <button class="text-red-600 hover:underline ml-2">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-400">No airports found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="airportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black text-lg">&times;</button>
        <h2 class="text-xl font-bold mb-4">Add Airport</h2>

        <form action="{{ route('admin-airport-store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-medium">Name</label>
                <input type="text" name="name" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div>
                <label class="block font-medium">City</label>
                <input type="text" name="city" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div>
                <label class="block font-medium">Country</label>
                <input type="text" name="country" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Script -->
<script>
    function openModal() {
        document.getElementById('airportModal').classList.remove('hidden');
        document.getElementById('airportModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('airportModal').classList.remove('flex');
        document.getElementById('airportModal').classList.add('hidden');
    }
</script>
@endsection
