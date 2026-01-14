<x-app-layout>
    <x-page-header 
        title="Modifier l'employé" 
        subtitle="Mettez à jour les informations de l'employé"
    />

    <div class="mx-auto max-w-3xl">
        <x-card>
                <form method="POST" action="{{ route('employees.update', $employee) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <x-input-label for="first_name" :value="__('Prénom')" />
                            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $employee->first_name)" required autofocus />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="last_name" :value="__('Nom')" />
                            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $employee->last_name)" required />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $employee->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Téléphone')" />
                            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $employee->phone)" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div class="md:col-span-2">
                            <x-input-label for="department_id" :value="__('Département')" />
                            <select id="department_id" name="department_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400" required>
                                <option value="">Sélectionner un département</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <x-button-secondary href="{{ route('employees.show', $employee) }}">
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
