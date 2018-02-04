<?php

namespace App\SOLID\SRP;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class SalesRepository
{

    public function between($startDate, $endDate)
    {
        return DB::table('sales')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('charge') / 100;
    }
}


class SalesReporter
{

    /**
     * @var SalesRepository
     */
    private $repo;

    public function __construct(SalesRepository $repo)
    {
        $this->repo = $repo;
    }

    public function between($startDate, $endDate, SalesReportOutputInterface $salesOutput)
    {
        $sales = $this->repo->between($startDate, $endDate);

        return $salesOutput->output($sales);
    }

}

class HtmlOutputer implements SalesReportOutputInterface
{
    public function output($sales)
    {
        return "<h1>Sales: $sales</h1>";
    }
}

interface SalesReportOutputInterface
{
    public function output($sales);
}

/**
 *   app/routes.php
 */
Route::get('/', function () {
    $report = new SalesReporter(new SalesRepository);

    $begin = \Carbon\Carbon::now()->subDays(10);
    $end = \Carbon\Carbon::now();

    return $report->between($begin, $end, new HtmlOutputer());
});