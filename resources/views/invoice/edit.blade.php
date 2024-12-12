<!-- resources/views/invoice/edit.blade.php -->
@extends('template.index')

@section('content')
    <div class="col-md-8 col-sm-10 mx-auto">
        <form action="{{ route('invoice.update', $invoice->id) }}" method="POST" id="editInvoiceForm">
            @csrf
            @method('PUT')
            <div class="card my-sm-5 my-lg-0">
                <div class="card-header text-center">
                    <h5>Edit Invoice</h5>
                </div>
                <div class="card-body">
                    <!-- Client Information in Two Columns -->
                    <div class="row">
                        <!-- Company Name -->
                        <div class="col-md-6 mb-3">
                            <label for="companyName" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="companyName" name="companyName"
                                value="{{ old('companyName', $invoice->company_name) }}" required>
                        </div>
                        <!-- Client Name -->
                        <div class="col-md-6 mb-3">
                            <label for="clientName" class="form-label">Client Name</label>
                            <input type="text" class="form-control" id="clientName" name="clientName"
                                value="{{ old('clientName', $invoice->client_name) }}" required>
                        </div>
                        <!-- Client Job Title -->
                        <div class="col-md-6 mb-3">
                            <label for="clientJobTitle" class="form-label">Client Job Title</label>
                            <input type="text" class="form-control" id="clientJobTitle" name="clientJobTitle"
                                value="{{ old('clientJobTitle', $invoice->client_job_title) }}">
                        </div>
                        <!-- Client Telephone -->
                        <div class="col-md-6 mb-3">
                            <label for="clientTelephone" class="form-label">Telephone</label>
                            <input type="text" class="form-control" id="clientTelephone" name="clientTelephone"
                                value="{{ old('clientTelephone', $invoice->client_telephone) }}">
                        </div>
                        <!-- Client Email -->
                        <div class="col-md-6 mb-3">
                            <label for="clientEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="clientEmail" name="clientEmail"
                                value="{{ old('clientEmail', $invoice->client_email) }}" required>
                        </div>
                        <!-- NPWP (Optional) -->
                        <div class="col-md-6 mb-3">
                            <label for="npwp" class="form-label">NPWP (Optional)</label>
                            <input type="text" class="form-control" id="npwp" name="npwp"
                                value="{{ old('npwp', $invoice->npwp) }}">
                        </div>
                        <!-- Rate IDR -->
                        <div class="col-md-6 mb-3">
                            <label for="rateIDR" class="form-label">Rate IDR</label>
                            <input type="text" class="form-control currency-input" id="rateIDR" name="rateIDR" required
                                value="{{ old('rateIDR', number_format($invoice->rate_idr, 0, ',', '.')) }}">
                        </div>
                        <!-- Client Address -->
                        <div class="col-md-6 mb-3">
                            <label for="clientAddress" class="form-label">Address</label>
                            <textarea class="form-control" id="clientAddress" name="clientAddress" rows="2" required>{{ old('clientAddress', $invoice->client_address) }}</textarea>
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
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="addItem">
                                            Add Item
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->items as $index => $item)
                                    <tr>
                                        <td>
                                            <textarea name="itemDescription[]" class="form-control item-description" required>{{ old('itemDescription.' . $index, $item->description) }}</textarea>
                                        </td>
                                        <td>
                                            <input type="number" name="itemQuantity[]" class="form-control item-quantity"
                                                required value="{{ old('itemQuantity.' . $index, $item->quantity) }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control currency-input item-unit-price"
                                                name="itemUnitPrice[]" required
                                                value="{{ old('itemUnitPrice.' . $index, number_format($item->unit_price, 0, ',', '.')) }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control currency-input item-total"
                                                name="itemTotal[]" readonly
                                                value="{{ old('itemTotal.' . $index, number_format($item->total, 0, ',', '.')) }}">
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger remove-item">Remove</button>
                                        </td>
                                    </tr>
                                @endforeach
                                <!-- Jika belum ada item, tambahkan satu baris kosong -->
                                @if ($invoice->items->isEmpty())
                                    <tr>
                                        <td>
                                            <textarea name="itemDescription[]" class="form-control item-description" required></textarea>
                                        </td>
                                        <td>
                                            <input type="number" name="itemQuantity[]" class="form-control item-quantity"
                                                required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control currency-input item-unit-price"
                                                name="itemUnitPrice[]" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control currency-input item-total"
                                                name="itemTotal[]" readonly>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger remove-item">Remove</button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Payment Method</label>
                        <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                            <option value="Manual Transfer"
                                {{ old('paymentMethod', $invoice->payment_method) === 'Manual Transfer' ? 'selected' : '' }}>
                                Manual Transfer
                            </option>
                            <option value="Xendit Transfer"
                                {{ old('paymentMethod', $invoice->payment_method) === 'Xendit Transfer' ? 'selected' : '' }}>
                                Xendit Transfer
                            </option>
                        </select>
                    </div>

                    <!-- PPN Section -->
                    <div class="mb-3">
                        <label for="ppnRate" class="form-label">PPN (Optional)</label>
                        <select class="form-select" id="ppnRate" name="ppnRate">
                            <option value="0" {{ old('ppnRate', $invoice->ppn_rate) == '0' ? 'selected' : '' }}>No
                                PPN</option>
                            <option value="11" {{ old('ppnRate', $invoice->ppn_rate) == '11' ? 'selected' : '' }}>11%
                            </option>
                            <option value="12" {{ old('ppnRate', $invoice->ppn_rate) == '12' ? 'selected' : '' }}>12%
                            </option>
                        </select>
                    </div>

                    <!-- PPN Display -->
                    <div class="mb-3">
                        <label for="ppnAmount" class="form-label">PPN Amount(IDR)</label>
                        <input type="text" class="form-control currency-input" id="ppnAmount" name="ppnAmount"
                            readonly value="{{ old('ppnAmount', number_format($invoice->ppn_amount, 0, ',', '.')) }}">
                    </div>

                    <!-- Total Amount -->
                    <div class="mb-3">
                        <label for="totalAmount" class="form-label">Total Amount(IDR)</label>
                        <input type="text" class="form-control currency-input" id="totalAmount" name="totalAmount"
                            readonly
                            value="{{ old('totalAmount', number_format($invoice->total_amount, 0, ',', '.')) }}">
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $invoice->notes) }}</textarea>
                    </div>

                    <!-- Payment Status -->
                    <div class="mb-3">
                        <label for="paymentStatus" class="form-label">Payment Status</label>
                        <select class="form-select" id="paymentStatus" name="paymentStatus" required>
                            <option value="Unpaid"
                                {{ old('paymentStatus', $invoice->payment_status) === 'Unpaid' ? 'selected' : '' }}>Unpaid
                            </option>
                            <option value="Paid"
                                {{ old('paymentStatus', $invoice->payment_status) === 'Paid' ? 'selected' : '' }}>Paid
                            </option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Invoice</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('top')
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <!-- Tambahkan JS tambahan jika diperlukan -->
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

            // Add new item row
            $('#addItem').click(function() {
                var newRow = '<tr>' +
                    '<td><textarea name="itemDescription[]" class="form-control item-description" required></textarea></td>' +
                    '<td><input type="number" name="itemQuantity[]" class="form-control item-quantity" required></td>' +
                    '<td><input type="text" class="form-control currency-input item-unit-price" name="itemUnitPrice[]" required></td>' +
                    '<td><input type="text" class="form-control currency-input item-total" name="itemTotal[]" readonly></td>' +
                    '<td><button type="button" class="btn btn-sm btn-outline-danger remove-item">Remove</button></td>' +
                    '</tr>';
                $('#invoiceItemsTable tbody').append(newRow);
            });

            // Remove item row
            $(document).on('click', '.remove-item', function() {
                $(this).closest('tr').remove();
                calculateTotal();
            });

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

            // Calculate total for each item and overall total when inputs change
            $(document).on('input', '.item-quantity, .item-unit-price', function() {
                var row = $(this).closest('tr');
                var quantity = parseInt(row.find('.item-quantity').val()) || 0;
                var unitPrice = parseInt(unformatNumber(row.find('.item-unit-price').val())) || 0;
                var total = quantity * unitPrice;
                row.find('.item-total').val(formatNumber(total));
                calculateTotal();
            });

            // Recalculate total when payment method or PPN rate changes
            $('#paymentMethod, #ppnRate').change(function() {
                calculateTotal();
            });

            // Fungsi untuk menghitung total
            function calculateTotal() {
                var totalAmount = 0;
                $('.item-total').each(function() {
                    var itemTotal = parseInt(unformatNumber($(this).val())) || 0;
                    totalAmount += itemTotal;
                });

                // Hitung PPN
                var ppnRate = parseInt($('#ppnRate').val()) || 0;
                var ppnAmount = Math.round(totalAmount * (ppnRate / 100));

                // Hitung surcharge jika payment method adalah Xendit Transfer
                var paymentMethod = $('#paymentMethod').val();
                var surcharge = 0;
                if (paymentMethod === 'Xendit Transfer') {
                    surcharge = Math.round(totalAmount * 0.03); // 3% surcharge
                }

                var grandTotal = totalAmount + ppnAmount + surcharge;

                // Tampilkan hasil di field PPN Amount dan Total Amount
                $('#ppnAmount').val(formatNumber(ppnAmount));
                $('#totalAmount').val(formatNumber(grandTotal));
            }

            // Handle form submission untuk menghapus format
            $('#editInvoiceForm').submit(function(e) {
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

            // Inisialisasi perhitungan saat halaman dimuat (untuk item yang sudah ada)
            calculateTotal();
        });
    </script>
@endpush
