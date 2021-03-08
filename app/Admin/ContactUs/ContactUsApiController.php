<?php

namespace App\Admin\ContactUs;

use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactUsAPIController extends Controller {
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
		$this->helper->validate( $request, [ 'name' => 'required','message' => 'required','phone'=>'required' ] );
		$contact = new Contact();
		$user_id = ( request()->user('api') ) ? request()->user('api')->id : null;
		$request->request->add( [ 'user_id' => $user_id ] );
		$this->setMessageAttribute( $request, $contact );

		$contact->save();

		return $this->helper->output( $contact );

	}

	public function setMessageAttribute( Request $request, contact &$contact ) {
		$contact->user_id = $request->user_id;
		$contact->title   = $request->title;
		$contact->name   = $request->name;
		$contact->message = $request->message;
		$contact->user_id = $request->user_id;
		$contact->email   = $request->email;
		$contact->phone   = $request->phone;
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
