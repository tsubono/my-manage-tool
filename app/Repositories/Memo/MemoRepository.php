<?php

namespace App\Repositories\Memo;

use App\Models\Memo;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class MemoRepository
 *
 * @package App\Repositories\Memo
 */
class MemoRepository implements MemoRepositoryInterface
{
    /**
     * @var Memo
     */
    private $memo;

    public function __construct(Memo $memo) {
        $this->memo = $memo;
    }

    /**
     * メモを全件取得する
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->memo->get();
    }

    /**
     * メモを1件取得する
     *
     * @param int $id
     * @return Memo
     */
    public function getOne(int $id): Memo
    {
        return $this->memo->find($id);
    }

    /**
     * メモを登録する
     *
     * @param array $data
     * @return Memo
     */
    public function store(array $data): Memo
    {
        $memo = $this->memo->create($data);
        return $memo;
    }

    /**
     * メモを更新する
     *
     * @param int $id
     * @param array $data
     * @return Memo
     */
    public function update(int $id, array $data): Memo
    {
        $memo = $this->memo->findOrFail($id);
        $memo->update($data);
        return $memo;
    }

    /**
     * メモを削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $memo = $this->memo->findOrFail($id);
        $memo->delete();
    }
}
