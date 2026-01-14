<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Equipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    /**
     * Show the form for creating a new assignment.
     */
    public function create(): View
    {
        $equipments = Equipment::available()->with('category')->get();
        $employees = Employee::with('department')->orderBy('last_name')->get();

        return view('assignments.create', compact('equipments', 'employees'));
    }

    /**
     * Store a newly created assignment.
     */
    public function store(StoreAssignmentRequest $request): RedirectResponse
    {
        $equipment = Equipment::findOrFail($request->equipment_id);

        // Vérifier que l'équipement est disponible
        if ($equipment->status !== 'available') {
            return back()->withErrors(['equipment_id' => 'Cet équipement n\'est pas disponible.'])
                ->withInput();
        }

        // Créer l'assignation
        Assignment::create([
            'equipment_id' => $request->equipment_id,
            'employee_id' => $request->employee_id,
            'user_id' => auth()->id(),
            'assigned_at' => now(),
            'notes' => $request->notes,
        ]);

        // Mettre à jour le statut de l'équipement
        $equipment->update(['status' => 'assigned']);

        return redirect()->route('equipments.index')
            ->with('success', 'Équipement affecté avec succès.');
    }

    /**
     * Return an equipment (check-in).
     */
    public function return(Assignment $assignment): RedirectResponse
    {
        // Vérifier que l'assignation est active
        if ($assignment->returned_at) {
            return back()->withErrors(['error' => 'Cet équipement a déjà été restitué.']);
        }

        // Mettre à jour l'assignation
        $assignment->update(['returned_at' => now()]);

        // Mettre à jour le statut de l'équipement
        $assignment->equipment->update(['status' => 'available']);

        return redirect()->route('equipments.show', $assignment->equipment)
            ->with('success', 'Équipement restitué avec succès.');
    }
}
