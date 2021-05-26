@component('profiles.activities.activity')
    @slot('heading')
        <div>
            <div class="text-white">
                <a href="{{ route('profile', $profileUser->name) }}"
                   class="text-neon hover:text-neon-dark">{{ $profileUser->name }}</a>
                posted
                <a href="{{ $activity->subject->path() }}" class="text-neon hover:text-neon-dark">
                    "{{ $activity->subject->title }}"
                </a>
            </div>
            <small class="text-white">{{ $activity->subject->created_at->diffForHumans() }}</small>
        </div>
    @endslot

    @slot('body')
        {!! $activity->subject->body !!}
    @endslot
@endcomponent
