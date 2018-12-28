<?php

namespace App\Libraries\Sunries;


class Report
{
    public static function getMontlyChartReport($aReportData, $iMonth, $iYear, $bAverage = false)
    {
        if (!is_array($aReportData))
        {
            $aReportData = $aReportData->toArray();
        }
        $aTempMonthData = self::createMonthArray($iMonth, $iYear);

        $aTempReportData   = self::changeArrayReport($aReportData);
        $aResultReportData = array_merge($aTempMonthData, $aTempReportData);
        $iSum = array_sum($aResultReportData);
        if ($bAverage)
        {
            $count = 1;
            if($iYear > date("Y"))
            {
                $count = 1;
            }
            else if($iYear == date("Y") && $iMonth == date("m"))
            {
                $count = date("d") - 1;
            }
            else
            {
                $count = date("t");
            }
            if($count < 1) $count = 1;
            $iSum = round($iSum / $count, 2);
        }
        return array(
            "chart_data" => $aResultReportData,
            "total"      => $iSum
        );

    }

    public static function changeArrayReport($aReportData = array())
    {
        $aResult = array();
        if (!empty($aReportData))
        {
            foreach ($aReportData as $aData)
            {
                $aResult["day-" . $aData["day"]] = $aData["value"];
            }
        }
        return $aResult;
    }

    public static function createMonthArray($iMonth, $iYear)
    {
        $iLastDay = date("t", strtotime($iYear . "-" . $iMonth . "-1"));
        $aResult  = array();
        for ($i = 1; $i <= $iLastDay; $i++)
        {
            $aResult["day-" . $i] = 0;
        }
        return $aResult;
    }

}