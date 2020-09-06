<?php

namespace App\Repositories\Subcontractor;

use App\Models\Subcontractor;
use App\Models\Label;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class SubcontractorRepository
 *
 * @package App\Repositories\Subcontractor
 */
class SubcontractorRepository implements SubcontractorRepositoryInterface
{
    /**
     * @var Subcontractor
     */
    private $subcontractor;

    /**
     * @var Label
     */
    private $label;

    public function __construct(Subcontractor $subcontractor, Label $label) {
        $this->subcontractor = $subcontractor;
        $this->label = $label;
    }

    /**
     * 外注先を検索取得する
     *
     * @param array $searchForm
     * @return Collection
     */
    public function getList(array $searchForm): Collection
    {
        $query = $this->subcontractor->query();
        !empty($searchForm['name']) && $query->where('name', 'LIKE', "%{$searchForm['name']}%");
        if (!empty($searchForm['labels'])) {
            $label_ids = array_column($searchForm['labels'], 'id');
            $query->whereHas('labels', function($query) use ($label_ids) {
                $query->whereIn('labels.id', $label_ids);
            });
        }
        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * 外注先を1件取得する
     *
     * @param int $id
     * @return Subcontractor
     */
    public function getOne(int $id): Subcontractor
    {
        return $this->subcontractor->find($id);
    }

    /**
     * 外注先を登録する
     *
     * @param array $data
     * @return Subcontractor
     * @throws \Exception
     */
    public function store(array $data): Subcontractor
    {
        DB::beginTransaction();
        try {
            // 外注先登録
            $subcontractor = $this->subcontractor->create($data);
            // ラベル更新
            $this->updateLabels($subcontractor, $data);

            DB::commit();

            return $subcontractor;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new \Exception($e);
        }
    }

    /**
     * 外注先を更新する
     *
     * @param int $id
     * @param array $data
     * @return Subcontractor
     * @throws \Exception
     */
    public function update(int $id, array $data): Subcontractor
    {
        DB::beginTransaction();
        try {
            $subcontractor = $this->subcontractor->findOrFail($id);
            // 外注先更新
            $subcontractor->update($data);
            // ラベル更新
            $this->updateLabels($subcontractor, $data);

            DB::commit();

            return $subcontractor;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new \Exception($e);
        }
    }

    /**
     * 外注先を削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $subcontractor = $this->subcontractor->findOrFail($id);
        $subcontractor->delete();
    }

    /**
     * ラベルを更新する
     *
     * @param Subcontractor $subcontractor
     * @param array $data
     */
    private function updateLabels(Subcontractor &$subcontractor, array $data)
    {
        $label_ids = [];
        if (!empty($data['labels'])) {
            foreach ($data['labels'] as $labelData) {
                $label = $this->label->find($labelData['id']);
                if (!empty($label)) {
                    $label->update($labelData);
                } else {
                    $labelData['type'] = Label::TYPE_SUBCONTRACTOR;
                    $label = $this->label->create($labelData);
                }
                $label_ids[] = $label->id;
            }
        }
        $subcontractor->labels()->sync($label_ids);
    }
}
