<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ButtonDanger extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $href = null,
        public string $type = 'button',
        public ?string $icon = null,
        public bool $disabled = false,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button-danger');
    }
}
