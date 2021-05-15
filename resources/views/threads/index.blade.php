@extends('layouts.two_columns')

@section('main')
    @include('threads.list')

    {{ $threads->links() }}
@endsection

@section('sidebar')
    @if($trending->isNotEmpty())
        <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
            <div class="px-4 py-5 sm:px-6">
                <p class="text-lg leading-6 font-medium">Trending threads</p>
            </div>

            <div>

                <ul class="divide-y divide-gray-200">

                    @foreach($trending as $thread)
                        <li class="relative bg-white py-5 px-4 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                            <div class="flex justify-between">
                                <div class="min-w-0 flex-1">
                                    <a href="{{ $thread->path() }}" class="block focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        <p class="text-sm font-medium text-indigo-600 hover:text-indigo-500 truncate">{{ $thread->title }}</p>
                                    </a>
                                </div>
                                <time datetime="{{ $thread->updated_at }}"
                                      class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500 ml-3">
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
