<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Model\Bids;
use App\Services\HelperService;

class SendEmailToWinner implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $bid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bid)
    {
        //
        $this->bid = $bid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //get latest bid detail
        $latest_bid_detail = $this->bid->bidDetail()->latest()->get();
        HelperService::sendEmailChangePassword($latest_bid_detail[0]->user, $this->bid->item->name, $latest_bid_detail[0]->price);
    }
}
