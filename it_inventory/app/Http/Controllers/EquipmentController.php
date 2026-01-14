<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Equipment::with(['category', 'currentAssignment.employee']);

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('serial_number', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Filtre par catégorie
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $equipments = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('equipments.index', compact('equipments', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('equipments.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Upload image
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('equipments', 'public');
        }

        Equipment::create($data);

        return redirect()->route('equipments.index')
            ->with('success', 'Équipement créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment): View
    {
        $equipment->load(['category', 'assignments.employee', 'assignments.user', 'maintenances.reportedBy']);
        return view('equipments.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment): View
    {
        $categories = Category::all();
        return view('equipments.edit', compact('equipment', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment): RedirectResponse
    {
        $data = $request->validated();

        // Upload nouvelle image
        if ($request->hasFile('image')) {
            // Supprimer ancienne image
            if ($equipment->image_path) {
                Storage::disk('public')->delete($equipment->image_path);
            }
            $data['image_path'] = $request->file('image')->store('equipments', 'public');
        }

        $equipment->update($data);

        return redirect()->route('equipments.index')
            ->with('success', 'Équipement mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment): RedirectResponse
    {
        // Supprimer l'image si elle existe
        if ($equipment->image_path) {
            Storage::disk('public')->delete($equipment->image_path);
        }

        $equipment->delete();

        return redirect()->route('equipments.index')
            ->with('success', 'Équipement supprimé avec succès.');
    }
}
