<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Schedule;

class ScheduleLookupController extends Controller
{
	public function normalizeStreet($street) {
		$street = preg_replace("/ ave$/i", " AV", $street);
		$street = preg_replace("/ blvd$/i", " BL", $street);
		$street = preg_replace("/ way$/i", " WY", $street);
		$street = preg_replace("/ ter\w*$/i", " TR", $street); //terrace
		$street = preg_replace("/ cir\w*$/i", " CR", $street); //circle
		$street = preg_replace("/ hwy$/i", " HY", $street); //highway
		$street = preg_replace("/ plaza$/i", " PZ", $street); //highway

		return $street;
	}

	public function normalizeNumber($number) {
		$number = preg_replace("/^(\d+)\s*-\s*\d+$/", "$1", $number);

		return $number;
	}

	public function routedLookup($street, $number) {
		return $this->doLookup($street, $number);
	}

	public function lookup(Request $request) {
		return $this->doLookup($request->input('street'), $request->input('number'));
	}

	private function doLookup($street, $number) {
		$schedule = Schedule::where('street', 'like', $this->normalizeStreet($street))
                            ->where('min', '<=', $this->normalizeNumber($number))
                            ->where('max', '>=', $this->normalizeNumber($number))
                            ->first();

		if ($schedule) {
			$response = array(
				'status' => 'success',
				'number' => $this->normalizeNumber($number),
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
