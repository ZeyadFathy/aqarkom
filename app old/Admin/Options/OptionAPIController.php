<?php

namespace App\Admin\Options;

use App\Admin\BankAccounts\BankAccount;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionAPIController extends Controller {
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
		$this->helper->validate( request(), [ 'key' => 'required' ] );
		$options = Option::where( 'key', request( 'key' ) )->first();
		$ret     = [];
		if ( $options ) {
			if (request('key') != 'about_us')
				$ret = preg_split ('/\s*\r\n|\n/', $options->value);
			else
				$ret = $options->value;
		}

		return $this->helper->output( $ret );


	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
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

	public function money() {
		$obj                = new \stdClass();
		$obj->money_const   = 0;
		$obj->bank_accounts = BankAccount::all();
		$obj->notes         = Option::where( 'key', 'notes' )->first()->value;
		$options            = Option::where( 'key', 'money_const' )->first();
		if ( $options )
			$obj->money_const = $options->value;


		return $this->helper->output( $obj );
	}
}
