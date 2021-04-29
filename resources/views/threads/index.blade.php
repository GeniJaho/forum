@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @forelse($threads as $thread)
                    <div class="my-2">
                        @component("profiles.activities.activity")
                            @slot('heading')
                                <h4>
                                    @if($thread->hasUpdatesFor(auth()->user()))
                                        <strong>
                                            <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                        </strong>
                                    @else
                                        <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                    @endif
                                </h4>
                                <a href="{{ $thread->path() }}">
                                    <strong>
                                        {{ $thread->replies_count }}
                                        {{ \Illuminate\Support\Str::plural('reply', $thread->replies_count) }}
                                    </strong>
                                </a>
                            @endslot
                            @slot('body')
                                {{ $thread->body }}
                            @endslot
                        @endcomponent
                    </div>
                @empty
                    <p class="my-2">There are no relevant results at this time.</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection
