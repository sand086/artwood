<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function cotizaciones()
    {
        // recopila datos para el dashboard de cotizaciones
        return view('dashboard.cotizaciones');
    }

    public function proyectos()
    {
        // recopila datos para el dashboard de proyectos
        return view('dashboard.proyectos');
    }

    public function configuraciones()
    {
        // recopila datos para el dashboard de configuraciones
        return view('dashboard.configuraciones');
    }
}
