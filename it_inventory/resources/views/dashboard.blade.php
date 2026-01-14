<x-app-layout>
    <x-page-header 
        title="Tableau de Bord" 
        subtitle="Vue d'ensemble de votre parc informatique"
    />

    <div class="mx-auto max-w-7xl">
        <!-- KPIs -->
        <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <x-dashboard-kpi
                    title="Total Équipements"
                    :value="$totalEquipments"
                    icon="computer-desktop"
                    color="indigo"
                />
                <x-dashboard-kpi
                    title="En Stock"
                    :value="$availableEquipments"
                    icon="archive-box"
                    color="green"
                />
                <x-dashboard-kpi
                    title="Affectés"
                    :value="$assignedEquipments"
                    icon="user-group"
                    color="blue"
                />
                <x-dashboard-kpi
                    title="En Panne"
                    :value="$brokenEquipments"
                    icon="exclamation-triangle"
                    color="red"
                />
            </div>

            <!-- Alertes Garanties -->
            @if($warrantyExpiringSoon > 0)
                <div class="mb-8">
                    <div class="rounded-xl border border-yellow-200 dark:border-yellow-800 bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 p-5 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-yellow-400 to-yellow-500 shadow-sm">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-yellow-900 dark:text-yellow-300">Attention : Garanties expirantes</h3>
                                <p class="mt-1 text-sm text-yellow-800 dark:text-yellow-400">
                                    <span class="font-bold">{{ $warrantyExpiringSoon }}</span> garantie(s) expirant dans moins de 30 jours
                                </p>
                                <a href="{{ route('equipments.index', ['filter' => 'warranty_expiring']) }}" class="mt-3 inline-flex items-center gap-2 text-sm font-medium text-yellow-700 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300 transition-colors duration-200">
                                    Voir les équipements concernés
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Dernières Activités -->
                <x-card title="Dernières Activités">
                    <div class="space-y-3">
                        @forelse($recentActivities as $activity)
                            <a href="{{ route('equipments.show', $activity->equipment) }}" class="group flex items-start gap-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 transition-all duration-200 hover:border-indigo-300 dark:hover:border-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:shadow-sm">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-600 shadow-sm">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 group-hover:text-indigo-700 dark:group-hover:text-indigo-300">
                                        {{ $activity->equipment->name }}
                                    </p>
                                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                                        Assigné à <span class="font-medium">{{ $activity->employee->full_name }}</span>
                                    </p>
                                    <p class="mt-1.5 flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Par {{ $activity->user->name }} • {{ $activity->assigned_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="shrink-0">
                                    <x-status-badge :status="$activity->equipment->status" />
                                </div>
                            </a>
                        @empty
                            <div class="py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-4 text-sm font-medium text-gray-900 dark:text-gray-100">Aucune activité récente</p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Les nouvelles affectations apparaîtront ici</p>
                            </div>
                        @endforelse
                    </div>
                </x-card>

                <!-- Maintenances Actives -->
                <x-card title="Maintenances Actives">
                    <div class="space-y-3">
                        @forelse($activeMaintenances as $maintenance)
                            <a href="{{ route('maintenances.show', $maintenance) }}" class="group flex items-start gap-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 transition-all duration-200 hover:border-red-300 dark:hover:border-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 hover:shadow-sm">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-red-500 to-red-600 shadow-sm">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 group-hover:text-red-700 dark:group-hover:text-red-400">
                                        {{ $maintenance->equipment->name }}
                                    </p>
                                    <p class="mt-1 line-clamp-2 text-xs text-gray-600 dark:text-gray-400">
                                        {{ Str::limit($maintenance->description, 80) }}
                                    </p>
                                    <p class="mt-1.5 flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Signalé {{ $maintenance->reported_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="shrink-0">
                                    <x-status-badge :status="$maintenance->status" />
                                </div>
                            </a>
                        @empty
                            <div class="py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="mt-4 text-sm font-medium text-gray-900 dark:text-gray-100">Aucune maintenance active</p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Toutes les maintenances sont résolues</p>
                            </div>
                        @endforelse
                    </div>
                </x-card>
            </div>
    </div>
</x-app-layout>
