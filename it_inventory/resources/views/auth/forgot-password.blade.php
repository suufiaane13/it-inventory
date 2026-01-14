<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Mot de passe oublié</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Récupérez votre mot de passe en quelques clics</p>
    </div>

    <div class="mb-6 rounded-lg border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 p-4">
        <p class="text-sm text-blue-800 dark:text-blue-300">
            {{ __('Mot de passe oublié ? Aucun problème. Indiquez-nous votre adresse email et nous vous enverrons un lien de réinitialisation qui vous permettra d\'en choisir un nouveau.') }}
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end">
            <x-button-primary type="submit" class="w-full sm:w-auto">
                {{ __('Envoyer le lien') }}
            </x-button-primary>
        </div>
    </form>
</x-guest-layout>
