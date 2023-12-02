<?php

namespace App\Helpers;

use DateTime;
use stdClass;

final class DateTimeSetter 
{
    public static function setDateTime($dateItem){
        if($dateItem==null) return null;
        if(is_string($dateItem)) return new DateTime($dateItem);
        if($dateItem instanceof DateTime) return $dateItem;
        if($dateItem instanceof stdClass) return new DateTime($dateItem->date);
        return null;
    }
}
