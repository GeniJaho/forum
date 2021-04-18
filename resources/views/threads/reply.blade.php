<div id="reply-{{ $reply->id }}">
    @component('profiles.activities.activity')
        @slot('heading')
            <div>
                <a href="{{ route('profile', $reply->owner->name) }}">{{ $reply->owner->name }}</a>
                said
                {{ $reply->created_at->diffForHumans() }}
            </div>
            <div class="inline">
                <div>
                    <form action="{{ route('replies.favorite', $reply) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="btn btn-primary" {{ $reply->favorites_count ? 'disabled' : '' }}>
                            {{ $reply->favorites_count }}
                            <i class="{{ $reply->favorites_count ? 'fa' : 'far' }} fa-heart ml-1"></i>
                        </button>
                    </form>
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="far fa-edit"></i>
                    </button>
                </div>
                @can('delete', $reply)
                    <div class="d-flex align-items-center justify-content-center">
                        <form action="{{ route('replies.destroy', $reply->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-times"></i>
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
