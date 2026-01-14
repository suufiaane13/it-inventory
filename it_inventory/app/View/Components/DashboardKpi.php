<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardKpi extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public string|int $value,
        public ?string $icon = null,
        public ?string $color = 'indigo',
        public ?string $subtitle = null,
    ) {
        //
    }

    /**
     * Get the color classes
     */
    public function getColorClasses(): string
    {
        return match ($this->color) {
            'indigo' => 'bg-indigo-500',
            'blue' => 'bg-blue-500',
            'green' => 'bg-green-500',
            'red' => 'bg-red-500',
            'yellow' => 'bg-yellow-500',
            'purple' => 'bg-purple-500',
            default => 'bg-indigo-500',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard-kpi');
    }
}
