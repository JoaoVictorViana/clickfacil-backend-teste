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

    /**
     * Cake model.
     *
     * @var App\Model\Cake $cake.
     */
    protected $cake;

    /**
     * User e-mail.
     *
     * @var string $email.
     */
    protected $email;

    /**
     * Create a new message instance.
     *
     * @param App\Model\Cake $cake.
     * @param string $email.
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
