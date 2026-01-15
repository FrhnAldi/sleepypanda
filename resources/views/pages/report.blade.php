@extends('layouts.app')

@section('title', 'Report')

@section('styles')
<style>
    /* Import Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap');

    body {
        background: #1e2238;
        font-family: 'DM Sans', sans-serif;
        color: #ffffff;
    }

    .report-container {
        padding: 30px;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    /* Stats Cards Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: #272E49;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .stat-card-header {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.6);
        font-weight: 500;
        margin-bottom: 15px;
    }

    .stat-card-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .stat-icon.total-users {
        background: rgba(255, 255, 255, 0.1);
    }

    .stat-icon.insomnia {
        background: rgba(255, 107, 107, 0.15);
    }

    .stat-icon.time-sleep {
        background: rgba(255, 255, 255, 0.1);
    }

    .stat-icon.avg-sleep {
        background: rgba(255, 255, 255, 0.1);
    }

    .stat-icon i {
        font-size: 28px;
    }

    .stat-icon.total-users i {
        color: #ffffff;
    }

    .stat-icon.insomnia i {
        color: #FF6B6B;
    }

    .stat-icon.time-sleep i,
    .stat-icon.avg-sleep i {
        color: #ffffff;
    }

    .stat-value {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 42px;
        font-weight: 700;
        color: #ffffff;
        line-height: 1;
    }

    /* Main Container */
    .main-container {
        background: #272E49;
        border-radius: 20px;
        padding: 25px 30px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        max-width: 100%;
        box-sizing: border-box;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    /* Header Section */
    .container-header {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        margin-bottom: 20px;
        flex-shrink: 0;
        gap: 20px;
    }

    .period-filter {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: 635px;
    }

    .alert-title {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 18px;
        font-weight: 600;
        color: #ffffff;
        margin: 0;
        margin-left: 110px;
    }

    .filter-dropdown {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: 8px 16px;
        color: #ffffff;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        outline: none;
        font-family: 'DM Sans', sans-serif;
        font-weight: 500;

    }

    .filter-dropdown:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .filter-dropdown:focus {
        border-color: rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.08) !important;
    }

    .filter-dropdown option {
    background: #272E49;
    color: #ffffff;
    padding: 8px;
}

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 20px;
        flex: 1;
        min-height: 0;
        overflow: hidden;
    }

    /* Chart Section */
    .chart-section {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        padding: 18px;
        padding-top: 45px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        position: relative;
    }

    .chart-header {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        margin-bottom: 12px;
        flex-shrink: 0;
    }

    .chart-title {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 16px;
        font-weight: 600;
        color: #c24c4c;
        margin: 0;
    }

    .date-range-filter {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 6px;
        padding: 6px 12px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        outline: none;
        font-family: 'DM Sans', sans-serif;
        position: absolute;
        top: 18px;
        right: 18px;

    }

    .date-range-filter:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .date-range-filter:focus {
    border-color: rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.08) !important;
    }
    .date-range-filter option {
    background: #272E49;
    color: #ffffff;
    padding: 6px;
    }

    .chart-container {
        position: relative;
        flex: 1;
        width: 100%;
        min-height: 0;
    }

    /* Alert Cards Section - MODIFIED */
    .alert-cards {
        display: flex;
        flex-direction: column;
        gap: 12px;
        height: 100%;
        overflow: hidden;
    }

    .alert-card {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 10px;
        padding: 14px 16px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    .alert-card:hover {
        background: rgba(255, 255, 255, 0.05);
        transform: translateX(3px);
    }

    .alert-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .alert-date {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.5);
        font-weight: 400;
    }

    .alert-time-ago {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.4);
    }

    .alert-card-content {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
    }

    .alert-top-row {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Bell Icon - MODIFIED untuk posisi turun */
    .alert {
        display: flex;
        align-items: center;
        margin-top: 8px;
    }

    .alert-icon {
        width: 28px;
        height: 28px;
        background: rgba(255, 107, 107, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .alert-icon i {
        color: #FF6B6B;
        font-size: 13px;
    }

    .alert-icon img {
        width: 16px;
        height: 16px;
        object-fit: contain;
    }

    .alert-info {
        flex: 1;
        display: flex;
        align-items: flex-start;
        gap: 20px; /* MODIFIED - Increased gap between user info and sleep info */
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        align-self: center;
    }

    .user-emoji {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    .user-emoji img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .user-emoji span {
        font-size: 14px;
        line-height: 1;
    }

    .user-id {
        font-size: 12px;
        color: #ffffff;
        font-weight: 500;
    }

    .sleep-info {
        display: flex;
        align-items: flex-start;
        gap: 6px;
        flex: 1;
    }

    .sleep-icon {
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 18px;
    }

    .sleep-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .sleep-icon span {
        font-size: 14px;
        line-height: 1;
    }

    .sleep-duration {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.4;
        display: flex;
        flex-direction: column;
    }

    .sleep-duration span {
        display: block;
    }

    .alert-message {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.6);
        line-height: 1.4;
        margin: 0;
        text-align: center;
        padding-top: 4px;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .stats-row {
            grid-template-columns: 1fr;
        }

        .report-container {
            padding: 20px;
        }

        .stat-value {
            font-size: 32px;
        }

        .main-container {
            padding: 20px;
        }

        .container-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .chart-section {
            padding-top: 50px;
        }

        .date-range-filter {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 10px;
            padding: 4px 8px;
        }

        .chart-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="report-container">
    <!-- Stats Cards Row -->
    <div class="stats-row">
        <!-- Total Users -->
        <div class="stat-card">
            <div class="stat-card-header">Total Users</div>
            <div class="stat-card-content">
                <div class="stat-icon total-users">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-value">4500</div>
            </div>
        </div>

        <!-- Insomnia Cases -->
        <div class="stat-card">
            <div class="stat-card-header">Insomnia Cases</div>
            <div class="stat-card-content">
                <div class="stat-icon insomnia">
                    <i class="bi bi-person-fill-exclamation"></i>
                </div>
                <div class="stat-value">900</div>
            </div>
        </div>

        <!-- Time to Sleep -->
        <div class="stat-card">
            <div class="stat-card-header">Time to Sleep</div>
            <div class="stat-card-content">
                <div class="stat-icon time-sleep">
                    <i class="bi bi-clock-fill"></i>
                </div>
                <div class="stat-value">90 min</div>
            </div>
        </div>

        <!-- Average Sleep Time -->
        <div class="stat-card">
            <div class="stat-card-header">Average Sleep Time</div>
            <div class="stat-card-content">
                <div class="stat-icon avg-sleep">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-value">5.2 h</div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Header Section -->
        <div class="container-header">
            <!-- Period Filter - Left -->
            <div class="period-filter">
                <select class="filter-dropdown" id="periodFilter">
                    <option value="monthly">Monthly</option>
                    <option value="weekly" selected>Weekly</option>
                    <option value="daily">Daily</option>
                </select>
            </div>

            <!-- Alert Title - Right -->
            <h2 class="alert-title">Alert Insomnia Terbaru</h2>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Chart Section -->
            <div class="chart-section">
                <div class="chart-header">
                    <h3 class="chart-title">Users</h3>
                    <select class="date-range-filter" id="dateRangeFilter">
                        <option value="12-18-aug" selected>12 Agustus - 18 Agustus 2023</option>
                        <option value="19-25-aug">19 Agustus - 25 Agustus 2023</option>
                        <option value="26-01-sep">26 Agustus - 1 September 2023</option>
                    </select>
                </div>
                <div class="chart-container">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>

            <!-- Alert Cards Section -->
            <div class="alert-cards">
                    <!-- Alert Card 1 -->
                    <div class="alert-card">
                        <div class="alert-card-header">
                            <span class="alert-date">10 September 2023</span>
                            <span class="alert-time-ago">30 menit yang lalu</span>
                        </div>
                        <div class="alert-card-content">
                            <div class="alert-top-row">
                                <div class="alert">
                                    <img src="images/bell.png" style="width: 35px; height: 35px;" alt="Bell">
                                </div>
                                <div class="alert-info">
                                    <div class="user-info">
                                        <div class="user-emoji">
                                            <span>😄</span>
                                        </div>
                                        <span class="user-id">User ID #12145</span>
                                    </div>
                                    <div class="sleep-info">
                                        <div class="sleep-icon">
                                            <img src="images/jam.png" style="width: 25px; height: 25px;" alt="Clock">
                                        </div>
                                        <div class="sleep-duration">
                                            <span>Average Durasi</span>
                                            <span>Tidur</span>
                                            <span>1 Jam 30 Menit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="alert-message">Tidak Tidur selama 22 jam terakhir</p>
                        </div>
                    </div>

                    <!-- Alert Card 2 -->
                    <div class="alert-card">
                        <div class="alert-card-header">
                            <span class="alert-date">15 Agustus 2023</span>
                            <span class="alert-time-ago">15 menit yang lalu</span>
                        </div>
                        <div class="alert-card-content">
                            <div class="alert-top-row">
                                <div class="alert">
                                    <img src="images/bell.png" style="width: 35px; height: 35px;" alt="Bell">
                                </div>
                                <div class="alert-info">
                                    <div class="user-info">
                                        <div class="user-emoji">
                                            <span>😄</span>
                                        </div>
                                        <span class="user-id">User ID #12388</span>
                                    </div>
                                    <div class="sleep-info">
                                        <div class="sleep-icon">
                                            <img src="images/jam.png" style="width: 25px; height: 25px;" alt="Clock">
                                        </div>
                                        <div class="sleep-duration">
                                            <span>Average Durasi</span>
                                            <span>Tidur</span>
                                            <span>1 Jam 35 Menit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="alert-message">Tidak Tidur selama 36 jam terakhir</p>
                        </div>
                    </div>

                    <!-- Alert Card 3 -->
                    <div class="alert-card">
                        <div class="alert-card-header">
                            <span class="alert-date">14 Agustus 2023</span>
                            <span class="alert-time-ago">1 hari yang lalu</span>
                        </div>
                        <div class="alert-card-content">
                            <div class="alert-top-row">
                                <div class="alert">
                                    <img src="images/bell.png" style="width: 35px; height: 35px;" alt="Bell">
                                </div>
                                <div class="alert-info">
                                    <div class="user-info">
                                        <div class="user-emoji">
                                            <span>😄</span>
                                        </div>
                                        <span class="user-id">User ID #16902</span>
                                    </div>
                                    <div class="sleep-info">
                                        <div class="sleep-icon">
                                            <img src="images/jam.png" style="width: 25px; height: 25px;" alt="Clock">
                                        </div>
                                        <div class="sleep-duration">
                                            <span>Average Durasi</span>
                                            <span>Tidur</span>
                                            <span>1 Jam 20 Menit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="alert-message">Tidak Tidur selama 20 jam terakhir</p>
                        </div>
                    </div>

                    <!-- Alert Card 4 -->
                    <div class="alert-card">
                        <div class="alert-card-header">
                            <span class="alert-date">13 Agustus 2023</span>
                            <span class="alert-time-ago">2 hari yang lalu</span>
                        </div>
                        <div class="alert-card-content">
                            <div class="alert-top-row">
                                <div class="alert">
                                    <img src="images/bell.png" style="width: 35px; height: 35px;" alt="Bell">
                                </div>
                                <div class="alert-info">
                                    <div class="user-info">
                                        <div class="user-emoji">
                                            <span>😄</span>
                                        </div>
                                        <span class="user-id">User ID #12402</span>
                                    </div>
                                    <div class="sleep-info">
                                        <div class="sleep-icon">
                                            <img src="images/jam.png" style="width: 25px; height: 25px;" alt="Clock">
                                        </div>
                                        <div class="sleep-duration">
                                            <span>Average Durasi</span>
                                            <span>Tidur</span>
                                            <span>95 Menit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="alert-message">Tidak Tidur selama 27 jam terakhir</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Configure Chart.js defaults
    Chart.defaults.color = 'rgba(255, 255, 255, 0.7)';
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.1)';
    Chart.defaults.font.family = "'DM Sans', sans-serif";

    // Sample data for the chart
    const chartDataSets = {
        weekly: {
            labels: ['22:00', '23:00', '00:00', '01:00', '02:00', '03:00', '04:00'],
            data: [50, 10, 1000, 2100, 2000, 250, 80]
        },
        daily: {
            labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '23:00'],
            data: [100, 50, 200, 1500, 2000, 1800, 500]
        },
        monthly: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            data: [1800, 2100, 1900, 2200]
        }
    };

    let currentPeriod = 'weekly';

    // Create gradient for bars
    function createGradient(ctx, chartArea) {
        const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
        gradient.addColorStop(0, '#FF6B6B');
        gradient.addColorStop(0.5, '#FF8787');
        gradient.addColorStop(1, '#8B4F5A');
        return gradient;
    }

    // Initialize Chart
    const ctx = document.getElementById('usersChart').getContext('2d');
    let usersChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartDataSets.weekly.labels,
            datasets: [{
                label: 'Users',
                data: chartDataSets.weekly.data,
                backgroundColor: function(context) {
                    const chart = context.chart;
                    const {ctx, chartArea} = chart;
                    if (!chartArea) {
                        return null;
                    }
                    return createGradient(ctx, chartArea);
                },
                borderRadius: 6,
                barThickness: 30
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
                    backgroundColor: 'rgba(39, 46, 73, 0.95)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Users: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 2500,
                    ticks: {
                        callback: function(value) {
                            if (value === 0) return '0';
                            if (value === 10) return '10';
                            if (value === 100) return '100';
                            if (value === 1000) return '1000';
                            if (value === 2000) return '2000';
                            if (value === 2500) return '2500';
                            return '';
                        },
                        stepSize: 500,
                        color: 'rgba(255, 255, 255, 0.5)',
                        font: {
                            size: 10
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
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.5)',
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });

    // Period Filter
    document.getElementById('periodFilter').addEventListener('change', function() {
        currentPeriod = this.value;
        updateChart(currentPeriod);
    });

    // Date Range Filter
    document.getElementById('dateRangeFilter').addEventListener('change', function() {
        console.log('Date range changed to:', this.value);
    });

    // Update chart based on period
    function updateChart(period) {
        const data = chartDataSets[period];
        usersChart.data.labels = data.labels;
        usersChart.data.datasets[0].data = data.data;
        usersChart.update('active');
    }

    // Animate alert cards on load
    document.addEventListener('DOMContentLoaded', function() {
        const alertCards = document.querySelectorAll('.alert-card');
        alertCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(15px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.4s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 80);
        });
    });
</script>
@endsection