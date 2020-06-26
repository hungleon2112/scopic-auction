<?php

namespace App\Services;

use App\Abstracts\AEloquentRepository;
use App\Abstracts\AEloquentService;
use App\Interfaces_Service\IItemService;
use App\Model\Constant;
use App\Traits\TraitsUpload;
use App\Traits\TraitsRespond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemService extends AEloquentService implements IItemService
{
    use TraitsUpload;
    use TraitsRespond;
    protected $itemRepository;

    public function __construct(
        AEloquentRepository $itemRepository
    )
    {
        $this->mainRepository = $itemRepository;
    }

    public function create(Request $request)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }
}
