<?php

namespace App\Repositories\Sale;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

interface SaleRepositoryInterface
{
    public function getSalesByYear(string $year): Collection;
    public function getSalesByMonth(string $year, string $month): Collection;
    public function getSalesByClient(string $year): array;
    public function getStatuses(): Collection;
    public function getOne(int $id): Sale;
    public function store(array $data): Sale;
    public function update(int $id, array $data): Sale;
    public function destroy(int $id);
    public function updateStatuses(array $statuses, array $deleted_ids): ?Collection;
}
