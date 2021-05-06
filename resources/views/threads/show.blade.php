@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/tribute.css">
@endsection

@section('content')

    <thread inline-template :initial-replies-count="{{ $thread->replies_count }}">

        <div class="container">
            <div class="row">

                <div class="col-md-8 justify-content-center">
                    @component('profiles.activities.activity')
                        @slot('heading')
                            <div>
                                <img src="{{ $thread->creator->avatar() }}"
                                     alt="Avatar" width="25" height="25" class="mr-2"
                                >
                                <span>
                                    <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a>
                                posted
                                <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                </span>
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
                            @added="replyAdded"
                            @removed="replyRemoved"
                        ></replies>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p>This thread was published {{ $thread->created_at->diffForHumans() }}
                                by <a href="#">{{ $thread->creator->name }}</a>, and currently has
                                @{{ repliesCount }}
                                {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}.
                            </p>

                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </thread>
@endsection
