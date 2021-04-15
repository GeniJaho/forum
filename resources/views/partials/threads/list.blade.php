@php
$title = $title ?? 'Forum Threads';
@endphp

<div class="card">
    <div class="card-header">{{ $title }}</div>

    <div class="card-body">

        @foreach($threads as $thread)
            <article class="thread-item">
                <div class="header">
                    <h4>
                        <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                    </h4>
                    <a href="{{ $thread->path() }}">
                        <strong>
                            {{ $thread->replies_count }}
                            {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}
                        </strong>
                    </a>
                </div>
                <div class="body"> {{ $thread->body }}</div>
            </article>
            <hr>
        @endforeach
    </div>
</div>
