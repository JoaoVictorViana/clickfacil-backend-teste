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
    /**
     * Display a listing of the emails.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection {
        if (!cache('all_emails_cakes')) {
            Cache::rememberForever(
                'all_emails_cakes',
                fn () => EmailInterestedCake::all()
            );
        }

        return cache('all_emails_cakes');
    }

    /**
     * Find a specific email in storage.
     *
     * @param int $id.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findById(int $id): EmailInterestedCake {
        return EmailInterestedCake::find($id);
    }

    /**
     * Store a email in storage.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $data): EmailInterestedCake {
        Cache::forget('all_emails_cakes'); 

        $emailCake = EmailInterestedCake::create($data);

        $cake = Cake::find($data['cake_id_fk']);
        SendEmail::dispatch($cake, $data['email']);

        return $emailCake;
    }

    /**
     * Store a email list in storage.
     *
     * @param array $data
     * @return bool
     */
    public function storeList(array $data): bool {
        Cache::forget('all_emails_cakes'); 

        $chunck_list_emails = array_chunk($data['list_emails'], 100);

        foreach ($chunck_list_emails as $chunck_emails) {
            CreateEmails::dispatch($chunck_emails, $data['cake_id']);
        }
        
        return true;
    }

    /**
     * Update a specific email in storage.
     *
     * @param array $data
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(array $data, int $id): bool {
        Cache::forget('all_emails_cakes'); 

        return EmailInterestedCake::where('email_interested_cake_id', $id)
                    ->update($data);
    }

    /**
     * Remove a specific email in storage.
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool {
        Cache::forget('all_emails_cakes'); 

        return EmailInterestedCake::where('email_interested_cake_id', $id)
                                    ->delete($id);
    }
}