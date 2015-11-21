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