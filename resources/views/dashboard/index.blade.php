@extends('template.index')

@section('content')
    <div class="container-fluid py-4">

        <!-- Title and Breadcrumb -->
        <div class="row mb-4">
            <div class="col-lg-6 col-7">
                <h6 class="text-white d-inline-block mb-0">Dashboard</h6>
                <nav aria-label="breadcrumb" class="d-inline-block ms-4">
                    <ol class="breadcrumb breadcrumb-dark bg-transparent mb-0 pb-0 pt-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Cards Row 1: Revenue & Expenses Overview -->
        <div class="row">
            <!-- Weekly Revenue Card -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card shadow">
                    <div class="card-body p-3">
                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Weekly Revenue</p>
                        <h5 class="font-weight-bolder">
                            IDR {{ number_format($weeklyRevenue['current_revenue'], 0, ',', '.') }}
                        </h5>
                        <p class="mb-0">
                            <span
                                class="{{ $weeklyRevenue['percentage_change'] >= 0 ? 'text-success' : 'text-danger' }} text-sm font-weight-bolder">
                                {{ $weeklyRevenue['percentage_change'] >= 0 ? '+' : '' }}{{ number_format($weeklyRevenue['percentage_change'], 2) }}%
                            </span>
                            <span class="text-secondary text-sm">since last week</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Monthly Expenses Card -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card shadow">
                    <div class="card-body p-3">
                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Monthly Expenses</p>
                        <h5 class="font-weight-bolder">
                            IDR {{ number_format($monthlyExpenses, 0, ',', '.') }}
                        </h5>
                        <p class="mb-0 text-secondary text-sm">
                            Outflow this month
                        </p>
                    </div>
                </div>
            </div>

            <!-- Yearly Net Profit -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card shadow">
                    <div class="card-body p-3">
                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Yearly Net Profit</p>
                        <h5 class="font-weight-bolder {{ $yearlyNetProfit >= 0 ? 'text-success' : 'text-danger' }}">
                            IDR {{ number_format($yearlyNetProfit, 0, ',', '.') }}
                        </h5>
                        <p class="mb-0 text-secondary text-sm">
                            (Revenue - Expenses) this year
                        </p>
                    </div>
                </div>
            </div>

            <!-- Invoices This Year -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card shadow">
                    <div class="card-body p-3">
                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Invoices ({{ now()->year }})</p>
                        <h5 class="font-weight-bolder">
                            {{ $invoicesThisYear }} Issued
                        </h5>
                        <p class="mb-0 text-sm">
                            <span class="text-success font-weight-bolder">{{ $invoicesPaidThisYear }} Paid</span> |
                            <span class="text-danger font-weight-bolder">{{ $invoicesUnpaidThisYear }} Unpaid</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2: Charts and Distributions -->
        <div class="row">
            <!-- Monthly Revenue vs Expenses (Line Chart) -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-header pb-0">
                        <h6>Monthly Revenue vs Expenses ({{ now()->year }})</h6>
                        <p class="text-sm mb-0">A comparison per month</p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="revenueExpenseChart" class="chart-canvas" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue by Category (Donut) -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-header pb-0">
                        <h6>Revenue by Category</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="revenueByCategoryChart" class="chart-canvas" height="200"></canvas>
                        </div>
                        <small class="text-secondary">Distribution of main revenue sources</small>
                    </div>
                </div>
            </div>

            <!-- Expenses by Category (Pie) -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-header pb-0">
                        <h6>Expenses by Category</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="expenseByCategoryChart" class="chart-canvas" height="200"></canvas>
                        </div>
                        <small class="text-secondary">Where most spending goes</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3: Additional Stats -->
        <div class="row">
            <!-- Top Revenue Category Card -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header pb-0">
                        <h6>Top Revenue Category</h6>
                        <p class="text-sm">Highest grossing category this year</p>
                    </div>
                    <div class="card-body p-3">
                        <h5 class="font-weight-bolder">{{ $topRevenueCategory[0]['category'] }}</h5>
                        <p>IDR {{ number_format($topRevenueCategory[0]['total'], 0, ',', '.') }}</p>
                        <p class="text-sm text-secondary">Followed by:
                            @foreach ($topRevenueCategory->slice(1) as $cat)
                                {{ $cat['category'] }} (IDR {{ number_format($cat['total'], 0, ',', '.') }}),
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>

            <!-- Invoice Payment Method Distribution (Donut) -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header pb-0">
                        <h6>Invoice Payment Methods</h6>
                        <p class="text-sm">Distribution of invoice payment methods</p>
                    </div>
                    <div class="card-body p-3">
                        <canvas id="invoicePaymentMethodChart" class="chart-canvas" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Clients Table -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header pb-0">
                        <h6>Top 5 Clients</h6>
                        <p class="text-sm">By total invoice amount</p>
                    </div>
                    <div class="card-body p-3">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-secondary text-xs font-weight-bold">Client</th>
                                    <th class="text-secondary text-xs font-weight-bold">Amount (IDR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topClients as $client)
                                    <tr>
                                        <td class="text-xs font-weight-bold">{{ $client['client_name'] }}</td>
                                        <td class="text-xs">{{ number_format($client['total_amount'], 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('top')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Line Chart Revenue vs Expenses
            var ctx1 = document.getElementById('revenueExpenseChart').getContext('2d');
            var revenueData = @json($monthlyPendapatan);
            var expenseData = @json($monthlyPengeluaran);
            var labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Revenue',
                            data: revenueData,
                            borderColor: '#2dce89',
                            backgroundColor: 'transparent',
                            borderWidth: 3,
                            pointBackgroundColor: '#2dce89',
                            tension: 0.4
                        },
                        {
                            label: 'Expenses',
                            data: expenseData,
                            borderColor: '#f5365c',
                            backgroundColor: 'transparent',
                            borderWidth: 3,
                            pointBackgroundColor: '#f5365c',
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'IDR ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            // Revenue by Category (Donut)
            var revenueByCategory = @json($revenueByCategory);
            var revenueLabels = Object.keys(revenueByCategory);
            var revenueValues = Object.values(revenueByCategory);

            var ctx2 = document.getElementById('revenueByCategoryChart').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: revenueLabels,
                    datasets: [{
                        data: revenueValues,
                        backgroundColor: ['#2dce89', '#5e72e4', '#f5365c', '#fb6340']
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '60%',
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var label = tooltipItem.label || '';
                                    var value = tooltipItem.parsed || 0;
                                    return label + ': IDR ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            // Expenses by Category (Pie)
            var expenseByCategory = @json($expenseByCategory);
            var expenseLabels = Object.keys(expenseByCategory);
            var expenseValues = Object.values(expenseByCategory).map(Number); // Konversi ke number

            var ctx3 = document.getElementById('expenseByCategoryChart').getContext('2d');
            new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: expenseLabels,
                    datasets: [{
                        data: expenseValues,
                        backgroundColor: ['#5e72e4', '#2dce89', '#f5365c']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var label = tooltipItem.label || '';
                                    var dataset = tooltipItem.chart.data.datasets[0];
                                    var total = dataset.data.reduce(function(sum, val) {
                                        return sum + Number(val);
                                    }, 0);
                                    var value = tooltipItem.parsed || 0;
                                    var percentage = ((value / total) * 100).toFixed(2);
                                    return label + ': ' + percentage + '%';
                                }
                            }
                        },
                        datalabels: {
                            color: '#fff',
                            formatter: function(value, context) {
                                var dataset = context.chart.data.datasets[0];
                                var total = dataset.data.reduce(function(sum, val) {
                                    return sum + Number(val);
                                }, 0);
                                return ((value / total) * 100).toFixed(2) + '%';
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels] // Register plugin ChartDataLabels
            });



            // Invoice Payment Method (Donut)
            var paymentMethodDistribution = @json($paymentMethodDistribution);
            var paymentMethodLabels = Object.keys(paymentMethodDistribution);
            var paymentMethodValues = Object.values(paymentMethodDistribution);

            var ctx4 = document.getElementById('invoicePaymentMethodChart').getContext('2d');
            new Chart(ctx4, {
                type: 'doughnut',
                data: {
                    labels: paymentMethodLabels,
                    datasets: [{
                        data: paymentMethodValues,
                        backgroundColor: ['#11cdef', '#fb6340']
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '60%',
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    var label = tooltipItem.label || '';
                                    var value = tooltipItem.parsed || 0;
                                    return label + ': ' + value + '%';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
