<?php

namespace App\Infrastructure\Helpers;
use Carbon\Carbon;

/**
 * Class DateTimeHelper is a helper class that know how to handle ISO8601 conversion
 * representation.
 */

class DateTimeHelper
{

		public static function convertISO8601DurationToSeconds($iso8601DurationStr)
		 {
			   $interval = new \DateInterval($iso8601DurationStr);
			   $seconds = $interval->h * 3600 + $interval->i * 60 + $interval->s;
			   return (int) $seconds;
		 }


		public static function getAge($date)
		 {

		    return Carbon::parse($date)->age;
		 }
}