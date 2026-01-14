<x-app-layout>
    <x-page-header 
        title="Employés" 
        subtitle="Gérez l'annuaire des employés de l'entreprise"
        action-label="Ajouter un employé"
        :action-href="route('employees.create')"
    />

    <x-card class="mb-6">
                <form method="GET" action="{{ route('employees.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recherche</label>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="Nom, prénom, email..."
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400 sm:text-sm"
                        />
                    </div>
                    <div class="w-full md:w-48">
                        <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Département</label>
                        <select
                            name="department_id"
                            id="department_id"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400 sm:text-sm"
                        >
                            <option value="">Tous</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <x-button-primary type="submit">Filtrer</x-button-primary>
                        @if(request()->anyFilled(['search', 'department_id']))
                            <x-button-secondary href="{{ route('employees.index') }}">Réinitialiser</x-button-secondary>
                        @endif
                    </div>
                </form>
    </x-card>

    <!-- Liste des employés -->
    <x-card>
                @if($employees->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Département</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Équipements</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @foreach($employees as $employee)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $employee->full_name }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $employee->email }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $employee->department->name }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                            {{ $employee->currentAssignments->count() }} équipement(s)
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <x-table-actions
                                                :show-route="route('employees.show', $employee)"
                                                :edit-route="route('employees.edit', $employee)"
                                                :delete-route="route('employees.destroy', $employee)"
                                                delete-message="Êtes-vous sûr de vouloir supprimer cet employé ?"
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($employees->hasPages())
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            {{ $employees->links() }}
                        </div>
                    @endif
                @else
                    <div class="py-12 text-center">
                        <p class="text-gray-500 dark:text-gray-400">Aucun employé trouvé.</p>
                        <x-button-primary href="{{ route('employees.create') }}" class="mt-4">
                            Ajouter un employé
                        </x-button-primary>
                    </div>
                @endif
    </x-card>
</x-app-layout>
