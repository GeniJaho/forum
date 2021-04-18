@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="page-header">
                    <h1>
                        {{ $profileUser->name }}
                    </h1>
                </div>

                <br>

                @if($activities->isNotEmpty())
                    @foreach($activities as $date => $activity)
                        <h3 class="my-2">{{ $date }}</h3>
                        @foreach($activity as $record)
                            <div class="my-2">
                                @if(view()->exists("profiles.activities.{$record->type}"))
                                    @include("profiles.activities.{$record->type}", ['activity' => $record])
                                @endif
                            </div>
                        @endforeach
                    @endforeach
                @endif

            </div>
        </div>
    </div>
@endsection
