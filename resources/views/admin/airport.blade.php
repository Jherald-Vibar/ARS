@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-end justify-between mb-8">
        <div>
            <div class="mb-1 text-xs font-bold tracking-widest uppercase text-sky">Network</div>
            <h1 class="text-3xl font-extrabold font-display text-navy">Airport List</h1>
        </div>
        <button onclick="openAddModal()"
            class="font-display font-bold text-sm bg-navy text-white px-5 py-2.5 rounded-lg hover:bg-navy-mid transition">
            + Add Airport
        </button>
    </div>

    <div class="overflow-x-auto bg-white border shadow-sm rounded-2xl border-slate-200">
        <table class="min-w-full text-sm text-left text-slate-700">
            <thead class="text-xs tracking-wide uppercase bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-6 py-4 font-semibold">#</th>
                    <th class="px-6 py-4 font-semibold">Name</th>
                    <th class="px-6 py-4 font-semibold">City</th>
                    <th class="px-6 py-4 font-semibold">Country</th>
                    <th class="px-6 py-4 font-semibold">Created At</th>
                    <th class="px-6 py-4 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($airports as $airport)
                <tr class="transition hover:bg-slate-50/70">
                    <td class="px-6 py-4 text-slate-400">{{ $airport->id }}</td>
                    <td class="px-6 py-4 font-bold font-display text-navy">{{ $airport->name }}</td>
                    <td class="px-6 py-4">{{ $airport->city }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center bg-navy/5 text-navy text-xs font-semibold px-2.5 py-1 rounded-full">
                            {{ $airport->country }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-500">{{ $airport->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 space-x-3">
                        <button class="font-medium text-sky hover:underline edit-btn"
                            data-id="{{ $airport->id }}"
                            data-name="{{ $airport->name }}"
                            data-city="{{ $airport->city }}"
                            data-country="{{ $airport->country }}">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin-airport-delete', $airport->id) }}" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-500 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-10 text-center text-slate-400">No airports found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="airportModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-navy/40 backdrop-blur-sm">
    <div class="relative w-full max-w-md bg-white shadow-2xl rounded-2xl p-7">
        <button onclick="closeAddModal()" class="absolute text-xl leading-none top-4 right-4 text-slate-400 hover:text-navy">&times;</button>
        <h2 class="mb-5 text-xl font-bold font-display text-navy">Add Airport</h2>

        <form action="{{ route('admin-airport-store') }}" method="POST" onsubmit="confirmAdd(event);">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Name</label>
                    <input type="text" name="name" required class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none px-3.5 py-2.5 rounded-lg transition" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">City</label>
                    <input type="text" name="city" required class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none px-3.5 py-2.5 rounded-lg transition" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Country</label>
                    <input type="text" name="country" required class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none px-3.5 py-2.5 rounded-lg transition" />
                </div>
                <div class="pt-2 text-right">
                    <button type="submit" class="font-display font-bold text-sm bg-navy text-white px-5 py-2.5 rounded-lg hover:bg-navy-mid transition">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="editAirportModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-navy/40 backdrop-blur-sm">
    <div class="relative w-full max-w-md bg-white shadow-2xl rounded-2xl p-7">
        <button onclick="closeEditModal()" class="absolute text-xl leading-none top-4 right-4 text-slate-400 hover:text-navy">&times;</button>
        <h2 class="mb-5 text-xl font-bold font-display text-navy">Edit Airport</h2>

        <form id="editAirportForm" method="POST" onsubmit="confirmUpdate(event)">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <input type="hidden" name="id" id="edit_id">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Name</label>
                    <input type="text" name="name" id="edit_name" required class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none px-3.5 py-2.5 rounded-lg transition" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">City</label>
                    <input type="text" name="city" id="edit_city" required class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none px-3.5 py-2.5 rounded-lg transition" />
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Country</label>
                    <input type="text" name="country" id="edit_country" required class="w-full border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none px-3.5 py-2.5 rounded-lg transition" />
                </div>
                <div class="pt-2 text-right">
                    <button type="submit" class="font-display font-bold text-sm bg-navy text-white px-5 py-2.5 rounded-lg hover:bg-navy-mid transition">Update</button>
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
                    confirmButtonColor: '#000053',
                    cancelButtonColor: '#94a3b8',
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
            confirmButtonColor: '#000053',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Yes, update',
        }).then(result => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }
</script>
@endsection