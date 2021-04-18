<div id="reply-{{ $reply->id }}">
    @component('profiles.activities.activity')
        @slot('heading')
            <div>
                <a href="{{ route('profile', $reply->owner->name) }}">{{ $reply->owner->name }}</a>
                said
                {{ $reply->created_at->diffForHumans() }}
            </div>
            <div class="inline">
                <div class="mr-2">
                    <form action="{{ route('replies.favorite', $reply) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="btn btn-primary" {{ $reply->favorites_count ? 'disabled' : '' }}>
                            {{ $reply->favorites_count }}
                            {{ Str::plural('Favorite', $reply->favorites_count) }}
                        </button>
                    </form>
                </div>
                @can('delete', $reply)
                    <div>
                        <form action="{{ route('replies.destroy', $reply->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                @endcan
            </div>

        @endslot

        @slot('body')
            {{ $reply->body }}
        @endslot
    @endcomponent
</div>
