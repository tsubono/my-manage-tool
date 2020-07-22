<?php

namespace App\Repositories\Project\Record;

use App\Models\ProjectRecord;
use Illuminate\Database\Eloquent\Collection;

interface RecordRepositoryInterface
{
    public function getAll(): Collection;
    public function getOne(int $id): ProjectRecord;
    public function store(array $data): ProjectRecord;
    public function update(int $id, array $data): ProjectRecord;
    public function destroy(int $id);
}
