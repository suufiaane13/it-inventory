<x-app-layout>
    <x-page-header 
        title="Signaler une panne" 
        subtitle="Enregistrez une nouvelle demande de maintenance"
        :centered="true"
    />

    <div class="mx-auto max-w-3xl">
        <x-card>
                <form method="POST" action="{{ route('maintenances.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="equipment_id" :value="__('Équipement')" />
                        <select id="equipment_id" name="equipment_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>
                            <option value="">Sélectionner un équipement</option>
                            @foreach($equipments as $equipment)
                                <option value="{{ $equipment->id }}" {{ old('equipment_id', $selectedEquipmentId ?? null) == $equipment->id ? 'selected' : '' }}>
                                    {{ $equipment->name }} - {{ $equipment->serial_number }} ({{ $equipment->category->name }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('equipment_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description de la panne')" />
                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                            required
                        >{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <x-button-secondary href="{{ route('maintenances.index') }}">
                            Annuler
                        </x-button-secondary>
                        <x-button-primary type="submit">
                            Signaler
                        </x-button-primary>
                    </div>
                </form>
        </x-card>
    </div>
</x-app-layout>
