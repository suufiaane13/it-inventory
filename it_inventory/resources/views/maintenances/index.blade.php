<x-app-layout>
    <x-page-header 
        title="Maintenances" 
        subtitle="Suivez et gérez les pannes et réparations"
    >
        <x-slot name="actions">
            <a href="{{ route('maintenances.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Signaler un problème
            </a>
        </x-slot>
    </x-page-header>

    <x-card class="mb-6">
                <form method="GET" action="{{ route('maintenances.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recherche</label>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Nom équipement, numéro de série..."
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400 sm:text-sm"
                        />
                    </div>
                    <div class="w-full md:w-48">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                        <select
                            name="status"
                            id="status"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400 sm:text-sm"
                        >
                            <option value="">Tous</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Ouvert</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>En Cours</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Résolu</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <x-button-primary type="submit">Filtrer</x-button-primary>
                        @if(request()->anyFilled(['search', 'status']))
                            <x-button-secondary href="{{ route('maintenances.index') }}">Réinitialiser</x-button-secondary>
                        @endif
                    </div>
                </form>
    </x-card>

    <!-- Liste des maintenances -->
    <x-card>
                @if($maintenances->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-800">
                                <tr>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Équipement</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Description</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Signalé par</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Date</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Statut</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Coût</th>
                                    <th class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @foreach($maintenances as $maintenance)
                                    <tr class="transition-colors duration-150 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $maintenance->equipment->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $maintenance->equipment->serial_number }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ Str::limit($maintenance->description, 50) }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $maintenance->reportedBy->name }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $maintenance->reported_at->format('d/m/Y') }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            @php
                                                $statusClasses = match($maintenance->status) {
                                                    'open' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800',
                                                    'in_progress' => 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 border-indigo-200 dark:border-indigo-800',
                                                    'resolved' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border-green-200 dark:border-green-800',
                                                    default => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-600',
                                                };
                                                $statusLabel = match($maintenance->status) {
                                                    'open' => 'Ouvert',
                                                    'in_progress' => 'En Cours',
                                                    'resolved' => 'Résolu',
                                                    default => ucfirst($maintenance->status),
                                                };
                                            @endphp
                                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium {{ $statusClasses }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $maintenance->cost ? number_format((int)$maintenance->cost, 0, ',', ' ') . ' dh' : '-' }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <x-table-actions
                                                :show-route="route('maintenances.show', $maintenance)"
                                                :edit-route="route('maintenances.edit', $maintenance)"
                                                :delete-route="route('maintenances.destroy', $maintenance)"
                                                delete-message="Êtes-vous sûr de vouloir supprimer cette maintenance ?"
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($maintenances->hasPages())
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            {{ $maintenances->links() }}
                        </div>
                    @endif
                @else
                    <div class="py-12 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Aucune maintenance trouvée.</p>
                        <a href="{{ route('maintenances.create') }}" class="inline-flex items-center gap-2 px-4 py-2 mt-4 text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Signaler un problème
                        </a>
                    </div>
                @endif
    </x-card>
</x-app-layout>
