<x-app-layout>
    <x-page-header 
        :title="$employee->full_name" 
        subtitle="Détails de l'employé"
    >
        <x-slot name="actions">
            <x-button-secondary href="{{ route('employees.edit', $employee) }}">
                Modifier
            </x-button-secondary>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-card title="Informations">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nom complet</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $employee->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Email</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $employee->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Téléphone</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $employee->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Département</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $employee->department->name }}</p>
                    </div>
                </div>
        </x-card>

        <x-card title="Équipements affectés">
                @if($employee->currentAssignments->count() > 0)
                    <div class="space-y-4">
                        @foreach($employee->currentAssignments as $assignment)
                            <div class="flex items-center justify-between border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $assignment->equipment->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $assignment->equipment->serial_number }}</p>
                                    <p class="text-xs text-gray-400">Affecté le {{ $assignment->assigned_at->format('d/m/Y') }}</p>
                                </div>
                                <x-status-badge :status="$assignment->equipment->status" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">Aucun équipement affecté.</p>
                @endif
        </x-card>
    </div>
</x-app-layout>
