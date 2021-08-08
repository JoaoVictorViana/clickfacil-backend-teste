<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\Repository;
use App\Models\Cake;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CakeRepository implements Repository
{
    /**
     * Display a listing of the cakes.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection {
        if (!cache('all_cakes')) {
            Cache::rememberForever(
                'all_cakes',
                fn () => Cake::all()
            );
        }

        return cache('all_cakes');
    }

    /**
     * Find a specific cake in storage.
     *
     * @param int $id.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findById(int $id): Cake {
        return Cake::find($id);
    }

    /**
     * Store a cake in storage.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $data): Cake {
        Cache::forget('all_cakes'); 

        return Cake::create($data);
    }

    /**
     * Update a specific cake in storage.
     *
     * @param array $data
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(array $data, int $id): bool {
        Cache::forget('all_cakes'); 

        return Cake::where('cake_id', $id)
                    ->update($data);
    }

    /**
     * Remove a specific cake in storage.
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool {
        Cache::forget('all_cakes'); 

        return Cake::where('cake_id', $id)->delete($id);
    }
}