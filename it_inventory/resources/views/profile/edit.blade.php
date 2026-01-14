<x-app-layout>
    <x-page-header 
        title="Profil" 
        subtitle="Gérez les informations de votre compte"
        :centered="true"
    />

    <div class="mx-auto max-w-3xl" x-data="{ activeTab: 'profile' }">
        <!-- Onglets -->
        <div>
            <nav class="flex space-x-8" aria-label="Tabs">
                <button
                    @click="activeTab = 'profile'"
                    :class="activeTab === 'profile' 
                        ? 'text-indigo-600 dark:text-indigo-400 font-semibold' 
                        : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                    class="border-0 bg-transparent whitespace-nowrap px-1 py-4 text-sm font-medium transition-colors duration-200 focus:outline-none"
                >
                    <svg class="mr-2 inline-block h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Informations du profil
                </button>
                <button
                    @click="activeTab = 'password'"
                    :class="activeTab === 'password' 
                        ? 'text-indigo-600 dark:text-indigo-400 font-semibold' 
                        : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                    class="border-0 bg-transparent whitespace-nowrap px-1 py-4 text-sm font-medium transition-colors duration-200 focus:outline-none"
                >
                    <svg class="mr-2 inline-block h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    Modifier le mot de passe
                </button>
                <button
                    @click="activeTab = 'delete'"
                    :class="activeTab === 'delete' 
                        ? 'text-red-600 dark:text-red-400 font-semibold' 
                        : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                    class="border-0 bg-transparent whitespace-nowrap px-1 py-4 text-sm font-medium transition-colors duration-200 focus:outline-none"
                >
                    <svg class="mr-2 inline-block h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer le compte
                </button>
            </nav>
        </div>

        <!-- Contenu des onglets -->
        <div class="mt-6">
            <!-- Onglet Informations du profil -->
            <div x-show="activeTab === 'profile'" x-transition>
                <div class="overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-sm">
                    <div class="p-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Onglet Modifier le mot de passe -->
            <div x-show="activeTab === 'password'" x-transition style="display: none;">
                <div class="overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-sm">
                    <div class="p-6">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Onglet Supprimer le compte -->
            <div x-show="activeTab === 'delete'" x-transition style="display: none;">
                <div class="overflow-hidden rounded-xl bg-white dark:bg-gray-800 shadow-sm">
                    <div class="p-6">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
