@component('profiles.activities.activity')
    @slot('heading')
        <div>
            <div>
                <a href="{{ route('profile', $profileUser->name) }}">{{ $profileUser->name }}</a>
                posted
                <a href="{{ $activity->subject->path() }}">
                    "{{ $activity->subject->title }}"
                </a>
            </div>
            <small>{{ $activity->subject->created_at->diffForHumans() }}</small>
        </div>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
