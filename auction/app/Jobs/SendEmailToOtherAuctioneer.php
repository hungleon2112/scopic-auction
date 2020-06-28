<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Model\Bids;
use App\Services\HelperService;
use App\Traits\TraitsSendEmail;

class SendEmailToOtherAuctioneer implements ShouldQueue
{
    use TraitsSendEmail;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $bid_details, $price;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bid_details, $price)
    {
        //
        $this->bid_details = $bid_details;
        $this->price = $price;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //get distinct user email except current user id from the bid
        foreach($this->bid_details  as $bid_detail)
        {
            $this->sendEmailToOtherAuctioneer($bid_detail->user, $bid_detail->bid->item->name, $this->price);
        }
    }
}
