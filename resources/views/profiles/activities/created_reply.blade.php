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
        <div>
            <form action="{{ route('replies.favorite', $activity->subject) }}" method="POST">
                @csrf
                <button type="submit"
                        class="btn btn-primary" {{ $activity->subject->favorites_count ? 'disabled' : '' }}>
                    {{ $activity->subject->favorites_count }}
                    {{ Str::plural('Favorite', $activity->subject->favorites_count) }}
                </button>
            </form>
        </div>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
