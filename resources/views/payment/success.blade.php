@extends('layouts.passenger_app') <!-- or your layout -->

@section('content')
<div class="min-h-screen flex items-center justify-center bg-green-50 p-6">
    <div class="bg-white p-8 rounded shadow-md max-w-md text-center space-y-4">
        <h1 class="text-3xl font-bold text-green-700">Payment Successful!</h1>
        <p class="text-gray-700">
            Thank you for your payment. Your transaction has been completed successfully.
        </p>
        <a href="{{ route('passenger-dashboard')}}"
           class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded">
            Return to Home
        </a>
    </div>
</div>
@endsection
