<x-app-layout>
    <x-page-header 
        title="Modifier le technicien" 
        subtitle="Mettez à jour les informations du technicien"
    />

    <div class="mx-auto max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <x-input-label for="name" :value="__('Nom')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="prenom" :value="__('Prénom')" />
                            <x-text-input id="prenom" name="prenom" type="text" class="mt-1 block w-full" :value="old('prenom', $user->prenom)" />
                            <x-input-error class="mt-2" :messages="$errors->get('prenom')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="tel" :value="__('Téléphone')" />
                        <x-text-input id="tel" name="tel" type="text" class="mt-1 block w-full" :value="old('tel', $user->tel)" />
                        <x-input-error class="mt-2" :messages="$errors->get('tel')" />
                    </div>

                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                        <p class="text-sm text-gray-600">Laissez les champs de mot de passe vides si vous ne souhaitez pas le modifier.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <x-input-label for="password" :value="__('Nouveau mot de passe')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-4">
                    <x-button-secondary href="{{ route('users.show', $user) }}">
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
