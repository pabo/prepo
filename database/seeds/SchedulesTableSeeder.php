<?php

use Illuminate\Database\Seeder;
use App\Schedule;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//
		$schedule = new Schedule;
		$schedule->street = "1ST AV";
		$schedule->min = "100";
		$schedule->max = "499";
		$schedule->posted = true;
		$schedule->rawschedule = "Posted (3am - 6am), ES Thu, WS Fri";
		$schedule->save();

		$schedule = new Schedule;
		$schedule->street = "1ST AV";
		$schedule->min = "500";
		$schedule->max = "599";
		$schedule->posted = true;
		$schedule->rawschedule = "Posted (3am - 6am), WS Mon,Wed,& Fri; ES Tue & Thu";
		$schedule->save();

		$schedule = new Schedule;
		$schedule->street = "HAMILTON ST";
		$schedule->min = "4100";
		$schedule->max = "4199";
		$schedule->posted = true;
		$schedule->rawschedule = "Posted (7am - 10am), WS 2nd & 4th Tue, ES 2nd & 4th Mon";
		$schedule->save();
    }
}
