<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectStatus;

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
        $projects = $this->project->all();
        return response()->json(['projects' => $projects], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $project = $this->project->query()->find($id);
        if (empty($project)) {
            return response()->json([], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json($project, 200, [], JSON_PRETTY_PRINT);
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
        $statuses = $this->projectStatus->all();
        return response()->json($statuses, 200, [], JSON_PRETTY_PRINT);
    }
}
