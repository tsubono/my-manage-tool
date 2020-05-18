<?php

namespace App\Repositories\Sale;

use App\Models\sale;
use App\Models\SaleStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class SaleRepository
 *
 * @package App\Repositories\Sale
 */
class SaleRepository implements SaleRepositoryInterface
{
    /**
     * @var Sale
     */
    private $sale;

    /**
     * @var saleStatus
     */
    private $saleStatus;

    public function __construct(Sale $sale, SaleStatus $saleStatus) {
        $this->sale = $sale;
        $this->saleStatus = $saleStatus;
    }

    /**
     * 年別の一覧を取得する
     *
     * @param string $year
     * @return Collection
     */
    public function getSalesByYear(string $year): Collection
    {
        return $this->sale->query()
                ->whereYear('planned_deposit_date', '=', $year)
                ->orderBy('planned_deposit_date')
                ->get();
    }

    /**
     * 月別の一覧を取得する
     *
     * @param string $year
     * @param string $month
     * @return Collection
     */
    public function getSalesByMonth(string $year, string $month): Collection
    {
        return $this->sale->query()
            ->whereYear('planned_deposit_date', '=', $year)
            ->whereMonth('planned_deposit_date', '=', $month)
            ->orderBy('planned_deposit_date')
            ->get();
    }

    /**
     * 取引先別の一覧を取得する
     *
     * @param string $year
     * @return Collection
     */
    public function getSalesByClient(string $year): array
    {
        $sales = $this->sale->query()
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

        return $salesByClient;
    }

    /**
     * 売上ステータスを取得する
     *
     * @return Collection
     */
    public function getStatuses(): Collection
    {
        return $this->saleStatus->get();
    }

    /**
     * 売上を1件取得する
     *
     * @param int $id
     * @return sale
     */
    public function getOne(int $id): Sale
    {
        return $this->sale->find($id);
    }

    /**
     * 売上を登録する
     *
     * @param array $data
     * @return sale
     */
    public function store(array $data): Sale
    {
        $sale = $this->sale->create($data);
        return $sale;
    }

    /**
     * 売上を更新する
     *
     * @param int $id
     * @param array $data
     * @return sale
     */
    public function update(int $id, array $data): Sale
    {
        $sale = $this->sale->findOrFail($id);
        $sale->update($data);
        return $sale;
    }

    /**
     * 売上を削除する
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $sale = $this->sale->findOrFail($id);
        $sale->delete();
    }

    /**
     * 売上ステータスを更新する
     *
     * @param array $statuses
     * @param array $deleted_ids
     * @return Collection|null
     * @throws \Exception
     */
    public function updateStatuses(array $statuses, array $deleted_ids): ?Collection
    {
        DB::beginTransaction();
        try {
            foreach ($statuses as $status) {
                // idがnullの場合は新規登録
                if (empty($status['id'])) {
                    $this->saleStatus->create($status);
                    // idが入っている場合は更新
                } else {
                    $targetStatus = $this->saleStatus->find($status['id']);
                    $targetStatus->update($status);
                }
            }
            // 削除するidがあれば削除処理
            foreach ($deleted_ids as $deleted_id) {
                $this->saleStatus->findOrFail($deleted_id)->delete();
            }

            DB::commit();

            return $this->saleStatus->get();

        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new \Exception($e);
        }
    }
}
