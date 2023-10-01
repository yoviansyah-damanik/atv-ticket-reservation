<?php

namespace App\Helpers;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ReportHelper
{
    public static function unit_report_print($data, $month, $year, $period)
    {
        return PDF::loadView(
            'printout.exe.unit_report',
            [
                'data' => $data,
                'month' => $month,
                'year' => $year,
                'period' => $period
            ]
        )
            ->setPaper('A4', 'landscape')
            ->output();
    }

    public static function unit_all_report_print($data, $year, $period)
    {
        return PDF::loadView(
            'printout.exe.unit_all_report',
            [
                'data' => $data,
                'year' => $year,
                'period' => $period
            ]
        )
            ->setPaper('A4', 'landscape')
            ->output();
    }

    public static function reservation_report_print($data, $month, $year)
    {
        return PDF::loadView(
            'printout.exe.reservation_report',
            [
                'data' => $data,
                'month' => $month,
                'year' => $year,
            ]
        )
            ->setPaper('A4', 'portrait')
            ->output();
    }

    public static function reservation_all_report_print($data, $year)
    {
        return PDF::loadView(
            'printout.exe.reservation_all_report',
            [
                'data' => $data,
                'year' => $year,
            ]
        )
            ->setPaper('A4', 'portrait')
            ->output();
    }

    public static function revenue_report_print($data, $year)
    {
        return PDF::loadView(
            'printout.exe.revenue_report',
            [
                'data' => $data,
                'year' => $year,
            ]
        )
            ->setPaper('A4', 'portrait')
            ->output();
    }
}
