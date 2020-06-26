<?php namespace App\Services;

use App\Model\Constant;
use App\Mail\BasicMail;

use Illuminate\Support\Facades\Mail;
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

    public static function sendEmailChangePassword($user, $item, $price)
    {
        Mail::to($user->email)->send(new BasicMail([
            'name' => $user->name,
            'item' => $item,
            'price' => $price,
        ]));
    }
}
