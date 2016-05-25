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
		# source: http://archive.sandiego.gov/stormwater/pdf/district3schedule.pdf
		# take source pdf and copy/paste text into text file
		# This run() will then parse it and seed the schedules table with it

		$schedulefile = "storage/import/district3schedule.txt";

		Log::info("seeding schedules table from $schedulefile");

		if (($handle = fopen($schedulefile, "r")) !== FALSE) {
			while (($line = fgets($handle)) !== FALSE) {
				# ignore header / other non data lines
				if (preg_match("/^(Street Sweeping|Council District|Street Name Block|City of San Diego)/", $line, $matches)) {
					continue;
				}

				# Examples of valid data lines:
				#08TH AV 3900 - 3999 UNIVERSITY AV - SR-163 SB OFF RA Not Posted, Both Sides Tue
				#GEORGIA ST 3750 - 3889 ROBINSON AV - UNIVERSITY (S FTG) Not Posted, Both Sides Odd Month 3rd Tue

				elseif (preg_match("/^([()0-9A-Z ]+) (\d+) - (\d+) ([()0-9A-Z -]+) - ([()0-9A-Z -]+) (Posted|Not Posted)[, ]?(.*)$/", $line, $matches)) {

					#add record to db
					$schedule = new Schedule;
					$schedule->street = $matches[1];
					$schedule->min = $matches[2];
					$schedule->max = $matches[3];
					#$matches[4] is first cross street limit
					#$matches[5] is second cross street limit
					$schedule->posted = ($matches[6] === "Posted");
					$schedule->rawschedule = $matches[7];
					$schedule->save();

					#debug printf
					#printf("%5s - %5s %-20s %55s (%s) \n", $min, $max, $street, $schedule, $posted);
				}
				else {
					# warn if the line wasn't in an expected format
					Log::warning("file $schedulefile contains an unparsed line: $line");
				}
			}
		}

		/** Three sample schedules
		$schedule = new Schedule;
		$schedule->street = "1ST AV";
		$schedule->min = "100";
		$schedule->max = "499";
		$schedule->posted = true;
		$schedule->rawschedule = "(3am - 6am), ES Thu, WS Fri";
		$schedule->save();

		$schedule = new Schedule;
		$schedule->street = "1ST AV";
		$schedule->min = "500";
		$schedule->max = "599";
		$schedule->posted = true;
		$schedule->rawschedule = "(3am - 6am), WS Mon,Wed,& Fri; ES Tue & Thu";
		$schedule->save();

		$schedule = new Schedule;
		$schedule->street = "HAMILTON ST";
		$schedule->min = "4100";
		$schedule->max = "4199";
		$schedule->posted = true;
		$schedule->rawschedule = "(7am - 10am), WS 2nd & 4th Tue, ES 2nd & 4th Mon";
		$schedule->save();
		**/
    }
}
