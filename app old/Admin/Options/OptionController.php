<?php

namespace App\Admin\Options;

use Encore\Admin\Form;
use Encore\Admin\Form\Builder;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class OptionController extends Controller {
	use ModelForm;

	/**
	 * Index interface.
	 *
	 * @return Content
	 */
	public function index() {
//		return $this->create();
		return redirect( url()->current() . '/create' );
//		return Admin::content( function ( Content $content ) {
//
////			$content->header( 'header' );
////			$content->description( 'description' );
//
//			$content->body( $this->form() );
//		} );
	}

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		return Admin::grid( Option::class, function ( Grid $grid ) {
			$grid->key( 'الثابت' );
			$grid->value( 'القيمة' );
		} );
	}

	/**
	 * Edit interface.
	 *
	 * @param $id
	 *
	 * @return Content
	 */
	public function edit( $id ) {
		return Admin::content( function ( Content $content ) use ( $id ) {

			$content->header( 'الثوابت' );

			$content->body( $this->form()->edit( $id ) );
		} );
	}

	/**
	 * Make a form builder.
	 *
	 * @return Form
	 */
	protected function form() {
		return Admin::form( Option::class, function ( Form $form ) {
			$form->hidden( 'key[]' )->value( 'fees' );
			$form->textarea( 'text[]', 'المصاريف' )->value( $this->getValueByKey( 'fees' ) );
			$form->hidden( 'key[]' )->value( 'about_us' );
			$form->textarea( 'text[]', 'عن التطبيق' )->value( $this->getValueByKey( 'about_us' ) );
			$form->hidden( 'key[]' )->value( 'privacy_policy' );
			$form->textarea( 'text[]', 'سياسية الخصوصية' )->value( $this->getValueByKey( 'privacy_policy' ) );
			$form->hidden( 'key[]' )->value( 'terms' );
			$form->textarea( 'text[]', 'الشروط والأحكام' )->value( $this->getValueByKey( 'terms' ) );
			$form->hidden( 'key[]' )->value( 'faq' );
			$form->textarea( 'text[]', 'الأسألة الشائعة' )->value( $this->getValueByKey( 'faq' ) );
			$form->hidden( 'key[]' )->value( 'notes' );
			$form->textarea( 'text[]', 'الملاحظات' )->value( $this->getValueByKey( 'notes' ) );

		} );
	}

	public function getValueByKey( $key ) {
		$option = Option::where( 'key', $key )->first();

		return ( $option ) ? $option->value : null;
	}

	/**
	 * Create interface.
	 *
	 * @return Content
	 */
	public function create() {
		return Admin::content( function ( Content $content ) {
			$content->header( 'الثوابت' );

			$content->body( $this->form() );
		} );
	}

	public function store() {

		$data   = Input::all();
		$keys   = $data['key'];
		$values = $data['text'];
		$insert = [];
		$delete = [];
		foreach ( $keys as $index => $key ) {
			$insert[] = [ 'key' => $key, 'value' => $values[ $index ] ];
			$delete[] = $key;
		}
		DB::table( 'options' )->whereIn( 'key', $delete )->delete();
		DB::table( 'options' )->insert( $insert );
		admin_toastr( trans( 'admin.save_succeeded' ) );
		$url = Input::get( Builder::PREVIOUS_URL_KEY ) ?: $this->resource( 0 );

		return redirect( $url );
	}

	public function resource( $slice = - 2 ) {
		$segments = explode( '/', trim( app( 'request' )->getUri(), '/' ) );

		if ( $slice != 0 ) {
			$segments = array_slice( $segments, 0, $slice );
		}
		// # fix #1768
		if ( $segments[0] == 'http:' && config( 'admin.secure' ) == true ) {
			$segments[0] = 'https:';
		}

		return implode( '/', $segments );
	}
}
