<?php

namespace App\Repository\Eloquent;

use App\Traits\FileManager;
use App\Repository\RepositoryInterface;
use Closure;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface
{
    use FileManager;

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(array $columns = ['*'], array $relations = [], Closure $addition = null , Closure $filters = null  , $orderBy = "ASC"): Collection
    {
        return $this->model->with($relations)->where(function ($query) use ($addition , $filters) {
            if ($addition !== null && !(auth()->user()->hasRole(['super-admin', 'admin']) || auth()->guard('api')->check())) {
                $addition($query);
            }
            if ($filters !== null && !auth()->guard('api')->check()){
                $filters($query);
            }
        })->orderBy('id', $orderBy)->get($columns);
    }

    public function getActive(array $columns = ['*'], array $relations = [], Closure $addition = null): Collection
    {
        return $this->model->with($relations)->where(function ($query) use ($addition) {
            if ($addition !== null && !(auth()->user()->hasRole(['super-admin', 'admin']) || auth()->guard('api')->check())) {
                return $addition($query);
            }
        })->where('is_active' , true)->get($columns);
    }

    public function getById($modelId, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        return $this->model::query()->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }

    public function get($byColumn, $value, array $columns = ['*'], array $relations = [], $orderBy = 'ASC'): array|Collection
    {
        return $this->model::query()->select($columns)->with($relations)->where($byColumn, $value)->orderBy('id', $orderBy)->get();
    }

    public function first($byColumn, $value, array $columns = ['*'], array $relations = [],): Builder|Model
    {
        return $this->model::query()->select($columns)->with($relations)->where($byColumn, $value)->first();
    }

    public function getFirst(): ?Model
    {
        return $this->model->first();
    }

    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);
        return $model->fresh();
    }

    public function insert(array $payload): bool
    {
        $model = $this->model::query()->insert($payload);
        return $model;
    }

    public function createMany(array $payload): bool
    {
        try
        {
            foreach ($payload as $record)
            {
                $this->model::query()->create($record);
            }
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function update($modelId, array $payload): bool
    {
        $model = $this->getById($modelId);
        return $model->update($payload);
    }

    public function delete($modelId, array $filesFields = []): bool
    {
        $model = $this->getById($modelId);
        foreach ($filesFields as $field)
        {
            if ($model->$field !== null)
            {
                $this->deleteFile($model->$field);
            }
        }
        return $model->delete();
    }

    public function paginate(int $perPage = 10, array $relations = [] , $orderBy = 'desc' , $columns = ['*'], $addition = null , $filter = null, $addition2 = null , $filter2 = null)
    {
        return $this->model::query()->select($columns)->with($relations)->orderBy('id' , $orderBy)->where($addition,$filter)->where($addition2,$filter2)->paginate($perPage);
    }

    public function whereHasMorph($relation, $class)
    {
        return $this->model::query()->whereHasMorph($relation, $class)->get();
    }

}
