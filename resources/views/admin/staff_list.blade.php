@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Staff List</h1>
        <button
            data-modal-target="addStaffModal"
            data-modal-toggle="addStaffModal"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
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
                @if(!empty($staffs))
                @foreach ($staffs as $staff )
                <tr>
                    <td class="px-6 py-4">{{$staff->id}}</td>
                    <td class="px-6 py-4">{{$staff->name}}</td>
                    <td class="px-6 py-4">{{$staff->email}}</td>
                    <td class="px-6 py-4">{{$staff->created_at}}</td>
                    <td class="px-6 py-4">
                        <button class="text-blue-600 hover:underline">Edit</button>
                        <button class="text-red-600 hover:underline ml-2">Delete</button>
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


<div id="addStaffModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-md">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Add New Staff
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="addStaffModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            <form action="{{route('admin-staff-store')}}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
