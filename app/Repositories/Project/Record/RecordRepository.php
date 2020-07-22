<?php

namespace App\Repositories\Project\Record;

use App\Models\ProjectRecord;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RecordRepository
 *
 * @package App\Repositories\Project\Record
 */
class RecordRepository implements RecordRepositoryInterface
{
    /**
     * @var ProjectRecord
     */
    private $projectRecord;


    public function __construct(ProjectRecord $projectRecord) {
        $this->projectRecord = $projectRecord;
    }

    /**
     * 案件レコードを全件取得する
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->projectRecord->orderBy('start_at', 'desc')->get();
    }

    /**
     * 案件レコードを1件取得する
     *
     * @param int $id
     * @return ProjectRecord
     */
    public function getOne(int $id): ProjectRecord
    {
        return $this->projectRecord->find($id);
    }

    /**
     * 案件レコードを登録する
     *
     * @param array $data
     * @return ProjectRecord
     * @throws \Exception
     */
    public function store(array $data): ProjectRecord
    {
        // 案件レコード登録
        $projectRecord = $this->projectRecord->create($data);
        return $projectRecord;
    }

    /**
     * 案件レコードを更新する
     *
     * @param int $id
     * @param array $data
     * @return ProjectRecord
     */
    public function update(int $id, array $data): ProjectRecord
    {
        $projectRecord = $this->projectRecord->findOrFail($id);
        // 案件レコード更新
        $projectRecord->update($data);

        return $projectRecord;
    }

    /**
     * 案件レコードを削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $projectRecord = $this->projectRecord->findOrFail($id);
        $projectRecord->delete();
    }
}
