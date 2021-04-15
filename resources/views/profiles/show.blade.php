@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>
                {{ $profileUser->name }}
            </h1>
            <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
        </div>

        <br>

        @foreach($threads as $thread)
            <div class="my-2">
                @include('partials.threads.item')
            </div>
        @endforeach

        {{ $threads->links() }}

    </div>
@endsection
