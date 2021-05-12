<div class="card activity-item">
    <div class="card-header header">
        {{ $heading }}
    </div>
    <div class="card-body">
        {{ $body }}
    </div>

    @if($footer ?? null)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
