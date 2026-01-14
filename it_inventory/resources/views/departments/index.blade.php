<x-app-layout>
    <x-page-header 
        title="Départements" 
        subtitle="Organisez votre entreprise par départements"
        action-label="Ajouter un département"
        :action-href="route('departments.create')"
    />

    <x-card class="mb-6">
                <form method="GET" action="{{ route('departments.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
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
                    <div class="flex gap-2">
                        <x-button-primary type="submit">Filtrer</x-button-primary>
                        @if(request()->filled('search'))
                            <x-button-secondary href="{{ route('departments.index') }}">Réinitialiser</x-button-secondary>
                        @endif
                    </div>
                </form>
    </x-card>

    <!-- Liste des départements -->
    <x-card>
                @if($departments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-800">
                                <tr>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Nom</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Description</th>
                                    <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Employés</th>
                                    <th class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @foreach($departments as $department)
                                    <tr class="transition-colors duration-150 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $department->name }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($department->description, 60) }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $department->employees_count }} employé(s)
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <x-table-actions
                                                :show-route="route('departments.show', $department)"
                                                :edit-route="route('departments.edit', $department)"
                                                :delete-route="route('departments.destroy', $department)"
                                                delete-message="Êtes-vous sûr de vouloir supprimer ce département ?"
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($departments->hasPages())
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            {{ $departments->links() }}
                        </div>
                    @endif
                @else
                    <div class="py-12 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Aucun département trouvé.</p>
                        <x-button-primary href="{{ route('departments.create') }}" class="mt-4">
                            Ajouter un département
                        </x-button-primary>
                    </div>
                @endif
    </x-card>
</x-app-layout>
