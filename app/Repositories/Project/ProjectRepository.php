<?php

namespace App\Repositories\Project;

use App\Models\Project;
use App\Models\Label;
use App\Models\ProjectStatus;
use App\Models\Subcontractor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class ProjectRepository
 *
 * @package App\Repositories\Project
 */
class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * @var Project
     */
    private $project;

    /**
     * @var Label
     */
    private $label;

    /**
     * @var ProjectStatus
     */
    private $status;

    /**
     * @var Subcontractor
     */
    private $subcontractor;

    public function __construct(Project $project, Label $label, ProjectStatus $status, Subcontractor $subcontractor) {
        $this->project = $project;
        $this->label = $label;
        $this->status = $status;
        $this->subcontractor = $subcontractor;
    }

    /**
     * 案件を検索取得する
     *
     * @param array $searchForm
     * @return Collection
     */
    public function getList(array $searchForm): Collection
    {
        $query = $this->project->query();
        !empty($searchForm['name']) && $query->where('name', 'LIKE', "%{$searchForm['name']}%");
        !empty($searchForm['status_id']) && $query->where('status_id', $searchForm['status_id']);
        if (!empty($searchForm['labels'])) {
            $label_ids = array_column($searchForm['labels'], 'id');
            $query->whereHas('labels', function($query) use ($label_ids) {
                $query->whereIn('labels.id', $label_ids);
            });
        }
        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * 案件を1件取得する
     *
     * @param int $id
     * @return Project
     */
    public function getOne(int $id): Project
    {
        return $this->project->find($id);
    }

    /**
     * 案件を登録する
     *
     * @param array $data
     * @return Project
     * @throws \Exception
     */
    public function store(array $data): Project
    {
        DB::beginTransaction();
        try {
            // 案件登録
            $project = $this->project->create($data);
            // ラベル更新
            $this->updateLabels($project, $data);
            // 外注先更新
            $this->updateSubcontractors($project, $data);

            DB::commit();

            return $project;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new \Exception($e);
        }
    }

    /**
     * 案件を更新する
     *
     * @param int $id
     * @param array $data
     * @return Project
     * @throws \Exception
     */
    public function update(int $id, array $data): Project
    {
        DB::beginTransaction();
        try {
            $project = $this->project->findOrFail($id);
            // 案件更新
            $project->update($data);
            // ラベル更新
            $this->updateLabels($project, $data);
            // 外注先更新
            $this->updateSubcontractors($project, $data);

            DB::commit();

            return $project;

        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new \Exception($e);
        }
    }

    /**
     * 案件を削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $project = $this->project->findOrFail($id);
        $project->delete();
    }

    /**
     * 案件ステータスを更新する
     *
     * @param array $statuses
     * @param array $deleted_ids
     * @return Collection|null
     * @throws \Exception
     */
    public function updateStatuses(array $statuses, array $deleted_ids): ?Collection
    {
        DB::beginTransaction();
        try {
            foreach ($statuses as $status) {
                // idがnullの場合は新規登録
                if (empty($status['id'])) {
                    $this->status->create($status);
                    // idが入っている場合は更新
                } else {
                    $targetStatus = $this->status->find($status['id']);
                    $targetStatus->update($status);
                }
            }
            // 削除するidがあれば削除処理
            foreach ($deleted_ids as $deleted_id) {
                $this->status->findOrFail($deleted_id)->delete();
            }

            DB::commit();

            return $this->status->get();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new \Exception($e);
        }
    }

    /**
     * 案件ラベルを更新する
     *
     * @param Project $project
     * @param array $data
     */
    private function updateLabels(Project &$project, array $data)
    {
        $label_ids = [];
        if (!empty($data['labels'])) {
            foreach ($data['labels'] as $labelData) {
                $label = $this->label->find($labelData['id']);
                if (!empty($label)) {
                    $label->update($labelData);
                } else {
                    $labelData['type'] = Label::TYPE_PROJECT;
                    $label = $this->label->create($labelData);
                }
                $label_ids[] = $label->id;
            }
        }
        $project->labels()->sync($label_ids);
    }

    /**
     * 外注先を更新する
     *
     * @param Project $project
     * @param array $data
     */
    private function updateSubcontractors(Project &$project, array $data)
    {
        $subcontractors = [];
        if (!empty($data['subcontractors'])) {
            foreach ($data['subcontractors'] as $subcontractorData) {
                $subcontractors[$subcontractorData['subcontractor']['id']] = [];
                $subcontractors[$subcontractorData['subcontractor']['id']]['price'] = $subcontractorData['price'];
            }
        }
        $project->subcontractors()->sync($subcontractors);
    }
}
