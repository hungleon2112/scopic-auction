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
        return 'uploads/files/'.$orignal_filename;
    }

    public static function formatDate($date) {
        if($date == null){
            return '';
        }
        return date('Y-m-d H:i:s', strtotime($date)) . " (".config('app.timezone') . ")";
    }
}
