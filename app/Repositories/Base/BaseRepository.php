<?php

namespace App\Repositories\Base;

use BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{

    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function delete(int $id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function restore(int $id)
    {
        if (! method_exists($this->model, 'restore')) {
            throw new \Exception('Model does not support restore()');
        }

        return $this->model->withTrashed()->findOrFail($id)->restore();
    }
}
