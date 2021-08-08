<?php

namespace App\Jobs;

use App\Mail\InterestedCake;
use App\Models\Cake;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public $cake;

    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Cake $cake, $email)
    {
        $this->cake = $cake;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new InterestedCake($this->cake, $this->email));
    }
}
