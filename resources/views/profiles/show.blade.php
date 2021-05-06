@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="page-header">
                    <avatar-form
                        :user="{{ $profileUser }}"
                    ></avatar-form>
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
