@extends('layouts.app')

@section('title', 'Jurnal Tidur Report - Weekly')

@section('styles')
<style>
    .container-jurnal {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
        width: 100%;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }

    .page-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: white;
        margin: 0;
    }

    .main-container {
        background: rgba(255, 255, 255, 0.05);
        border: 1.5px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 30px;
        overflow: hidden;
    }

    .filter-row {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 30px;
    }

    .dropdown-select {
        min-width: 150px;
        background: rgba(255, 255, 255, 0.08);
        border: 1.5px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 12px 40px 12px 16px;
        color: white;
        font-size: 14px;
        font-weight: 600;
        font-family: 'Space Grotesk', sans-serif;
        cursor: pointer;
        outline: none;
        transition: all 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
    }

    .dropdown-select:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.25);
    }

    .dropdown-select option {
        background: #2C2E4E;
        color: white;
    }

    .content-grid {
        display: grid;
        grid-template-columns: minmax(350px, 40%) 1fr;
        gap: 30px;
        align-items: start;
        transition: all 0.3s ease;
    }

    /* Left Side - Report Card - EXACT COPY FROM MONTHLY */
    .report-card {
        background: #3C4567;
        border: 1.5px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 18px;
        transition: all 0.3s ease;
        height: 245px;
        width: 100%;
    }

    .report-card:hover {
        background: #454D72;
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    /* Date at top */
    .card-date {
        font-size: 12px;
        font-weight: 600;
        color: white;
        text-align: center;
        margin-bottom: 22px;
        transition: font-size 0.3s ease;
    }

    /* Main content: User left, Stats right */
    .card-main {
        display: flex;
        gap: 28px;
        align-items: center;
        height: calc(100% - 46px);
        transition: gap 0.3s ease;
    }

    /* User section - Left side, centered vertically */
    .user-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex: 0 0 70px;
        transition: all 0.3s ease;
    }

    .user-emoji {
        font-size: 30px;
        line-height: 1;
        transition: font-size 0.3s ease;
    }

    .user-label {
        font-size: 7px;
        color: rgba(255, 255, 255, 0.7);
        margin-top: 3px;
        transition: font-size 0.3s ease;
    }

    .user-count {
        font-size: 16px;
        font-weight: 700;
        color: white;
        line-height: 1;
        transition: font-size 0.3s ease;
    }

    /* Stats Grid - Right side, 2x2 */
    .stats-grid {
        flex: 1;
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        gap: 50px;
        align-content: center;
        transition: gap 0.3s ease;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 12px;
        transition: gap 0.3s ease;
    }

    .stat-icon {
        font-size: 26px;
        line-height: 1;
        flex-shrink: 0;
        transition: font-size 0.3s ease;
    }

    .stat-text {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
        flex: 1;
    }

    .stat-label {
        font-size: 7.5px;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: font-size 0.3s ease;
    }

    .stat-value {
        font-size: 9px;
        font-weight: 700;
        color: white;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: font-size 0.3s ease;
    }

    /* Right Side - Chart */
    .chart-section {
        background: #3C4567;
        border: 1.5px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 25px;
        height: 565px;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-title {
        font-size: 20px;
        font-weight: 700;
        color: white;
        margin: 0;
    }

    .chart-filter {
        min-width: 180px;
    }

    .chart-container {
        flex: 1;
        position: relative;
        width: 100%;
        overflow: hidden;
    }
    
    .chart-container canvas {
        max-width: 100%;
        height: auto !important;
    }

    /* Responsive untuk sidebar active */
    @media (min-width: 969px) {
        .main-content.pushed .container-jurnal {
            max-width: 100%;
            padding: 40px 15px;
        }
        
        .main-content.pushed .content-grid {
            grid-template-columns: minmax(300px, 35%) 1fr;
            gap: 20px;
        }
        
        .main-content.pushed .main-container {
            padding: 25px 20px;
        }
        
        .main-content.pushed .card-main {
            gap: 18px;
        }
        
        .main-content.pushed .user-section {
            flex: 0 0 60px;
        }
        
        .main-content.pushed .user-emoji {
            font-size: 24px;
        }
        
        .main-content.pushed .user-label {
            font-size: 6px;
        }
        
        .main-content.pushed .user-count {
            font-size: 14px;
        }
        
        .main-content.pushed .stats-grid {
            gap: 30px;
        }
        
        .main-content.pushed .stat-icon {
            font-size: 22px;
        }
        
        .main-content.pushed .stat-item {
            gap: 8px;
        }
        
        .main-content.pushed .stat-label {
            font-size: 6.5px;
        }
        
        .main-content.pushed .stat-value {
            font-size: 8px;
        }
        
        .main-content.pushed .report-card {
            padding: 16px;
            height: 230px;
        }
        
        .main-content.pushed .card-date {
            font-size: 11px;
            margin-bottom: 18px;
        }
        
        .main-content.pushed .chart-section {
            padding: 20px;
            height: 530px;
        }
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .report-card {
            width: 100%;
        }

        .chart-section {
            height: 450px;
        }
    }

    @media (max-width: 640px) {
        .page-title {
            font-size: 24px;
        }

        .main-container {
            padding: 20px;
        }

        .card-main {
            flex-direction: column;
            gap: 12px;
        }

        .user-section {
            flex: 0 0 auto;
        }

        .stats-grid {
            width: 100%;
            gap: 10px;
        }

        .stat-label {
            font-size: 8px;
        }

        .stat-value {
            font-size: 10px;
        }

        .chart-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .chart-filter {
            width: 100%;
        }

        .chart-section {
            height: 400px;
        }

        .report-card {
            height: auto;
            min-height: 245px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-jurnal">
    <!-- Centered Header -->
    <div class="page-header">
        <h1 class="page-title">Jurnal Tidur Report</h1>
    </div>
    
    <!-- Main Container -->
    <div class="main-container">
        <!-- Filter Row -->
        <div class="filter-row">
            <select id="filterDropdown" class="dropdown-select">
                <option value="daily">Daily</option>
                <option value="weekly" selected>Weekly</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Left Side - Single Report Card (EXACT COPY FROM MONTHLY) -->
            <div class="report-card">
                <!-- Date Header -->
                <div class="card-date">1 Juni - 7 Juni 2023</div>
                
                <!-- Main Content: User Left, Stats Grid Right -->
                <div class="card-main">
                    <!-- User Section - Left Center -->
                    <div class="user-section">
                        <div class="user-emoji">😊</div>
                        <div class="user-label">User</div>
                        <div class="user-count">4000</div>
                    </div>

                    <!-- Stats Grid 2x2 - Right -->
                    <div class="stats-grid">
                        <!-- Top Left: Average Durasi Tidur -->
                        <div class="stat-item">
                            <div class="stat-icon">😴</div>
                            <div class="stat-text">
                                <div class="stat-label">Average</div>
                                <div class="stat-label">Durasi Tidur</div>
                                <div class="stat-value">8 jam 2 menit</div>
                            </div>
                        </div>

                        <!-- Top Right: Total Durasi Tidur -->
                        <div class="stat-item">
                            <div class="stat-icon">⭐</div>
                            <div class="stat-text">
                                <div class="stat-label">Total</div>
                                <div class="stat-label">Durasi Tidur</div>
                                <div class="stat-value">60 jam 51 menit</div>
                            </div>
                        </div>

                        <!-- Bottom Left: Average Mulai Tidur -->
                        <div class="stat-item">
                            <div class="stat-icon">🌙</div>
                            <div class="stat-text">
                                <div class="stat-label">Avg Mulai Tidur</div>
                                <div class="stat-value">21:08</div>
                            </div>
                        </div>

                        <!-- Bottom Right: Average Bangun Tidur -->
                        <div class="stat-item">
                            <div class="stat-icon">☀️</div>
                            <div class="stat-text">
                                <div class="stat-label">Avg Bangun Tidur</div>
                                <div class="stat-value">06:30</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Chart -->
            <div class="chart-section">
                <div class="chart-header">
                    <h3 class="chart-title">Weekly Sleep Hours</h3>
                    <div class="chart-filter">
                        <select id="chartFilter" class="dropdown-select">
                            <option value="week1">1 Juni - 7 Juni 2023</option>
                            <option value="week2">8 Juni - 14 Juni 2023</option>
                            <option value="week3">15 Juni - 21 Juni 2023</option>
                        </select>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="weeklyChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart.js Configuration for Weekly Bar Chart
        const ctx = document.getElementById('weeklyChart').getContext('2d');

        const weeklyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                datasets: [{
                    label: 'Sleep Hours',
                    data: [5, 7, 4, 9, 7, 7, 3.5],
                    backgroundColor: [
                        '#B56576',
                        '#B56576',
                        '#B56576',
                        '#E74C4C',
                        '#B56576',
                        '#B56576',
                        '#B56576'
                    ],
                    borderRadius: 8,
                    barThickness: 50
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + 'j';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        max: 10,
                        ticks: {
                            stepSize: 2,
                            color: 'rgba(255, 255, 255, 0.6)',
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return value + 'j';
                            }
                        },
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    },
                    x: {
                        ticks: {
                            color: 'rgba(255, 255, 255, 0.6)',
                            font: {
                                size: 13,
                                weight: '500'
                            }
                        },
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });

        // Listen to window resize events (triggered by sidebar toggle)
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                if (weeklyChart) {
                    weeklyChart.resize();
                }
            }, 100);
        });

        // Also listen to specific sidebar toggle events if available
        const hamburger = document.getElementById('hamburger');
        const closeSidebar = document.getElementById('closeSidebar');
        
        if (hamburger) {
            hamburger.addEventListener('click', function() {
                setTimeout(function() {
                    if (weeklyChart) {
                        weeklyChart.resize();
                    }
                }, 350); // Wait for sidebar animation to complete
            });
        }
        
        if (closeSidebar) {
            closeSidebar.addEventListener('click', function() {
                setTimeout(function() {
                    if (weeklyChart) {
                        weeklyChart.resize();
                    }
                }, 350); // Wait for sidebar animation to complete
            });
        }

        // Filter functionality - Navigate to different pages
        document.getElementById('filterDropdown').addEventListener('change', function(e) {
            const value = e.target.value;
            if (value === 'daily') {
                window.location.href = '{{ route("jurnal") }}';
            } else if (value === 'monthly') {
                window.location.href = '{{ route("jurnal.tidur.monthly") }}';
            }
        });

        document.getElementById('chartFilter').addEventListener('change', function(e) {
            console.log('Chart filter changed to:', e.target.value);
            // Add your chart update logic here
        });
    });
</script>
@endsection