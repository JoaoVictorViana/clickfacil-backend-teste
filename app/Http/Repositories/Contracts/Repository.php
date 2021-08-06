<?php

namespace App\Http\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface Repository
{
    public function all(): array;

    public function findById(int $id): Model;

    public function store(array $data): Model;

    public function update(array $data, string $id): bool;

    public function destroy(int $id): bool;
}
