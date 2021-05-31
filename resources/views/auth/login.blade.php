@extends('layouts.app')

@section('criticalCss')
    @if(file_exists(public_path('/css/critical/login.min.css')))
        <style>{!! file_get_contents(public_path('/css/critical/login.min.css')) !!}</style>
    @endif
@endsection

@section('content')
    <!-- 2 column wrapper -->
    <div class="flex-grow w-full max-w-xl mx-auto lg:flex">
        <!-- Left sidebar & main wrapper -->
        <div class="flex-1 min-w-0 xl:flex">

            <div class="lg:min-w-0 lg:flex-1 overflow-hidden sm:overflow-visible">
                <div class="h-full py-6 px-4 sm:px-6 lg:px-8">
                    <!-- Start main area-->
                    <div class="relative h-full">
                        <div>
                            <h2 class="mt-6 text-center text-3xl font-extrabold text-neon">
                                Sign in
                            </h2>
                        </div>
                        <form method="POST" class="mt-8 space-y-6" action="{{ route('login') }}">
                            @csrf
                            <input type="hidden" name="remember" value="true">
                            <div class="rounded-md -space-y-px">
                                <div>
                                    <label for="email-address" class="sr-only">Email address</label>
                                    <input
                                        id="email-address"
                                        name="email"
                                        type="email"
                                        autocomplete="email"
                                        value="{{ old('email') }}"
                                        required
                                        class="appearance-none bg-transparent rounded-none relative block w-full px-3 py-2 border border-neon placeholder-neon text-neon rounded-t-md focus:outline-none focus:ring focus:ring-offset focus:ring-offset-gray-800 focus:ring-neon-dark focus:z-10 sm:text-sm"
                                        placeholder="Email address"
                                    >
                                </div>
                                <div>
                                    <label for="password" class="sr-only">Password</label>
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        autocomplete="current-password"
                                        value="{{ old('password') }}"
                                        required
                                        class="appearance-none bg-transparent rounded-none relative block w-full px-3 py-2 border border-neon placeholder-neon text-neon rounded-b-md focus:outline-none focus:ring focus:ring-offset focus:ring-offset-gray-800 focus:ring-neon-dark focus:z-10 sm:text-sm"
                                        placeholder="Password"
                                    >
                                </div>
                            </div>

                            @error('email')
                            <span class="text-pink text-sm mt-1" role="alert">{{ $message }}</span>
                            @enderror
                            @error('password')
                            <span class="text-pink text-sm mt-1" role="alert">{{ $message }}</span>
                            @enderror

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input
                                        id="remember"
                                        name="remember"
                                        type="checkbox"
                                        class="bg-transparent h-4 w-4 text-neon border-neon rounded focus:outline-none focus:ring focus:ring-offset focus:ring-offset-gray-800 focus:ring-neon-dark"
                                        {{ old('remember') ? 'checked' : '' }}
                                    >
                                    <label for="remember" class="ml-2 block text-sm text-neon">
                                        Remember me
                                    </label>
                                </div>
                            </div>

                            <div>
                                <button type="submit"
                                        class="button-neon inner-shadow-neon ground-shadow-neon group relative w-full flex justify-center py-2 px-4 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-neon-dark">
                                      <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                        <!-- Heroicon name: solid/lock-closed -->
                                        <svg class="h-5 w-5 text-neon group-hover:text-neon-dark"
                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                             aria-hidden="true">
                                          <path fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd"/>
                                        </svg>
                                      </span>
                                    Sign in
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- End main area -->
                </div>
            </div>

        </div>

    </div>

@endsection
