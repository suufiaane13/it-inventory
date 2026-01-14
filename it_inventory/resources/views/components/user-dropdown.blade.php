@props(['user'])

<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    <!-- Bouton utilisateur -->
    <button @click="open = !open" 
            class="flex items-center gap-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 dark:hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 text-xs font-semibold text-white shadow-sm">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="hidden text-left lg:block">
            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">
                {{ $user->isSuperAdmin() ? 'Super Admin' : 'Technicien' }}
            </div>
        </div>
        <svg class="h-4 w-4 text-gray-400 dark:text-gray-300 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Menu déroulant -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-64 origin-top-right rounded-lg border-[0.5px] border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-md focus:outline-none z-50"
         style="display: none;">
        
        <!-- En-tête avec infos utilisateur -->
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 text-sm font-semibold text-white shadow-sm">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $user->full_name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                    <span class="mt-1 inline-flex items-center rounded-full border px-2 py-0.5 text-xs font-medium {{ $user->isSuperAdmin() ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 border-purple-200 dark:border-purple-700' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 border-blue-200 dark:border-blue-700' }}">
                        {{ $user->isSuperAdmin() ? 'Super Admin' : 'Technicien' }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Menu Items -->
        <div class="py-1">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 transition-colors duration-150 hover:bg-gray-50 dark:hover:bg-gray-700">
                <svg class="h-5 w-5 text-gray-400 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Mon profil</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 transition-colors duration-150 hover:bg-red-50 dark:hover:bg-red-900/20">
                    <svg class="h-5 w-5 text-red-400 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
</div>
