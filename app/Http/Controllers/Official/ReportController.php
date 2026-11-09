<?php

namespace App\Http\Controllers\Official;

use App\Http\Controllers\Controller;
use App\Models\Incident;

class ReportController extends Controller
{
    public function index()
    {
        $all = Incident::all();

        // Get available years
        $years = [];

        foreach ($all as $incident) {
            if ($incident->incident_date) {
                $year = $incident->incident_date->format('Y');

                if (!in_array($year, $years)) {
                    $years[] = $year;
                }
            }
        }

        rsort($years);

        // Get selected filters
        $selectedYear = request('year');
        $selectedMonth = request('month');

        // Check if selected year is valid
        if (!in_array((string) $selectedYear, $years)) {
            $selectedYear = '';
        }

        // Check if selected month is valid
        if (!is_numeric($selectedMonth) || $selectedMonth < 1 || $selectedMonth > 12) {
            $selectedMonth = '';
        }

        // Filter complaints
        $filtered = [];

        foreach ($all as $incident) {
            if (!$incident->incident_date) {
                continue;
            }

            if ($selectedYear && $incident->incident_date->format('Y') != $selectedYear) {
                continue;
            }

            if ($selectedMonth && $incident->incident_date->format('m') != $selectedMonth) {
                continue;
            }

            $filtered[] = $incident;
        }

        // Prepare report data
        $total = count($filtered);
        $byStatus = [];
        $byType = [];
        $byLocation = [];
        $byMonth = [];

        $settledCount = 0;
        $totalDays = 0;

        foreach ($filtered as $incident) {

            // Count by status
            $status = $incident->status;
            if (!isset($byStatus[$status])) {
                $byStatus[$status] = 0;
            }
            $byStatus[$status]++;

            // Count by incident type
            $type = $incident->incident_type;
            if (!isset($byType[$type])) {
                $byType[$type] = 0;
            }
            $byType[$type]++;

            // Count by location
            $location = $incident->location;
            if (!isset($byLocation[$location])) {
                $byLocation[$location] = 0;
            }
            $byLocation[$location]++;

            // Count by month
            $month = $incident->incident_date->format('Y-m');
            if (!isset($byMonth[$month])) {
                $byMonth[$month] = 0;
            }
            $byMonth[$month]++;

            // Calculate settled cases
            if ($incident->status == 'Settled') {
                $settledCount++;
                $totalDays += $incident->created_at->diffInDays($incident->updated_at);
            }
        }

        // Sort locations from highest to lowest
        arsort($byLocation);
        $byLocation = array_slice($byLocation, 0, 5, true);

        // Sort months
        ksort($byMonth);

        // Calculate settlement rate
        $rate = 0;

        if ($total > 0) {
            $rate = round(($settledCount / $total) * 100);
        }

        // Calculate average settlement days
        $avgDays = 0;

        if ($settledCount > 0) {
            $avgDays = round($totalDays / $settledCount);
        }

        return view('official.reports', [
            'total' => $total,
            'byStatus' => $byStatus,
            'byType' => $byType,
            'byLocation' => $byLocation,
            'byMonth' => $byMonth,
            'rate' => $rate,
            'avgDays' => $avgDays,
            'years' => $years,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
        ]);
    }
}
