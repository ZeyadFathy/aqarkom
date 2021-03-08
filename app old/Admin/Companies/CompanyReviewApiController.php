<?php

namespace App\Admin\Companies;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyReviewApiController extends Controller
{
    public $helper;

    public function __construct()
    {
        $this->helper = new ApiHelper();
    }

    public function index()
    {

        $companyReview = CompanyReview::where('status', 1)
            ->select(['id', 'comment', 'rate', 'created_at', 'user_id'])
            ->with(['user:id,name,avatar'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'data' => $companyReview,
            'moreData' => $companyReview->hasMorePages(),
            'status' => 1
        ]);
    }


    public function store(Request $request)
    {
        //
        $this->helper->validate($request, [
            'company_id' => 'required|exists:companies,id',
            'comment' => 'required|min:1',
            'rate' => 'required|integer|min:1|max:5',
        ]);

        if (CompanyReview::where('user_id', auth()->user()->id)->where('company_id', $request->company_id)->count() > 0) {
            $error = new \stdClass();
            $error->message = 'لديك تقيم بالفعل';
            $error->status = 0;
            response()->json($error)->send();
            die();
        }
        $obj = new CompanyReview;
        $obj->company_id = $request->company_id;
        $obj->user_id = auth()->user()->id;
        $obj->status = -1;
        $obj->rate = $request->rate;
        $obj->comment = $request->comment;
        $obj->save();
        return $this->helper->output($obj);
    }


}
