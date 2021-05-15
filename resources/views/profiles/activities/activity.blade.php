<div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
    <div class="px-4 py-5 sm:px-6">
        {{ $heading }}
    </div>
    <div class="px-4 py-5 sm:p-6">
        {{ $body }}
    </div>
    @if($footer ?? null)
    <div class="bg-gray-50 px-4 py-4 sm:px-6">
        {{ $footer }}
    </div>
    @endif
</div>
