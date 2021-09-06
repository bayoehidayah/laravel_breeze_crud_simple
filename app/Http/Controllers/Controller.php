<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function changeNumberToMonth($number, $type = 'full', $region = 'indonesia'){
        $number = intval($number);
        $data_month = [
            '1' => [
                'full' => ['indonesia' => 'Januari', 'english' => 'January'],
                'med' => ['indonesia' => 'Jan', 'english' => 'Jan']
            ],
            '2' => [
                'full' => ['indonesia' => 'Februari', 'english' => 'February'],
                'med' => ['indonesia' => 'Feb', 'english' => 'Feb']
            ],
            '3' => [
                'full' => ['indonesia' => 'Maret', 'english' => 'March'],
                'med' => ['indonesia' => 'Mar', 'english' => 'Mar']
            ],
            '4' => [
                'full' => ['indonesia' => 'April', 'english' => 'April'],
                'med' => ['indonesia' => 'April', 'english' => 'April']
            ],
            '5' => [
                'full' => ['indonesia' => 'Mei', 'english' => 'May'],
                'med' => ['indonesia' => 'Mei', 'english' => 'May']
            ],
            '6' => [
                'full' => ['indonesia' => 'Juni', 'english' => 'June'],
                'med' => ['indonesia' => 'Jun', 'english' => 'Jun']
            ],
            '7' => [
                'full' => ['indonesia' => 'Juli', 'english' => 'July'],
                'med' => ['indonesia' => 'Jul', 'english' => 'Jul']
            ],
            '8' => [
                'full' => ['indonesia' => 'Agustus', 'english' => 'August'],
                'med' => ['indonesia' => 'Agustus', 'english' => 'August']
            ],
            '9' => [
                'full' => ['indonesia' => 'September', 'english' => 'September'],
                'med' => ['indonesia' => 'September', 'english' => 'September']
            ],
            '10' => [
                'full' => ['indonesia' => 'Oktober', 'english' => 'October'],
                'med' => ['indonesia' => 'Oktober', 'english' => 'October']
            ],
            '11' => [
                'full' => ['indonesia' => 'November', 'english' => 'November'],
                'med' => ['indonesia' => 'November', 'english' => 'November']
            ],
            '12' => [
                'full' => ['indonesia' => 'Desember', 'english' => 'December'],
                'med' => ['indonesia' => 'Desember', 'english' => 'December']
            ]
        ];

        $month_name = "-";
        if (array_key_exists($number, $data_month)) {
            $month_name = $data_month[$number][$type][$region];
        }

        return $month_name;
    }

    public function changeDateTimeStyle($dateTime, $show_second = false)
    {
        $changeData     = explode(" ", $dateTime);

        $changeDate     = explode("-", @$changeData[0]);
        $changeTime     = explode(":", @$changeData[1]);

        $date         = @$changeDate[2];
        $mon         = $this->changeNumberToMonth(@$changeDate[1], "med");
        $year        = $changeDate[0];

        $second = @$changeTime[2];
        $minute = @$changeTime[1];
        $hour     = @$changeTime[0];

        if ($show_second) {
            $resultChange     = "$date $mon $year $hour:$minute:$second";
        } else {
            $resultChange     = "$date $mon $year $hour:$minute";
        }

        return $resultChange;
    }
}
