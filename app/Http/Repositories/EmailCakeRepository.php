<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\Repository;
use App\Jobs\CreateEmails;
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

    public function store(array $data): EmailInterestedCake {
        Cache::forget('all_emails_cakes'); 

        $emailCake = EmailInterestedCake::create($data);

        SendEmail::dispatch(Cake::find($data['cake_id_fk']), $data['email']);

        return $emailCake;
    }

    public function storeList(array $data): bool {
        Cache::forget('all_emails_cakes'); 

        $chunck_list_emails = array_chunk($data['list_emails'], 100);

        foreach ($chunck_list_emails as $chunck_emails) {
            CreateEmails::dispatch($chunck_emails, $data['cake_id']);
        }
        
        return true;
    }


    public function update(array $data, string $id): bool {
        Cache::forget('all_emails_cakes'); 

        return EmailInterestedCake::where('email_interested_cake_id', $id)
                    ->update($data);
    }

    public function destroy(int $id): bool {
        Cache::forget('all_emails_cakes'); 

        return EmailInterestedCake::where('email_interested_cake_id', $id)
                                    ->delete($id);
    }
}