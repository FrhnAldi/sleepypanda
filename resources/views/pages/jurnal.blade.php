@extends('layouts.app')

@section('title', 'Jurnal Tidur Report')

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
        grid-template-columns: minmax(400px, 45%) 1fr;
        gap: 30px;
        align-items: stretch;
        transition: all 0.3s ease;
    }

    /* Left Side - User Reports */
    .reports-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
        height: 100%;
    }

    .report-card {
        background: #3C4567;
        border: 1.5px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 18px 28px;
        transition: all 0.3s ease;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .report-card:hover {
        background: #454D72;
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .card-date {
        font-size: 13px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 12px;
        transition: font-size 0.3s ease;
    }

    .card-items {
        display: flex;
        flex-direction: row;
        gap: 18px;
        justify-content: space-between;
        transition: gap 0.3s ease;
    }

    .card-item {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        gap: 10px;
        flex: 1;
        min-width: 0;
        overflow: hidden;
    }

    .item-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        flex-shrink: 0;
        transition: all 0.3s ease;
        background: transparent;
    }

    .icon-user {
        background: transparent;
    }

    .icon-sleep {
        background: transparent;
    }

    .icon-time {
        background: transparent;
    }

    .item-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
        min-width: 0;
    }

    .item-label {
        font-size: 10px;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 4px;
        white-space: nowrap;
        line-height: 1.4;
        transition: font-size 0.3s ease;
    }

    .item-value {
        font-size: 12px;
        font-weight: 700;
        color: white;
        white-space: nowrap;
        line-height: 1.3;
        transition: font-size 0.3s ease;
    }

    /* Right Side - Chart */
    .chart-section {
        background: #3C4567;
        border: 1.5px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 25px;
        height: 100%;
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
        min-height: 400px;
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
            grid-template-columns: minmax(350px, 40%) 1fr;
            gap: 20px;
        }
        
        .main-content.pushed .main-container {
            padding: 25px 20px;
        }
        
        .main-content.pushed .card-items {
            gap: 12px;
        }
        
        .main-content.pushed .item-icon {
            width: 40px;
            height: 40px;
            font-size: 22px;
        }
        
        .main-content.pushed .item-label {
            font-size: 9px;
        }
        
        .main-content.pushed .item-value {
            font-size: 10px;
        }
        
        .main-content.pushed .report-card {
            padding: 16px 22px;
        }
        
        .main-content.pushed .chart-section {
            padding: 20px;
        }
        
        .main-content.pushed .card-date {
            font-size: 12px;
        }
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .reports-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
    }

    @media (max-width: 640px) {
        .page-title {
            font-size: 24px;
        }

        .main-container {
            padding: 20px;
        }

        .reports-section {
            grid-template-columns: 1fr;
        }

        .chart-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .chart-filter {
            width: 100%;
        }

        .chart-container {
            min-height: 300px;
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
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Left Side - 3 User Reports -->
            <div class="reports-section">
                <!-- Report Card 1 -->
                <div class="report-card">
                    <div class="card-date">12 Agustus 2023</div>
                    <div class="card-items">
                        <div class="card-item">
                            <div class="item-icon icon-user">😊</div>
                            <div class="item-content">
                                <div class="item-label">User</div>
                                <div class="item-value">1000</div>
                            </div>
                        </div>
                        <div class="card-item">
                            <div class="item-icon icon-sleep">😴</div>
                            <div class="item-content">
                                <div class="item-label">Avarage Durasi Tidur</div>
                                <div class="item-value">7 jam 2 menit</div>
                            </div>
                        </div>
                        <div class="card-item">
                            <div class="item-icon icon-time">⭐</div>
                            <div class="item-content">
                                <div class="item-label">Avarage Waktu Tidur</div>
                                <div class="item-value">21:30 - 06:10</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Card 2 -->
                <div class="report-card">
                    <div class="card-date">12 Agustus 2023</div>
                    <div class="card-items">
                        <div class="card-item">
                            <div class="item-icon icon-user">😊</div>
                            <div class="item-content">
                                <div class="item-label">User</div>
                                <div class="item-value">1000</div>
                            </div>
                        </div>
                        <div class="card-item">
                            <div class="item-icon icon-sleep">😴</div>
                            <div class="item-content">
                                <div class="item-label">Avarage Durasi Tidur</div>
                                <div class="item-value">7 jam 2 menit</div>
                            </div>
                        </div>
                        <div class="card-item">
                            <div class="item-icon icon-time">⭐</div>
                            <div class="item-content">
                                <div class="item-label">Avarage Waktu Tidur</div>
                                <div class="item-value">21:30 - 06:10</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Card 3 -->
                <div class="report-card">
                    <div class="card-date">12 Agustus 2023</div>
                    <div class="card-items">
                        <div class="card-item">
                            <div class="item-icon icon-user">😊</div>
                            <div class="item-content">
                                <div class="item-label">User</div>
                                <div class="item-value">1000</div>
                            </div>
                        </div>
                        <div class="card-item">
                            <div class="item-icon icon-sleep">😴</div>
                            <div class="item-content">
                                <div class="item-label">Avarage Durasi Tidur</div>
                                <div class="item-value">7 jam 2 menit</div>
                            </div>
                        </div>
                        <div class="card-item">
                            <div class="item-icon icon-time">⭐</div>
                            <div class="item-content">
                                <div class="item-label">Avarage Waktu Tidur</div>
                                <div class="item-value">21:30 - 06:10</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Chart -->
            <div class="chart-section">
                <div class="chart-header">
                    <h3 class="chart-title">Users</h3>
                    <div class="chart-filter">
                        <select id="chartFilter" class="dropdown-select">
                            <option value="12-august">12 Agustus 2023</option>
                            <option value="13-august">13 Agustus 2023</option>
                            <option value="14-august">14 Agustus 2023</option>
                        </select>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="usersChart"></canvas>
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
        // Chart.js Configuration
        const ctx = document.getElementById('usersChart').getContext('2d');
        
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(255, 193, 7, 0.3)');
        gradient.addColorStop(1, 'rgba(255, 193, 7, 0)');

        // Plugin untuk menampilkan angka Y axis secara manual
        const customYAxisPlugin = {
            id: 'customYAxis',
            afterDraw: (chart) => {
                const ctx = chart.ctx;
                const yScale = chart.scales.y;
                const chartHeight = yScale.bottom - yScale.top;
                
                const values = [
                    { value: 0, position: 1.0 },
                    { value: 10, position: 0.8 },
                    { value: 100, position: 0.6 },
                    { value: 1000, position: 0.4 },
                    { value: 2000, position: 0.2 },
                    { value: 2500, position: 0.0 }
                ];
                
                ctx.save();
                ctx.fillStyle = 'rgba(255, 255, 255, 0.6)';
                ctx.font = '11px "Space Grotesk", sans-serif';
                ctx.textAlign = 'left';
                ctx.textBaseline = 'middle';
                
                values.forEach(item => {
                    const y = yScale.top + (chartHeight * item.position);
                    ctx.fillText(item.value.toString(), yScale.left - 35, y);
                });
                
                ctx.restore();
            }
        };

        const usersChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['0j', '2j', '4j', '6j', '8j'],
                datasets: [{
                    label: 'Users',
                    data: [0, 1500, 400, 100, 2300],
                    borderColor: '#FFC107',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    tension: 0,
                    fill: true,
                    pointBackgroundColor: '#FFC107',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 35,
                        right: 10,
                        top: 10,
                        bottom: 10
                    }
                },
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
                        borderColor: 'rgba(255, 193, 7, 0.3)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        max: 2500,
                        ticks: {
                            display: false
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
            },
            plugins: [customYAxisPlugin]
        });

        // Listen to window resize events (triggered by sidebar toggle)
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                if (usersChart) {
                    usersChart.resize();
                }
            }, 100);
        });

        // Also listen to specific sidebar toggle events if available
        const hamburger = document.getElementById('hamburger');
        const closeSidebar = document.getElementById('closeSidebar');
        
        if (hamburger) {
            hamburger.addEventListener('click', function() {
                setTimeout(function() {
                    if (usersChart) {
                        usersChart.resize();
                    }
                }, 350); // Wait for sidebar animation to complete
            });
        }
        
        if (closeSidebar) {
            closeSidebar.addEventListener('click', function() {
                setTimeout(function() {
                    if (usersChart) {
                        usersChart.resize();
                    }
                }, 350); // Wait for sidebar animation to complete
            });
        }

        // Filter functionality
        document.getElementById('filterDropdown').addEventListener('change', function(e) {
            const value = e.target.value;
            if (value === 'weekly') {
                window.location.href = '{{ route("jurnal.tidur.weekly") }}';
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