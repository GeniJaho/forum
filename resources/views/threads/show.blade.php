@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-8">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <a href="#">{{ $thread->creator->name }}</a>
                                posted
                                {{ $thread->title }}
                            </div>

                            <div class="card-body">
                                {{ $thread->body }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-5">
                    <div class="col-md-8">
                        @foreach($replies as $reply)
                            @include('partials.threads.reply')
                        @endforeach

                        {{ $replies->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>

                @if(auth()->check())
                    <div class="row justify-content-center mt-5">
                        <div class="col-md-8">
                            <form method="post" action="{{ $thread->path() . '/replies' }}">
                                @csrf

                                <div class="form-group">
                            <textarea name="body" id="body" class="form-control"
                                      rows="5" placeholder="Have something to say?"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Post</button>
                            </form>
                        </div>
                    </div>
                @else
                    <p class="text-center mt-2">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
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
