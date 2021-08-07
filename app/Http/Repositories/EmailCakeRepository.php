<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\Repository;
use App\Jobs\SendEmail;
use App\Models\Cake;
use App\Models\EmailInterestedCake;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class EmailCakeRepository implements Repository
{
    public function all(): Collection {
        if (!cache('all_emails_cakes')) {
            Cache::rememberForever(
                'all_emails_cakes',
                fn () => EmailInterestedCake::all()
            );
        }

        return cache('all_emails_cakes');
    }

    public function findById(int $id): EmailInterestedCake {
        return EmailInterestedCake::find($id);
    }

    public function findByCakeId($cake_id): Collection {
        return EmailInterestedCake::where('cake_id_fk', $cake_id)
                                    ->get();
    }

    public function findByEmail($email): Collection {
        return EmailInterestedCake::where('email', $email)
                                    ->get();
    }

    public function findByEmailAndCakeId($email, $cake_id): Collection {
        return EmailInterestedCake::where('email', $email)
                                    ->where('cake_id_fk', $cake_id)
                                    ->get();
    }

    public function store(array $data): EmailInterestedCake {
        Cache::forget('all_emails_cakes'); 

        $emailCake =  EmailInterestedCake::create($this->format($data));

        SendEmail::dispatch(Cake::find($data['cake_id']), $data['email']);

        return EmailInterestedCake::find(1);
    }

    public function storeList(array $data): bool {
        Cache::forget('all_emails_cakes'); 

        array_map(
            function ($email) use ($data) {
                $data = [
                    'cake_id' => $data['cake_id'],
                    'email' => $email
                ];

                $this->store($data);
            },
            $data['list_emails']
        );

        return true;
    }


    public function update(array $data, string $id): bool {
        Cache::forget('all_emails_cakes'); 

        return EmailInterestedCake::where('email_interested_cake_id', $id)
                    ->update($this->format($data));
    }

    public function destroy(int $id): bool {
        Cache::forget('all_emails_cakes'); 

        return EmailInterestedCake::where('email_interested_cake_id', $id)
                                    ->delete($id);
    }

    public function format($data): array {
        return [
            'cake_id_fk' => $data['cake_id'],
            'email' => $data['email'],
        ];
    }
}