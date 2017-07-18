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

class ApiLicenseController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// if (Auth::check()) {
			$licenses = ActCode::with(['imei', 'projects'])->get();
			return response()->json($licenses);
		// } else {
		// 	return response()->json(array(
		// 		'message'	=> "please login first"
		// 		));
		// }
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
            'activation_code'	=> 'required|unique:activation,activation_code' . ($id ? ",$id" : ''),
            'number_of_device'	=> 'required',
            'status'			=> 'required',
            'branch_id'			=> 'required',
            'project_id'		=> 'required',
            // 'created_date'		=> 'required',
            'expiry_date'		=> 'required'
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
        // $licenses = Request::get('licensedata');

		// if (Auth::check()) {
	        $validator = Validator::make(Request::all(), ApiLicenseController::rules());
			// Log::error($licenses[0]);

	        if ($validator->fails()) {
				return response()->json(array(
					'success'	=> false,
					'status'	=> $validator->messages()
					));
	        } else {
				$license = ActCode::create(Request::all());
				return response()->json(array(
					'success'	=> true,
					'license'	=> $license,
					'status'	=> $validator->messages()
					));
			}
		// } else {
		// 	return response()->json(array(
		// 		'message'	=> "please login first"
		// 		));
		// }
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
		// if (Auth::check()) {
	        // validate
	        // read more on validation at http://laravel.com/docs/validation
	        $validator = Validator::make(Request::all(), ApiLicenseController::rules($id
	        	// , ['branch_id'	=> 'unique:activation,branch_id' . ($id ? ",$id" : '')]
	        	// adds validation when edit mode
	        	));

	        if ($validator->fails()) {
				return response()->json(array(
					'success'	=> false,
					'status'	=> $validator->messages()
					));
	        } else {

				$license = ActCode::find($id);
	            $license->activation_code	= Request::get('activation_code');
	            $license->number_of_device	= Request::get('number_of_device');
	            $license->status			= Request::get('status');
	            $license->branch_id			= Request::get('branch_id');
	            $license->project_id		= Request::get('project_id');
	            $license->created_date		= Request::get('created_date');
	            $license->expiry_date		= Request::get('expiry_date');
				$license->save();

				return response()->json(array(
					'success'	=> true,
					'license'	=> $license,
					'status'	=> $validator->messages()
					));
			}
		// } else {
		// 	return response()->json(array(
		// 		'message'	=> "please login first"
		// 		));
		// }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// if (Auth::check()) {
			ActCode::destroy($id);
			return response()->json(array('success' => true));
		// } else {
		// 	return response()->json(array(
		// 		'message'	=> "please login first"
		// 		));
		// }
	}

}
