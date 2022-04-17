<?php

namespace app\includes\interfaces;

use app\includes\Model;

interface Repository
{
    public function findOne($where=null, $table=null, $return_class_type=null, $fetched_data=null): ?Model;

    public function findAll($table=null, $where=null, $return_class_type=null, $sql=null): array;

    public function findManyToMany($table, $on_params_with_pivot, $on_params_with_target, $return_class_type, $where=null): array;

    public function findOrFail($where=null, $table=null, $return_class_type=null, $fetched_data=null);

    public function findById($id);

    public function query($clause, string $target_clause=null, $where=null, $param=null): bool;

    public function create($attributes): bool;

    public function update(): bool;

    public function delete($where=null): bool;
}