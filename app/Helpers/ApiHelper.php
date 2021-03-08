<?php

namespace App\Helpers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Intervention\Image\Facades\Image;

class ApiHelper
{
    public $image_path;
    public $voice_path;

    public function __construct()
    {
        $this->image_path = $path = 'images/';
        $this->voice_path = public_path('uploads/voices/');
    }

    public function validate($request, $validation_data)
    {
        $validator = Validator::make($request->all(), $validation_data);
        if ($validator->fails()) {
            $error = new \stdClass();
            $error->fields = array_keys($validator->errors()->toArray());
            $error->message = array_values($validator->errors()->toArray())[0][0];
            $error->status = 0;
            response()->json($error)->send();
            exit;
        }
    }

    public function output($data, $status = 1)
    {
        if (!is_object($data) && !is_scalar($data)) {
            return response()->json([
                'data' => (empty($data)) ? [] : $data,
                'status' => $status,
            ], 200);
        } else {
            if (is_object($data) && property_exists($data, 'status')) {
                unset($data->status);
            }

            return response()->json([
                'data' => (is_null($data)) ? new \stdClass() : $data,
                'status' => $status,
            ], 200);
        }
    }

    public function saveBase64Image($photo, $ext)
    {
        if ($photo) {
            $photo_name = md5(uniqid()) . '.' . $ext;
            if (!File::exists($this->image_path)) {
                File::makeDirectory($this->image_path, $mode = 0777, true, true);
            }
            Storage::disk('admin')->put($this->image_path . $photo_name, base64_decode($photo));
            return $this->image_path.$photo_name;
        }
    }

    public function saveBase64ImageForAds($photo, $ext)
    {
        if ($photo) {
            $photo_name = md5(uniqid()) . '.' . $ext;
            if (!File::exists($this->image_path)) {
                File::makeDirectory($this->image_path, $mode = 0777, true, true);
            }
            Storage::disk('admin')->put($this->image_path . $photo_name, base64_decode($photo));
            return $photo_name;
        }
    }

    public function removeIfExists($photo, $model_photo, $multiple = false)
    {
        if (!$multiple) {
            if ($photo && $model_photo && file_exists($this->image_path . $model_photo)) {
                unlink($this->image_path . $model_photo);
            }
        } else {
            if ($model_photo) {
                for ($i = 0; $i < count($model_photo); $i++) {
                    if ($model_photo[$i] && file_exists($this->image_path . $model_photo[$i])) {
                        unlink($this->image_path . $model_photo[$i]);
                    }
                }
            }
        }
    }

    public function timeToText($inputSeconds, $lang = 'ar')
    {

        if (!$inputSeconds) {
            $inputSeconds = 0;
        }

        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$inputSeconds");
        // extract days
        $days = $dtF->diff($dtT)->d;
        $hours = $dtF->diff($dtT)->h;
        $minutes = $dtT->diff($dtT)->m;
        $seconds = $dtT->diff($dtT)->s;

        // return the final array

        if ($lang == 'ar') {
            $obj = array(
                'يوم' => (int)$days,
                'ساعة' => (int)$hours,
                'دقيقة' => (int)$minutes,
                'ثانية' => (int)$seconds,
            );
        } else {
            $obj = array(
                'days' => (int)$days,
                'hours' => (int)$hours,
                'minutes' => (int)$minutes,
                'seconds' => (int)$seconds,
            );
        }
        $ret = '';
        foreach ($obj as $key => $value) {
            if ($value != 0) {
                $ret .= $value . ' ' . $key . ' ';
            }
        }
        if (strlen($ret) > 0) {
            $ret = substr_replace($ret, "", -1);
        }
        return $ret;
    }

    public static function concatImages($images)
    {
        $temp = [];
        foreach ($images as $image) {
            $temp[] = ApiHelper::concatImage($image);
        }
        return $temp;
    }

    public static function concatImage($image)
    {
        return 'https://old-api.aqarito.net/uploads/' . $image;
    }

    public function paginate($items, $perPage = 15)
    {

        $page = request()->get('page');
        $options = [
            'path' => request()->url(),
            'query' => request()->query(),
        ];

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($messages);

        $paginated = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

        return response()->json([
            'data' => $paginated,
            'status' => 1,
        ], 200);
    }
    public function saveBase64Voice($voice)
    {
        if ($voice) {
            $voice_name = md5(uniqid()) . '.aac';
            if (!File::exists($this->voice_path)) {
                File::makeDirectory($this->voice_path, $mode = 0777, true, true);
            }
            file_put_contents($this->voice_path . $voice_name, base64_decode($voice));
            return 'voices/' . $voice_name;
        }
    }

    public function watermark($image)
    {
        $watermark =  Image::make(public_path('uploads/images/water_mark.png'));
        $img = Image::make(public_path('uploads/images/' . $image));
        //#1
        $watermarkSize = $img->width() - 20; //size of the image minus 20 margins
        //#2
        $watermarkSize = $img->width() / 2; //half of the image size
        //#3
        $resizePercentage = 70; //70% less then an actual image (play with this value)
        $watermarkSize = round($img->width() * ((100 - $resizePercentage) / 100), 2); //watermark will be $resizePercentage less then the actual width of the image

        // resize watermark width keep height auto
        $watermark->resize($watermarkSize, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        //insert resized watermark to image center aligned
        $img->insert($watermark, 'bottom');
        //save new image
        $img->save(public_path('uploads/images/' . $image));
    }
}
