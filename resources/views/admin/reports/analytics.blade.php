@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Reports & Analytics</h2>

    <!-- Yearly Sales -->
    <div class="card mb-4">
        <div class="card-body">
            {!! $yearlySalesChart->renderHtml() !!}
        </div>
    </div>

    <!-- Sales Range with Date Picker -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.analytics') }}" class="mb-3">
                <input type="date" name="start_date" value="{{ request('start_date') }}">
                <input type="date" name="end_date" value="{{ request('end_date') }}">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            </form>
            {!! $salesRangeChart->renderHtml() !!}
        </div>
    </div>

    <!-- Product Contribution Pie -->
    <div class="card mb-4">
        <div class="card-body">
            {!! $productSalesChart->renderHtml() !!}
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
{!! $yearlySalesChart->renderJs() !!}
{!! $salesRangeChart->renderJs() !!}
{!! $productSalesChart->renderJs() !!}
@endsection
