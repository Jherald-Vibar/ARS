@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Aircraft List</h1>
        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            + Add Aircraft
        </button>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-center text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Model</th>
                    <th class="px-6 py-3">Manufacturer</th>
                    <th class="px-6 py-3">Seat Capacity</th>
                    <th class="px-6 py-3">Created At</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($aircraft as $plane)
                <tr>
                    <td class="px-6 py-4">{{ $plane->id }}</td>
                    <td class="px-6 py-4">{{ $plane->model }}</td>
                    <td class="px-6 py-4">{{ $plane->manufacturer }}</td>
                    <td class="px-6 py-4">{{ $plane->seat_capacity }}</td>
                    <td class="px-6 py-4">{{ $plane->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4">
                        <button class="text-blue-600 hover:underline">Edit</button>
                        <button class="text-red-600 hover:underline ml-2">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-400">No aircraft found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="aircraftModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
        <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black text-lg">&times;</button>
        <h2 class="text-xl font-bold mb-4">Add Aircraft</h2>

        <form action="{{ route('admin-aircraft-store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-medium">Model</label>
                <input type="text" name="model" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div>
                <label class="block font-medium">Manufacturer</label>
                <input type="text" name="manufacturer" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div>
                <label class="block font-medium">Seat Capacity</label>
                <input type="number" name="seat_capacity" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Scripts -->
<script>
    function openModal() {
        document.getElementById('aircraftModal').classList.remove('hidden');
        document.getElementById('aircraftModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('aircraftModal').classList.remove('flex');
        document.getElementById('aircraftModal').classList.add('hidden');
    }
</script>
@endsection
