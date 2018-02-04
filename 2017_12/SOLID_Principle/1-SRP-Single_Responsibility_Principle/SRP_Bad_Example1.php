<?php


namespace App\SOLID\SRP;

use Illuminate\Support\Facades\Auth, Illuminate\Support\Facades\DB, Exception;
use Illuminate\Support\Facades\Route;

class SalesReporter {

    public function between($startDate, $endDate)
    {
        if (! Auth::check()) throw new Exception('Authentication required for reporting');

        $sales = $this->queryDBForSalesBetween($startDate, $endDate);

        return $this->format($sales);
    }

    protected function queryDBForSalesBetween($startDate, $endDate)
    {
        return DB::table('sales')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('charge') / 100;
    }

    protected function format($sales)
    {
        return "<h1>Sales: $sales</h1>";
    }

}

/**
*   app/routes.php
*/
Route::get('/', function()
{
    $report = new SalesReporter();

    $begin = \Carbon\Carbon::now()->subDays(10);
    $end = \Carbon\Carbon::now();

    return $report->between($begin, $end);
});