<?php

namespace App\Repositories\Client;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

interface ClientRepositoryInterface
{
    public function getAll(): Collection;
    public function getOne(int $id): Client;
    public function store(array $data): Client;
    public function update(int $id, array $data): Client;
    public function destroy(int $id);
}
