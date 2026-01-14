<x-app-layout>
    <x-page-header 
        title="Modifier la maintenance" 
        subtitle="Mettez à jour les informations de la maintenance"
    />

    <div class="mx-auto max-w-3xl">
        <x-card>
                <form method="POST" action="{{ route('maintenances.update', $maintenance) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="status" :value="__('Statut')" />
                        <select id="status" name="status" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>
                            <option value="open" {{ old('status', $maintenance->status) == 'open' ? 'selected' : '' }}>Ouvert</option>
                            <option value="in_progress" {{ old('status', $maintenance->status) == 'in_progress' ? 'selected' : '' }}>En Cours</option>
                            <option value="resolved" {{ old('status', $maintenance->status) == 'resolved' ? 'selected' : '' }}>Résolu</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                            required
                        >{{ old('description', $maintenance->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="cost" :value="__('Coût (dh)')" />
                        <x-text-input id="cost" name="cost" type="number" step="1" min="0" class="mt-1 block w-full" :value="old('cost', $maintenance->cost ? (int)$maintenance->cost : '')" />
                        <x-input-error :messages="$errors->get('cost')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <x-button-secondary href="{{ route('maintenances.show', $maintenance) }}">
                            Annuler
                        </x-button-secondary>
                        <x-button-primary type="submit">
                            Enregistrer
                        </x-button-primary>
                    </div>
                </form>
        </x-card>
    </div>
</x-app-layout>
