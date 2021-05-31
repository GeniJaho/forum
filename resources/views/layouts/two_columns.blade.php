@extends('layouts.app')

@section('content')

    <!-- 2 column wrapper -->
    <div class="flex-grow w-full max-w-7xl mx-auto lg:flex">
        <!-- Left sidebar & main wrapper -->
        <div class="flex-1 min-w-0 xl:flex">

            <div class="border-b border-neon xl:border-b-0 lg:min-w-0 lg:flex-1">
                <div class="h-full py-6 px-4 sm:px-6 lg:px-8">
                    <!-- Start main area-->
                    <div class="relative h-full" style="min-height: 36rem;">
                        @yield('main')
                    </div>
                    <!-- End main area -->
                </div>
            </div>

            <div class="xl:flex-shrink-0 xl:w-80">
                <div class="h-full px-4 py-6 sm:pr-6 lg:pr-8">
                    <!-- Start right column area -->
                    <div class="h-full relative" style="min-height: 12rem;">
                        @yield('sidebar')
                    </div>
                    <!-- End right column area -->
                </div>
            </div>

        </div>

    </div>
@endsection
