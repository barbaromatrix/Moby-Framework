<?php

namespace DateTime;

use \DateTime;

class Times
{
    /**
     * Return the date according parameter
     * 
     * @param string $format
     * @return date
     */
    public static function now($format = 'Y-m-d')
    {
        return DateTime::createFromFormat($format, date('Y-m-d'))->format($format);
    }
}