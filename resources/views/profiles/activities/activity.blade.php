<div class="frame-neon hover:box-shadow-neon overflow-hidden rounded-lg divide-y divide-carolinaBlue">
    <div class="px-4 py-5 sm:px-6">
        {{ $heading }}
    </div>
    <div class="px-4 py-5 sm:p-6 text-carolinaBlue">
        {{ $body }}
    </div>
    @if($footer ?? null)
    <div class="px-4 py-4 sm:px-6 bg-neon-dark text-carolinaBlue">
        {{ $footer }}
    </div>
    @endif
</div>
