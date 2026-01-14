<x-app-layout>
    <x-page-header 
        title="Maintenance #{{ $maintenance->id }}" 
        subtitle="Détails de la maintenance"
        :centered="true"
    >
        <x-slot name="actions">
            <x-button-secondary href="{{ route('maintenances.edit', $maintenance) }}">
                Modifier
            </x-button-secondary>
        </x-slot>
    </x-page-header>

    <div class="mx-auto max-w-3xl">
            <x-card title="Informations">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Équipement</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $maintenance->equipment->name }} - {{ $maintenance->equipment->serial_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Description</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $maintenance->description }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Statut</p>
                            <p class="mt-1">
                                <x-status-badge :status="$maintenance->status" />
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Signalé par</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $maintenance->reportedBy->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date de signalement</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $maintenance->reported_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        @if($maintenance->resolved_at)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date de résolution</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $maintenance->resolved_at->format('d/m/Y à H:i') }}</p>
                            </div>
                        @endif
                        @if($maintenance->cost)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Coût</p>
                                <p class="mt-1 text-sm text-gray-900">{{ number_format((int)$maintenance->cost, 0, ',', ' ') }} dh</p>
                            </div>
                        @endif
                    </div>
                </div>
            </x-card>
    </div>
</x-app-layout>
