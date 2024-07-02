<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cctv;
use App\Models\CctvMonitoring;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil tahun saat ini
        $currentYear = Carbon::now()->year;
    
        // Ambil semua CCTV
        $cctvs = Cctv::all();
    
        // Array untuk menyimpan data chart
        $chartData = [];
    
        // Data untuk menyimpan total persentase per bulan
        $monthlyData = [];
    
        foreach ($cctvs as $cctv) {
            $cctvMonitoringData = CctvMonitoring::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "OK" THEN 1 ELSE 0 END) as ok_count'),
                DB::raw('SUM(CASE WHEN status = "NG" THEN 1 ELSE 0 END) as ng_count')
            )
            ->where('cctv_id', $cctv->id)
            ->whereYear('created_at', $currentYear) // Hanya ambil data untuk tahun saat ini
            ->groupBy('month')
            ->orderBy('month', 'asc') // Urutkan berdasarkan bulan secara naik
            ->get();
    
            foreach ($cctvMonitoringData as $dataPoint) {
                $monthName = Carbon::createFromDate($currentYear, $dataPoint->month, 1)->format('F');
                $percentage = $dataPoint->total > 0 ? ($dataPoint->ok_count / $dataPoint->total) * 100 : 0;
    
                if (!isset($monthlyData[$dataPoint->month])) {
                    $monthlyData[$dataPoint->month] = ['total_ok' => 0, 'total_count' => 0];
                }
    
                $monthlyData[$dataPoint->month]['total_ok'] += $dataPoint->ok_count;
                $monthlyData[$dataPoint->month]['total_count'] += $dataPoint->total;
            }
        }
    
        $labels = [];
        $data = [];
    
        foreach ($monthlyData as $month => $dataPoint) {
            $monthName = Carbon::createFromDate($currentYear, $month, 1)->format('F');
            $labels[] = $monthName;
            $percentage = $dataPoint['total_count'] > 0 ? ($dataPoint['total_ok'] / $dataPoint['total_count']) * 100 : 0;
            $data[] = number_format($percentage, 2);
        }
    
        $chartData = [
            'labels' => $labels,
            'data' => $data,
            'label' => 'Overall CCTV Monitoring OK Percentage for ' . $currentYear
        ];
    
        return view('dashboard.index', compact('chartData'));
    }
}
