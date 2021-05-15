@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full py-6">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="max-w-3xl mx-auto">
            <div class="mt-3">
                <avatar-form
                    :user="{{ $profileUser }}"
                ></avatar-form>
            </div>

            <br>

            @forelse($activities as $date => $activity)
                <h3 class="my-2 font-medium text-lg leading-5">{{ $date }}</h3>
                <div class="space-y-3">
                    @foreach($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                </div>
            @empty
                <p>There is no activity for this user yet.</p>
            @endforelse
        </div>
    </div>
@endsection
