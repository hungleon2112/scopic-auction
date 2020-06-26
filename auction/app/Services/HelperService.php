<?php namespace App\Services;

use App\Model\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelperService
{

    public static function uploadItemImage(Request $request)
    {
        if (!isset($request->file))
            return null;
        $file = $request->file;
        $orignal_filename = time().$file->getClientOriginalName();

        if(!Storage::disk('public_uploads')->putFileAs(
            'files',
            $file,
            $orignal_filename
        )) {
            return false;
        }
        return 'files/'.$orignal_filename;
    }

    
}
