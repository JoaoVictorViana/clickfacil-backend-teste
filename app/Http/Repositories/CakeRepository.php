<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\Repository;
use App\Models\Cake;
use Illuminate\Support\Facades\Cache;

class CakeRepository implements Repository
{
    public function all(): array {
        if (!cache('all_cakes')) {
            Cache::rememberForever(
                'all_cakes',
                fn () => Cake::all()->toArray()
            );
        }

        return cache('all_cakes');
    }

    public function findById(int $id): Cake {
        return Cake::find($id);
    }

    public function store(array $data): Cake {
        Cache::forget('all_cakes'); 

        return Cake::create($this->format($data));
    }

    public function update(array $data, string $id): bool {
        Cache::forget('all_cakes'); 

        return Cake::where('cake_id', $id)
                    ->create($this->format($data));
    }

    public function destroy(int $id): bool {
        Cache::forget('all_cakes'); 

        return Cake::where('cake_id', $id)->delete($id);
    }

    public function format($data): array {
        return [
            'name' => $data['name'],
            'weight' => $data['weight'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
        ];
    }
}