<x-app-layout>
    <x-page-header 
        :title="$category->name" 
        subtitle="Détails de la catégorie"
    >
        <x-slot name="actions">
            <x-button-secondary href="{{ route('categories.edit', $category) }}">
                Modifier
            </x-button-secondary>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-card title="Informations">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <p class="text-sm font-medium text-gray-500">Nom</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Type</p>
                    <p class="mt-1">
                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium {{ $category->type === 'hardware' ? 'bg-blue-100 text-blue-800 border-blue-200' : 'bg-purple-100 text-purple-800 border-purple-200' }}">
                            {{ $category->type === 'hardware' ? 'Hardware' : 'Accessoire' }}
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Nombre d'équipements</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->equipments->count() }} équipement(s)</p>
                </div>
                @if($category->description)
                    <div class="col-span-2">
                        <p class="text-sm font-medium text-gray-500">Description</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->description }}</p>
                    </div>
                @endif
                <div>
                    <p class="text-sm font-medium text-gray-500">Créé le</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </x-card>

        <x-card title="Équipements">
            @if($category->equipments->count() > 0)
                <div class="space-y-4">
                    @foreach($category->equipments->take(5) as $equipment)
                        <div class="flex items-center justify-between border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $equipment->name }}</p>
                                <p class="text-xs text-gray-500">{{ $equipment->serial_number }}</p>
                                <p class="mt-1">
                                    <x-status-badge :status="$equipment->status" />
                                </p>
                            </div>
                            <x-button-secondary href="{{ route('equipments.show', $equipment) }}" class="!px-3 !py-1.5 text-xs">
                                Voir
                            </x-button-secondary>
                        </div>
                    @endforeach
                    @if($category->equipments->count() > 5)
                        <div class="pt-2 text-center">
                            <p class="text-xs text-gray-500 mb-3">
                                Et {{ $category->equipments->count() - 5 }} autre(s) équipement(s)
                            </p>
                        </div>
                    @endif
                    <div class="pt-2">
                        <x-button-primary href="{{ route('equipments.index', ['category_id' => $category->id]) }}" class="w-full">
                            Voir tous les équipements
                        </x-button-primary>
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-500">Aucun équipement dans cette catégorie.</p>
            @endif
        </x-card>
    </div>
</x-app-layout>
