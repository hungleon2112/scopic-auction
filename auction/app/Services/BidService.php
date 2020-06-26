<?php

namespace App\Services;

use App\Abstracts\AEloquentRepository;
use App\Abstracts\AEloquentService;
use App\Interfaces_Service\IBidService;
use App\Model\Constant;
use App\Traits\TraitsRespond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BidService extends AEloquentService implements IBidService
{
    use TraitsRespond;
    protected $bidRepository;

    public function __construct(
        AEloquentRepository $bidRepository
    )
    {
        $this->mainRepository = $bidRepository;
    }

    public function create(Request $request)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }
}
