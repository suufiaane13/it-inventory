@props(['href', 'active'])

<a href="{{ $href }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 transition-colors duration-150 hover:bg-gray-50 dark:hover:bg-gray-700 {{ $active ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : '' }}">
    {{ $slot }}
</a>
