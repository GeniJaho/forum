@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Forum Threads</div>

                    <div class="card-body thread-list">

                        @foreach($threads as $thread)
                            <article class="thread-item">
                                <div class="header">
                                    <h4>
                                        <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                    </h4>
                                    <a href="{{ $thread->path() }}">
                                        <strong>
                                            {{ $thread->replies_count }}
                                            {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}
                                        </strong>
                                    </a>
                                </div>
                                <div class="body"> {{ $thread->body }}</div>
                            </article>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
