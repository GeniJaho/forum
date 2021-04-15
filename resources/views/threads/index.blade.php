@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @foreach($threads as $thread)
                    <div class="my-2">
                        <div class="card thread-item">
                            <div class="card-header header">
                                <h4>
                                    <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                </h4>
                                <a href="{{ $thread->path() }}">
                                    <strong>
                                        {{ $thread->replies_count }}
                                        {{ \Illuminate\Support\Str::plural('reply', $thread->replies_count) }}
                                    </strong>
                                </a>
                            </div>

                            <div class="card-body">
                                {{ $thread->body }}
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
