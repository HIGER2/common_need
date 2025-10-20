<?php

namespace App\Services;

use App\Models\MonthlyReport;

class MonthlyReportService
{

    public function createReport($data)
    {
        try {
            $report = MonthlyReport::create([
                'month' => $data['month'],
                'year' => $data['year'],
                'center_id' => $data['center_id'],
                'liaison_officer_id' => $data['liaison_officer_id'],
                'total_amount' => $data['total_amount'],
                'report_file' => $data['report_file'] ?? null
            ]);
            return response()->json(['success' => true, 'report' => $report], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getReports()
    {
        return response()->json(['success' => true, 'reports' => MonthlyReport::all()]);
    }
}
