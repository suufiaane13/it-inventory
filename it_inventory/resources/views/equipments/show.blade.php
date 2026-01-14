<x-app-layout>
    <x-page-header 
        :title="$equipment->name" 
        subtitle="Détails de l'équipement"
    >
        <x-slot name="actions">
            <div class="flex gap-2">
                @if(auth()->user()->isSuperAdmin())
                    <x-button-secondary href="{{ route('equipments.edit', $equipment) }}">
                        Modifier
                    </x-button-secondary>
                    @if($equipment->status === 'available')
                        <x-button-primary href="{{ route('assignments.create') }}?equipment_id={{ $equipment->id }}">
                            Affecter
                        </x-button-primary>
                    @endif
                @else
                    @if($equipment->status !== 'broken')
                        <a href="{{ route('maintenances.create', ['equipment_id' => $equipment->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Signaler un problème
                        </a>
                    @endif
                @endif
            </div>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Informations principales -->
                <div class="lg:col-span-2 space-y-6">
                    <x-card title="Informations">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nom</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $equipment->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Numéro de série</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $equipment->serial_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Marque</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $equipment->brand }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Modèle</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $equipment->model }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Catégorie</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $equipment->category->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Statut</p>
                                <p class="mt-1">
                                    <x-status-badge :status="$equipment->status" />
                                </p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date d'achat</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $equipment->purchase_date->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Garantie</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $equipment->warranty_duration }} mois
                                    @if($equipment->warranty_expires_at)
                                        <br>
                                        <span class="text-xs {{ $equipment->isWarrantyExpiringSoon() ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-gray-500 dark:text-gray-400' }}">
                                            Expire le {{ $equipment->warranty_expires_at->format('d/m/Y') }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </x-card>

                    <!-- Historique des affectations -->
                    <x-card title="Historique des affectations">
                        @if($equipment->assignments->count() > 0)
                            <div class="space-y-4">
                                @foreach($equipment->assignments->sortByDesc('assigned_at') as $assignment)
                                    <div class="flex items-start justify-between border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $assignment->employee->full_name }}
                                            </p>
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                Affecté le {{ $assignment->assigned_at->format('d/m/Y à H:i') }}
                                                @if($assignment->returned_at)
                                                    • Restitué le {{ $assignment->returned_at->format('d/m/Y à H:i') }}
                                                @else
                                                    <span class="text-green-600 dark:text-green-400 font-medium">• En cours</span>
                                                @endif
                                            </p>
                                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                                Par {{ $assignment->user->name }}
                                            </p>
                                            @if($assignment->notes)
                                                <p class="mt-2 text-xs text-gray-600 dark:text-gray-400 italic">{{ $assignment->notes }}</p>
                                            @endif
                                        </div>
                                        @if($assignment->isActive())
                                            <form method="POST" action="{{ route('assignments.return', $assignment) }}" class="ml-4">
                                                @csrf
                                                <x-button-secondary type="submit" class="!px-3 !py-1.5 text-xs">
                                                    Restituer
                                                </x-button-secondary>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">Aucune affectation enregistrée.</p>
                        @endif
                    </x-card>

                    <!-- Historique des maintenances -->
                    @if($equipment->maintenances->count() > 0)
                        <x-card title="Historique des maintenances">
                            <div class="space-y-4">
                                @foreach($equipment->maintenances->sortByDesc('reported_at') as $maintenance)
                                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $maintenance->description }}
                                                </p>
                                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                    Signalé le {{ $maintenance->reported_at->format('d/m/Y à H:i') }}
                                                    @if($maintenance->resolved_at)
                                                        • Résolu le {{ $maintenance->resolved_at->format('d/m/Y à H:i') }}
                                                    @endif
                                                </p>
                                                <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                                    Par {{ $maintenance->reportedBy->name }}
                                                    @if($maintenance->cost)
                                                        • Coût : {{ number_format((int)$maintenance->cost, 0, ',', ' ') }} dh
                                                    @endif
                                                </p>
                                            </div>
                                            <x-status-badge :status="$maintenance->status" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-card>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Photo de l'équipement -->
                    @if($equipment->image_path)
                        <x-card title="Photo">
                            <div class="overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800 p-2">
                                <img 
                                    src="{{ asset('storage/' . $equipment->image_path) }}" 
                                    alt="{{ $equipment->name }}" 
                                    class="w-full h-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow-lg object-contain cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-xl"
                                    @click="$dispatch('open-image-modal', { src: '{{ asset('storage/' . $equipment->image_path) }}', alt: '{{ $equipment->name }}' })"
                                >
                            </div>
                            <p class="mt-3 text-xs text-center text-gray-500 dark:text-gray-400">
                                Cliquez pour agrandir
                            </p>
                        </x-card>
                    @endif

                    <!-- Actions rapides -->
                    @if(auth()->user()->isSuperAdmin())
                        <x-card title="Actions">
                            <div class="space-y-2">
                                @if($equipment->status === 'available')
                                    <x-button-primary href="{{ route('assignments.create') }}?equipment_id={{ $equipment->id }}" class="w-full">
                                        Affecter
                                    </x-button-primary>
                                @endif
                                <x-button-secondary href="{{ route('equipments.edit', $equipment) }}" class="w-full">
                                    Modifier
                                </x-button-secondary>
                            </div>
                        </x-card>
                    @endif
                </div>
    </div>

    <!-- Modal pour agrandir l'image -->
    <div 
        x-data="{ 
            open: false, 
            imageSrc: '', 
            imageAlt: '',
            closeModal() {
                this.open = false;
                document.body.style.overflow = '';
            }
        }"
        @open-image-modal.window="open = true; imageSrc = $event.detail.src; imageAlt = $event.detail.alt; document.body.style.overflow = 'hidden'"
        @keydown.escape.window="closeModal()"
        @click.self="closeModal()"
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90 p-4"
        style="display: none;"
    >
        <div 
            class="relative max-w-5xl max-h-full"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <button 
                @click="closeModal()"
                class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-white rounded-full p-1"
                aria-label="Fermer"
            >
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img 
                :src="imageSrc" 
                :alt="imageAlt" 
                class="max-w-full max-h-[90vh] rounded-lg shadow-2xl object-contain"
            >
        </div>
    </div>
</x-app-layout>
