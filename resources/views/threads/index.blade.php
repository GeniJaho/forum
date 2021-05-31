@extends('layouts.two_columns')

@section('criticalCss')
    @if(file_exists(public_path('/css/critical/threads.index.min.css')))
        <style>{!! file_get_contents(public_path('/css/critical/threads.index.min.css')) !!}</style>
    @endif
@endsection

@section('main')
    @include('threads.list')

    {{ $threads->links() }}
@endsection

@section('sidebar')
    @if($trending->isNotEmpty())
        <div class="frame-neon rounded-lg divide-y divide-neon">
            <div class="px-4 py-5 sm:px-6">
                <p class="text-lg text-white leading-6 font-medium">Trending threads</p>
            </div>

            <div>

                <ul class="divide-y divide-neon">

                    @foreach($trending as $thread)
                        <li class="relative py-5 px-4 focus-within:ring-2 focus-within:ring-inset focus-within:ring-neon-dark">
                            <div class="flex justify-between text-neon hover:text-neon-dark">
                                <div class="min-w-0 flex-1">
                                    <a href="{{ $thread->path() }}" class="block inner-shadow-neon focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        <p class="text-sm font-medium truncate">{{ $thread->title }}</p>
                                    </a>
                                </div>
                                <time datetime="{{ $thread->updated_at }}"
                                      class="flex-shrink-0 whitespace-nowrap text-sm ml-3">
                                    {{ $thread->updated_at->diffForHumans() }}
                                </time>
                            </div>
                        </li>

                    @endforeach
                </ul>

            </div>
        </div>
    @endif
@endsection
