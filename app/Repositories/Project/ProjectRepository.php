<?php

namespace App\Repositories\Project;

use App\Models\Project;
use App\Models\Label;
use App\Models\ProjectStatus;
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

    public function __construct(Project $project, Label $label, ProjectStatus $status) {
        $this->project = $project;
        $this->label = $label;
        $this->status = $status;
    }

    /**
     * 案件を全件取得する
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->project->orderBy('created_at', 'desc')->get();
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
}
