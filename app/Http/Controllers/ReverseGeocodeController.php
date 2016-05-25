<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;

class ReverseGeocodeController extends Controller
{
	public function lookup(Request $request) {


		$response = array(
			'status' => 'success',
			'latlong' => $request->input('query'),
			'address' => '123 Test St.',
		);

		return Response::json($response);
	}
}
