<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableActions extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $showRoute = null,
        public ?string $editRoute = null,
        public ?string $deleteRoute = null,
        public ?string $deleteMessage = null,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-actions');
    }
}
