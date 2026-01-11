@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Airport List</h1>
        <button onclick="openAddModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
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
                    <td class="px-6 py-4 space-x-2">
                        <button class="text-blue-600 hover:underline edit-btn"
                            data-id="{{ $airport->id }}"
                            data-name="{{ $airport->name }}"
                            data-city="{{ $airport->city }}"
                            data-country="{{ $airport->country }}">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin-airport-delete', $airport->id) }}" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
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

<div id="airportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
        <button onclick="closeAddModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black text-lg">&times;</button>
        <h2 class="text-xl font-bold mb-4">Add Airport</h2>

        <form action="{{ route('admin-airport-store') }}" method="POST" onsubmit="confirmAdd(event);">
            @csrf
            <div class="space-y-4">
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
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="editAirportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
        <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-600 hover:text-black text-lg">&times;</button>
        <h2 class="text-xl font-bold mb-4">Edit Airport</h2>

        <form id="editAirportForm" method="POST" onsubmit="confirmUpdate(event)">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <input type="hidden" name="id" id="edit_id">
                <div>
                    <label class="block font-medium">Name</label>
                    <input type="text" name="name" id="edit_name" required class="w-full border px-3 py-2 rounded" />
                </div>
                <div>
                    <label class="block font-medium">City</label>
                    <input type="text" name="city" id="edit_city" required class="w-full border px-3 py-2 rounded" />
                </div>
                <div>
                    <label class="block font-medium">Country</label>
                    <input type="text" name="country" id="edit_country" required class="w-full border px-3 py-2 rounded" />
                </div>
                <div class="text-right">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    function confirmAdd(event){
            event.preventDefault();

            Swal.fire({
            title: 'Are you sure you want to add this airport?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, add',
            cancelButtonText: 'Cancel',
            }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
                }
            });
            return false;
        }

    const updateRoute = @json(route('admin-airport-update', ['id' => '__id__']));

    function openAddModal() {
        document.getElementById('airportModal').classList.remove('hidden');
        document.getElementById('airportModal').classList.add('flex');
    }

    function closeAddModal() {
        document.getElementById('airportModal').classList.remove('flex');
        document.getElementById('airportModal').classList.add('hidden');
    }

    function closeEditModal() {
        document.getElementById('editAirportModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Handle edit
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                Swal.fire({
                    title: 'Edit this airport?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, edit',
                }).then(result => {
                    if (result.isConfirmed) {
                        const id = button.dataset.id;
                        const name = button.dataset.name;
                        const city = button.dataset.city;
                        const country = button.dataset.country;

                        document.getElementById('edit_id').value = id;
                        document.getElementById('edit_name').value = name;
                        document.getElementById('edit_city').value = city;
                        document.getElementById('edit_country').value = country;

                        const form = document.getElementById('editAirportForm');
                        form.action = updateRoute.replace('__id__', id);

                        document.getElementById('editAirportModal').classList.remove('hidden');
                    }
                });
            });
        });

        // Handle delete
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Delete this airport?',
                    text: "This cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then(result => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // SweetAlert Success
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: @json(session('success')),
            timer: 3000,
            showConfirmButton: false,
        });
        @endif
    });

    function confirmUpdate(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Update this airport?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, update',
        }).then(result => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }
</script>
@endsection
