@component('profiles.activities.activity')
    @slot('heading')
        <div>
            <div>
                <a href="{{ $activity->subject->favorited->path() }}" class="text-neon hover:text-neon-dark">
                    {{ $profileUser->name }} favorited a reply.
                </a>
            </div>
            <small class="text-white">{{ $activity->subject->created_at->diffForHumans() }}</small>
        </div>
    @endslot

    @slot('body')
        {!! $activity->subject->favorited->body !!}
    @endslot
@endcomponent
