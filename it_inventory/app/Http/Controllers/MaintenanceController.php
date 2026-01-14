<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaintenanceRequest;
use App\Http\Requests\UpdateMaintenanceRequest;
use App\Models\Equipment;
use App\Models\Maintenance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Maintenance::with(['equipment', 'reportedBy']);

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('equipment', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        $maintenances = $query->latest('reported_at')->paginate(15);

        return view('maintenances.index', compact('maintenances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $equipments = Equipment::with('category')
            ->whereIn('status', ['available', 'assigned', 'broken'])
            ->get();
        
        $selectedEquipmentId = $request->get('equipment_id');
        
        return view('maintenances.create', compact('equipments', 'selectedEquipmentId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaintenanceRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $maintenance = Maintenance::create([
            'equipment_id' => $validated['equipment_id'],
            'reported_by' => auth()->id(),
            'description' => $validated['description'],
            'status' => 'open',
            'reported_at' => now(),
        ]);

        // Mettre à jour le statut de l'équipement
        $maintenance->equipment->update(['status' => 'broken']);

        return redirect()->route('maintenances.index')
            ->with('success', 'Maintenance signalée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance): View
    {
        $maintenance->load(['equipment', 'reportedBy']);
        return view('maintenances.show', compact('maintenance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance): View
    {
        return view('maintenances.edit', compact('maintenance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaintenanceRequest $request, Maintenance $maintenance): RedirectResponse
    {
        $validated = $request->validated();

        $data = $validated;

        // Si on passe à résolu, enregistrer la date
        if ($validated['status'] === 'resolved' && $maintenance->status !== 'resolved') {
            $data['resolved_at'] = now();
            // Remettre l'équipement en disponible si c'était en panne
            if ($maintenance->equipment->status === 'broken') {
                $maintenance->equipment->update(['status' => 'available']);
            }
        }

        $maintenance->update($data);

        return redirect()->route('maintenances.index')
            ->with('success', 'Maintenance mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance): RedirectResponse
    {
        $maintenance->delete();

        return redirect()->route('maintenances.index')
            ->with('success', 'Maintenance supprimée avec succès.');
    }
}
