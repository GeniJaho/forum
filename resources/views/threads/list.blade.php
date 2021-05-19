<div class="space-y-3">
    @forelse($threads as $thread)
        @component("profiles.activities.activity")
            @slot('heading')
                <div class="flex flex-row justify-between">
                    <div class="flex flex-col">
                        <h3 class="text-lg leading-6 font-medium text-carolinaBlue hover:text-carolinaBlue">
                            @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>
                                    <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                </strong>
                            @else
                                <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                            @endif
                        </h3>

                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Posted by: <a href="{{ route('profile', $thread->creator) }}" class="text-carolinaBlue hover:text-carolinaBlue">
                                {{ $thread->creator->name }}
                            </a>
                        </p>
                    </div>
                    <a href="{{ $thread->path() }}" class="font-medium text-carolinaBlue hover:text-carolinaBlue">
                        {{ $thread->replies_count }}
                        {{ \Illuminate\Support\Str::plural('reply', $thread->replies_count) }}
                    </a>
                </div>
            @endslot
            @slot('body')
                {{ $thread->body }}
            @endslot
            @slot('footer')
                {{ $thread->visits }} {{ \Illuminate\Support\Str::plural('Visit', $thread->visits) }}
            @endslot
        @endcomponent
    @empty
        <p class="my-2">There are no relevant results at this time.</p>
    @endforelse
</div>
