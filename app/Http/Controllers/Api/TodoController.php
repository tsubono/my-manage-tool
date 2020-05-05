<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;

/**
 * Class TodoController
 *
 * @package App\Http\Controllers\Api
 */
class TodoController extends Controller
{
    /**
     * @var Todo
     */
    private $todo;

    /**
     * LabelController constructor.
     *
     * @param Todo $todo
     */
    public function __construct(Todo $todo) {
        $this->todo = $todo;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $todos = $this->todo->query()->orderBy('sort')->get()->toArray();
        return response()->json(['todos' => $todos], 200, [], JSON_PRETTY_PRINT);
    }
}
