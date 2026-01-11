
@extends('layouts.app')

@section('title', 'Admin Profile')

@section('content')
<div class="text-4xl font-bold text-gray-800 mb-6 flex items-center gap-2" style="color:#001840">
    <a href="{{ route('admin-dashboard') }}" class="text-blue-500 hover:underline text-2xl">&larr;</a>
    Admin Profile
</div>

<div class="flex flex-col md:flex-row gap-10 items-start mt-16">


    <div class="bg-white shadow rounded-lg p-6 flex-1 mr-20 min-h-[400px]">
        <h3 class="text-3xl font-bold mb-6 border-b pb-3">About you</h3>
        <div class="space-y-6">
            <div>
                <label class="text-lg text-gray-700">Name</label>
                <input type="text" value="{{ Auth::user()->name }}" class="w-full mt-2 px-5 py-3 text-lg bg-gray-100 border rounded" disabled>
            </div>

            <div>
                <label class="text-lg text-gray-700">Email</label>
                <input type="email" value="{{ Auth::user()->email }}" class="w-full mt-2 px-5 py-3 text-lg bg-gray-100 border rounded" disabled>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
