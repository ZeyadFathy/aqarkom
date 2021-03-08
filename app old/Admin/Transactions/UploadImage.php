<?php

namespace App\Admin\Transactions;

use Illuminate\Support\Facades\Storage;
use File;

trait UploadImage
{
    public function uploade($image, $path)
    {
        $full_name = time() . '_' . $image->getClientOriginalName();
        Storage::disk('public/uploads/' . $path)->put($full_name,  File::get($image));

        return $full_name;
    }
}
