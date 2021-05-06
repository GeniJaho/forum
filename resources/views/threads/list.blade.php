@forelse($threads as $thread)
    <div class="my-2">
        @component("profiles.activities.activity")
            @slot('heading')
                <div>
                    <h4>
                        @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                            <strong>
                                <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                            </strong>
                        @else
                            <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                        @endif
                    </h4>
                    <p class="mb-0">
                        Posted by: <a href="{{ route('profile', $thread->creator) }}">
                            {{ $thread->creator->name }}
                        </a>
                    </p>
                </div>
                <a href="{{ $thread->path() }}">
                    <strong>
                        {{ $thread->replies_count }}
                        {{ \Illuminate\Support\Str::plural('reply', $thread->replies_count) }}
                    </strong>
                </a>
            @endslot
            @slot('body')
                {{ $thread->body }}
            @endslot
        @endcomponent
    </div>
@empty
    <p class="my-2">There are no relevant results at this time.</p>
@endforelse
