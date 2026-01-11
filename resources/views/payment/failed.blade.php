@extends('layouts.passenger_app') <!-- or your layout -->

@section('content')
<div class="min-h-screen flex items-center justify-center bg-red-50 p-6">
    <div class="bg-white p-8 rounded shadow-md max-w-md text-center space-y-4">
        <h1 class="text-3xl font-bold text-red-700">Payment Failed</h1>
        <p class="text-gray-700">
            Unfortunately, your payment could not be processed at this time. Please try again or use a different payment method.
        </p>
        <a href="{{ url()->previous() }}"
           class="inline-block mt-4 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded">
            Go Back
        </a>
    </div>
</div>
@endsection
