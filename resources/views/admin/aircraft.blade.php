@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-end justify-between mb-8">
        <div>
            <div class="mb-1 text-xs font-bold tracking-widest uppercase text-sky">Fleet</div>
            <h1 class="text-3xl font-extrabold font-display text-navy">Aircraft Management</h1>
        </div>
        <button onclick="document.getElementById('addAircraftModal').classList.remove('hidden')"
            class="font-display font-bold text-sm bg-navy text-white px-5 py-2.5 rounded-lg hover:bg-navy-mid transition">
            + Add Aircraft
        </button>
    </div>

    <div class="overflow-x-auto bg-white border shadow-sm rounded-2xl border-slate-200">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-xs font-semibold tracking-wide uppercase text-slate-500">Model</th>
                    <th class="px-6 py-4 text-xs font-semibold tracking-wide uppercase text-slate-500">Manufacturer</th>
                    <th class="px-6 py-4 text-xs font-semibold tracking-wide uppercase text-slate-500">Seat Capacity</th>
                    <th class="px-6 py-4 text-xs font-semibold tracking-wide uppercase text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($aircraft as $plane)
                <tr class="transition hover:bg-slate-50/70">
                    <td class="px-6 py-4 font-bold font-display text-navy">{{ $plane->model }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $plane->manufacturer }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center bg-navy/5 text-navy text-xs font-semibold px-2.5 py-1 rounded-full">
                            {{ $plane->seat_capacity }} seats
                        </span>
                    </td>
                    <td class="px-6 py-4 space-x-4">
                        <button type="button" class="font-medium text-sky hover:underline edit-aircraft-btn"
                            data-id="{{ $plane->id }}"
                            data-model="{{ $plane->model }}"
                            data-manufacturer="{{ $plane->manufacturer }}"
                            data-seat_capacity="{{ $plane->seat_capacity }}">
                            Edit
                        </button>
                        <form action="{{ route('admin-aircraft-delete', $plane->id) }}" method="POST" class="inline-block delete-aircraft-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-500 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-10 text-center text-slate-400">No aircraft found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="addAircraftModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-navy/40 backdrop-blur-sm">
    <div class="relative w-full max-w-md bg-white shadow-2xl rounded-2xl p-7">
        <button onclick="document.getElementById('addAircraftModal').classList.add('hidden')"
            class="absolute text-xl leading-none top-4 right-4 text-slate-400 hover:text-navy">&times;</button>
        <h2 class="mb-5 text-xl font-bold font-display text-navy">Add New Aircraft</h2>

        <form action="{{ route('admin-aircraft-store') }}" method="POST" onsubmit="confirmAdd(event);" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Model</label>
                <input type="text" name="model" required class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none px-3.5 py-2.5 rounded-lg transition" />
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Manufacturer</label>
                <input type="text" name="manufacturer" required class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none px-3.5 py-2.5 rounded-lg transition" />
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Seat Capacity</label>
                <input type="number" name="seat_capacity" required class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none px-3.5 py-2.5 rounded-lg transition" />
            </div>
            <div class="pt-2 text-right">
                <button type="submit" class="font-display font-bold text-sm bg-navy text-white px-5 py-2.5 rounded-lg hover:bg-navy-mid transition">
                    Add
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editAircraftModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-navy/40 backdrop-blur-sm">
    <div class="relative w-full max-w-md bg-white shadow-2xl rounded-2xl p-7">
        <button onclick="document.getElementById('editAircraftModal').classList.add('hidden')"
            class="absolute text-xl leading-none top-4 right-4 text-slate-400 hover:text-navy">&times;</button>
        <h2 class="mb-5 text-xl font-bold font-display text-navy">Edit Aircraft</h2>

        <form id="editAircraftForm" method="POST" onsubmit="confirmAircraftUpdate(event)" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit_aircraft_id">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Model</label>
                <input type="text" name="model" id="edit_model" required class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none px-3.5 py-2.5 rounded-lg transition" />
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Manufacturer</label>
                <input type="text" name="manufacturer" id="edit_manufacturer" required class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none px-3.5 py-2.5 rounded-lg transition" />
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Seat Capacity</label>
                <input type="number" name="seat_capacity" id="edit_seat_capacity" required class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none px-3.5 py-2.5 rounded-lg transition" />
            </div>
            <div class="pt-2 text-right">
                <button type="submit" class="font-display font-bold text-sm bg-navy text-white px-5 py-2.5 rounded-lg hover:bg-navy-mid transition">
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
        confirmButtonColor: '#000053',
        cancelButtonColor: '#94a3b8',
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
                    confirmButtonColor: '#000053',
                    cancelButtonColor: '#94a3b8',
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
            confirmButtonColor: '#000053',
            cancelButtonColor: '#94a3b8',
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