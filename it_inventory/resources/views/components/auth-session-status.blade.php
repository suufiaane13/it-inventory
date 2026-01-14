@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-lg border border-green-200 bg-green-50 p-4']) }}>
        <p class="text-sm font-medium text-green-800">
        {{ $status }}
        </p>
    </div>
@endif
