@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center border-l-4 border-indigo-600 dark:border-indigo-500 bg-indigo-50 dark:bg-indigo-900/30 px-4 py-3 text-base font-semibold text-indigo-700 dark:text-indigo-300 transition-colors duration-200 focus:border-indigo-700 dark:focus:border-indigo-400 focus:bg-indigo-100 dark:focus:bg-indigo-900/40 focus:text-indigo-800 dark:focus:text-indigo-200 focus:outline-none'
            : 'flex items-center border-l-4 border-transparent px-4 py-3 text-base font-medium text-gray-600 dark:text-gray-300 transition-colors duration-200 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-gray-100 focus:border-gray-300 dark:focus:border-gray-600 focus:bg-gray-50 dark:focus:bg-gray-700 focus:text-gray-800 dark:focus:text-gray-100 focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
