@extends('template.index')

@section('content')
    <div class="container-fluid py-4">
        <!-- Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Filter Periode dengan Input Group -->
        <div class="row mb-4">
            <div class="col-md-12 text-end">
                <form method="GET" action="{{ route('invoice.index') }}" class="d-inline">
                    <div class="input-group">
                        <!-- Prepend Text atau Ikon -->
                        <span class="input-group-text" id="period-addon">
                            <i class="fas fa-filter"></i> <!-- Contoh Ikon menggunakan Font Awesome -->
                        </span>
                        <!-- Select Dropdown -->
                        <select class="form-select" id="period" name="period" aria-describedby="period-addon"
                            onchange="this.form.submit()">
                            <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>This Year</option>
                            <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>This Month</option>
                            <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="last_month" {{ request('period') == 'last_month' ? 'selected' : '' }}>Last Month
                            </option>
                            <!-- Tambahkan opsi lain jika diperlukan -->
                        </select>
                        <!-- Tambahkan Button atau Elemen Lain jika Diperlukan -->
                        <!-- Contoh: Tombol Reset -->
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="window.location='{{ route('invoice.index') }}'">Reset</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistical Cards -->
        <div class="row">
            <!-- Total Invoices Issued -->
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <p class="text-sm mb-1 text-uppercase font-weight-bold">Invoices Issued</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $totalInvoicesIssuedThisPeriod }}
                                    <span class="text-sm text-success font-weight-bolder">
                                        <!-- Misalnya, tambahkan ikon atau persentase perubahan jika diinginkan -->
                                    </span>
                                </h5>
                            </div>
                            <div class="col-4">
                                <div class="dropdown text-end">
                                    <a href="#" class="cursor-pointer text-secondary" id="dropdownIssued"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="text-xs text-secondary">{{ ucfirst($period) }}</span>
                                    </a>
                                    <!-- Dropdown content if needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Paid Invoices -->
            <div class="col-sm-4 mt-sm-0 mt-4">
                <div class="card">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <p class="text-sm mb-1 text-uppercase font-weight-bold">Invoices Paid</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $totalInvoicesPaidThisPeriod }}
                                    <span class="text-sm text-success font-weight-bolder">
                                        <!-- Tambahkan ikon atau persentase jika diinginkan -->
                                    </span>
                                </h5>
                            </div>
                            <div class="col-4">
                                <div class="dropdown text-end">
                                    <a href="#" class="cursor-pointer text-secondary" id="dropdownPaid"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="text-xs text-secondary">{{ ucfirst($period) }}</span>
                                    </a>
                                    <!-- Dropdown content if needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Unpaid Invoices -->
            <div class="col-sm-4 mt-sm-0 mt-4">
                <div class="card">
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <p class="text-sm mb-1 text-uppercase font-weight-bold">Invoices Unpaid</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $totalInvoicesUnpaidThisPeriod }}
                                    <span class="text-sm text-danger font-weight-bolder">
                                        <!-- Tambahkan ikon atau persentase jika diinginkan -->
                                    </span>
                                </h5>
                            </div>
                            <div class="col-4">
                                <div class="dropdown text-end">
                                    <a href="#" class="cursor-pointer text-secondary" id="dropdownUnpaid"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="text-xs text-secondary">{{ ucfirst($period) }}</span>
                                    </a>
                                    <!-- Dropdown content if needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Invoices Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <!-- Header with Add Invoice Button -->
                    <div class="d-sm-flex justify-content-between m-3">
                        <div>
                            <a href="#" class="btn btn-icon btn-outline-blue" data-bs-toggle="modal"
                                data-bs-target="#addInvoiceModal">
                                Add Invoice
                            </a>
                        </div>
                        <!-- Filters and Export Buttons if needed -->
                    </div>
                    <!-- Table -->
                    <div class="table-responsive">
                        <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                            <div class="dataTable-container">
                                <table class="table table-flush dataTable-table" id="datatable-invoice">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>Date Issued</th>
                                            <th>Due Date</th>
                                            <th>Client Name</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <!-- Bagian Tabel Invoice di Template Utama -->
                                    <tbody>
                                        @foreach ($invoices as $invoice)
                                            <tr data-invoice-id="{{ $invoice->id }}">
                                                <td>#{{ $invoice->invoice_number }}</td>
                                                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') }}</td>
                                                <td>{{ $invoice->client_name }}</td>
                                                <td>Rp {{ number_format($invoice->total_amount, 0) }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $invoice->payment_status === 'Paid' ? 'success' : 'danger' }}">
                                                        {{ $invoice->payment_status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <!-- Tombol View -->
                                                    <a href="{{ route('invoice.detail', $invoice->id) }}"
                                                        class="btn btn-sm btn-outline-primary">View</a>

                                                    <!-- Tombol Edit -->
                                                    <a href="{{ route('invoice.edit', $invoice->id) }}"
                                                        class="btn btn-sm btn-outline-secondary">Edit</a>

                                                    <!-- Tombol Remove -->
                                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteInvoiceModal"
                                                        data-invoice-id="{{ $invoice->id }}"
                                                        data-invoice-number="{{ $invoice->invoice_number }}">
                                                        Remove
                                                    </button>

                                                    <!-- Tombol Download PDF -->
                                                    <a href="{{ route('invoice.downloadPdf', $invoice->id) }}"
                                                        class="btn btn-sm btn-outline-success">Download PDF</a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                            <!-- Pagination if needed -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Invoice Modal -->
        <div class="modal fade" id="addInvoiceModal" tabindex="-1" aria-labelledby="addInvoiceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form action="{{ route('invoice.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addInvoiceModalLabel">Add Manual Invoice</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Client Information in Two Columns -->
                            <div class="row">
                                <!-- Company Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="companyName" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="companyName" name="companyName"
                                        required>
                                </div>
                                <!-- Client Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="clientName" class="form-label">Client Name</label>
                                    <input type="text" class="form-control" id="clientName" name="clientName"
                                        required>
                                </div>
                                <!-- Client Job Title -->
                                <div class="col-md-6 mb-3">
                                    <label for="clientJobTitle" class="form-label">Client Job Title</label>
                                    <input type="text" class="form-control" id="clientJobTitle"
                                        name="clientJobTitle">
                                </div>
                                <!-- Client Telephone -->
                                <div class="col-md-6 mb-3">
                                    <label for="clientTelephone" class="form-label">Telephone</label>
                                    <input type="text" class="form-control" id="clientTelephone"
                                        name="clientTelephone">
                                </div>
                                <!-- Client Email -->
                                <div class="col-md-6 mb-3">
                                    <label for="clientEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="clientEmail" name="clientEmail"
                                        required>
                                </div>
                                <!-- NPWP (Optional) -->
                                <div class="col-md-6 mb-3">
                                    <label for="npwp" class="form-label">NPWP (Optional)</label>
                                    <input type="text" class="form-control" id="npwp" name="npwp">
                                </div>
                                <!-- Rate IDR -->
                                <div class="col-md-6 mb-3">
                                    <label for="rateIDR" class="form-label">Rate IDR</label>
                                    <input type="number" class="form-control" id="rateIDR" name="rateIDR" readonly>
                                </div>
                                <!-- Client Address -->
                                <div class="col-md-6 mb-3">
                                    <label for="clientAddress" class="form-label">Address</label>
                                    <textarea class="form-control" id="clientAddress" name="clientAddress" rows="2" required></textarea>
                                </div>
                            </div>

                            <!-- Invoice Items -->
                            <div class="mb-3">
                                <label class="form-label">Invoice Items</label>
                                <table class="table table-bordered" id="invoiceItemsTable">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price(IDR)</th>
                                            <th>Total(IDR)</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    id="addItem">
                                                    Add Item
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Initial Row -->
                                        <tr>
                                            <td>
                                                <textarea name="itemDescription[]" class="form-control"></textarea>
                                            </td>
                                            <td><input type="text" name="itemQuantity[]"
                                                    class="form-control item-quantity" required></td>
                                            <td><input type="text" name="itemUnitPrice[]"
                                                    class="form-control item-unit-price" required></td>
                                            <td><input type="text" name="itemTotal[]" class="form-control item-total"
                                                    readonly></td>
                                            <td><button type="button"
                                                    class="btn btn-sm btn-outline-danger remove-item">Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-3">
                                <label for="paymentMethod" class="form-label">Payment Method</label>
                                <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                                    <option value="Manual Transfer">Manual Transfer</option>
                                    <option value="Xendit Transfer">Xendit Transfer</option>
                                </select>
                            </div>

                            <!-- PPN Section -->
                            <div class="mb-3">
                                <label for="ppnRate" class="form-label">PPN (Optional)</label>
                                <select class="form-select" id="ppnRate" name="ppnRate">
                                    <option value="0" selected>No PPN</option>
                                    <option value="11">11%</option>
                                    <option value="12">12%</option>
                                </select>
                            </div>

                            <!-- PPN Display -->
                            <div class="mb-3">
                                <label for="ppnAmount" class="form-label">PPN Amount(IDR)</label>
                                <input type="text" class="form-control" id="ppnAmount" name="ppnAmount" readonly>
                            </div>

                            <!-- Total Amount -->
                            <div class="mb-3">
                                <label for="totalAmount" class="form-label">Total Amount(IDR)</label>
                                <input type="text" class="form-control" id="totalAmount" name="totalAmount" readonly>
                            </div>

                            <!-- Notes -->
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>

                            <!-- Payment Status -->
                            <div class="mb-3">
                                <label for="paymentStatus" class="form-label">Payment Status</label>
                                <select class="form-select" id="paymentStatus" name="paymentStatus" required>
                                    <option value="Unpaid">Unpaid</option>
                                    <option value="Paid">Paid</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Invoice</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Delete Invoice Modal -->
        <div class="modal fade" id="deleteInvoiceModal" tabindex="-1" aria-labelledby="deleteInvoiceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="deleteInvoiceForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteInvoiceModalLabel">Remove Invoice</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to remove invoice <strong id="invoiceNumber"></strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Remove</button>
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

    <!-- Include CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>
@endpush

@push('scripts')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <!-- Include CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            var ckeditors = [];

            // Add new item row
            $('#addItem').click(function() {
                var newRow = '<tr>' +
                    '<td>' +
                    '<textarea name="itemDescription[]" class="form-control item-description"></textarea>' +
                    '</td>' +
                    '<td><input type="text" name="itemQuantity[]" class="form-control item-quantity" required></td>' +
                    '<td><input type="text" name="itemUnitPrice[]" class="form-control item-unit-price" required></td>' +
                    '<td><input type="text" name="itemTotal[]" class="form-control item-total" readonly></td>' +
                    '<td><button type="button" class="btn btn-sm btn-outline-danger remove-item">Remove</button></td>' +
                    '</tr>';
                $('#invoiceItemsTable tbody').append(newRow);

                // Initialize CKEditor for the new item description
                var textarea = $('#invoiceItemsTable tbody tr:last .item-description')[0];
            });

            // Remove item row
            $(document).on('click', '.remove-item', function() {
                var row = $(this).closest('tr');
                var textarea = row.find('.item-description')[0];


                // Remove the row
                row.remove();
                calculateTotal();
            });

            // Format number inputs on focus out
            $(document).on('blur', '.item-quantity, .item-unit-price', function() {
                var value = $(this).val();
                value = formatNumber(value);
                $(this).val(value);
            });

            // Remove formatting on focus in
            $(document).on('focus', '.item-quantity, .item-unit-price', function() {
                var value = $(this).val();
                value = unformatNumber(value);
                $(this).val(value);
            });

            // Calculate total for each item and overall total when inputs change
            $(document).on('input', '.item-quantity, .item-unit-price', function() {
                var row = $(this).closest('tr');
                var quantity = parseNumber(row.find('.item-quantity').val()) || 0;
                var unitPrice = parseNumber(row.find('.item-unit-price').val()) || 0;
                var total = quantity * unitPrice;
                row.find('.item-total').val(formatNumber(total));
                calculateTotal();
            });

            // Calculate total when PPN rate changes
            $('#ppnRate').change(function() {
                calculateTotal();
            });

            // Recalculate total when payment method changes (if needed)
            $('#paymentMethod').change(function() {
                calculateTotal();
            });

            function calculateTotal() {
                var subtotal = 0;
                $('.item-total').each(function() {
                    var itemTotal = parseNumber($(this).val()) || 0;
                    subtotal += itemTotal;
                });

                // Get selected PPN rate
                var ppnRate = parseNumber($('#ppnRate').val()) || 0;
                var ppnAmount = subtotal * (ppnRate / 100);
                var totalAmount = subtotal + ppnAmount;

                $('#ppnAmount').val(formatNumber(ppnAmount));
                $('#totalAmount').val(formatNumber(totalAmount));
            }

            // Function to format numbers with thousand separators
            function formatNumber(number) {
                number = parseFloat(number);
                if (isNaN(number)) {
                    return '';
                }
                return number.toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2
                });
            }

            // Function to parse formatted numbers
            function parseNumber(numberString) {
                if (!numberString) return 0;
                // Remove thousand separators (dots) and replace decimal separator (comma) with dot
                var cleanString = numberString.replace(/\./g, '').replace(',', '.');
                return parseFloat(cleanString);
            }

            // Function to remove formatting
            function unformatNumber(numberString) {
                return parseNumber(numberString).toString();
            }

            // Handle Delete Invoice Modal
            $('#deleteInvoiceModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var invoiceId = button.data('invoice-id'); // Dapatkan ID invoice
                var invoiceNumber = button.data('invoice-number'); // Dapatkan nomor invoice

                // Update isi modal
                var modal = $(this);
                modal.find('#invoiceNumber').text(invoiceNumber);
                modal.find('#deleteInvoiceForm').attr('action', '{{ url('/invoice') }}/' + invoiceId);
            });

            // Fetch latest rate when Add Invoice Modal is opened
            $('#addInvoiceModal').on('show.bs.modal', function(event) {
                $.ajax({
                    url: '{{ route('invoice.latestRate') }}',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#rateIDR').val(data.rate);
                        calculateTotal(); // Recalculate total with new rate
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching latest rate:', error);
                        // Optionally, set a default value or notify the user
                        $('#rateIDR').val(''); // or some default
                        calculateTotal(); // Recalculate total without rate
                    }
                });
            });
        });
    </script>
@endpush
