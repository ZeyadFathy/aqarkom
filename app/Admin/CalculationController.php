<?php

namespace App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Calculation\SelectCalculationRequest;
use App\Infrastructure\Http\Responders\GenericResponder;
use App\Mail\CalculationAdminMail;
use App\Mail\CalculationCompanyMail;
use App\Mail\CalculationUserMail;
// use App\Repositories\Calculation\CalculationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;
use App\Models\Company;
use App\Models\CalculationItem;
use App\Models\Calculation;

class CalculationController extends Controller
{
    private $calculation;

    public function __construct()
    {
    }

    public function storea(Request $request)
    {
        
        $companies = Company::where('status', 1)->select('id','email','title_ar','title_en','contact_number','image')->get();

        $objects = [];
        $company_prices = [];
        $calcul = Calculation::create([
            'name'          => $request->name,
            'mobile'        => $request->mobile,
            'email'         => $request->email,
            'area'          => $request->area,
            'length'        => $request->length,
            'width'         => $request->width,
            'no_streets'    => $request->no_streets,
            'title'    => $request->title,
            'notes'    => $request->notes,
        ]);

        //create calculation item
            foreach($request->calculation as $childs){
                    foreach($childs as $item){
                 $object = (object) $item;
                 array_push($objects,$object); 
                 $calcul->calculationItems()->create([
                                         'calculation_id' => $calcul->id,
                                         'item_id' => $object->id,
                                         'num' => $object->value
                    ]);
                }

        }


        // get price foreach company
        foreach($companies as $company){
            $single = [];
            foreach($objects as $obj){
            $item_select = $obj->id;
            //price for each company and item    
            $item_price = Company::where('companies.id', $company->id)
            ->leftjoin('company_prices','companies.id', '=', 'company_prices.company_id')->where('item_id', $item_select)
            ->get();
            //calculate
            $data_price = isset($item_price[0]->price) ? $item_price[0]->price : false;
            $final_price =  $data_price * $obj->value;
            array_push($single,$final_price);
            $x = array_sum($single);
            $company->price = $x;

        }
        array_push($company_prices,$company);
        }
        
        return response()->json([
            'data' => $company_prices,
            'sucess' => true,
        ], 200);
    }

    public function select(SelectCalculationRequest $request)
    {
        $data = $this->calculation->select($request->all());
        Mail::to($data['calculation']->email)->send(new CalculationUserMail(
            $data['company'], $data['calculation']
        ));
        Mail::to($data['company']->email)->send(new CalculationCompanyMail(
            $data['company'], $data['calculation']
        ));
        Mail::to('aqarito@aqarito.com')->send(new CalculationAdminMail(
            $data['company'], $data['calculation']
        ));
        return GenericResponder::make('mail sent successfully');
    }
    
    
        public function search(Request $request)
    {
        $data = Calculation::with('calculationItems')->where('mobile',$request->phone)->get();
        return response()->json([
            'data' => $data,
            'sucess' => true,
        ], 200);

    }

}
