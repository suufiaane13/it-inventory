<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Confirmer le mot de passe</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Zone sécurisée - Confirmez votre mot de passe</p>
    </div>

    <div class="mb-6 rounded-lg border border-yellow-200 dark:border-yellow-800 bg-yellow-50 dark:bg-yellow-900/20 p-4">
        <p class="text-sm text-yellow-800 dark:text-yellow-300">
            {{ __('Ceci est une zone sécurisée de l\'application. Veuillez confirmer votre mot de passe avant de continuer.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="mt-1 block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end">
            <x-button-primary type="submit" class="w-full sm:w-auto">
                {{ __('Confirmer') }}
            </x-button-primary>
        </div>
    </form>
</x-guest-layout>
