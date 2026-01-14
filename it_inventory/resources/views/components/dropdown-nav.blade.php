@props(['active', 'label', 'id'])

<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    <button @click="open = !open" 
            :class="$active ? 'inline-flex items-center gap-1.5 rounded-md border-b-2 border-indigo-600 bg-indigo-50 px-3 py-2 text-sm font-semibold leading-5 text-indigo-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1' : 'inline-flex items-center gap-1.5 rounded-md border-b-2 border-transparent px-3 py-2 text-sm font-medium leading-5 text-gray-600 transition-all duration-200 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1'">
        @if(isset($icon))
            <span class="mr-1.5">{{ $icon }}</span>
        @endif
        {{ $label }}
        <svg class="ml-1 h-3.5 w-3.5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute left-0 mt-2 w-56 origin-top-left rounded-lg border-[0.5px] border-gray-200 bg-white shadow-md focus:outline-none z-50"
         style="display: none;">
        <div class="py-1">
            {{ $slot }}
        </div>
    </div>
</div>
