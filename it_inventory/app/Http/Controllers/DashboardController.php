<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Equipment;
use App\Models\Maintenance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        // KPIs
        $totalEquipments = Equipment::count();
        $availableEquipments = Equipment::available()->count();
        $assignedEquipments = Equipment::assigned()->count();
        $brokenEquipments = Equipment::broken()->count();

        // Garanties expirant dans moins de 30 jours
        $warrantyExpiringSoon = Equipment::whereNotNull('warranty_expires_at')
            ->where('warranty_expires_at', '>', now())
            ->where('warranty_expires_at', '<=', now()->addDays(30))
            ->count();

        // Dernières activités (assignments récents)
        $recentActivities = Assignment::with(['equipment', 'employee', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Maintenances actives
        $activeMaintenances = Maintenance::whereIn('status', ['open', 'in_progress'])
            ->with('equipment')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'totalEquipments' => $totalEquipments,
            'availableEquipments' => $availableEquipments,
            'assignedEquipments' => $assignedEquipments,
            'brokenEquipments' => $brokenEquipments,
            'warrantyExpiringSoon' => $warrantyExpiringSoon,
            'recentActivities' => $recentActivities,
            'activeMaintenances' => $activeMaintenances,
        ]);
    }
}
