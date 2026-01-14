<x-app-layout>
    <x-page-header 
        title="Catégories" 
        subtitle="Organisez vos équipements par catégories"
        action-label="Ajouter une catégorie"
        :action-href="route('categories.create')"
    />

    <x-card class="mb-6">
                <form method="GET" action="{{ route('categories.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recherche</label>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Nom, description..."
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400 sm:text-sm"
                        />
                    </div>
                    <div class="w-full md:w-48">
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                        <select
                            name="type"
                            id="type"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400 sm:text-sm"
                        >
                            <option value="">Tous</option>
                            <option value="hardware" {{ request('type') == 'hardware' ? 'selected' : '' }}>Hardware</option>
                            <option value="accessory" {{ request('type') == 'accessory' ? 'selected' : '' }}>Accessoire</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <x-button-primary type="submit">Filtrer</x-button-primary>
                        @if(request()->anyFilled(['search', 'type']))
                            <x-button-secondary href="{{ route('categories.index') }}">Réinitialiser</x-button-secondary>
                        @endif
                    </div>
                </form>
    </x-card>

    <!-- Liste des catégories -->
    <x-card>
                @if($categories->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-800">
                                <tr>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Nom</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Type</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Description</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Équipements</th>
                                    <th class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @foreach($categories as $category)
                                    <tr class="transition-colors duration-150 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $category->name }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium {{ $category->type === 'hardware' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 border-blue-200 dark:border-blue-800' : 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 border-purple-200 dark:border-purple-800' }}">
                                                {{ $category->type === 'hardware' ? 'Hardware' : 'Accessoire' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($category->description, 60) }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $category->equipments_count }} équipement(s)
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <x-table-actions
                                                :show-route="route('categories.show', $category)"
                                                :edit-route="route('categories.edit', $category)"
                                                :delete-route="route('categories.destroy', $category)"
                                                delete-message="Êtes-vous sûr de vouloir supprimer cette catégorie ?"
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($categories->hasPages())
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            {{ $categories->links() }}
                        </div>
                    @endif
                @else
                    <div class="py-12 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Aucune catégorie trouvée.</p>
                        <x-button-primary href="{{ route('categories.create') }}" class="mt-4">
                            Ajouter une catégorie
                        </x-button-primary>
                    </div>
                @endif
    </x-card>
</x-app-layout>
