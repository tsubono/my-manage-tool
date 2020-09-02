<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\ProjectStatusRequest;
use App\Models\ProjectStatus;
use App\Repositories\Project\ProjectRepositoryInterface as ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class ProjectController
 *
 * @package App\Http\Controllers\Api
 */
class ProjectController extends Controller
{
    /**
     * @var ProjectStatus
     */
    private $projectStatus;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * ProjectController constructor.
     *
     * @param ProjectStatus $projectStatus
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectStatus $projectStatus, ProjectRepository $projectRepository) {
        $this->projectStatus = $projectStatus;
        $this->projectRepository = $projectRepository;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $searchForm = $request->get('searchForm');
        $projects = $this->projectRepository->getList(json_decode($searchForm, true));

        return response()->json(['projects' => $projects], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $project = $this->projectRepository->getOne($id);

        if (empty($project)) {
            return response()->json([], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json($project, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param ProjectRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->all();
        $project = $this->projectRepository->store($data);

        return response()->json(['project' => $project], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 更新
     *
     * @param ProjectRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProjectRequest $request, int $id)
    {
        $data = $request->all();
        $project = $this->projectRepository->update($id, $data);

        return response()->json(['project' => $project], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->projectRepository->destroy($id);

        return response()->noContent();
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
     * @param ProjectStatusRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatuses(ProjectStatusRequest $request)
    {
        $statuses = $this->projectRepository->updateStatuses(
            $request->get('statuses'),
            $request->get('deleted_ids', [])
        );
        return response()->json(['status' => 'OK', 'statuses' => $statuses], 200, [], JSON_PRETTY_PRINT);
    }
}
