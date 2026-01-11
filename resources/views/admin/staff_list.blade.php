@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Staff List</h1>
        <button
            onclick="document.getElementById('addStaffModal').classList.remove('hidden')"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
            type="button"
        >
            + Add Staff
        </button>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Created At</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @if(!empty($staffs) && $staffs->count() > 0)
                    @foreach ($staffs as $staff )
                    <tr>
                        <td class="px-6 py-4">{{$staff->id}}</td>
                        <td class="px-6 py-4">{{$staff->name}}</td>
                        <td class="px-6 py-4">{{$staff->email}}</td>
                        <td class="px-6 py-4">{{$staff->created_at->format('Y-m-d H:i')}}</td>
                        <td class="px-6 py-4 space-x-4">
                            <button
                                type="button"
                                class="text-blue-600 hover:underline edit-btn"
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
                                <button type="submit" class="text-red-600 hover:underline delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-400">No staff found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div id="addStaffModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  <div class="relative p-6 w-full max-w-md rounded-lg bg-white">
    <button
      onclick="document.getElementById('addStaffModal').classList.add('hidden')"
      class="absolute top-2 right-2 text-gray-600 hover:text-black text-lg font-bold"
      type="button"
    >&times;</button>

    <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Staff</h3>

    <form action="{{route('admin-staff-store')}}" method="POST" class="space-y-4" onsubmit="confirmAdd(event);">
      @csrf
      <div>
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
        <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded-lg" required>
      </div>
      <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
        <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg" required>
      </div>
      <div class="text-right">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
          Save
        </button>
      </div>
    </form>
  </div>
</div>

<div id="editStaffModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  <div class="relative p-6 w-full max-w-md rounded-lg bg-white">
    <button
      onclick="document.getElementById('editStaffModal').classList.add('hidden')"
      class="absolute top-2 right-2 text-gray-600 hover:text-black text-lg font-bold"
      type="button"
    >&times;</button>

    <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Staff</h3>

    <form id="editStaffForm" method="POST" class="space-y-4" onsubmit="confirmUpdate(event);">
      @csrf
      @method('PUT')
      <input type="hidden" id="edit_id" name="id">
      <div>
        <label for="edit_name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
        <input type="text" id="edit_name" name="name" class="w-full px-3 py-2 border rounded-lg" required>
      </div>
      <div>
        <label for="edit_email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
        <input type="email" id="edit_email" name="email" class="w-full px-3 py-2 border rounded-lg" required>
      </div>
      <div class="text-right">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
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
