@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full py-6">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="max-w-3xl mx-auto">

                <div class="frame-neon overflow-hidden shadow rounded-lg divide-y divide-neon text-white ">
                    <div class="px-4 py-5 sm:px-6 font-medium">
                        {{ __('Dashboard') }}
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        @if (session('status'))
                            <div class="text-sm text-teal" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <div class="text-sm text-teal" role="alert">
                                sdfghfdgh dfg df gdfsg df
                            </div>
                        Display something here
                    </div>
                </div>
        </div>
    </div>

@endsection
