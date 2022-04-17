<?php

namespace app\admin\repository;

use app\includes\interfaces\Repository;
use app\includes\Model;

class BaseRepository implements Repository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findOne($where = null, $table = null, $return_class_type = null, $fetched_data = null): ?Model
    {
        return $this->model::findOne($where, $table, $return_class_type, $fetched_data);
    }

    public function findAll($table = null, $where = null, $return_class_type = null, $sql = null): array
    {
        return $this->model::findAll($table, $where, $return_class_type, $sql);
    }

    public function findManyToMany($table, $on_params_with_pivot, $on_params_with_target, $return_class_type, $where = null): array
    {
        return $this->model->findManyToMany($table, $on_params_with_pivot, $on_params_with_target, $return_class_type, $where);
    }

    public function findOrFail($where = null, $table = null, $return_class_type = null, $fetched_data = null)
    {
        return $this->model::findOrFail($where, $table, $return_class_type, $fetched_data);
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    public function query($clause, string $target_clause = null, $where = null, $param=null): bool
    {
        return $this->model->query($clause, $target_clause, $where, $param);
    }

    public function create($attributes): bool
    {
        return $this->model->create($attributes);
    }

    public function update(): bool
    {
        return $this->model->update();
    }

    public function delete($where=null): bool
    {
        return $this->model->delete($where);
    }
}