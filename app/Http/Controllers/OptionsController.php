<?php

namespace App\Http\Controllers; // O el namespace correcto, ej: App\Http\Controllers\Api

// Asegúrate de que la clase se llame OptionsController si así se llama tu archivo.
// Si está en una subcarpeta Api, el namespace sería App\Http\Controllers\Api
// y la clase class OptionsController extends Controller

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller; // Si no está ya en el namespace base

class OptionsController extends Controller // Asegúrate que hereda de Controller
{
    public function getOptions(Request $request, $table)
    {
        // Verificar si la tabla o vista existe
        if (!Schema::hasTable($table) && !Schema::hasView($table)) {
            return response()->json(['error' => "Tabla o vista '{$table}' no encontrada."], 404);
        }

        $valueField = $request->query('valueField');
        $labelField = $request->query('labelField');
        $populateSourceKeys = $request->query('populateSourceKeys', []);

        if (!$valueField || !$labelField) {
            return response()->json(['error' => 'valueField y labelField son requeridos'], 400);
        }

        $tableColumns = Schema::getColumnListing($table);
        if (!in_array($valueField, $tableColumns) || !in_array($labelField, $tableColumns)) {
            return response()->json(['error' => 'valueField o labelField no existen en la tabla'], 400);
        }
        foreach ($populateSourceKeys as $key) {
            if (!empty($key) && !in_array($key, $tableColumns)) {
                return response()->json(['error' => "populateSourceKey '{$key}' no existe en la tabla"], 400);
            }
        }

        $query = DB::table($table);

        $staticWhereConditions = $request->query('where', []);
        if (is_array($staticWhereConditions)) {
            foreach ($staticWhereConditions as $column => $value) {
                if (in_array($column, $tableColumns)) {
                    if (is_array($value)) {
                        $query->whereIn($column, $value);
                    } else if ($value === 'IS NULL' || $value === 'ISNULL' || 
                                $value === 'is null' || $value === 'isnull') {
                        $query->whereNull($column);
                    } else if ($value === 'IS NOT NULL' || $value === 'ISNOTNULL' || 
                                $value === 'is not null' || $value === 'isnotnull') {
                        $query->whereNotNull($column);
                    } else {
                        $query->where($column, $value);
                    }
                }
            }
        }

        // Aplicar condiciones de los 'selects' padres
        // parentConditions llegará como ['nombre_columna_padre1' => 'valor1', 'nombre_columna_padre2' => 'valor2']
        $parentConditions = $request->query('parentConditions', []);
        if (is_array($parentConditions)) {
            foreach ($parentConditions as $parentColumnName => $parentValue) {
                // Aplicar la condición solo si el padre tiene un valor y la columna existe
                if ($parentValue !== null && $parentValue !== '' && in_array($parentColumnName, $tableColumns)) {
                    $query->where($parentColumnName, $parentValue);
                } else if ($parentValue === null || $parentValue === '') {
                    // Si un campo padre es requerido (implícitamente por estar en parentConditions)
                    // pero no tiene valor, no debería devolver resultados.
                    // El JS ya previene la llamada si un padre está vacío, pero esto es un seguro.
                    return response()->json([]); // Devuelve un array vacío, el select se mostrará sin opciones.
                }
            }
        }

        $orderByColumn = $request->query('orderByColumn');
        $orderByDirection = $request->query('orderByDirection', 'asc');
        if ($orderByColumn && in_array($orderByColumn, $tableColumns)) {
            $query->orderBy($orderByColumn, $orderByDirection);
        }

        $selectFields = array_unique(array_filter(array_merge([$valueField, $labelField], $populateSourceKeys)));
        $query->select($selectFields);

        try {
            $options = $query->get();
            return response()->json($options);
        } catch (\Illuminate\Database\QueryException $e) {
            // Considera loggear el error: Log::error("Error en OptionsController: " . $e->getMessage());
            return response()->json(['error' => 'Error al consultar la base de datos.'], 500);
        }
    }
}

