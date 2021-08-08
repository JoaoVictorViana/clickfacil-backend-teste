<?php

namespace App\Jobs;

use Facades\App\Http\Repositories\EmailCakeRepository;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateEmails implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $emails;
    public $cake_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emails, $cake_id)
    {
        $this->emails = $emails;
        $this->cake_id = $cake_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->emails as $email) {
            $data_email = [
                'cake_id_fk' => $this->cake_id,
                'email' => $email
            ];
            EmailCakeRepository::store($data_email);
        }
    }
}
