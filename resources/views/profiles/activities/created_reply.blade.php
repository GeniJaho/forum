@component('profiles.activities.activity')
    @slot('heading')
        <div>
            <div>
                <a href="{{ route('profile', $profileUser->name) }}">{{ $profileUser->name }}</a>
                replied to
                <a href="{{ $activity->subject->thread->path() }}">
                    "{{ $activity->subject->thread->title }}"
                </a>
            </div>
            <small>{{ $activity->subject->created_at->diffForHumans() }}</small>
        </div>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
