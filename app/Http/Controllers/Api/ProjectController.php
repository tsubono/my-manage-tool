<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ProjectController
 *
 * @package App\Http\Controllers\Api
 */
class ProjectController extends Controller
{
    /**
     * @var Project
     */
    private $project;

    /**
     * @var ProjectStatus
     */
    private $projectStatus;

    /**
     * ProjectController constructor.
     *
     * @param Project $project
     * @param ProjectStatus $projectStatus
     */
    public function __construct(Project $project, ProjectStatus $projectStatus) {
        $this->project = $project;
        $this->projectStatus = $projectStatus;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $projects = $this->project->get();
        return response()->json(['projects' => $projects], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成 : TODO
     */
    public function store()
    {
        //
    }

    /**
     * 更新 : TODO
     */
    public function update()
    {
       //
    }

    /**
     * 削除 : TODO
     */
    public function destroy()
    {
       //
    }

    /**
     * プロジェクトのステータス一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatuses()
    {
        $statuses = $this->projectStatus->get();
        return response()->json($statuses, 200, [], JSON_PRETTY_PRINT);
    }


    /**
     * ステータスを更新する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatuses(Request $request)
    {
        DB::beginTransaction();
        try {
            $statuses = $request->get('statuses');
            $deleted_ids = $request->get('deleted_ids', []);
            foreach ($statuses as $status) {
                // ログイン中のユーザーを設定
                $status['user_id'] = auth()->user()->id;
                // idがnullの場合は新規登録
                if (is_null($status['id'])) {
                    $this->projectStatus->create($status);
                // idが入っている場合は更新
                } else {
                    $targetStatus = $this->projectStatus->find($status['id']);
                    $targetStatus->update($status);
                }
            }
            // 削除するidがあれば削除処理
            foreach ($deleted_ids as $deleted_id) {
                $this->projectStatus->findOrFail($deleted_id)->delete();
            }

            $response = ['status' => 'OK', 'statuses' => $this->projectStatus->get()];

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $response['status'] = 'NG';
            $response['message'] = $e->getMessage();
            return response()->json($response, 422, [], JSON_PRETTY_PRINT);
        }

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
