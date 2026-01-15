<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JurnalTidurController extends Controller
{
    /**
     * Display the daily report page
     */
    public function daily()
    {
        // Data untuk daily report
        $data = [
            'reports' => [
                [
                    'date' => '12 Agustus 2023',
                    'user_count' => 1000,
                    'avg_duration' => '7 jam 2 menit',
                    'avg_time' => '21:30 - 06:10'
                ],
                [
                    'date' => '12 Agustus 2023',
                    'user_count' => 1000,
                    'avg_duration' => '7 jam 2 menit',
                    'avg_time' => '21:30 - 06:10'
                ],
                [
                    'date' => '12 Agustus 2023',
                    'user_count' => 1000,
                    'avg_duration' => '7 jam 2 menit',
                    'avg_time' => '21:30 - 06:10'
                ]
            ],
            'chart_data' => [
                'labels' => ['0j', '2j', '4j', '6j', '8j'],
                'data' => [0, 1500, 400, 100, 2300]
            ],
            'chart_dates' => [
                ['value' => '12-august', 'label' => '12 Agustus 2023'],
                ['value' => '13-august', 'label' => '13 Agustus 2023'],
                ['value' => '14-august', 'label' => '14 Agustus 2023']
            ]
        ];

        return view('pages.jurnal', $data);
    }

    /**
     * Display the weekly report page
     */
    public function weekly()
    {
        // Data untuk weekly report
        $data = [
            'report' => [
                'date_range' => '1 Juni - 7 Juni 2023',
                'user_count' => 4000,
                'avg_duration' => '8 jam 2 menit',
                'total_duration' => '60 jam 51 menit',
                'avg_sleep_time' => '21:08',
                'avg_wake_time' => '06:30'
            ],
            'chart_data' => [
                'labels' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                'data' => [5, 7, 4, 9, 7, 7, 3.5],
                'colors' => ['#B56576', '#B56576', '#B56576', '#E74C4C', '#B56576', '#B56576', '#B56576']
            ],
            'week_options' => [
                ['value' => 'week1', 'label' => '1 Juni - 7 Juni 2023'],
                ['value' => 'week2', 'label' => '8 Juni - 14 Juni 2023'],
                ['value' => 'week3', 'label' => '15 Juni - 21 Juni 2023']
            ]
        ];

        return view('pages.jweekly', $data);
    }

    /**
     * Display the monthly report page
     */
    public function monthly()
    {
        // Data untuk monthly report
        $data = [
            'reports' => [
                // Tambahkan data monthly reports di sini jika diperlukan
            ],
            'chart_data' => [
                // Tambahkan data chart monthly di sini
            ]
        ];

        return view('pages.jmonthly', $data);
    }

    /**
     * Get filtered data via AJAX
     */
    public function getFilteredData(Request $request)
    {
        $type = $request->input('type'); // daily, weekly, monthly
        $date = $request->input('date');

        // Logic untuk fetch data berdasarkan filter
        // Contoh response:
        $response = [
            'success' => true,
            'data' => [
                'labels' => ['0j', '2j', '4j', '6j', '8j'],
                'values' => [0, 1500, 400, 100, 2300]
            ]
        ];

        return response()->json($response);
    }

    /**
     * Get chart data for specific date
     */
    public function getChartData(Request $request)
    {
        $type = $request->input('type'); // daily, weekly, monthly
        $selectedDate = $request->input('selected_date');

        // Logic untuk fetch chart data berdasarkan tanggal
        switch ($type) {
            case 'daily':
                $chartData = [
                    'labels' => ['0j', '2j', '4j', '6j', '8j'],
                    'data' => [0, 1500, 400, 100, 2300]
                ];
                break;
            
            case 'weekly':
                $chartData = [
                    'labels' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    'data' => [5, 7, 4, 9, 7, 7, 3.5]
                ];
                break;
            
            case 'monthly':
                $chartData = [
                    'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    'data' => [30, 35, 28, 32]
                ];
                break;
            
            default:
                $chartData = [];
        }

        return response()->json([
            'success' => true,
            'data' => $chartData
        ]);
    }
}