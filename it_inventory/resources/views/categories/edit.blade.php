<x-app-layout>
    <x-page-header 
        title="Modifier la catégorie" 
        subtitle="Mettez à jour les informations de la catégorie"
    />

    <div class="mx-auto max-w-3xl">
        <x-card>
                <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Nom')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $category->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="type" :value="__('Type')" />
                        <select id="type" name="type" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Sélectionner un type</option>
                            <option value="hardware" {{ old('type', $category->type) == 'hardware' ? 'selected' : '' }}>Hardware</option>
                            <option value="accessory" {{ old('type', $category->type) == 'accessory' ? 'selected' : '' }}>Accessoire</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('description', $category->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <x-button-secondary href="{{ route('categories.show', $category) }}">
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
