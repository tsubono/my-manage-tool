<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubcontractorRequest;
use App\Repositories\Subcontractor\SubcontractorRepositoryInterface as SubcontractorRepository;
use Illuminate\Http\Request;

/**
 * Class SubcontractorController
 *
 * @package App\Http\Controllers\Api
 */
class SubcontractorController extends Controller
{
    /**
     * @var SubcontractorController
     */
    private $subcontractorRepository;

    /**
     * SubcontractorController constructor.
     *
     * @param SubcontractorRepository $subcontractorRepository
     */
    public function __construct(SubcontractorRepository $subcontractorRepository) {
        $this->subcontractorRepository = $subcontractorRepository;
    }

    /**
     * 一覧
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $searchForm = $request->get('searchForm');
        $subcontractors = $this->subcontractorRepository->getList(json_decode($searchForm, true));

        return response()->json(['subcontractors' => $subcontractors], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $subcontractor = $this->subcontractorRepository->getOne($id);

        if (empty($subcontractor)) {
            return response()->json([], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json($subcontractor, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param SubcontractorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SubcontractorRequest $request)
    {
        $data = $request->all();
        $subcontractor = $this->subcontractorRepository->store($data);

        return response()->json(['subContractor' => $subcontractor], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 更新
     *
     * @param SubcontractorRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SubcontractorRequest $request, int $id)
    {
        $data = $request->all();
        $subcontractor = $this->subcontractorRepository->update($id, $data);

        return response()->json(['subcontractor' => $subcontractor], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->subcontractorRepository->destroy($id);

        return response()->noContent();
    }
}
