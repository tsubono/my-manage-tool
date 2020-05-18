<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Http\Requests\SaleStatusRequest;
use App\Models\Sale;
use App\Models\SaleStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\Sale\SaleRepositoryInterface as SaleRepository;


/**
 * Class SaleController
 *
 * @package App\Http\Controllers\Api
 */
class SaleController extends Controller
{
    /**
     * @var Sale
     */
    private $sale;

    /**
     * @var SaleStatus
     */
    private $saleStatus;

    /**
     * @var SaleRepository
     */
    private $saleRepository;

    /**
     * ProjectController constructor.
     *
     * @param Sale $sale
     * @param SaleStatus $saleStatus
     */
    public function __construct(Sale $sale, SaleStatus $saleStatus, SaleRepository $saleRepository) {
        $this->sale = $sale;
        $this->saleStatus = $saleStatus;
        $this->saleRepository = $saleRepository;
    }

    /**
     * 年別の一覧
     *
     * @param string $year
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesByYear($year)
    {
        $sales = $this->saleRepository->getSalesByYear($year);

        return response()->json(['sales' => $sales], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 月別の一覧
     *
     * @param string $year
     * @param string $month
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesByMonth($year, $month)
    {
        $sales = $this->saleRepository->getSalesByMonth($year, $month);

        return response()->json(['sales' => $sales], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 取引先別の一覧
     *
     * @param string $year
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesByClient($year)
    {
        $salesByClient = $this->saleRepository->getSalesByClient($year);

        return response()->json(['sales' => $salesByClient], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $sale = $this->saleRepository->getOne($id);

        if (empty($sale)) {
            return response()->json([], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json($sale, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param SaleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SaleRequest $request)
    {
        $data = $request->all();
        $sale = $this->saleRepository->store($data);

        return response()->json(['sale' => $sale], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 更新
     *
     * @param SaleRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SaleRequest $request, int $id)
    {
        $data = $request->all();
        $sale = $this->saleRepository->update($id, $data);

        return response()->json(['sale' => $sale], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->saleRepository->destroy($id);

        return response()->noContent();
    }

    /**
     * 売上のステータス一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatuses()
    {
        $statuses = $this->saleRepository->getStatuses();
        return response()->json(['statuses' => $statuses], 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * ステータスを更新する
     *
     * @param SaleStatusRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatuses(SaleStatusRequest $request)
    {
        $statuses = $this->saleRepository->updateStatuses(
            $request->get('statuses'),
            $request->get('deleted_ids', [])
        );

        return response()->json(['status' => 'OK', 'statuses' => $statuses], 200, [], JSON_PRETTY_PRINT);
    }
}
