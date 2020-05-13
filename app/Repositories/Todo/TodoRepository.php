<?php

namespace App\Repositories\Todo;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TodoRepository
 *
 * @package App\Repositories\Todo
 */
class TodoRepository implements TodoRepositoryInterface
{
    /**
     * @var Todo
     */
    private $todo;

    public function __construct(Todo $todo) {
        $this->todo = $todo;
    }

    /**
     * TODOを全件取得する
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->todo->get();
    }

    /**
     * TODOを1件取得する
     *
     * @param int $id
     * @return Todo
     */
    public function getOne(int $id): Todo
    {
        return $this->todo->find($id);
    }

    /**
     * TODOを登録する
     *
     * @param array $data
     * @return Todo
     */
    public function store(array $data): Todo
    {
        $todo = $this->todo->create($data);
        return $todo;
    }

    /**
     * TODOを更新する
     *
     * @param int $id
     * @param array $data
     * @return Todo
     */
    public function update(int $id, array $data): Todo
    {
        $todo = $this->todo->findOrFail($id);
        $todo->update($data);
        return $todo;
    }

    /**
     * TODOを削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $todo = $this->todo->findOrFail($id);
        $todo->delete();
    }
}
