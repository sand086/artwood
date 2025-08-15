<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class modal extends Component
{
    public $id;
    public $formId;
    public $showSaveButton;
    public $showCancelButton;
    public $showClearButton;

    public $size; // Modal tamaño

    /**
     * Create a new component instance.
     */
    public function __construct($id, $formId = null, $showSaveButton = true, $showCancelButton = true, $showClearButton = true, $size = 'md')
    {
        $this->id = $id;
        $this->formId = $formId;
        $this->showSaveButton = $showSaveButton;
        $this->showCancelButton = $showCancelButton;
        $this->showClearButton = $showClearButton;
        $this->size = $size; // Si no se especifica, será "md"
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
