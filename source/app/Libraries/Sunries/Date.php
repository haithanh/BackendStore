<?php

namespace App\Libraries\Sunries;


class Date
{
    public static function createDateRange($startDate, $endDate, $format = "Y-m-d")
    {
        $begin = new \DateTime($startDate);
        $end   = new \DateTime($endDate);

        $interval  = new \DateInterval('P1D'); // 1 Day
        $dateRange = new \DatePeriod($begin, $interval, $end);

        $range = [];
        foreach ($dateRange as $date)
        {
            $range[] = $date->format($format);
        }

        return $range;
    }
}