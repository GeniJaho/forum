@component('profiles.activities.activity')
    @slot('heading')
        <div>
            <div>
                <a href="{{ $activity->subject->favorited->path() }}" class="text-indigo-600 hover:text-indigo-500">
                    {{ $profileUser->name }} favorited a reply.
                </a>
            </div>
            <small>{{ $activity->subject->created_at->diffForHumans() }}</small>
        </div>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent
