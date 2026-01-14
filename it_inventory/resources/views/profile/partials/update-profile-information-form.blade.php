<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-6">
    @csrf
    @method('patch')

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div>
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="prenom" :value="__('Prénom')" />
            <x-text-input id="prenom" name="prenom" type="text" class="mt-1 block w-full" :value="old('prenom', $user->prenom)" autocomplete="given-name" />
            <x-input-error class="mt-2" :messages="$errors->get('prenom')" />
        </div>
    </div>

    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <div>
        <x-input-label for="tel" :value="__('Téléphone')" />
        <x-text-input id="tel" name="tel" type="tel" class="mt-1 block w-full" :value="old('tel', $user->tel)" autocomplete="tel" />
        <x-input-error class="mt-2" :messages="$errors->get('tel')" />
    </div>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="rounded-lg border border-yellow-200 dark:border-yellow-800 bg-yellow-50 dark:bg-yellow-900/20 p-4">
            <p class="text-sm text-yellow-800 dark:text-yellow-300">
                {{ __('Votre adresse email n\'est pas vérifiée.') }}
                <button form="send-verification" class="ml-1 font-medium text-yellow-900 dark:text-yellow-200 underline transition-colors duration-200 hover:text-yellow-700 dark:hover:text-yellow-400">
                    {{ __('Cliquez ici pour renvoyer l\'email de vérification.') }}
                </button>
            </p>

            @if (session('status') === 'verification-link-sent')
                <p class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                    {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                </p>
            @endif
        </div>
    @endif

    <div class="flex items-center gap-4">
        <x-button-primary type="submit">
            Enregistrer
        </x-button-primary>

        @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm font-medium text-green-600 dark:text-green-400"
            >{{ __('Enregistré.') }}</p>
        @endif
    </div>
</form>
