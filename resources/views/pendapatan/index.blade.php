@extends('template.index')

@section('content')
    <div class="container-fluid py-4">
        <!-- Cards for Weekly, Monthly, Yearly Revenue -->
        <div class="row">
            <!-- Weekly Revenue Card -->
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-7 text-start">
                                <p class="text-sm mb-1 text-uppercase font-weight-bold">Weekly Revenue</p>
                                <h5 class="font-weight-bolder mb-0">
                                    IDR {{ number_format($weeklyRevenue['current_revenue'], 2) }}
                                </h5>
                                <span
                                    class="text-sm text-end {{ $weeklyRevenue['percentage_change'] >= 0 ? 'text-success' : 'text-danger' }} font-weight-bolder mt-auto mb-0">
                                    @if ($weeklyRevenue['percentage_change'] >= 0)
                                        +{{ number_format($weeklyRevenue['percentage_change'], 2) }}%
                                    @else
                                        {{ number_format($weeklyRevenue['percentage_change'], 2) }}%
                                    @endif
                                    <span class="font-weight-normal text-secondary"> from last week</span>
                                </span>
                            </div>
                            <div class="col-5">
                                <div class="dropdown text-end">
                                    <a href="#" class="cursor-pointer text-secondary" id="dropdownUsers1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="text-xs text-secondary">Jan 1 - Jan 7, 2024</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Revenue Card -->
            <div class="col-sm-4 mt-sm-0 mt-4">
                <div class="card">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-7 text-start">
                                <p class="text-sm mb-1 text-uppercase font-weight-bold">Monthly Revenue</p>
                                <h5 class="font-weight-bolder mb-0">
                                    IDR {{ number_format($monthlyRevenue['current_revenue'], 2) }}
                                </h5>
                                <span
                                    class="text-sm text-end {{ $monthlyRevenue['percentage_change'] >= 0 ? 'text-success' : 'text-danger' }} font-weight-bolder mt-auto mb-0">
                                    @if ($monthlyRevenue['percentage_change'] >= 0)
                                        +{{ number_format($monthlyRevenue['percentage_change'], 2) }}%
                                    @else
                                        {{ number_format($monthlyRevenue['percentage_change'], 2) }}%
                                    @endif
                                    <span class="font-weight-normal text-secondary"> from last month</span>
                                </span>
                            </div>
                            <div class="col-5">
                                <div class="dropdown text-end">
                                    <a href="#" class="cursor-pointer text-secondary" id="dropdownUsers2"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="text-xs text-secondary">January 2024</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Yearly Revenue Card -->
            <div class="col-sm-4 mt-sm-0 mt-4">
                <div class="card">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-10 text-start">
                                <p class="text-sm mb-1 text-uppercase font-weight-bold">Yearly Revenue</p>
                                <h5 class="font-weight-bolder mb-0">
                                    IDR {{ number_format($yearlyRevenue['current_revenue'], 2) }}
                                </h5>
                                <span class="font-weight-normal text-secondary text-sm">
                                    <span class="font-weight-bolder">
                                        +IDR
                                        {{ number_format($yearlyRevenue['current_revenue'] - $yearlyRevenue['previous_revenue'], 2) }}
                                    </span>
                                    from last year
                                </span>
                            </div>
                            <div class="col-2">
                                <div class="dropdown text-end">
                                    <a href="#" class="cursor-pointer text-secondary" id="dropdownUsers3"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="text-xs text-secondary">2024</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart and Pie Chart -->
        <div class="row mt-4">
            <!-- Bar Chart -->
            <div class="col-lg-8 col-sm-6">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Revenue by Category and Venue</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <div style="position: relative; height:400px;">
                                <canvas id="lineChart" class="chart-canvas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-lg-4 col-sm-6 mt-sm-0 mt -4">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Revenue Percentage by Category</h6>
                    </div>
                    <div class="card-body pb-0 p-3 mt-4">
                        <div class="chart">
                            <canvas id="pieChart" class="chart-canvas" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <!-- Header with Add Revenue Button -->
                    <div class="d-sm-flex justify-content-between m-3">
                        <div>
                            <a href="#" class="btn btn-icon btn-outline-blue" data-bs-toggle="modal"
                                data-bs-target="#addRevenueModal">
                                Add Revenue
                            </a>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-flush dataTable-table" id="datatable-revenue">
                            <thead class="thead-light">
                                <tr>
                                    <th>Revenue ID</th>
                                    <th>Category</th>
                                    <th>Revenue Amount</th>
                                    <th>Quantity</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allRevenueData as $revenue)
                                    <tr>
                                        <td>{{ $revenue->revenue_id }}</td>
                                        <td>{{ $revenue->category }}</td>
                                        <td>IDR {{ number_format($revenue->revenue_amount, 2) }}</td>
                                        <td>{{ $revenue->quantity }}</td>
                                        <td>{{ \Carbon\Carbon::parse($revenue->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination Kustom --}}
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                {{-- Tombol Previous --}}
                                <li class="page-item {{ $allRevenueData->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $allRevenueData->previousPageUrl() }}" tabindex="-1">
                                        <i class="fa fa-angle-left"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>

                                {{-- Tombol Halaman --}}
                                @for ($i = 1; $i <= $allRevenueData->lastPage(); $i++)
                                    <li class="page-item {{ $allRevenueData->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $allRevenueData->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                {{-- Tombol Next --}}
                                <li class="page-item {{ !$allRevenueData->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $allRevenueData->nextPageUrl() }}">
                                        <i class="fa fa-angle-right"></i>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Revenue Modal -->
        <div class="modal fade" id="addRevenueModal" tabindex="-1" aria-labelledby="addRevenueModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <!-- CSRF Token if using Laravel -->
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addRevenueModalLabel">Add Revenue</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form fields -->
                            <div class="mb-3">
                                <label for="revenueName" class="form-label">Revenue Name</label>
                                <input type="text" class="form-control" id="revenueName" name="revenueName" required>
                            </div>
                            <div class="mb-3">
                                <label for="rateIDR" class="form-label">Rate IDR Revenue</label>
                                <input type="number" class="form-control" id="rateIDR" name="rateIDR" required>
                            </div>
                            <div class="mb-3">
                                <label for="revenueAmount" class="form-label">Revenue Amount</label>
                                <input type="number" class="form-control" id="revenueAmount" name="revenueAmount"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="paymentType" class="form-label">Payment Type</label>
                                <select class="form-select" id="paymentType" name="paymentType" required>
                                    <option value="">Select Payment Type</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Transfer">Transfer</option>
                                    <!-- Add more options if needed -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="paymentCategory" class="form-label">Payment Category</label>
                                <select class="form-select" id="paymentCategory" name="paymentCategory" required>
                                    <option value="">Select Category</option>
                                    <option value="Exhibitor">Exhibitor</option>
                                    <option value="Sponsors">Sponsors</option>
                                    <option value="Advertisement">Advertisement</option>
                                    <option value="Additional Order">Additional Order</option>
                                    <!-- Add more categories if needed -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">
                                    <textarea name="notes" id="notes" cols="30" rows="10"></textarea>
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Revenue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('top')
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('scripts')
    <script>
        // Inisialisasi Pie Chart
        const pieData = {
            labels: ['Ticket', 'Exhibitor', 'Sponsor', 'Advertisement'],
            datasets: [{
                data: [
                    {{ $revenueByCategory['ticket'] }},
                    {{ $revenueByCategory['exhibitor'] }},
                    {{ $revenueByCategory['sponsor'] }},
                    {{ $revenueByCategory['advertisement'] }},
                ],
                backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56'],
            }]
        };

        // Inisialisasi Line Chart Data (Multiple Lines per Category)
        const lineData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                    label: 'Ticket',
                    data: [
                        @foreach ($yearlyRevenueByCategory['ticket'] as $revenue)
                            {{ $revenue }},
                        @endforeach
                    ],
                    fill: false,
                    borderColor: '#ff6384',
                    tension: 0.1
                },
                {
                    label: 'Exhibitor',
                    data: [
                        @foreach ($yearlyRevenueByCategory['exhibitor'] as $revenue)
                            {{ $revenue }},
                        @endforeach
                    ],
                    fill: false,
                    borderColor: '#36a2eb',
                    tension: 0.1
                },
                {
                    label: 'Sponsor',
                    data: [
                        @foreach ($yearlyRevenueByCategory['sponsor'] as $revenue)
                            {{ $revenue }},
                        @endforeach
                    ],
                    fill: false,
                    borderColor: '#cc65fe',
                    tension: 0.1
                },
                {
                    label: 'Advertisement',
                    data: [
                        @foreach ($yearlyRevenueByCategory['advertisement'] as $revenue)
                            {{ $revenue }},
                        @endforeach
                    ],
                    fill: false,
                    borderColor: '#ffce56',
                    tension: 0.1
                }
            ]
        };


        // Membuat Pie Chart
        const pieChartContext = document.getElementById('pieChart').getContext('2d');
        new Chart(pieChartContext, {
            type: 'pie',
            data: pieData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': IDR ' + tooltipItem.raw.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Membuat Line Chart
        const lineChartContext = document.getElementById('lineChart').getContext('2d');
        new Chart(lineChartContext, {
            type: 'line',
            data: lineData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'IDR ' + tooltipItem.raw.toLocaleString();
                            }
                        }
                    }
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
    </script>
@endpush
