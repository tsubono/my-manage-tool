<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemoRequest;
use App\Repositories\Memo\MemoRepositoryInterface as MemoRepository;

/**
 * Class MemoController
 *
 * @package App\Http\Controllers\Api
 */
class MemoController extends Controller
{
    /**
     * @var MemoRepository
     */
    private $memoRepository;

    /**
     * LabelController constructor.
     *
     * @param MemoRepository $memoRepository
     */
    public function __construct(MemoRepository $memoRepository) {
        $this->memoRepository = $memoRepository;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $memos = $this->memoRepository->getAll();

        return response()->json(['memos' => $memos], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $memo = $this->memoRepository->getOne($id);

        if (empty($memo)) {
            return response()->json([], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json($memo, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param MemoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MemoRequest $request)
    {
        $data = $request->all();
        $memo = $this->memoRepository->store($data);

        return response()->json(['memo' => $memo], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 更新
     *
     * @param MemoRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MemoRequest $request, int $id)
    {
        $data = $request->all();
        $memo = $this->memoRepository->update($id, $data);

        return response()->json(['memo' => $memo], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->memoRepository->destroy($id);

        return response()->noContent();
    }
}
