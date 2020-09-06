<?php

namespace App\Repositories\Subcontractor;

use App\Models\Subcontractor;
use Illuminate\Database\Eloquent\Collection;

interface SubcontractorRepositoryInterface
{
    public function getList(array $searchForm): Collection;
    public function getOne(int $id): Subcontractor;
    public function store(array $data): Subcontractor;
    public function update(int $id, array $data): Subcontractor;
    public function destroy(int $id);
}
