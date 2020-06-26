<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Datetime;
use App\Model\Constant;
use App\Model\Bids;
use App\Jobs\SendEmail;

class CompleteAuction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $deadline_bid_id_arr = [];
        $deadline_bid_obj_arr = [];
        // Get all In Progress Bid
        $list_bids = Bids::where('status', Constant::BID_STATUS_IN_PROGRESS)->get();
        //Compare Closed Date Time and Current Date Time
        foreach($list_bids as $bid)
        {
            if(strtotime($bid->closed_date) <= strtotime(date("Y/m/d h:i")) )
            {
                //Store Array of bid ID for mass updating, avoid call many times to DB
                $deadline_bid_id_arr[] = $bid->id;
                //Store bid Object for sending email
                $deadline_bid_obj_arr[] = $bid;
            }
        }

        //Change Bid Status to Completed
        Bids::whereIn('id', $deadline_bid_id_arr)->update(['status' => Constant::BID_STATUS_IN_COMPLETED]);

        //Send Email to winner
        //To avoid this current schedule have not finish yet (sending email takes time about 1-2s) while another schedule run, we push to the job queue
        foreach($deadline_bid_obj_arr as $bid)
        {
            //Dispatch Job Queue
            SendEmail::dispatch($bid)->delay(now()->addSeconds(5));
        }
    }
}
