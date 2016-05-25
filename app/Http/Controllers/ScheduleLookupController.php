<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Schedule;

class ScheduleLookupController extends Controller
{
	public function routedLookup($street, $number) {
		return $this->doLookup($street, $number);
	}

	public function lookup(Request $request) {
		return $this->doLookup($request->input('street'), $request->input('number'));
	}

	private function doLookup($street, $number) {
		$schedule = Schedule::where('street', 'like', $street)
                            ->where('min', '<=', $number)
                            ->where('max', '>=', $number)
                            ->first();

		if ($schedule) {
			$response = array(
				'status' => 'success',
				'number' => $number,
				'street' => $street,
				'schedule' => $schedule->rawschedule,
				'address' => $schedule->min . "-" . $schedule->max . " " . $schedule->street,
			);
		}
		else {
			$response = array(
				'status' => 'fail',
				'number' => $number,
				'street' => $street,
			);
		}

		return Response::json($response);
	}
}
