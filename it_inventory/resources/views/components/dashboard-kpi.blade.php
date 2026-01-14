@php
    $iconPaths = [
        'computer-desktop' => 'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25',
        'archive-box' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z',
        'user-group' => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z',
        'exclamation-triangle' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z',
    ];
    $iconPath = $iconPaths[$icon] ?? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
    
    $bgGradients = [
        'indigo' => 'from-indigo-500 to-indigo-600',
        'blue' => 'from-blue-500 to-blue-600',
        'green' => 'from-green-500 to-green-600',
        'red' => 'from-red-500 to-red-600',
        'yellow' => 'from-yellow-500 to-yellow-600',
        'purple' => 'from-purple-500 to-purple-600',
    ];
    $bgGradient = $bgGradients[$color] ?? 'from-indigo-500 to-indigo-600';
@endphp

<div class="group relative overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm transition-all duration-300 hover:shadow-md hover:border-gray-300 dark:hover:border-gray-600">
    <div class="absolute inset-0 bg-gradient-to-br {{ $bgGradient }} opacity-0 dark:opacity-10 transition-opacity duration-300 group-hover:opacity-5 dark:group-hover:opacity-15"></div>
    <div class="relative p-6">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</p>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($value, 0, ',', ' ') }}</p>
                @if($subtitle)
                    <p class="mt-1.5 text-xs font-medium text-gray-400 dark:text-gray-500">{{ $subtitle }}</p>
                @endif
            </div>
            @if($icon)
                <div class="flex-shrink-0">
                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br {{ $bgGradient }} shadow-lg transition-transform duration-300 group-hover:scale-110">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}" />
                        </svg>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
