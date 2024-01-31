<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository
{
    public function __construct(protected Model $baseModel)
    {
    }

    public function all(): Collection
    {
        return $this->baseModel::all();
    }

    public function create($data): Model
    {
        return $this->baseModel::create($data);
    }

    public function update($id, $data): void
    {
        $this->baseModel::findOrFail($id)->update($data);
    }

    public function delete($id): void
    {
        $this->baseModel::findOrFail($id)->delete();
    }
}
