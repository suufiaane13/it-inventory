<div class="flex items-center justify-end gap-1.5">
    @if($showRoute)
        <a href="{{ $showRoute }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-2.5 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 shadow-sm transition-colors duration-150 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 dark:hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:ring-offset-1">
            Voir
        </a>
    @endif
    
    @if($editRoute)
        <a href="{{ $editRoute }}" class="inline-flex items-center justify-center rounded-md border border-indigo-300 dark:border-indigo-600 bg-indigo-50 dark:bg-indigo-900/30 px-2.5 py-1.5 text-xs font-medium text-indigo-700 dark:text-indigo-300 shadow-sm transition-colors duration-150 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 hover:border-indigo-400 dark:hover:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:ring-offset-1">
            Modifier
        </a>
    @endif
    
    @if($deleteRoute)
        <form method="POST" action="{{ $deleteRoute }}" class="inline" onsubmit="return confirm('{{ $deleteMessage ?? 'Êtes-vous sûr de vouloir supprimer cet élément ?' }}');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center justify-center rounded-md border border-red-300 dark:border-red-600 bg-red-50 dark:bg-red-900/20 px-2.5 py-1.5 text-xs font-medium text-red-700 dark:text-red-400 shadow-sm transition-colors duration-150 hover:bg-red-100 dark:hover:bg-red-900/30 hover:border-red-400 dark:hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:ring-offset-1">
                Supprimer
            </button>
        </form>
    @endif
</div>
