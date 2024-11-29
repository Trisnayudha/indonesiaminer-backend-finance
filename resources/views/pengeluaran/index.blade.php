@extends('template.index')

@section('content')
    <div class="container-fluid py-4">
        <!-- Cards for Weekly, Monthly, Yearly -->
        <div class="row">
            <!-- Revenue Cards -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Weekly Revenue</h5>
                    </div>
                    <div class="card-body">
                        <h4>Rp {{ number_format($weeklyRevenue, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Monthly Revenue</h5>
                    </div>
                    <div class="card-body">
                        <h4>Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Yearly Revenue</h5>
                    </div>
                    <div class="card-body">
                        <h4>Rp {{ number_format($yearlyRevenue, 0, ',', '.') }}</h4>
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
                        <h6 class="mb-0">Expenses by Category and Venue</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <div style="position: relative; height:400px;">
                                <canvas id="expenseBarChart" class="chart-canvas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-lg-4 col-sm-6 mt-sm-0 mt-4">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Expense Percentage by Category</h6>
                    </div>
                    <div class="card-body pb-0 p-3 mt-4">
                        <div class="chart">
                            <canvas id="expensePieChart" class="chart-canvas" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expenses Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <!-- Header with Add Expense Button -->
                    <div class="d-sm-flex justify-content-between m-3">
                        <div>
                            <a href="#" class="btn btn-icon btn-outline-blue" data-bs-toggle="modal"
                                data-bs-target="#addExpenseModal">
                                Add Expense
                            </a>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive">
                        <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                            <div class="dataTable-container">
                                <table class="table table-flush dataTable-table" id="datatable-expense">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Expense ID</th>
                                            <th>Category</th>
                                            <th>Expense Price</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Example data row -->
                                        @foreach ($getData as $item)
                                            <tr>
                                                <td>#{{ $item->code_payment }}</td>
                                                <td>{{ $item->expense_name }}</td>
                                                <td>{{ number_format($item->total_price, 0, ',', '.') }}</td>
                                                <td>{{ $item->payment_type }}</td>
                                            </tr>
                                        @endforeach
                                        <!-- Add more data rows as needed -->
                                    </tbody>
                                </table>
                            </div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    {{-- Tombol Previous --}}
                                    <li class="page-item {{ $getData->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $getData->previousPageUrl() }}" tabindex="-1">
                                            <i class="fa fa-angle-left"></i>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>

                                    {{-- Tombol Halaman --}}
                                    @for ($i = 1; $i <= $getData->lastPage(); $i++)
                                        <li class="page-item {{ $getData->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $getData->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    {{-- Tombol Next --}}
                                    <li class="page-item {{ !$getData->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $getData->nextPageUrl() }}">
                                            <i class="fa fa-angle-right"></i>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            <!-- Pagination if needed -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Expense Modal -->
        <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <!-- CSRF Token if using Laravel -->
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addExpenseModalLabel">Add Expense</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form fields -->
                            <div class="mb-3">
                                <label for="expenseName" class="form-label">Expense Name</label>
                                <input type="text" class="form-control" id="expenseName" name="expenseName" required>
                            </div>
                            <div class="mb-3">
                                <label for="rateIDR" class="form-label">Rate IDR Expense</label>
                                <input type="number" class="form-control" id="rateIDR" name="rateIDR" required>
                            </div>
                            <div class="mb-3">
                                <label for="expensePrice" class="form-label">Expense Price</label>
                                <input type="number" class="form-control" id="expensePrice" name="expensePrice" required>
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
                                    <option value="Marketing">Marketing</option>
                                    <option value="Operational">Operational</option>
                                    <option value="Salary">Salary</option>
                                    <!-- Add more categories if needed -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Expense</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('top')
@endpush

@push('scripts')
    <script>
        // Bar Chart Data
        var ctxBar = document.getElementById('expenseBarChart').getContext('2d');
        var expenseBarChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: @json($barChartData['categories']),
                datasets: [{
                    label: 'Expense by Category',
                    data: @json($barChartData['totals']),
                    backgroundColor: '#007bff' // Customize color
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Pie Chart Data
        var ctxPie = document.getElementById('expensePieChart').getContext('2d');
        var expensePieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: @json($pieChartData['labels']),
                datasets: [{
                    data: @json($pieChartData['data']),
                    backgroundColor: @json($pieChartData['backgroundColors']),
                    hoverBackgroundColor: @json($pieChartData['backgroundColors'])
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    </script>
@endpush
