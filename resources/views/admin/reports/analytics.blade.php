@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Reports & Analytics</h2>

    <div class="row">
        <!-- Yearly Sales -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Yearly Sales</div>
                <div class="card-body">
                    <canvas id="yearlySales"></canvas>
                </div>
            </div>
        </div>

        <!-- Product Contribution -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">Product Contribution</div>
                <div class="card-body">
                    <canvas id="productContribution"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Range -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">Sales in Date Range</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.reports.analytics') }}" class="mb-3 d-flex gap-2">
                        <input type="date" name="start_date" value="{{ $start }}" class="form-control w-auto">
                        <input type="date" name="end_date" value="{{ $end }}" class="form-control w-auto">
                        <button type="submit" class="btn btn-danger">Filter</button>
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
            backgroundColor: '#007bff',
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
            backgroundColor: '#ff6384',
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
            backgroundColor: ['#FF6384','#36A2EB','#FFCE56','#4BC0C0','#999999'],
            datalabels: {
                display: true,
                formatter: function(value, ctx) {
                    let data = ctx.chart.data.datasets[0].data;
                    let sum = data.reduce(function(a, b) { return parseFloat(a) + parseFloat(b); }, 0);
                    return (parseFloat(value) / sum * 100).toFixed(1) + "%";
                },
                color: '#fff',
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