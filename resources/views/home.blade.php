@extends('layouts.app')

@section('criticalCss')
    @if(file_exists(public_path('/css/critical/home.min.css')))
        <style>{!! file_get_contents(public_path('/css/critical/home.min.css')) !!}</style>
    @endif
@endsection

@section('head')
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Audiowide&text=Neon%20Forum" rel="stylesheet">

    <link href="{{ mix('/css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full py-6">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="max-w-3xl mx-auto">

            <div class="my-5 text-center">
                <p class="neon-title">Neon Forum</p>
            </div>

            <div class="frame-neon overflow-hidden shadow rounded-lg divide-y divide-neon text-white ">
                <div class="px-4 py-5 sm:px-6 font-medium text-lg">
                    {{ __('Features') }}
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="text-sm text-teal" role="alert">
                        <ol class="space-y-3">
                            <li>100% Test Coverage on the backend</li>
                            <li>Neon look & feel</li>
                            <li>Top stats on Performance, Accessibility, SEO, and Best Practices Audit</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="frame-neon overflow-hidden shadow rounded-lg divide-y divide-neon text-white mt-10">
                <div class="px-4 py-5 sm:px-6 font-medium text-lg">
                    {{ __('Based on') }}
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="text-sm text-teal" role="alert">
                        <ol class="space-y-3">
                            <li>
                                Most in depth TDD course on
                                <a href="https://laracasts.com/series/lets-build-a-forum-with-laravel"
                                   target="_blank"
                                   rel="noopener"
                                   class="text-neonSecondary hover:text-neonSecondary-dark"
                                >
                                    Laracasts
                                </a>
                            </li>
                            <li>
                                This awesome neon glow on
                                <a href="https://codepen.io/FelixRilling/pen/qzfoc"
                                   target="_blank"
                                   rel="noopener"
                                   class="text-neonSecondary hover:text-neonSecondary-dark"
                                >
                                    Codepen
                                </a>
                            </li>
                            <li>
                                This top performance
                                <a href="https://www.youtube.com/watch?v=6xNcXwC6ikQ"
                                   target="_blank"
                                   rel="noopener"
                                   class="text-neonSecondary hover:text-neonSecondary-dark"
                                >
                                    neon button implementation
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="mt-10 mb-48 text-center">
                <a href="{{ route('threads.index') }}"
                   class="button-neon inner-shadow-neon ground-shadow-neon text-3xl py-3 px-12">
                    See threads
                </a>
            </div>
        </div>
    </div>
@endsection
