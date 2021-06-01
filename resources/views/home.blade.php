@extends('layouts.app')

@section('criticalCss')
    @if(file_exists(public_path('/css/critical/home.min.css')))
        <style>{!! file_get_contents(public_path('/css/critical/home.min.css')) !!}</style>
    @endif
@endsection

@section('head')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="true"/>
    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css?family=Audiowide&text=Neon%20Forum&display=swap"
    />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Audiowide&text=Neon%20Forum&display=swap"
        media="print"
        onLoad="this.media='all'"
    />

    <link href="{{ mix('/css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full py-6">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="max-w-3xl mx-auto">

            <div class="my-5 text-center">
                <p class="neon-title">Neon <br class="sm:hidden"> Forum</p>
            </div>

            <div class="frame-neon overflow-hidden shadow rounded-lg divide-y divide-neon text-white ">
                <div class="px-4 py-5 sm:px-6 font-medium text-lg">
                    {{ __('Features') }}
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="text-sm text-teal" role="alert">
                        <ol class="space-y-3">
                            <li>100% Test Coverage on the backend</li>
                            <li>Neon look and feel</li>
                            <li>
                                Top stats on
                                <a href="https://developers.google.com/speed/pagespeed/insights/?url=https%3A%2F%2Fwww.forum.genijaho.dev"
                                   target="_blank"
                                   rel="noopener"
                                   class="text-neonSecondary hover:text-neonSecondary-dark"
                                >
                                    Performance, SEO, Accessibility, and Best Practices
                                </a>
                            </li>
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
                                This performant
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
                <div class="px-4 py-5 sm:px-6 text-lg text-teal">
                    Check the repo on
                    <a href="https://github.com/GeniJaho/forum"
                       target="_blank"
                       rel="noopener"
                       class="text-neonSecondary hover:text-neonSecondary-dark"
                    >Github</a>.
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
