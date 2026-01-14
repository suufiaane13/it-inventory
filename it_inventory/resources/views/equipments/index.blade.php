<x-app-layout>
    <x-page-header 
        title="Équipements" 
        subtitle="Gérez votre inventaire d'équipements informatiques"
        :action-label="auth()->user()->isSuperAdmin() ? 'Ajouter un équipement' : null"
        :action-href="auth()->user()->isSuperAdmin() ? route('equipments.create') : null"
    />

    <x-card class="mb-6">
                <form method="GET" action="{{ route('equipments.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recherche</label>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Numéro de série, modèle..."
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400 sm:text-sm"
                        />
                    </div>
                    <div class="w-full md:w-48">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catégorie</label>
                        <select
                            name="category_id"
                            id="category_id"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400 sm:text-sm"
                        >
                            <option value="">Toutes</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-48">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Statut</label>
                        <select
                            name="status"
                            id="status"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400 sm:text-sm"
                        >
                            <option value="">Tous</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                            <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Affecté</option>
                            <option value="broken" {{ request('status') == 'broken' ? 'selected' : '' }}>En Panne</option>
                            <option value="scrapped" {{ request('status') == 'scrapped' ? 'selected' : '' }}>Rebut</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <x-button-primary type="submit">Filtrer</x-button-primary>
                        @if(request()->anyFilled(['search', 'category_id', 'status']))
                            <x-button-secondary href="{{ route('equipments.index') }}">Réinitialiser</x-button-secondary>
                        @endif
                    </div>
                </form>
    </x-card>

    <!-- Liste des équipements -->
    <x-card>
                @if($equipments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-800">
                                <tr>
                                    <th class="px-4 py-3.5 text-center text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 w-16">Photo</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Marque/Modèle</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">N° Série</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Catégorie</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Statut</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Affecté à</th>
                                    <th class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @foreach($equipments as $equipment)
                                    <tr class="transition-colors duration-150 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="whitespace-nowrap px-4 py-4 text-center">
                                            @if($equipment->image_path)
                                                <img 
                                                    src="{{ asset('storage/' . $equipment->image_path) }}" 
                                                    alt="{{ $equipment->name }}" 
                                                    class="w-10 h-10 rounded-lg object-cover border border-gray-200 dark:border-gray-700 mx-auto"
                                                >
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center mx-auto">
                                                    <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ $equipment->brand }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $equipment->model }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $equipment->serial_number }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $equipment->category->name }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            @php
                                                $statusClasses = match($equipment->status) {
                                                    'available' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border-green-200 dark:border-green-800',
                                                    'assigned' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 border-blue-200 dark:border-blue-800',
                                                    'broken' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border-red-200 dark:border-red-800',
                                                    'scrapped' => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-600',
                                                    default => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-600',
                                                };
                                                $statusLabel = match($equipment->status) {
                                                    'available' => 'Disponible',
                                                    'assigned' => 'Affecté',
                                                    'broken' => 'En Panne',
                                                    'scrapped' => 'Rebut',
                                                    default => ucfirst($equipment->status),
                                                };
                                            @endphp
                                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium {{ $statusClasses }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            @if($equipment->currentAssignment)
                                                {{ $equipment->currentAssignment->employee->full_name }}
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            @if(auth()->user()->isSuperAdmin())
                                                <x-table-actions
                                                    :show-route="route('equipments.show', $equipment)"
                                                    :edit-route="route('equipments.edit', $equipment)"
                                                    :delete-route="route('equipments.destroy', $equipment)"
                                                    delete-message="Êtes-vous sûr de vouloir supprimer cet équipement ?"
                                                />
                                            @else
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('equipments.show', $equipment) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    @if($equipment->status !== 'broken')
                                                        <a href="{{ route('maintenances.create', ['equipment_id' => $equipment->id]) }}" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" title="Signaler une panne">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($equipments->hasPages())
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            {{ $equipments->links() }}
                        </div>
                    @endif
                @else
                    <div class="py-12 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Aucun équipement trouvé.</p>
                        @if(auth()->user()->isSuperAdmin())
                            <x-button-primary href="{{ route('equipments.create') }}" class="mt-4">
                                Ajouter un équipement
                            </x-button-primary>
                        @endif
                    </div>
                @endif
    </x-card>
</x-app-layout>
