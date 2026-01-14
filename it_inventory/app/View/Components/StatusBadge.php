<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusBadge extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $status,
    ) {
        //
    }

    /**
     * Get the color classes based on status
     */
    public function getColorClasses(): string
    {
        return match ($this->status) {
            'available' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border-green-200 dark:border-green-800',
            'assigned' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 border-blue-200 dark:border-blue-800',
            'broken' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 border-red-200 dark:border-red-800',
            'scrapped' => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-600',
            'open' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800',
            'in_progress' => 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 border-indigo-200 dark:border-indigo-800',
            'resolved' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border-green-200 dark:border-green-800',
            default => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-600',
        };
    }

    /**
     * Get the label based on status
     */
    public function getLabel(): string
    {
        return match ($this->status) {
            'available' => 'Disponible',
            'assigned' => 'Affecté',
            'broken' => 'En Panne',
            'scrapped' => 'Rebut',
            'open' => 'Ouvert',
            'in_progress' => 'En Cours',
            'resolved' => 'Résolu',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.status-badge');
    }
}
