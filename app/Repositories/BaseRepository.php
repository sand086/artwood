<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Exception; // Importamos la clase Exception

// Creamos nuestras clases de excepciones personalizadas
class RecordCreationFailedException extends Exception {}
class RecordUpdateFailedException extends Exception {}
class RecordDeletionFailedException extends Exception {}

abstract class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        try {
            return $this->model->create($data);
        } catch (\Exception $e) {
            // Ahora lanzamos nuestra excepción personalizada
            throw new RecordCreationFailedException("Error al crear el registro: " . $e->getMessage());
        }
    }

    public function update(Model $model, array $data): bool
    {
        try {
            return $model->update($data);
        } catch (\Exception $e) {
            // También para el método update
            throw new RecordUpdateFailedException("Error al actualizar el registro: " . $e->getMessage());
        }
    }

    public function delete(Model $model)
    {
        try {
            return $model->delete();
        } catch (\Exception $e) {
            // Y para el método delete
            throw new RecordDeletionFailedException("Error al eliminar el registro: " . $e->getMessage());
        }
    }

    abstract public function queryDataTable(): Builder;
}