<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRecordRequest;
use App\Repositories\Project\Record\RecordRepositoryInterface as RecordRepository;

/**
 * Class ProjectRecordController
 *
 * @package App\Http\Controllers\Api
 */
class ProjectRecordController extends Controller
{
    /**
     * @var RecordRepository
     */
    private $recordRepository;

    /**
     * ClientController constructor.
     *
     * @param RecordRepository $recordRepository
     */
    public function __construct(RecordRepository $recordRepository) {
        $this->recordRepository = $recordRepository;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $projectRecords = $this->recordRepository->getAll();

        return response()->json(['projectRecords' => $projectRecords], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $projectRecord = $this->recordRepository->getOne($id);

        if (empty($projectRecord)) {
            return response()->json([], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json($projectRecord, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param ProjectRecordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProjectRecordRequest $request)
    {
        $data = $request->all();
        $projectRecord = $this->recordRepository->store($data);

        return response()->json(['projectRecord' => $projectRecord], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 更新
     *
     * @param ProjectRecordRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProjectRecordRequest $request, int $id)
    {
        $data = $request->all();
        $projectRecord = $this->recordRepository->update($id, $data);

        return response()->json(['projectRecord' => $projectRecord], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->recordRepository->destroy($id);

        return response()->noContent();
    }
}
