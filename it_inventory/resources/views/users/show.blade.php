<x-app-layout>
    <x-page-header
        :title="$user->full_name"
        subtitle="Détails du technicien"
    >
        <x-slot name="actions">
            <x-button-secondary href="{{ route('users.edit', $user) }}">
                Modifier
            </x-button-secondary>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-card title="Informations">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Nom complet</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->full_name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Email</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Téléphone</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->tel ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Créé le</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Dernière mise à jour</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </x-card>

        <x-card title="Statistiques">
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Affectations</p>
                        <p class="text-xs text-gray-500">Nombre d'affectations effectuées</p>
                    </div>
                    <p class="text-2xl font-bold text-indigo-600">{{ $user->assignments()->count() }}</p>
                </div>
                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Maintenances signalées</p>
                        <p class="text-xs text-gray-500">Nombre de maintenances signalées</p>
                    </div>
                    <p class="text-2xl font-bold text-indigo-600">{{ $user->reportedMaintenances()->count() }}</p>
                </div>
            </div>
        </x-card>
    </div>
</x-app-layout>
