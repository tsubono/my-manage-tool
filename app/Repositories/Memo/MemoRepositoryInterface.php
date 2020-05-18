<?php

namespace App\Repositories\Memo;

use App\Models\Memo;
use Illuminate\Database\Eloquent\Collection;

interface MemoRepositoryInterface
{
    public function getAll(): Collection;
    public function getOne(int $id): Memo;
    public function store(array $data): Memo;
    public function update(int $id, array $data): Memo;
    public function destroy(int $id);
}
