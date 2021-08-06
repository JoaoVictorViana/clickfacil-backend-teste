<?php

namespace App\Mail;

use App\Models\Cake;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterestedCake extends Mailable
{
    use Queueable, SerializesModels;

    protected $cake;

    protected $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Cake $cake, $email)
    {
        $this->cake = $cake;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Interesse em nossos bolos!');
        $this->to($this->email);

        return $this->markdown(
            'mail.interestedCake',
            ['cake' => $this->cake]
        );
    }
}
