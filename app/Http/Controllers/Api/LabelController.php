<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Label;
use Illuminate\Support\Facades\Log;

/**
 * Class LabelController
 *
 * @package App\Http\Controllers\Api
 */
class LabelController extends Controller
{
    /**
     * @var Label
     */
    private $label;

    /**
     * LabelController constructor.
     *
     * @param Label $label
     */
    public function __construct(Label $label) {
        $this->label = $label;
    }

    /**
     * 一覧
     * ラベルには現状「project」「client」の2種類が存在する
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // projectのラベル
        $projectLabels = [];
        // clientのラベル
        $clientLabels = [];
        // subContractorのラベル
        $subcontractorLabels = [];

        $labels = $this->label::select(['id', 'name', 'type'])->get();
        // typeに応じて振り分け
        foreach ($labels as $label) {
            if ($label['type'] === Label::TYPE_PROJECT) {
                $projectLabels[] = $label;
            } elseif ($label['type'] === Label::TYPE_CLIENT) {
                $clientLabels[] = $label;
            } elseif ($label['type'] === Label::TYPE_SUBCONTRACTOR) {
                $subcontractorLabels[] = $label;
            }
        }

        return response()->json(
            ['data' => compact('projectLabels', 'clientLabels', 'subcontractorLabels')],
            200, [],
            JSON_PRETTY_PRINT);
    }
}
