<?php

namespace App\Repositories\Project;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    public function getAll(): Collection;
    public function getOne(int $id): Project;
    public function store(array $data): Project;
    public function update(int $id, array $data): Project;
    public function destroy(int $id);
    public function updateStatuses(array $statuses, array $deleted_ids): ?Collection;
}
