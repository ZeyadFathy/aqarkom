<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin\Companies\Company;
use Illuminate\Support\Facades\Storage;
use File;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return response()->json([
            'status' => 200,
            'success' => true,
            'payload' => $companies,
            'errors' => [],
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title_ar'          => 'required|string|min:3|max:30',
            'title_en'          => 'required|string|min:3|max:30',
            'description_ar'    => 'required|string|min:3|max:500',
            'description_en'    => 'required|string|min:3|max:500',
            'category_id'       => 'required|numeric|exists:categories,id',
            'city_id'           => 'required|numeric|exists:cities,id',
            'contact_number'    => 'required|digits:10',
            'email'             => 'required|email',
            'facebook'          => 'required|url',
            'instagram'         => 'required|url',
            'twitter'           => 'required|url',
            'website'           => 'required|url',
            'image'             => 'required|image',
            'lat'               => 'required|numeric',
            'long'              => 'required|numeric',
            'csr'               => 'required|numeric',
        ]);

        $day_ar = ['الاحد', 'الاثنين', 'الثلاثاء', 'الاربعاء', 'الخميس', 'الجمعة', 'السبت'];
        $day_en = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $workingDays = request('day');
        $dayTimes_ar = '{';
        $dayTimes_en = '{';

        foreach ($workingDays as $day) {
            $dayTimes_ar .= '"' . $day_ar[$day] . '":' . '"' . request('from_' . $day) . " - " . request('to_' . $day) . '",';
            $dayTimes_en .= '"' . $day_en[$day] . '":' . '"' . request('from_' . $day) . " - " . request('to_' . $day) . '",';
        }

        $dayTimes_ar .= '}';
        $dayTimes_en .= '}';

        $full_name = time() . '_' . request('image')->getClientOriginalName();
        Storage::disk('public/uploads/companies')->put($full_name,  File::get(request('image')));

        $path = url('') . '/uploads/companies/' . $full_name;

        Company::create([
            'title_ar'          => request('title_ar'),
            'title_en'          => request('title_en'),
            'description_ar'    => request('description_ar'),
            'description_en'    => request('description_en'),
            'category_id'       => request('category_id'),
            'city_id'           => request('city_id'),
            'contact_number'    => request('contact_number'),
            'email'             => request('email'),
            'facebook'          => request('facebook'),
            'instagram'         => request('instagram'),
            'twitter'           => request('twitter'),
            'website'           => request('website'),
            'days'              => $dayTimes_ar,
            'days_en'           => $dayTimes_en,
            'image'             => $path,
            'lat'               => request('lat'),
            'long'              => request('long'),
            'csr'               => request('csr'),
        ]);

        return redirect()->back()->with('success', 'لقد تم تسجيل الشركة بنجاح');
    }
}