@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <div class="flex items-end justify-between">
        <div>
            <div class="mb-1 text-xs font-bold tracking-widest uppercase text-sky">Personnel</div>
            <h1 class="text-3xl font-extrabold font-display text-navy">Staff List</h1>
        </div>
        <button
            onclick="document.getElementById('addStaffModal').classList.remove('hidden')"
            class="font-display font-bold text-sm bg-navy text-white px-5 py-2.5 rounded-lg hover:bg-navy-mid transition"
            type="button"
        >
            + Add Staff
        </button>
    </div>

    <div class="overflow-x-auto bg-white border shadow-sm rounded-2xl border-slate-200">
        <table class="min-w-full text-sm text-left text-slate-700">
            <thead class="text-xs tracking-wide uppercase bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-6 py-4 font-semibold">#</th>
                    <th class="px-6 py-4 font-semibold">Name</th>
                    <th class="px-6 py-4 font-semibold">Email</th>
                    <th class="px-6 py-4 font-semibold">Created At</th>
                    <th class="px-6 py-4 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @if(!empty($staffs) && $staffs->count() > 0)
                    @foreach ($staffs as $staff )
                    <tr class="transition hover:bg-slate-50/70">
                        <td class="px-6 py-4 text-slate-400">{{$staff->id}}</td>
                        <td class="px-6 py-4 font-bold font-display text-navy">{{$staff->name}}</td>
                        <td class="px-6 py-4">{{$staff->email}}</td>
                        <td class="px-6 py-4 text-slate-500">{{$staff->created_at->format('Y-m-d H:i')}}</td>
                        <td class="px-6 py-4 space-x-3">
                            <button
                                type="button"
                                class="font-medium text-sky hover:underline edit-btn"
                                data-id="{{ $staff->id }}"
                                data-name="{{ $staff->name }}"
                                data-email="{{ $staff->email }}"
                            >
                                Edit
                            </button>

                            <form
                                action="{{ route('admin-staff-delete', $staff->id) }}"
                                method="POST"
                                class="inline-block delete-form"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-500 hover:underline delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="6" class="py-10 text-center text-slate-400">No staff found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div id="addStaffModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-navy/40 backdrop-blur-sm">
  <div class="relative w-full max-w-md bg-white shadow-2xl p-7 rounded-2xl">
    <button
      onclick="document.getElementById('addStaffModal').classList.add('hidden')"
      class="absolute text-xl leading-none top-4 right-4 text-slate-400 hover:text-navy"
      type="button"
    >&times;</button>

    <h3 class="mb-5 text-xl font-bold font-display text-navy">Add New Staff</h3>

    <form action="{{route('admin-staff-store')}}" method="POST" class="space-y-4" onsubmit="confirmAdd(event);">
      @csrf
      <div>
        <label for="name" class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Name</label>
        <input type="text" id="name" name="name" class="w-full px-3.5 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none rounded-lg transition" required>
      </div>
      <div>
        <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Email</label>
        <input type="email" id="email" name="email" class="w-full px-3.5 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none rounded-lg transition" required>
      </div>
      <div class="pt-2 text-right">
        <button type="submit" class="font-display font-bold text-sm bg-navy text-white px-5 py-2.5 rounded-lg hover:bg-navy-mid transition">
          Save
        </button>
      </div>
    </form>
  </div>
</div>

<div id="editStaffModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-navy/40 backdrop-blur-sm">
  <div class="relative w-full max-w-md bg-white shadow-2xl p-7 rounded-2xl">
    <button
      onclick="document.getElementById('editStaffModal').classList.add('hidden')"
      class="absolute text-xl leading-none top-4 right-4 text-slate-400 hover:text-navy"
      type="button"
    >&times;</button>

    <h3 class="mb-5 text-xl font-bold font-display text-navy">Edit Staff</h3>

    <form id="editStaffForm" method="POST" class="space-y-4" onsubmit="confirmUpdate(event);">
      @csrf
      @method('PUT')
      <input type="hidden" id="edit_id" name="id">
      <div>
        <label for="edit_name" class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Name</label>
        <input type="text" id="edit_name" name="name" class="w-full px-3.5 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none rounded-lg transition" required>
      </div>
      <div>
        <label for="edit_email" class="block text-xs font-semibold uppercase tracking-wide text-slate-500 mb-1.5">Email</label>
        <input type="email" id="edit_email" name="email" class="w-full px-3.5 py-2.5 border border-slate-200 bg-slate-50 focus:bg-white focus:border-navy outline-none rounded-lg transition" required>
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
        title: 'Are you sure you want to add this staff?',
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


    const routeUpdate = @json(route('admin-staff-update', ['id' => '__id__']));

    document.addEventListener('DOMContentLoaded', () => {
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                Swal.fire({
                    title: 'Are you sure you want to edit this staff?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#000053',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, edit',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        const id = button.getAttribute('data-id');
                        const name = button.getAttribute('data-name');
                        const email = button.getAttribute('data-email');

                        document.getElementById('edit_id').value = id;
                        document.getElementById('edit_name').value = name;
                        document.getElementById('edit_email').value = email;

                        const actionUrl = routeUpdate.replace('__id__', id);
                        document.getElementById('editStaffForm').action = actionUrl;

                        document.getElementById('editStaffModal').classList.remove('hidden');
                    }
                });
            });
        });

        // Delete form confirmation
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure you want to delete this staff?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });

    function confirmUpdate(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Are you sure you want to update this staff?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#000053',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Yes, update',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });

        return false;
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