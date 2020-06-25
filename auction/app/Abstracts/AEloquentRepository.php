<?php
namespace App\Abstracts;

abstract class AEloquentRepository
{
    public function all(){
        return $this->model->all();
    }

    public function create(array $data){
        return $this->model->create($data);
    }

    public function update(array $data, $id){
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete($id){
        return $this->model->destroy($id);
    }

    public function find($id){
        return $this->model->findOrFail($id);
    }

    public function findByColumn($column_name, $value)
    {
        return $this->model->where($column_name, '=', $value);
    }
}
