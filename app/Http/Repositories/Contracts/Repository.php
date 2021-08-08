<?php

namespace App\Http\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface Repository
{
    /**
     * Display a listing of the resources.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection;

    /**
     * Find a specific resource in storage.
     *
     * @param int $id.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findById(int $id): Model;

    /**
     * Store a resource in storage.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $data): Model;

    /**
     * Update a specific resource in storage.
     *
     * @param array $data
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(array $data, int $id): bool;

    /**
     * Remove a specific resource in storage.
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool;
}
