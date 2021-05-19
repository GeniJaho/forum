@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full py-6">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="max-w-3xl mx-auto">

                <div class="frame-neon overflow-hidden shadow rounded-lg divide-y divide-carolinaBlue text-white ">
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
                <button class="button-neon inner-shadow-neon focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500">
                    Nice
                </button>

                <a href="/threads/create"
                   class="button-neon inner-shadow-neon relative inline-flex items-center px-4 py-2 text-sm font-medium rounded-md">
                    <!-- Heroicon name: solid/plus -->
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                         fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                              clip-rule="evenodd"/>
                    </svg>
                    <span>New Thread</span>
                </a>
            </div>

        </div>
    </div>

@endsection
