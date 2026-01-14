<x-app-layout>
    <x-page-header 
        title="Affecter un équipement" 
        subtitle="Assignez un équipement à un employé"
        :centered="true"
    />

    <div class="mx-auto max-w-3xl">
            @if($errors->any())
                <x-alert type="error" :message="'Veuillez corriger les erreurs ci-dessous.'" />
            @endif

            <x-card>
                <form method="POST" action="{{ route('assignments.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="equipment_id" :value="__('Équipement')" />
                        <select id="equipment_id" name="equipment_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>
                            <option value="">Sélectionner un équipement disponible</option>
                            @foreach($equipments as $equipment)
                                <option value="{{ $equipment->id }}" {{ old('equipment_id') == $equipment->id ? 'selected' : '' }}>
                                    {{ $equipment->name }} - {{ $equipment->serial_number }} ({{ $equipment->category->name }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('equipment_id')" class="mt-2" />
                        @if($equipments->isEmpty())
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Aucun équipement disponible pour le moment.</p>
                        @endif
                    </div>

                    <div>
                        <x-input-label for="employee_id" :value="__('Employé')" />
                        <select id="employee_id" name="employee_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>
                            <option value="">Sélectionner un employé</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->full_name }} - {{ $employee->department->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="notes" :value="__('Notes (optionnel)')" />
                        <textarea
                            id="notes"
                            name="notes"
                            rows="3"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                        >{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <x-button-secondary href="{{ route('equipments.index') }}">
                            Annuler
                        </x-button-secondary>
                        <x-button-primary type="submit" :disabled="$equipments->isEmpty()">
                            Affecter
                        </x-button-primary>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
