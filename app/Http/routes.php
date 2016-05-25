<?php

use App\Task;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/task', function (Request $request) {
	// get all tasks
	$tasks = Task::orderBy('created_at', 'asc')->get();

	return view('tasks', [
		'tasks' => $tasks
	]);
});

Route::post('/task', function (Request $request) {
	// Add a new task
	$validator = Validator::make($request->all(), [
		'name' => 'required|max:255',
	]);

	if ($validator->fails()) {
		return redirect('/task')->withInput()->withErrors($validator);
	}

	$task = new Task;
	$task->name = $request->name;
	$task->save();

	return redirect('/task');
});

Route::delete('/task/{task}', function (Task $task) {
	$task->delete();

	return redirect('/task');
});

Route::post('/lookup', 'ReverseGeocodeController@lookup');
