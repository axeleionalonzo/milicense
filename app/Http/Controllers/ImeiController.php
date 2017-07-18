<?php

namespace App\Http\Controllers;

use App\Activation as ActCode;
use App\Imei as Imei;
use App\Projects as Projects;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
use Log;
use Auth;
use DB;

class ImeiController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::check()) {
			$imeis = Imei::with(['imei', 'projects'])->get();
			return response()->json($imeis);
		} else {
			return response()->json(array(
				'message'	=> "please login first"
				));
		}
	}

	/**
	 * Rules for validation
	 *
	 * @return Response
	 */
	private static function rules($id=0, $merge=[])
	{
		// we used array merge so that we can add additional rules when needed
		return array_merge(
        [
            'activation_id'		=> 'required'
        ], 
        $merge);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{	
        // validate
        // read more on validation at http://laravel.com/docs/validation
        // $imeis = Request::get('imeidata');

		if (Auth::check()) {
	        $validator = Validator::make(Request::all(), ApiLicenseController::rules());
			// Log::error($imeis[0]);

	        if ($validator->fails()) {
				return response()->json(array(
					'success'	=> false,
					'status'	=> $validator->messages()
					));
	        } else {
				$imei = Imei::create(Request::all());
				return response()->json(array(
					'success'	=> true,
					'imei'	=> $imei,
					'status'	=> $validator->messages()
					));
			}
		} else {
			return response()->json(array(
				'message'	=> "please login first"
				));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{	
		if (Auth::check()) {

			$imei = Imei::find($id);
	        $imei->activation_id	= Request::get('activation_id');
			$imei->save();

			return response()->json(array(
				'success'	=> true
				));
			
		} else {
			return response()->json(array(
				'message'	=> "please login first"
				));
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Auth::check()) {
			Imei::destroy($id);
			return response()->json(array('success' => true));
		} else {
			return response()->json(array(
				'message'	=> "please login first"
				));
		}
	}

}
