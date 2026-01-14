<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Vérifier votre email</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Confirmez votre adresse email pour continuer</p>
    </div>

    <div class="mb-6 rounded-lg border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 p-4">
        <p class="text-sm text-blue-800 dark:text-blue-300">
            {{ __('Merci de vous être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ? Si vous n\'avez pas reçu l\'email, nous vous en enverrons un autre avec plaisir.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 rounded-lg border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 p-4">
            <p class="text-sm font-medium text-green-800 dark:text-green-300">
                {{ __('Un nouveau lien de vérification a été envoyé à l\'adresse email que vous avez fournie lors de l\'inscription.') }}
            </p>
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-button-primary type="submit" class="w-full">
                {{ __('Renvoyer l\'email de vérification') }}
            </x-button-primary>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-center text-sm font-medium text-gray-600 dark:text-gray-400 transition-colors duration-200 hover:text-gray-900 dark:hover:text-gray-200">
                {{ __('Déconnexion') }}
            </button>
        </form>
    </div>
</x-guest-layout>
