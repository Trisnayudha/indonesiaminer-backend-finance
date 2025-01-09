<!-- resources/views/expenses/index.blade.php -->

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
                            <button type="button" class="btn btn-icon btn-outline-blue" data-bs-toggle="modal"
                                data-bs-target="#addExpenseModal">
                                <i class="fas fa-plus"></i> Add Expense
                            </button>
                        </div>
                        <!-- Optional: Search Form -->
                        <form action="{{ route('pengeluaran.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search expenses..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive">
                        <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                            <div class="dataTable-container">
                                <table class="table table-flush dataTable-table" id="datatable-expense">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Expense ID</th>
                                            <th>Payment Date</th>
                                            <th>Expense Name</th>
                                            <th>Base Price (IDR)</th>
                                            <th>Admin Fee (IDR)</th>
                                            <th>Quantity</th>
                                            <th>Total (IDR)</th>
                                            <th>PPN Rate (%)</th>
                                            <th>PPN Amount (IDR)</th>
                                            <th>Grand Total (IDR)</th>
                                            <th>Payment Type</th>
                                            <th>Payment Category</th>
                                            <th>Invoice Number</th>
                                            <th>Remarks</th>
                                            <th>Lampiran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($getData as $index => $item)
                                            <tr>
                                                <td>{{ $getData->firstItem() + $index }}</td>
                                                <td>{{ $item->invoice_number }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->payment_date)->format('d-m-Y') }}</td>
                                                <td>{{ $item->expense_name }}</td>
                                                <td>{{ number_format($item->base_price, 0, ',', '.') }}</td>
                                                <td>{{ number_format($item->admin_fee, 0, ',', '.') }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->total, 0, ',', '.') }}</td>
                                                <td>{{ number_format($item->ppn_rate, 2, ',', '.') }}%</td>
                                                <td>{{ number_format($item->ppn_amount, 0, ',', '.') }}</td>
                                                <td>{{ number_format($item->total + $item->ppn_amount, 0, ',', '.') }}</td>
                                                <td>{{ $item->payment_type }}</td>
                                                <td>{{ $item->payment_category }}</td>
                                                <td>{{ $item->invoice_number }}</td>
                                                <td>{{ $item->remarks }}</td>
                                                <td>
                                                    @if ($item->attachment)
                                                        <a href="{{ asset('storage/' . $item->attachment) }}"
                                                            target="_blank" class="btn btn-sm btn-info">View</a>
                                                    @else
                                                        <span class="text-muted">No Attachment</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('pengeluaran.edit', $item->id) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('pengeluaran.destroy', $item->id) }}"
                                                        method="POST" class="d-inline-block"
                                                        onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="17" class="text-center">No expenses found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination -->
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    {{-- Previous Button --}}
                                    <li class="page-item {{ $getData->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $getData->previousPageUrl() }}" tabindex="-1">
                                            <i class="fa fa-angle-left"></i>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>

                                    {{-- Page Numbers --}}
                                    @for ($i = 1; $i <= $getData->lastPage(); $i++)
                                        <li class="page-item {{ $getData->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $getData->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    {{-- Next Button --}}
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
            <div class="modal-dialog modal-lg"> <!-- Menggunakan modal-lg untuk lebar yang lebih besar -->
                <div class="modal-content">
                    <form action="{{ route('pengeluaran.store') }}" method="POST" enctype="multipart/form-data"
                        id="addExpenseForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addExpenseModalLabel">Add Expense</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Row 1: Expense Name & Payment Date -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="expense_name" class="form-label">Expense Name</label>
                                    <input type="text" class="form-control @error('expense_name') is-invalid @enderror"
                                        id="expense_name" name="expense_name" value="{{ old('expense_name') }}"
                                        required>
                                    @error('expense_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="payment_date" class="form-label">Payment Date</label>
                                    <input type="date" class="form-control @error('payment_date') is-invalid @enderror"
                                        id="payment_date" name="payment_date" value="{{ old('payment_date') }}"
                                        required>
                                    @error('payment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 2: Base Price, Admin Fee & Quantity -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="base_price" class="form-label">Base Price (IDR)</label>
                                    <input type="text"
                                        class="form-control currency-input @error('base_price') is-invalid @enderror"
                                        id="base_price" name="base_price" value="{{ old('base_price') }}" required>
                                    @error('base_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="admin_fee" class="form-label">Admin Fee (IDR) <small
                                            class="text-muted">(Optional)</small></label>
                                    <input type="text"
                                        class="form-control currency-input @error('admin_fee') is-invalid @enderror"
                                        id="admin_fee" name="admin_fee" value="{{ old('admin_fee') }}">
                                    @error('admin_fee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                        id="quantity" name="quantity" min="1" value="{{ old('quantity', 1) }}"
                                        required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 3: Total, PPN Rate & PPN Amount -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="total" class="form-label">Total (IDR)</label>
                                    <input type="text" class="form-control currency-input" id="total"
                                        name="total" readonly value="{{ old('total') }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="ppn_rate" class="form-label">PPN Rate (%)</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('ppn_rate') is-invalid @enderror" id="ppn_rate"
                                        name="ppn_rate" value="{{ old('ppn_rate', 10.0) }}" min="0" required>
                                    @error('ppn_rate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="ppn_amount" class="form-label">PPN Amount (IDR)</label>
                                    <input type="text" class="form-control currency-input" id="ppn_amount"
                                        name="ppn_amount" readonly value="{{ old('ppn_amount') }}">
                                </div>
                            </div>

                            <!-- Row 4: Grand Total -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="grand_total" class="form-label">Grand Total (IDR)</label>
                                    <input type="text" class="form-control currency-input" id="grand_total"
                                        name="grand_total" readonly value="{{ old('grand_total') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="payment_type" class="form-label">Payment Type</label>
                                    <select class="form-select @error('payment_type') is-invalid @enderror"
                                        id="payment_type" name="payment_type" required>
                                        <option value="">Select Payment Type</option>
                                        <option value="Cash" {{ old('payment_type') === 'Cash' ? 'selected' : '' }}>Cash
                                        </option>
                                        <option value="Transfer"
                                            {{ old('payment_type') === 'Transfer' ? 'selected' : '' }}>Transfer</option>
                                        <option value="Paper" {{ old('payment_type') === 'Paper' ? 'selected' : '' }}>
                                            Paper</option>
                                        <!-- Add more options if needed -->
                                    </select>
                                    @error('payment_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 5: Payment Category & Invoice Number -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="payment_category" class="form-label">Payment Category</label>
                                    <select class="form-select @error('payment_category') is-invalid @enderror"
                                        id="payment_category" name="payment_category" required>
                                        <option value="">Select Category</option>
                                        <option value="Marketing"
                                            {{ old('payment_category') === 'Marketing' ? 'selected' : '' }}>Marketing
                                        </option>
                                        <option value="Operational"
                                            {{ old('payment_category') === 'Operational' ? 'selected' : '' }}>Operational
                                        </option>
                                        <option value="Salary"
                                            {{ old('payment_category') === 'Salary' ? 'selected' : '' }}>Salary</option>
                                        <option value="Operasional Kantor"
                                            {{ old('payment_category') === 'Operasional Kantor' ? 'selected' : '' }}>
                                            Operasional Kantor</option>
                                        <option value="Website"
                                            {{ old('payment_category') === 'Website' ? 'selected' : '' }}>Website</option>
                                        <option value="Beban lain-lain"
                                            {{ old('payment_category') === 'Beban lain-lain' ? 'selected' : '' }}>Beban
                                            lain-lain</option>
                                        <option value="Pameran, Perjalanan, Meeting"
                                            {{ old('payment_category') === 'Pameran, Perjalanan, Meeting' ? 'selected' : '' }}>
                                            Pameran, Perjalanan, Meeting</option>
                                        <!-- Add more categories if needed -->
                                    </select>
                                    @error('payment_category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="invoice_number" class="form-label">Invoice Number</label>
                                    <input type="text"
                                        class="form-control @error('invoice_number') is-invalid @enderror"
                                        id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}"
                                        required>
                                    @error('invoice_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 6: Remarks & Attachment -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="remarks" class="form-label">Remarks <small
                                            class="text-muted">(Optional)</small></label>
                                    <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" rows="2">{{ old('remarks') }}</textarea>
                                    @error('remarks')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="attachment" class="form-label">Attachment <small
                                            class="text-muted">(Optional)</small></label>
                                    <input type="file" class="form-control @error('attachment') is-invalid @enderror"
                                        id="attachment" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    @error('attachment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 7: Attachment Preview -->
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <img src="#" alt="Attachment Preview" id="attachmentPreview"
                                        class="img-thumbnail d-none" style="max-height: 150px;">
                                </div>
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
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome for icons (optional) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            // Fungsi untuk memformat angka dengan titik sebagai pemisah ribuan
            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // Fungsi untuk menghapus titik dari angka
            function unformatNumber(numStr) {
                return numStr.replace(/\./g, '');
            }

            // Inisialisasi format pada halaman load
            $('.currency-input').each(function() {
                var value = $(this).val();
                if (value) {
                    $(this).val(formatNumber(value));
                }
            });

            // Hitung Total dan PPN saat input berubah
            $('#base_price, #admin_fee, #quantity, #ppn_rate').on('input change', function() {
                calculateTotals();
            });

            function calculateTotals() {
                var base_price = parseFloat(unformatNumber($('#base_price').val())) || 0;
                var admin_fee = parseFloat(unformatNumber($('#admin_fee').val())) || 0;
                var quantity = parseInt($('#quantity').val()) || 0;
                var ppn_rate = parseFloat($('#ppn_rate').val()) || 0;

                // Asumsi: Total = (base_price + admin_fee) * quantity
                var total = (base_price + admin_fee) * quantity;

                // PPN Amount = Total * (ppn_rate / 100)
                var ppn_amount = total * (ppn_rate / 100);

                // Grand Total = Total + PPN Amount
                var grand_total = total + ppn_amount;

                // Update fields
                $('#total').val(formatNumber(total.toFixed(0)));
                $('#ppn_amount').val(formatNumber(ppn_amount.toFixed(0)));
                $('#grand_total').val(formatNumber(grand_total.toFixed(0)));
            }

            // Format saat input focus out
            $(document).on('blur', '.currency-input', function() {
                var value = unformatNumber($(this).val());
                if ($.isNumeric(value)) {
                    $(this).val(formatNumber(value));
                } else {
                    $(this).val('');
                }
            });

            // Unformat saat input focus in
            $(document).on('focus', '.currency-input', function() {
                var value = unformatNumber($(this).val());
                $(this).val(value);
            });

            // Handle form submission untuk menghapus format
            $('#addExpenseForm').submit(function(e) {
                // Format semua currency-input menjadi integer tanpa titik
                $('.currency-input').each(function() {
                    var value = unformatNumber($(this).val());
                    if ($.isNumeric(value)) {
                        $(this).val(value);
                    } else {
                        $(this).val('');
                    }
                });
            });

            // Inisialisasi perhitungan saat halaman dimuat
            calculateTotals();

            // Attachment Preview
            $('#attachment').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const mimeType = file.type;
                        if (mimeType.startsWith('image/')) {
                            $('#attachmentPreview').attr('src', event.target.result).removeClass(
                                'd-none');
                        } else {
                            $('#attachmentPreview').addClass('d-none').attr('src', '#');
                        }
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#attachmentPreview').addClass('d-none').attr('src', '#');
                }
            });
        });

        // Chart.js Initialization
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

        // Buka Modal Secara Otomatis Jika Ada Error
        @if ($errors->any())
            var addExpenseModal = new bootstrap.Modal(document.getElementById('addExpenseModal'));
            addExpenseModal.show();
        @endif
    </script>
@endpush
