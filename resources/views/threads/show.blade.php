@extends('layouts.app')

@section('content')

    <thread inline-template :initial-replies-count="{{ $thread->replies_count }}">

        <div class="container">
            <div class="row">

                <div class="col-md-8 justify-content-center">
                    @component('profiles.activities.activity')
                        @slot('heading')
                            <div>
                                <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a>
                                posted
                                <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                            </div>
                            @can('delete', $thread)
                                <div class="d-flex align-items-center justify-content-center">
                                    <form action="{{ $thread->path() }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            @endcan
                        @endslot
                        @slot('body')
                            {{ $thread->body }}
                        @endslot
                    @endcomponent

                    <div class="mt-5">
                        <replies
                            :data="{{ $thread->replies }}"
                            @removed="replyRemoved"
                        ></replies>
                    </div>

                    @if(auth()->check())
                        <div class="my-5">
                            <form method="post" action="{{ $thread->path() . '/replies' }}">
                                @csrf

                                <div class="form-group">
                                    <textarea name="body" id="body" class="form-control"
                                              required
                                              rows="5" placeholder="Have something to say?"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Post</button>
                            </form>
                        </div>
                    @else
                        <p class="text-center mt-2">Please <a href="{{ route('login') }}">sign in</a> to participate in
                            this
                            discussion.</p>
                    @endif

                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p>This thread was published {{ $thread->created_at->diffForHumans() }}
                                by <a href="#">{{ $thread->creator->name }}</a>, and currently has
                                @{{ repliesCount }}
                                {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </thread>
@endsection
