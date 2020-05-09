<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
     * ProjectController constructor.
     *
     * @param Sale $sale
     * @param SaleStatus $saleStatus
     */
    public function __construct(Sale $sale, SaleStatus $saleStatus) {
        $this->sale = $sale;
        $this->saleStatus = $saleStatus;
    }

    /**
     * 年別の一覧
     *
     * @param string $year
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSalesByYear($year)
    {
        $sales =
            $this->sale->query()
                ->whereYear('planned_deposit_date', '=', $year)
                ->orderBy('planned_deposit_date')
                ->get();

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
        $sales =
            $this->sale->query()
                ->whereYear('planned_deposit_date', '=', $year)
                ->whereMonth('planned_deposit_date', '=', $month)
                ->orderBy('planned_deposit_date')
                ->get();

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
        $sales =
            $this->sale->query()
                ->whereYear('planned_deposit_date', '=', $year)
                ->orderBy('planned_deposit_date')
                ->get();

        $salesByClient = [];
        foreach ($sales as $sale) {
            $client = $sale->project->client->name;
            if (!isset($salesByClient[$client])) {
                $salesByClient[$client] = 0;
            }
            $salesByClient[$client] += $sale->price;
        }

        return response()->json(['sales' => $salesByClient], 200, [], JSON_PRETTY_PRINT);
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
     * 売上のステータス一覧
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatuses()
    {
        $statuses = $this->saleStatus->get();
        return response()->json(['statuses' => $statuses], 200, [], JSON_PRETTY_PRINT);
    }
}
