<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\MonthlyReportService;

class MonthlyReportController extends Controller
{
    protected $service;
    public function __construct(MonthlyReportService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        return $this->service->getReports();
    }
    public function store(Request $request)
    {
        return $this->service->createReport($request->all());
    }
}
