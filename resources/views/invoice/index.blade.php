@extends('template.index')

@section('content')
    <div class="container-fluid py-4">
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
                                    120
                                </h5>
                            </div>
                            <div class="col-4">
                                <div class="dropdown text-end">
                                    <a href="#" class="cursor-pointer text-secondary" id="dropdownIssued"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="text-xs text-secondary">This Year</span>
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
                                    80
                                </h5>
                            </div>
                            <div class="col-4">
                                <div class="dropdown text-end">
                                    <a href="#" class="cursor-pointer text-secondary" id="dropdownPaid"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="text-xs text-secondary">This Year</span>
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
                                    40
                                </h5>
                            </div>
                            <div class="col-4">
                                <div class="dropdown text-end">
                                    <a href="#" class="cursor-pointer text-secondary" id="dropdownUnpaid"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="text-xs text-secondary">This Year</span>
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
                                    <tbody>
                                        <!-- Dummy Data Rows -->
                                        <tr data-invoice-id="1">
                                            <td>#INV001</td>
                                            <td>2023-12-01</td>
                                            <td>2023-12-15</td>
                                            <td>Acme Corporation</td>
                                            <td>Rp1.500.000,00</td>
                                            <td>
                                                <span class="badge status-badge bg-danger">Unpaid</span>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                                                <button class="btn btn-sm btn-outline-success toggle-status"
                                                    data-new-status="Paid">
                                                    Mark as Paid
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-invoice-id="2">
                                            <td>#INV002</td>
                                            <td>2023-12-05</td>
                                            <td>2023-12-20</td>
                                            <td>Beta LLC</td>
                                            <td>Rp2.000.000,00</td>
                                            <td>
                                                <span class="badge status-badge bg-success">Paid</span>
                                            </td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                <a href="#" class="btn btn-sm btn-outline-danger">Delete</a>
                                                <button class="btn btn-sm btn-outline-warning toggle-status"
                                                    data-new-status="Unpaid">
                                                    Mark as Unpaid
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Add more dummy data rows as needed -->
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
                    <form>
                        <!-- CSRF Token if using Laravel -->
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addInvoiceModalLabel">Add Manual Invoice</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <input type="number" class="form-control" id="rateIDR" name="rateIDR" required>
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
                                            <th>Unit Price</th>
                                            <th>Total</th>
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
                                                <textarea name="itemDescription[]" class="form-control item-description"></textarea>
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

                            <!-- Total Amount -->
                            <div class="mb-3">
                                <label for="totalAmount" class="form-label">Total Amount</label>
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
                            <!-- Additional fields as per the predetermined format -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Invoice</button>
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

    <script>
        $(document).ready(function() {
            // Add new item row
            $('#addItem').click(function() {
                var newRow = '<tr>' +
                    '<td><textarea name="itemDescription[]" class="form-control item-description"></textarea></td>' +
                    '<td><input type="text" name="itemQuantity[]" class="form-control item-quantity" required></td>' +
                    '<td><input type="text" name="itemUnitPrice[]" class="form-control item-unit-price" required></td>' +
                    '<td><input type="text" name="itemTotal[]" class="form-control item-total" readonly></td>' +
                    '<td><button type="button" class="btn btn-sm btn-outline-danger remove-item">Remove</button></td>' +
                    '</tr>';
                $('#invoiceItemsTable tbody').append(newRow);

                // Initialize CKEditor for the new item description
            });

            // Remove item row
            $(document).on('click', '.remove-item', function() {
                // Destroy CKEditor instance of the removed item
                $(this).closest('tr').remove();
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

            // Recalculate total when payment method changes
            $('#paymentMethod').change(function() {
                calculateTotal();
            });

            function calculateTotal() {
                var totalAmount = 0;
                $('.item-total').each(function() {
                    var itemTotal = parseNumber($(this).val()) || 0;
                    totalAmount += itemTotal;
                });

                // Apply 3% fee if Xendit Transfer is selected
                if ($('#paymentMethod').val() === 'Xendit Transfer') {
                    var surcharge = totalAmount * 0.03;
                    totalAmount += surcharge;
                }

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
        });
    </script>
@endpush
