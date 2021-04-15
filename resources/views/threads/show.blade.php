@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-8 justify-content-center">

                <div class="card thread-item">
                    <div class="card-header header">
                        <div>
                            <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a>
                            posted
                            <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                        </div>
                        <div>
                            <form action="{{ $thread->path() }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>


                <div class="mt-5">
                    @foreach($replies as $reply)
                        <div class="mt-2">
                            @include('partials.threads.reply')
                        </div>
                    @endforeach

                    {{ $replies->links('vendor.pagination.bootstrap-4') }}
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
                            {{ $thread->replies_count }}
                            {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}.
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
