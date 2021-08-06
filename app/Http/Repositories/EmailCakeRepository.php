<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\Repository;
use App\Mail\InterestedCake;
use App\Models\Cake;
use App\Models\EmailInterestedCake;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class EmailCakeRepository implements Repository
{
    public function all(): array {
        if (!cache('all_emails_cakes')) {
            Cache::rememberForever(
                'all_emails_cakes',
                fn () => EmailInterestedCake::all()->toArray()
            );
        }

        return cache('all_emails_cakes');
    }

    public function findById(int $id): EmailInterestedCake {
        return EmailInterestedCake::find($id);
    }

    public function findByCakeId($cake_id): array {
        return EmailInterestedCake::where('cake_id_fk', $cake_id)
                                    ->get()
                                    ->toArray();
    }

    public function findByEmail($email): array {
        return EmailInterestedCake::where('email', $email)
                                    ->get()
                                    ->toArray();
    }

    public function findByEmailAndCakeId($email, $cake_id): array {
        return EmailInterestedCake::where('email', $email)
                                    ->where('cake_id_fk', $cake_id)
                                    ->get()
                                    ->toArray();
    }

    public function store(array $data): EmailInterestedCake {
        Cache::forget('all_emails_cakes'); 

        $emailCake =  EmailInterestedCake::create($this->format($data));

        Mail::send(new InterestedCake(Cake::find($data['cake_id']), $data['email']));

        return $emailCake;
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