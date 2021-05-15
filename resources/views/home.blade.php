@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full py-6">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="max-w-3xl mx-auto">

            <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
                <div class="px-4 py-5 sm:px-6 font-medium">
                    {{ __('Dashboard') }}
                </div>
                <div class="px-4 py-5 sm:p-6">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>

            <div class="mt-24 text-center">
                <button class="neon-button focus:ring-0 text-xl font-medium">
                    Nice
                </button>
            </div>

        </div>
    </div>

@endsection
