@extends('layouts.app')

@section('content')
<style>
    /* Neo-Brutalist Layout Base */
    body {
        background-color: #ffffff;
        font-family: 'Courier New', Courier, monospace;
        background-image: linear-gradient(#d0d0d0 1px, transparent 1px), linear-gradient(90deg, #d0d0d0 1px, transparent 1px);
        background-size: 50px 50px;
    }

    .retro-container { padding: 40px 20px; }

    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 900;
        font-size: 2.8rem;
        text-transform: uppercase;
        margin-bottom: 30px;
        letter-spacing: -1px;
        color: #000000;
        display: inline-block;
        padding: 5px 20px;
    }

    /* Action bar */
    .action-card {
        background: #fff;
        border: 4px solid #000;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 10px 10px 0px 0px #000;
    }

    /* Chart Cards */
    .chart-card {
        background: #fff;
        border: 4px solid #000;
        box-shadow: 10px 10px 0px 0px #000;
        margin-bottom: 30px;
        overflow: hidden;
    }

    .chart-card-header {
        padding: 14px 20px;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
        border-bottom: 4px solid #000;
    }

    .chart-card-header.yellow { background-color: #ffff00; color: #000; }
    .chart-card-header.green  { background-color: #00ff41; color: #000; }
    .chart-card-header.red    { background-color: #ff4d4d; color: #000; }

    .chart-card-body {
        padding: 24px;
    }

    /* Filter Form */
    .filter-form {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        margin-bottom: 24px;
    }

    .form-control-retro {
        border: 3px solid #000;
        border-radius: 0;
        padding: 8px 12px;
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        font-size: 0.9rem;
        background: #fff;
        box-shadow: 4px 4px 0px #000;
        transition: all 0.1s;
        box-sizing: border-box;
    }

    .form-control-retro:focus {
        outline: none;
        box-shadow: 0px 0px 0px #000;
        transform: translate(2px, 2px);
        background: #fffde7;
    }

    /* Buttons */
    .btn-retro {
        border: 3px solid #000;
        border-radius: 0;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding: 10px 20px;
        transition: all 0.1s;
        box-shadow: 5px 5px 0px 0px #000;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
        color: #000;
        font-family: 'Courier New', Courier, monospace;
        background: none;
    }
    .btn-retro:hover { transform: translate(2px, 2px); box-shadow: 0px 0px 0px 0px #000; color: #000; }
    .btn-primary-retro   { background-color: #ffff00; }
    .btn-secondary-retro { background-color: #fff; }
</style>

<div class="container retro-container">
    <h1 class="page-title">Reports & Analytics</h1>

    <div class="action-card">
        <a href="/admin" class="btn-retro btn-secondary-retro">Admin Dashboard</a>
    </div>

    <div class="row">
        <!-- Yearly Sales -->
        <div class="col-md-6 mb-4">
            <div class="chart-card">
                <div class="chart-card-header yellow">Yearly Sales</div>
                <div class="chart-card-body">
                    <canvas id="yearlySales"></canvas>
                </div>
            </div>
        </div>

        <!-- Product Contribution -->
        <div class="col-md-6 mb-4">
            <div class="chart-card">
                <div class="chart-card-header green">Product Contribution</div>
                <div class="chart-card-body">
                    <canvas id="productContribution"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Range -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="chart-card">
                <div class="chart-card-header red">Sales in Date Range</div>
                <div class="chart-card-body">
                    <form method="GET" action="{{ route('admin.reports.analytics') }}" class="filter-form">
                        <input type="date" name="start_date" value="{{ $start }}" class="form-control-retro">
                        <input type="date" name="end_date" value="{{ $end }}" class="form-control-retro">
                        <button type="submit" class="btn-retro btn-primary-retro">Filter</button>
                    </form>
                    <canvas id="salesRange"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js v2.9.4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<!-- datalabels plugin compatible with Chart.js v2 -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

<script>
new Chart(document.getElementById('yearlySales'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($yearlyData->keys()) !!},
        datasets: [{
            label: 'Yearly Sales',
            data: {!! json_encode($yearlyData->values()) !!},
            backgroundColor: '#ffff00',
            borderColor: '#000',
            borderWidth: 2,
            datalabels: { display: false }
        }]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    let value = data.datasets[0].data[tooltipItem.index];
                    return '₱' + value.toLocaleString();
                }
            }
        }
    }
});

new Chart(document.getElementById('salesRange'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($rangeData->keys()) !!},
        datasets: [{
            label: 'Sales in Date Range',
            data: {!! json_encode($rangeData->values()) !!},
            backgroundColor: '#ff4d4d',
            borderColor: '#000',
            borderWidth: 2,
            datalabels: { display: false }
        }]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    let value = data.datasets[0].data[tooltipItem.index];
                    return '₱' + value.toLocaleString();
                }
            }
        }
    }
});

new Chart(document.getElementById('productContribution'), {
    type: 'pie',
    data: {
        labels: {!! json_encode($productData->keys()) !!},
        datasets: [{
            data: {!! json_encode($productData->values()) !!},
            backgroundColor: ['#ffff00','#00ff41','#ff4d4d','#66d9ff','#000000'],
            borderColor: '#000',
            borderWidth: 2,
            datalabels: {
                display: true,
                formatter: function(value, ctx) {
                    let data = ctx.chart.data.datasets[0].data;
                    let sum = data.reduce(function(a, b) { return parseFloat(a) + parseFloat(b); }, 0);
                    return (parseFloat(value) / sum * 100).toFixed(1) + "%";
                },
                color: '#000',
                font: {
                    weight: 'bold',
                    size: 14
                }
            }
        }]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    let value = data.datasets[0].data[tooltipItem.index];
                    let label = data.labels[tooltipItem.index];
                    return label + ': ₱' + parseFloat(value).toLocaleString();
                }
            }
        }
    }
});
</script>
@endsection