<?php

namespace App\Admin\BankForm;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankFormAPIController extends Controller {
	public $helper;

	public function __construct() {
		$this->helper = new ApiHelper();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		//
		$this->helper->validate( $request, [ 'name' => 'required', 'amount' => 'required' ] );

		$bank = new BankForm();

		$user_id = ( request()->user() ) ? request()->user()->id : null;
		$request->request->add( [ 'user_id' => $user_id ] );
		$this->setBankAttribute( $request, $bank );
		$bank->save();

		return $this->helper->output( $bank );

	}

	public function setBankAttribute( Request $request, BankForm &$bank_form ) {
		$bank_form->user_id = $request->user_id;
		$bank_form->name   = $request->name;
		$bank_form->amount = $request->amount;
		$bank_form->email   = $request->email;
		$bank_form->mobile   = $request->mobile;
		$bank_form->bank_name = $request->bank_name;
		$bank_form->date = $request->date;

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		//
	}

}
