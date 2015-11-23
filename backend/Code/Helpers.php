<?php


namespace backend\Code;

use Yii;

/**
 * Helpers short summary.
 *
 * Helpers description.
 *
 * @version 1.0
 * @author Pablo
 */
class Helpers
{
	public static function GetDistance($lat1, $lon1, $lat2, $lon2, $unit)
	{
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") 
		{
			return ($miles * 1.609344);
		} 
		else if ($unit == "N") 
		{
			return ($miles * 0.8684);
		}
		else if ($unit == "M") 
		{
			return round($miles * 1.609344 * 1000);
		} 
		else 
		{
			return $miles;
		}
	}
	
    public static function FormatHours($source)
    {
        $result = null;
        if(substr($source, strlen($source)-2,2) == "PM")
        {
            $hours = split(":", $source)[0];
            $result = str_replace($hours, $hours + 12, $source);
        }
        else
        {
            $result = $source;
        }
        return $result;
    }

    public static function GetPriorityDescription($value)
    {
        $result = "";
        switch ($value)
        {
			case 1: $result = Yii::t('app', "Normal");
                break;
			case 2: $result = Yii::t('app', "Alta");
                break;
        }
        return $result;
    }
	
	public static function GetSpanishDay($date)
	{ 
		$result = null;
		$day = date('l', strtotime($date));
		switch($day)
		{
			case "Monday": $result = 'lunes';
				break;
			case 'Tuesday': $result = 'martes';
				break;	
			case 'Wednesday': $result = 'miercoles';
				break;
			case 'Thursday': $result = 'jueves';
				break;
			case 'Friday': $result = 'viernes';
				break;
			case 'Saturday': $result = 'sabado';
				break;
			case 'Sunday': $result = 'domingo';
				break;
		}
		return $result;
	}
}
?>