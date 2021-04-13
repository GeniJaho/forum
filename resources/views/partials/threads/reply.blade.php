<div class="card reply-item">
    <div class="card-header header">
       <div>
           <a href="#">{{ $reply->owner->name }}</a>
           said
           {{ $reply->created_at->diffForHumans() }}
       </div>
        <div>
            <form action="{{ route('replies.favorite', $reply) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary" {{ $reply->favorites()->count() ? 'disabled' : '' }}>
                    {{ $reply->favorites()->count() }}
                    {{ Str::plural('Favorite', $reply->favorites()->count()) }}
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
