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
    
    /**
     * Number of attempts.
     *
     * @var int $tries.
     */
    public $tries = 3;

    /**
     * E-mail list.
     *
     * @var array $messages.
     */
    public $emails;

    /**
     * Cake id.
     *
     * @var int $cake_id.
     */
    public $cake_id;

    /**
     * Create a new job instance.
     *
     * @param array $emails.
     * @param int $cake_id.
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
