<?php namespace App\Traits;

use App\Model\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait TraitsUpload
{
    /**
     * @param $folder
     * @return string
     */
    public function uploadItemImage(Request $request)
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
