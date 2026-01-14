@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center gap-1.5 rounded-md border-b-2 border-indigo-600 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-2 text-sm font-semibold leading-5 text-indigo-700 dark:text-indigo-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1'
            : 'inline-flex items-center gap-1.5 rounded-md border-b-2 border-transparent px-3 py-2 text-sm font-medium leading-5 text-gray-600 dark:text-gray-300 transition-all duration-200 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
