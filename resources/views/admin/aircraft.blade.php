@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Aircraft Management</h1>
        <button onclick="document.getElementById('addAircraftModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Add Aircraft
        </button>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 font-medium text-gray-700">Model</th>
                    <th class="px-6 py-3 font-medium text-gray-700">Manufacturer</th>
                    <th class="px-6 py-3 font-medium text-gray-700">Seat Capacity</th>
                    <th class="px-6 py-3 font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($aircraft as $plane)
                <tr>
                    <td class="px-6 py-4">{{ $plane->model }}</td>
                    <td class="px-6 py-4">{{ $plane->manufacturer }}</td>
                    <td class="px-6 py-4">{{ $plane->seat_capacity }}</td>
                    <td class="px-6 py-4 space-x-4">
                        <button
                            type="button"
                            class="text-blue-600 hover:underline edit-aircraft-btn"
                            data-id="{{ $plane->id }}"
                            data-model="{{ $plane->model }}"
                            data-manufacturer="{{ $plane->manufacturer }}"
                            data-seat_capacity="{{ $plane->seat_capacity }}"
                        >
                            Edit
                        </button>

                        <form action="{{ route('admin-aircraft-delete', $plane->id) }}" method="POST" class="inline-block delete-aircraft-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="addAircraftModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
        <button onclick="document.getElementById('addAircraftModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-600 hover:text-black text-lg">&times;</button>
        <h2 class="text-xl font-bold mb-4">Add New Aircraft</h2>

        <form action="{{ route('admin-aircraft-store') }}" method="POST" onsubmit="confirmAdd(event);">
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
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mt-4">
                    Add
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editAircraftModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
        <button onclick="document.getElementById('editAircraftModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-600 hover:text-black text-lg">&times;</button>
        <h2 class="text-xl font-bold mb-4">Edit Aircraft</h2>

        <form id="editAircraftForm" method="POST" onsubmit="confirmAircraftUpdate(event)">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit_aircraft_id">
            <div>
                <label class="block font-medium">Model</label>
                <input type="text" name="model" id="edit_model" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div>
                <label class="block font-medium">Manufacturer</label>
                <input type="text" name="manufacturer" id="edit_manufacturer" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div>
                <label class="block font-medium">Seat Capacity</label>
                <input type="number" name="seat_capacity" id="edit_seat_capacity" required class="w-full border px-3 py-2 rounded" />
            </div>
            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mt-4">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

function confirmAdd(event){
        event.preventDefault();
        Swal.fire({
        title: 'Are you sure you want to add this aircraft?',
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

    const updateRoute = @json(route('admin-aircraft-update', ['id' => '__id__']));

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.edit-aircraft-btn').forEach(button => {
            button.addEventListener('click', () => {
                Swal.fire({
                    title: 'Edit this aircraft?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, edit',
                }).then(result => {
                    if (result.isConfirmed) {
                        const id = button.dataset.id;
                        const model = button.dataset.model;
                        const manufacturer = button.dataset.manufacturer;
                        const seat_capacity = button.dataset.seat_capacity;

                        document.getElementById('edit_aircraft_id').value = id;
                        document.getElementById('edit_model').value = model;
                        document.getElementById('edit_manufacturer').value = manufacturer;
                        document.getElementById('edit_seat_capacity').value = seat_capacity;

                        const form = document.getElementById('editAircraftForm');
                        form.action = updateRoute.replace('__id__', id);

                        document.getElementById('editAircraftModal').classList.remove('hidden');
                    }
                });
            });
        });

        // Delete confirmation
        document.querySelectorAll('.delete-aircraft-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Delete this aircraft?',
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
    });

    function confirmAircraftUpdate(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Update this aircraft?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, update',
        }).then(result => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: @json(session('success')),
        timer: 3000,
        showConfirmButton: false,
    });
    @endif
</script>
@endsection
