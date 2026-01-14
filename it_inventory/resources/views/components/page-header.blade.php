<div class="mb-8">
    @if($centered)
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $title }}</h1>
            @if($subtitle)
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
            @endif
            @if(isset($actions))
                <div class="mt-4 flex justify-center">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @else
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
<div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $title }}</h1>
                @if($subtitle)
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
                @endif
            </div>
            <div class="flex items-center gap-2">
                @if(isset($actions))
                    {{ $actions }}
                @elseif($actionLabel && $actionHref)
                    <x-button-primary href="{{ $actionHref }}">
                        {{ $actionLabel }}
                    </x-button-primary>
                @endif
            </div>
        </div>
    @endif
</div>
