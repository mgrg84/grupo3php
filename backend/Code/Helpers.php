<?php

namespace backend\Code;
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
}
?>