<?php

namespace App\Repositories\Todo;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;

interface TodoRepositoryInterface
{
    public function getAll(): Collection;
    public function getOne(int $id): Todo;
    public function store(array $data): Todo;
    public function update(int $id, array $data): Todo;
    public function destroy(int $id);
}
