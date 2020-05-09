<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Memo;

/**
 * Class MemoController
 *
 * @package App\Http\Controllers\Api
 */
class MemoController extends Controller
{
    /**
     * @var Memo
     */
    private $memo;

    /**
     * LabelController constructor.
     *
     * @param Memo $memo
     */
    public function __construct(Memo $memo) {
        $this->memo = $memo;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $memos = $this->memo->get();
        return response()->json(['memos' => $memos], 200, [], JSON_PRETTY_PRINT);
    }
}
