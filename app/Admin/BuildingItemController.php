<?php

namespace App\Admin;

use App\Http\Requests\BuildingItem\StoreItemRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BuildingItem;
use App\Models\BuildingLocation;

class BuildingItemController extends Controller
{
    private $item;

    public function __construct()
    {

    }

    // public function index()
    // {
    //     $item = GenericResponder::make($this->item->index());
    // }

    public function all()
    {
        //return GenericResponder::make($this->item->all());
        $statusCode = 200;
        $data = BuildingLocation::with('items:id,location_id,title_ar,title_en,multiple')->select('id','title_ar','title_en')->get();
        return response()->json([
            'status' => $statusCode,
            'success' => true,
            'payload' => $data,
            'errors' => [],
        ], $statusCode);
    }

    // public function store(StoreItemRequest $request)
    // {
    //     return GenericResponder::make($this->item->store($request->all()), true, 201);
    // }

    // public function update($id, StoreItemRequest $request)
    // {
    //     $item = $this->item->update($id, $request->all());

    //     return $item ? GenericResponder::make($item, true, 202) :
    //         GenericResponder::make(null, false, 404);
    // }
}
