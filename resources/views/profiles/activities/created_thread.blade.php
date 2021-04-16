@component('profiles.activities.activity')
    @slot('heading')
        <div>
            <a href="{{ route('profile', $profileUser->name) }}">{{ $profileUser->name }}</a>
            posted
            <a href="{{ $activity->subject->path() }}">
                "{{ $activity->subject->title }}"
            </a>
        </div>
        <div>
            {{ $activity->subject->created_at->diffForHumans() }}
        </div>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
