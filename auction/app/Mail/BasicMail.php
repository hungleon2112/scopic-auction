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
    public $mail_type;
    public function __construct($data, $mail_type)
    {
        $this->data = $data;
        $this->mail_type = $mail_type;
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

        switch($this->mail_type)
        {
            case  Constant::MAIL_TYPE_WINNER:
                $place_holder = ['{name}', '{item}', '{price}'];
                $data_relacement = [$this->data['name'], $this->data['item'], $this->data['price']];
                $content = str_replace($place_holder, $data_relacement, Constant::MAIL_WIN_AUCTION_SUBJECT);
                $subject = str_replace($place_holder, $data_relacement, Constant::MAIL_WIN_AUCTION_SUBJECT);
            break;
            case  Constant::MAIL_TYPE_OTHER_AUCTIONEER:
                $place_holder = ['{name}', '{item}', '{price}'];
                $data_relacement = [$this->data['name'], $this->data['item'], $this->data['price']];
                $content = str_replace($place_holder, $data_relacement, Constant::MAIL_OTHER_AUCTIONEER_SUBJECT);
                $subject = str_replace($place_holder, $data_relacement, Constant::MAIL_OTHER_AUCTIONEER_SUBJECT);
            break;
        }
        return $this->view('emails.basic')
                    ->from($address, $name)
                    ->subject($subject)
                    ->with([
                        'subject' => $subject,
                        'content' => $content,
                    ]);
    }
}
