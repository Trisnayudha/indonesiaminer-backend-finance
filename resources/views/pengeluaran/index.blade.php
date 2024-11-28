@extends('template.index')

@section('content')
    <div class="container-fluid py-4">
        <!-- Cards for Weekly, Monthly, Yearly -->
        <div class="row">
            <!-- Weekly Card -->
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-7 text-start">
                                <p class="text-sm mb-1 text-uppercase font-weight-bold">Weekly</p>
                                <h5 class="font-weight-bolder mb-0">
                                    $230,220
                                </h5>
                                <span class="text-sm text-end text-danger font-weight-bolder mt-auto mb-0">+55% <span
                                        class="font-weight-normal text-secondary">from last week</span></span>
                            </div>
                            <div class="col-5">
                                <div class="dropdown text-end">
                                    <a href="#" class="cursor-pointer text-secondary" id="dropdownUsers1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="text-xs text-secondary">Jan 1 - Jan 7, 2024</span>
                                    </a>
                                    <!-- Dropdown content if needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Monthly Card -->
            <div class="col-sm-4 mt-sm-0 mt-4">
                <div class="card">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-7 text-start">
                                <p class="text-sm mb-1 text-uppercase font-weight-bold">Monthly</p>
                                <h5 class="font-weight-bolder mb-0">
                                    $3,200,000
                                </h5>
                                <span class="text-sm text-end text-danger font-weight-bolder mt-auto mb-0">+12% <span
                                        class="font-weight-normal text-secondary">from last month</span></span>
                            </div>
                            <div class="col-5">
                                <div class="dropdown text-end">
                                    <a href="#" class="cursor-pointer text-secondary" id="dropdownUsers2"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="text-xs text-secondary">January 2024</span>
                                    </a>
                                    <!-- Dropdown content if needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Yearly Card -->
            <div class="col-sm-4 mt-sm-0 mt-4">
                <div class="card">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-7 text-start">
                                <p class="text-sm mb-1 text-uppercase font-weight-bold">Yearly</p>
                                <h5 class="font-weight-bolder mb-0">
                                    $1,200,000
                                </h5>
                                <span class="font-weight-normal text-secondary text-sm"><span
                                        class="font-weight-bolder">+$213,000</span> from last year</span>
                            </div>
                            <div class="col-5">
                                <div class="dropdown text-end">
                                    <a href="#" class="cursor-pointer text-secondary" id="dropdownUsers3"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="text-xs text-secondary">2024</span>
                                    </a>
                                    <!-- Dropdown content if needed -->
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
                        <!-- Legend -->
                        <div class="mt-3">
                            <span class="badge badge-md badge-dot me-4">
                                <i class="bg-info"></i>
                                <span class="text-dark text-xs">Marketing</span>
                            </span>
                            <span class="badge badge-md badge-dot me-4">
                                <i class="bg-primary"></i>
                                <span class="text-dark text-xs">Operational</span>
                            </span>
                            <span class="badge badge-md badge-dot me-4">
                                <i class="bg-success"></i>
                                <span class="text-dark text-xs">Salary</span>
                            </span>
                            <!-- Add more categories if needed -->
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
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Example data row -->
                                        <tr>
                                            <td>#EXP001</td>
                                            <td>Marketing</td>
                                            <td>$5,000</td>
                                            <td>1</td>
                                        </tr>
                                        <!-- Add more data rows as needed -->
                                    </tbody>
                                </table>
                            </div>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
                                <input type="number" class="form-control" id="expensePrice" name="expensePrice"
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
        // Data for Bar Chart
        var ctxBar = document.getElementById('expenseBarChart').getContext('2d');
        var expenseBarChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Venue A', 'Venue B', 'Venue C'],
                datasets: [{
                        label: 'Marketing',
                        data: [5000, 3000, 4000],
                        backgroundColor: '#17a2b8'
                    },
                    {
                        label: 'Operational',
                        data: [2000, 4000, 3000],
                        backgroundColor: '#007bff'
                    },
                    {
                        label: 'Salary',
                        data: [7000, 8000, 6000],
                        backgroundColor: '#28a745'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Data for Pie Chart
        var ctxPie = document.getElementById('expensePieChart').getContext('2d');
        var expensePieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Marketing', 'Operational', 'Salary'],
                datasets: [{
                    data: [40, 30, 30],
                    backgroundColor: ['#17a2b8', '#007bff', '#28a745'],
                    hoverBackgroundColor: ['#17a2b8', '#007bff', '#28a745']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endpush
