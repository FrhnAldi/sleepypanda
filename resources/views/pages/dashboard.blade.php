@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
    /* Container utama untuk dashboard */
    .dashboard-container {
        padding: 10px;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: hidden;
    }

    .charts-row {
        display: grid;
        grid-template-columns: repeat(3, 1.2fr); /* Memperlebar ukuran card */
        gap: 20px; /* Kurangi gap agar card lebih lebar */
        margin-bottom: 30px;
    }

    .chart-card {
        background: rgba(39, 46, 73, 0.16);
        border-radius: 16px;
        padding: 10px; /* Diubah menjadi 10px */
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        min-width: 0;
        box-sizing: border-box;
    }

    .chart-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px; /* Kembali ke ukuran awal */
    }

    .chart-title {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 18px;
        font-weight: 600;
        color: #ffffff;
    }

    .chart-container {
        position: relative;
        height: 200px; /* Kembali ke 200px */
        width: 100%;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #272E49;
        border-radius: 16px;
        padding: 25px 30px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        min-width: 0;
        box-sizing: border-box;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 40px rgba(0, 0, 0, 0.4);
    }

    .stat-label {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.6);
        font-weight: 500;
        margin-bottom: 15px;
    }

    .stat-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .stat-value {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 36px;
        font-weight: 700;
        color: #ffffff;
        line-height: 1;
    }

    .large-chart {
        background: #272E49;
        border-radius: 16px;
        padding: 20px 25px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-sizing: border-box;
        min-width: 0;
        max-width: 1150px;
        margin: 0 auto;
    }

    .large-chart-container {
        position: relative;
        height: 250px;
        width: 100%;
    }

    /* Updated legend styling untuk sleep time chart */
    .legend {
        display: flex;
        flex-direction: column;
        gap: 10px; /* Diperbesar untuk jarak lebih */
        margin-top: 10px; /* Tambahkan margin top untuk turunkan posisi */
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .legend-dot {
        width: 12px; /* Diperbesar sedikit */
        height: 12px; /* Diperbesar sedikit */
        border-radius: 2px; /* Ubah dari 50% menjadi 2px untuk bentuk kotak */
    }

    .legend-dot.female {
        background: #AF5579;
    }

    .legend-dot.male {
        background: #3A4BAE;
    }

    .legend-label {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.7);
    }

    /* Special styling for sleep time chart header */
    .sleep-chart-header {
        margin-bottom: 20px;
    }

    .sleep-chart-title {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 18px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.95);
        letter-spacing: 0.3px;
        margin-bottom: 15px;
    }

    .sleep-legend {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }

    .sleep-legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sleep-legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 2px;
    }

    .sleep-legend-dot.female {
        background: #AF5579;
    }

    .sleep-legend-dot.male {
        background: #3A4BAE;
    }

    .sleep-legend-label {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.7);
        font-weight: 400;
    }

    @media (max-width: 1200px) {
        .charts-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 968px) {
        .charts-row {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-container {
            padding: 20px;
        }
    }

    @media (max-width: 640px) {
        .charts-row {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-container {
            padding: 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <div class="charts-row">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Daily Report</h3>
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-dot female"></div>
                        <span class="legend-label">Female</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot male"></div>
                        <span class="legend-label">Male</span>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="dailyChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Weekly Report</h3>
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-dot female"></div>
                        <span class="legend-label">Female</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot male"></div>
                        <span class="legend-label">Male</span>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Monthly Report</h3>
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-dot female"></div>
                        <span class="legend-label">Female</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot male"></div>
                        <span class="legend-label">Male</span>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Users</div>
            <div class="stat-content">
                <div class="stat-icon"><img src="images/userp.png" style="width: 50px; height: 50px;" alt=""></div>
                <div class="stat-value">4500</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Female Users</div>
            <div class="stat-content">
                <div class="stat-icon"><img src="images/userp.png" style="width: 50px; height: 50px;" alt=""></div>
                <div class="stat-value">2000</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Male Users</div>
            <div class="stat-content">
                <div class="stat-icon"><img src="images/userp.png" style="width: 50px; height: 50px;"alt=""></div>
                <div class="stat-value">2500</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Avarage Time</div>
            <div class="stat-content">
                <div class="stat-icon"><img src="images/cl2.png" style="width: 50px; height: 50px;"alt=""></div>
                <div class="stat-value">154.25</div>
            </div>
        </div>
    </div>

    <div class="large-chart">
        <div class="sleep-chart-header">
            <h3 class="sleep-chart-title">Average Users Sleep Time</h3>
            <div class="sleep-legend">
                <div class="sleep-legend-item">
                    <div class="sleep-legend-dot female"></div>
                    <span class="sleep-legend-label">Female</span>
                </div>
                <div class="sleep-legend-item">
                    <div class="sleep-legend-dot male"></div>
                    <span class="sleep-legend-label">Male</span>
                </div>
            </div>
        </div>
        <div class="large-chart-container">
            <canvas id="sleepTimeChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    Chart.defaults.color = 'rgba(255, 255, 255, 0.7)';
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.1)';
    Chart.defaults.font.family = "'DM Sans', sans-serif";

    // Simpan instance chart untuk resize
    let dailyChart, weeklyChart, monthlyChart, sleepTimeChart;

    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    
    // Plugin untuk menampilkan angka Y axis secara manual agar tidak bertumpuk
    const customYAxisPlugin = {
        id: 'customYAxis',
        afterDraw: (chart) => {
            const ctx = chart.ctx;
            const yScale = chart.scales.y;
            const chartHeight = yScale.bottom - yScale.top;
            
            // Nilai yang ingin ditampilkan dengan jarak LEBIH BESAR
            const values = [
                { value: 0, position: 1.0 },      // paling bawah
                { value: 10, position: 0.8 },     
                { value: 100, position: 0.6 },    
                { value: 1000, position: 0.4 },   
                { value: 2000, position: 0.2 },   
                { value: 2500, position: 0.0 }    // paling atas
            ];
            
            ctx.save();
            ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
            ctx.font = '11px "DM Sans", sans-serif';
            ctx.textAlign = 'left';  // Rata kiri
            ctx.textBaseline = 'middle';
            
            // Gambar setiap angka pada posisi yang tepat
            values.forEach(item => {
                const y = yScale.top + (chartHeight * item.position);
                ctx.fillText(item.value.toString(), yScale.left - 35, y);
            });
            
            ctx.restore();
        }
    };
    
    dailyChart = new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Female',
                data: [2100, 1900, 1850, 2300, 2000, 150, 100],
                backgroundColor: '#AF5579',
                borderRadius: 4,
                barThickness: 6,
                categoryPercentage: 0.6,
                barPercentage: 0.7
            }, {
                label: 'Male',
                data: [2000, 2100, 1800, 2100, 1950, 1200, 250],
                backgroundColor: '#3A4BAE',
                borderRadius: 4,
                barThickness: 6,
                categoryPercentage: 0.6,
                barPercentage: 0.7
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
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: 2500,
                    ticks: {
                        display: false
                    },
                    grid: { display: false },
                    border: { display: false }
                },
                x: { 
                    grid: { display: false },
                    border: { display: false }
                }
            }
        },
        plugins: [customYAxisPlugin]
    });

    const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
    
    // Plugin untuk menampilkan angka Y axis secara manual agar tidak bertumpuk
    const customYAxisPluginWeekly = {
        id: 'customYAxisWeekly',
        afterDraw: (chart) => {
            const ctx = chart.ctx;
            const yScale = chart.scales.y;
            const chartHeight = yScale.bottom - yScale.top;
            
            // Nilai yang ingin ditampilkan dengan jarak LEBIH BESAR
            const values = [
                { value: 0, position: 1.0 },      // paling bawah
                { value: 10, position: 0.8 },     
                { value: 100, position: 0.6 },    
                { value: 1000, position: 0.4 },   
                { value: 2000, position: 0.2 },   
                { value: 2500, position: 0.0 }    // paling atas
            ];
            
            ctx.save();
            ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
            ctx.font = '11px "DM Sans", sans-serif';
            ctx.textAlign = 'left';  // Rata kiri
            ctx.textBaseline = 'middle';
            
            // Gambar setiap angka pada posisi yang tepat
            values.forEach(item => {
                const y = yScale.top + (chartHeight * item.position);
                ctx.fillText(item.value.toString(), yScale.left - 35, y);
            });
            
            ctx.restore();
        }
    };
    
    weeklyChart = new Chart(weeklyCtx, {
        type: 'bar',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Female',
                data: [2100, 1900, 1750, 2200],
                backgroundColor: '#AF5579',
                borderRadius: 4,
                barThickness: 6,
                categoryPercentage: 0.6,
                barPercentage: 0.7
            }, {
                label: 'Male',
                data: [1950, 2050, 1850, 2100],
                backgroundColor: '#3A4BAE',
                borderRadius: 4,
                barThickness: 6,
                categoryPercentage: 0.6,
                barPercentage: 0.7
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
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: 2500,
                    ticks: {
                        display: false
                    },
                    grid: { display: false },
                    border: { display: false }
                },
                x: { 
                    grid: { display: false },
                    border: { display: false }
                }
            }
        },
        plugins: [customYAxisPluginWeekly]
    });

    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    
    // Plugin untuk menampilkan angka Y axis secara manual agar tidak bertumpuk
    const customYAxisPluginMonthly = {
        id: 'customYAxisMonthly',
        afterDraw: (chart) => {
            const ctx = chart.ctx;
            const yScale = chart.scales.y;
            const chartHeight = yScale.bottom - yScale.top;
            
            // Nilai yang ingin ditampilkan dengan jarak LEBIH BESAR
            const values = [
                { value: 0, position: 1.0 },      // paling bawah
                { value: 10, position: 0.8 },     
                { value: 100, position: 0.6 },    
                { value: 1000, position: 0.4 },   
                { value: 2000, position: 0.2 },   
                { value: 2500, position: 0.0 }    // paling atas
            ];
            
            ctx.save();
            ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
            ctx.font = '11px "DM Sans", sans-serif';
            ctx.textAlign = 'left';  // Rata kiri
            ctx.textBaseline = 'middle';
            
            // Gambar setiap angka pada posisi yang tepat
            values.forEach(item => {
                const y = yScale.top + (chartHeight * item.position);
                ctx.fillText(item.value.toString(), yScale.left - 35, y);
            });
            
            ctx.restore();
        }
    };
    
    monthlyChart = new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt'],
            datasets: [{
                label: 'Female',
                data: [2100, 1900, 1800, 2200, 1850, 2100, 1100, 1800, 1900, 1850],
                backgroundColor: '#AF5579',
                borderRadius: 4,
                barThickness: 5,
                categoryPercentage: 0.6,
                barPercentage: 0.7
            }, {
                label: 'Male',
                data: [2000, 2100, 1850, 2150, 1900, 2050, 1000, 1850, 1950, 1900],
                backgroundColor: '#3A4BAE',
                borderRadius: 4,
                barThickness: 5,
                categoryPercentage: 0.6,
                barPercentage: 0.7
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
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: 2500,
                    ticks: {
                        display: false
                    },
                    grid: { display: false },
                    border: { display: false }
                },
                x: { 
                    grid: { display: false },
                    border: { display: false }
                }
            }
        },
        plugins: [customYAxisPluginMonthly]
    });

    // Updated Sleep Time Chart dengan styling yang mirip dengan gambar
    const sleepTimeCtx = document.getElementById('sleepTimeChart').getContext('2d');
    
    // Plugin untuk menambahkan label Time (h) di bawah angka 0
    const timeLabel = {
        id: 'timeLabel',
        afterDraw: (chart) => {
            const ctx = chart.ctx;
            const yScale = chart.scales.y;
            const xScale = chart.scales.x;
            
            // Cari posisi angka 0
            const zeroPosition = yScale.getPixelForValue(0);
            const leftPosition = yScale.left;
            
            ctx.save();
            ctx.fillStyle = 'rgba(255, 255, 255, 0.5)';
            ctx.font = '11px "DM Sans", sans-serif';
            ctx.textAlign = 'left';
            ctx.textBaseline = 'top';
            
            // Gambar teks "Time (h)" di bawah angka 0
            ctx.fillText('Time (h)', leftPosition - 10, zeroPosition + 25);
            
            ctx.restore();
        }
    };
    
    sleepTimeChart = new Chart(sleepTimeCtx, {
        type: 'line',
        data: {
            labels: ['Jan 01', 'Jan 02', 'Jan 03', 'Jan 04', 'Jan 05', 'Jan 06'],
            datasets: [{
                label: 'Female',
                data: [1, 4, 3, 6, 2, 5, 7, 4, 8, 3, 6, 4],
                borderColor: '#AF5579',
                backgroundColor: 'transparent',
                tension: 0,
                borderWidth: 2,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#AF5579',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2
            }, {
                label: 'Male',
                data: [0, 2, 4, 2, 5, 3, 6, 4, 7, 8, 7, 9],
                borderColor: '#3A4BAE',
                backgroundColor: 'transparent',
                tension: 0,
                borderWidth: 2,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#3A4BAE',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(39, 46, 73, 0.95)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + 'h';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 10,
                    position: 'left',
                    ticks: {
                        stepSize: 2,
                        font: {
                            size: 11
                        },
                        color: 'rgba(255, 255, 255, 0.5)',
                        padding: 10,
                        callback: function(value) {
                            return value + 'h';
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
                    offset: true,
                    ticks: {
                        font: {
                            size: 12
                        },
                        color: 'rgba(255, 255, 255, 0.5)',
                        padding: 10,
                        autoSkip: false
                    },
                    grid: { 
                        display: false,
                        offset: true
                    },
                    border: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            layout: {
                padding: {
                    left: 15,
                    right: 20,
                    top: 10,
                    bottom: 40
                }
            }
        },
        plugins: [timeLabel]
    });

    // Force resize semua chart saat window resize
    window.addEventListener('resize', function() {
        if (dailyChart) dailyChart.resize();
        if (weeklyChart) weeklyChart.resize();
        if (monthlyChart) monthlyChart.resize();
        if (sleepTimeChart) sleepTimeChart.resize();
    });
</script>
@endsection