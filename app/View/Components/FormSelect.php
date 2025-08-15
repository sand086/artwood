<?php

namespace App\View\Components;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class FormSelect extends Component
{
    public $label;
    public $name;
    public $id;
    public $table;
    public $valueField;
    public $labelField;
    public $where;
    public $orderBy;
    public $placeholder;
    public $dependentOn;
    public $parentIdField;
    public $options;

    public function __construct($label, $name, $id, $table, $valueField, $labelField, $where = [], $orderBy = [], $placeholder = null, $dependentOn = null, $parentIdField = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->table = $table;
        $this->valueField = $valueField;
        $this->labelField = $labelField;
        $this->where = $where;
        $this->orderBy = $orderBy;
        $this->placeholder = $placeholder;
        
        // Datos para tablas dependientes
        $this->dependentOn = $dependentOn;
        $this->parentIdField = $parentIdField;

        $this->options = new Collection(); // Inicializar como una colección vacía;
    }

    public function render()
    {
        return view('components.form-select');
    }
}