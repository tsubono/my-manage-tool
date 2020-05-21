<?php

namespace App\Repositories\Todo;

use App\Models\Todo;
use Carbon\Carbon;
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
        return $this->todo
            ->orderBy('limit_datetime', 'asc')
            ->get();
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

    /**
     * 期限が近い / 過去のTODOを取得する
     *
     * @return Collection
     */
    public function getCurrent(): Collection
    {
        $limitWarningDays = Carbon::now()->addDays(Todo::LIMIT_WARNING_DAYS);
        return $this->todo
            ->where('limit_datetime', '<', $limitWarningDays)
            ->orderBy('limit_datetime', 'asc')
            ->get();
    }

    /**
     * ステータスを更新する (true or false)
     *
     * @param int $id
     * @param bool $status
     * @return Todo
     */
    public function toggleStatus(int $id, bool $status): Todo
    {
        $todo = $this->todo->findOrFail($id);
        $todo->update([
            'status' => $status
        ]);
        return $todo;
    }
}
