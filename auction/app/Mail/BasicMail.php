<?php

namespace App\Mail;

use App\Model\Constant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BasicMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        $address = env('MAIL_FROM_ADDRESS');
        $name = env('MAIL_FROM_NAME');

        $place_holder = ['{name}', '{item}', '{price}'];
        $data_relacement = [$this->data['name'], $this->data['item'], $this->data['price']];

        $content = str_replace($place_holder, $data_relacement, Constant::MAIL_WIN_AUCTION_SUBJECT);
        $subject = str_replace($place_holder, $data_relacement, Constant::MAIL_WIN_AUCTION_SUBJECT);

        return $this->view('emails.basic')
                    ->from($address, $name)
                    ->subject($subject)
                    ->with([
                        'subject' => $subject,
                        'content' => $content,
                    ]);
    }
}
