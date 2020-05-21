<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Repositories\Todo\TodoRepositoryInterface as TodoRepository;
use Illuminate\Http\Request;

/**
 * Class TodoController
 *
 * @package App\Http\Controllers\Api
 */
class TodoController extends Controller
{
    /**
     * @var TodoRepository
     */
    private $todoRepository;

    /**
     * LabelController constructor.
     *
     * @param TodoRepository $todoRepository
     */
    public function __construct(TodoRepository $todoRepository) {
        $this->todoRepository = $todoRepository;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $todos = $this->todoRepository->getAll();

        return response()->json(['todos' => $todos], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $todo = $this->todoRepository->getOne($id);

        if (empty($todo)) {
            return response()->json([], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json($todo, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param TodoRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TodoRequest $request)
    {
        $data = $request->all();
        $todo = $this->todoRepository->store($data);

        return response()->json(['todo' => $todo], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 更新
     *
     * @param TodoRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TodoRequest $request, int $id)
    {
        $data = $request->all();
        $todo = $this->todoRepository->update($id, $data);

        return response()->json(['todo' => $todo], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->todoRepository->destroy($id);

        return response()->noContent();
    }

    /**
     * 期限が近い / 切れているTODOを取得
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function current()
    {
        $todos = $this->todoRepository->getCurrent();

        return response()->json(['todos' => $todos], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * ステータス更新
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Request $request, int $id)
    {
        $todo = $this->todoRepository->toggleStatus($id, $request->get('status', false));

        return response()->json(['todo' => $todo], 200, [], JSON_PRETTY_PRINT);
    }
}
