@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('threads.list')

                {{ $threads->links() }}
            </div>

            <div class="col-md-4">
                <div class="card my-2">
                    <div class="card-header">
                        Trending threads
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($trending as $thread)
                                <a href="{{ $thread->path() }}" class="list-group-item list-group-item-action">
                                    {{ $thread->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
