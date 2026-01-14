<x-app-layout>
    <x-page-header 
        :title="$department->name" 
        subtitle="Détails du département"
    >
        <x-slot name="actions">
            <x-button-secondary href="{{ route('departments.edit', $department) }}">
                Modifier
            </x-button-secondary>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-card title="Informations">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <p class="text-sm font-medium text-gray-500">Nom</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $department->name }}</p>
                </div>
                @if($department->description)
                    <div class="col-span-2">
                        <p class="text-sm font-medium text-gray-500">Description</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $department->description }}</p>
                    </div>
                @endif
                <div>
                    <p class="text-sm font-medium text-gray-500">Nombre d'employés</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $department->employees->count() }} employé(s)</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Créé le</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $department->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </x-card>

        <x-card title="Employés">
            @if($department->employees->count() > 0)
                <div class="space-y-4">
                    @foreach($department->employees->take(5) as $employee)
                        <div class="flex items-center justify-between border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $employee->full_name }}</p>
                                <p class="text-xs text-gray-500">{{ $employee->email }}</p>
                                @if($employee->phone)
                                    <p class="text-xs text-gray-400">{{ $employee->phone }}</p>
                                @endif
                            </div>
                            <x-button-secondary href="{{ route('employees.show', $employee) }}" class="!px-3 !py-1.5 text-xs">
                                Voir
                            </x-button-secondary>
                        </div>
                    @endforeach
                    @if($department->employees->count() > 5)
                        <div class="pt-2 text-center">
                            <p class="text-xs text-gray-500 mb-3">
                                Et {{ $department->employees->count() - 5 }} autre(s) employé(s)
                            </p>
                        </div>
                    @endif
                    <div class="pt-2">
                        <x-button-primary href="{{ route('employees.index', ['department_id' => $department->id]) }}" class="w-full">
                            Voir tous les employés
                        </x-button-primary>
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-500">Aucun employé dans ce département.</p>
            @endif
        </x-card>
    </div>
</x-app-layout>
