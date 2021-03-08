<?php

namespace App\Admin\Transactions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiHelper;
use Illuminate\Support\Facades\Log;
class TransactionController extends Controller
{
    use UploadImage;

    public $offer, $bouquet, $helper;

    public function __construct(OfferTransaction $offer, BouquetTransaction $bouquet)
    {
        $this->offer   = $offer;
        $this->bouquet = $bouquet;
        $this->helper = new ApiHelper();
    }

    public function storeOfferTransaction(Request $request)
    {
        $validatedData = $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'offer_id' => 'required|exists:offers,id',
            'transformer_name' => 'required|string|min:5|max:100',
            'transformer_mobile_code' => 'required|string|min:2|max:10',
            'transformer_mobile' => 'required|digits:10',
            'date' => 'required|date|before_or_equal:today',
            'reference_number' => 'required|min:7|max:15',
        ]);
        $file=null;
        if( request('image') ) {
            $file = $this->helper->saveBase64Image(request('image')['image'], request('image')['ext']);
        }
        return $this->offer->create([
            'bank_account_id'           => $request->bank_account_id,
            'user_id'                   => auth()->user()->id,
            'offer_id'                  => $request->offer_id,
            'transformer_name'          => $request->transformer_name,
            'transformer_mobile_code'   => $request->transformer_mobile_code,
            'transformer_mobile'        => $request->transformer_mobile,
            'date'                      => $request->date,
            'reason'                    => $request->reason,
            'reference_number'          => $request->reference_number,
            'image'                     => $file
        ]);
    }

    public function storeBouquetTransaction(Request $request)
    {

        $validatedData = $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'bouquet_id' => 'required|exists:bouquets,id',
            'transformer_name' => 'required|string|min:5|max:100',
            'transformer_mobile_code' => 'required|string|min:2|max:10',
            'transformer_mobile' => 'required|digits:10',
            'date' => 'required|date|before_or_equal:today',
            'reference_number' => 'required|min:7|max:15'
        ]);
        $file=null;
        if( request('image') ) {
            $file = $this->helper->saveBase64Image(request('image')['image'], request('image')['ext']);
        }
        return $this->bouquet->create([
            'bank_account_id'           => $request->bank_account_id,
            'user_id'                   => auth()->user()->id,
            'bouquet_id'                => $request->bouquet_id,
            'transformer_name'          => $request->transformer_name,
            'transformer_mobile_code'   => $request->transformer_mobile_code,
            'transformer_mobile'        => $request->transformer_mobile,
            'date'                      => $request->date,
            'reason'                    => $request->reason,
            'reference_number'          => $request->reference_number,
            'image'                     =>  $file
        ]);
    }
}
