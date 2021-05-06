@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="page-header">
                    <h1>
                        {{ $profileUser->name }}
                    </h1>

                    @can('update', $profileUser)
                        <form action="{{ route('avatar', $profileUser) }}"
                              enctype="multipart/form-data"
                              method="post"
                        >
                            @csrf

                            <input type="file" name="avatar">
                            <button class="btn btn-primary">Add Avatar</button>
                        </form>
                    @endcan

                    <img src="{{ $profileUser->avatar() }}"
                         alt="Avatar" width="50" height="50"
                    >
                </div>

                <br>

                @forelse($activities as $date => $activity)
                    <h3 class="my-2">{{ $date }}</h3>
                    @foreach($activity as $record)
                        <div class="my-2">
                            @if(view()->exists("profiles.activities.{$record->type}"))
                                @include("profiles.activities.{$record->type}", ['activity' => $record])
                            @endif
                        </div>
                    @endforeach
                @empty
                    <p>There is no activity for this user yet.</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection
