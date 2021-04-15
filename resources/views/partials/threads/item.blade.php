<div class="card thread-item">
    <div class="card-header header">
       <div>
           <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a>
           posted
           <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
       </div>
        <div>
            {{ $thread->created_at->diffForHumans() }}
        </div>
    </div>

    <div class="card-body">
        {{ $thread->body }}
    </div>
</div>
