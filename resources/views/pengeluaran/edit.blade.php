<!-- resources/views/expenses/edit.blade.php -->

@extends('template.index')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Expense</h5>
                        <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary btn-sm float-end">Back to
                            Expenses</a>
                    </div>
                    <div class="card-body">
                        <!-- Notifikasi -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
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

                        <form action="{{ route('pengeluaran.update', $expense->id) }}" method="POST"
                            enctype="multipart/form-data" id="editExpenseForm">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <!-- Row 1: Expense Name & Payment Date -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="expense_name" class="form-label">Expense Name</label>
                                        <input type="text"
                                            class="form-control @error('expense_name') is-invalid @enderror"
                                            id="expense_name" name="expense_name"
                                            value="{{ old('expense_name', $expense->expense_name) }}" required>
                                        @error('expense_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="payment_date" class="form-label">Payment Date</label>
                                        <input type="date"
                                            class="form-control @error('payment_date') is-invalid @enderror"
                                            id="payment_date" name="payment_date"
                                            value="{{ old('payment_date', $expense->payment_date->format('Y-m-d')) }}"
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
                                            id="base_price" name="base_price"
                                            value="{{ old('base_price', $expense->base_price) }}" required>
                                        @error('base_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="admin_fee" class="form-label">Admin Fee (IDR) <small
                                                class="text-muted">(Optional)</small></label>
                                        <input type="text"
                                            class="form-control currency-input @error('admin_fee') is-invalid @enderror"
                                            id="admin_fee" name="admin_fee"
                                            value="{{ old('admin_fee', $expense->admin_fee) }}">
                                        @error('admin_fee')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                            id="quantity" name="quantity" min="1"
                                            value="{{ old('quantity', $expense->quantity) }}" required>
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
                                            name="total" readonly value="{{ old('total', $expense->total) }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="ppn_rate" class="form-label">PPN Rate (%)</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('ppn_rate') is-invalid @enderror" id="ppn_rate"
                                            name="ppn_rate" value="{{ old('ppn_rate', $expense->ppn_rate) }}"
                                            min="0" required>
                                        @error('ppn_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="ppn_amount" class="form-label">PPN Amount (IDR)</label>
                                        <input type="text" class="form-control currency-input" id="ppn_amount"
                                            name="ppn_amount" readonly
                                            value="{{ old('ppn_amount', $expense->ppn_amount) }}">
                                    </div>
                                </div>

                                <!-- Row 4: Grand Total & Payment Type -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="grand_total" class="form-label">Grand Total (IDR)</label>
                                        <input type="text" class="form-control currency-input" id="grand_total"
                                            name="grand_total" readonly
                                            value="{{ old('grand_total', $expense->grand_total) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="payment_type" class="form-label">Payment Type</label>
                                        <select class="form-select @error('payment_type') is-invalid @enderror"
                                            id="payment_type" name="payment_type" required>
                                            <option value="">Select Payment Type</option>
                                            <option value="Cash"
                                                {{ old('payment_type', $expense->payment_type) === 'Cash' ? 'selected' : '' }}>
                                                Cash</option>
                                            <option value="Transfer"
                                                {{ old('payment_type', $expense->payment_type) === 'Transfer' ? 'selected' : '' }}>
                                                Transfer</option>
                                            <option value="Paper"
                                                {{ old('payment_type', $expense->payment_type) === 'Paper' ? 'selected' : '' }}>
                                                Paper</option>
                                            <option value="Credit Card"
                                                {{ old('payment_type', $expense->payment_type) === 'Credit Card' ? 'selected' : '' }}>
                                                Credit Card</option>
                                            <!-- Tambahkan opsi lain jika diperlukan -->
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
                                                {{ old('payment_category', $expense->payment_category) === 'Marketing' ? 'selected' : '' }}>
                                                Marketing</option>
                                            <option value="Temporary Worker"
                                                {{ old('payment_category', $expense->payment_category) === 'Temporary Worker' ? 'selected' : '' }}>
                                                Temporary Worker</option>
                                            <option value="Graphic Design"
                                                {{ old('payment_category', $expense->payment_category) === 'Graphic Design' ? 'selected' : '' }}>
                                                Graphic Design</option>
                                            <option value="Venue"
                                                {{ old('payment_category', $expense->payment_category) === 'Venue' ? 'selected' : '' }}>
                                                Venue</option>
                                            <option value="Produksi"
                                                {{ old('payment_category', $expense->payment_category) === 'Produksi' ? 'selected' : '' }}>
                                                Produksi</option>
                                            <option value="Stand Kontraktor"
                                                {{ old('payment_category', $expense->payment_category) === 'Stand Kontraktor' ? 'selected' : '' }}>
                                                Stand Kontraktor</option>
                                            <option value="Salary"
                                                {{ old('payment_category', $expense->payment_category) === 'Salary' ? 'selected' : '' }}>
                                                Salary</option>
                                            <option value="Printing"
                                                {{ old('payment_category', $expense->payment_category) === 'Printing' ? 'selected' : '' }}>
                                                Printing</option>
                                            <option value="Akomodasi"
                                                {{ old('payment_category', $expense->payment_category) === 'Akomodasi' ? 'selected' : '' }}>
                                                Akomodasi</option>
                                            <option value="Participant"
                                                {{ old('payment_category', $expense->payment_category) === 'Participant' ? 'selected' : '' }}>
                                                Participant</option>
                                            <option value="Media"
                                                {{ old('payment_category', $expense->payment_category) === 'Media' ? 'selected' : '' }}>
                                                Media</option>
                                            <option value="Gift"
                                                {{ old('payment_category', $expense->payment_category) === 'Gift' ? 'selected' : '' }}>
                                                Gift</option>
                                            <option value="Konsumsi"
                                                {{ old('payment_category', $expense->payment_category) === 'Konsumsi' ? 'selected' : '' }}>
                                                Konsumsi</option>
                                            <option value="Mc"
                                                {{ old('payment_category', $expense->payment_category) === 'Mc' ? 'selected' : '' }}>
                                                Mc</option>
                                            <option value="Entertainment"
                                                {{ old('payment_category', $expense->payment_category) === 'Entertainment' ? 'selected' : '' }}>
                                                Entertainment</option>
                                            <option value="Operasional Kantor"
                                                {{ old('payment_category', $expense->payment_category) === 'Operasional Kantor' ? 'selected' : '' }}>
                                                Operasional Kantor</option>
                                            <option value="Website"
                                                {{ old('payment_category', $expense->payment_category) === 'Website' ? 'selected' : '' }}>
                                                Website</option>
                                            <option value="Digital Subscription"
                                                {{ old('payment_category', $expense->payment_category) === 'Digital Subscription' ? 'selected' : '' }}>
                                                Digital Subscription</option>
                                            <option value="Beban lain-lain"
                                                {{ old('payment_category', $expense->payment_category) === 'Beban lain-lain' ? 'selected' : '' }}>
                                                Beban lain-lain</option>
                                            <option value="Pameran, Perjalanan, Meeting"
                                                {{ old('payment_category', $expense->payment_category) === 'Pameran, Perjalanan, Meeting' ? 'selected' : '' }}>
                                                Pameran, Perjalanan, Meeting</option>
                                            <!-- Tambahkan kategori lain jika diperlukan -->
                                        </select>
                                        @error('payment_category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="invoice_number" class="form-label">Invoice Number</label>
                                        <input type="text"
                                            class="form-control @error('invoice_number') is-invalid @enderror"
                                            id="invoice_number" name="invoice_number"
                                            value="{{ old('invoice_number', $expense->invoice_number) }}" required>
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
                                        <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" rows="2">{{ old('remarks', $expense->remarks) }}</textarea>
                                        @error('remarks')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="attachment" class="form-label">Attachment <small
                                                class="text-muted">(Optional)</small></label>
                                        <input type="file"
                                            class="form-control @error('attachment') is-invalid @enderror"
                                            id="attachment" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                        @error('attachment')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Row 7: Existing Attachment & Preview -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        @if ($expense->attachment)
                                            <label class="form-label">Existing Attachment:</label>
                                            <div>
                                                @php
                                                    $mime = Storage::disk('public')->mimeType($expense->attachment);
                                                @endphp
                                                @if (Str::startsWith($mime, 'image/'))
                                                    <img src="{{ asset('storage/' . $expense->attachment) }}"
                                                        alt="Attachment" class="img-thumbnail"
                                                        style="max-height: 150px;">
                                                @else
                                                    <a href="{{ asset('storage/' . $expense->attachment) }}"
                                                        target="_blank" class="btn btn-sm btn-info">View Attachment</a>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">No existing attachment.</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <img src="#" alt="Attachment Preview" id="attachmentPreview"
                                            class="img-thumbnail d-none" style="max-height: 150px;">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Expense</button>
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

                // Hitung Total, PPN Amount, dan Grand Total saat input berubah
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
                $('#editExpenseForm').submit(function(e) {
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


            // Buka Modal Secara Otomatis Jika Ada Error
            @if ($errors->any())
                var editExpenseModal = new bootstrap.Modal(document.getElementById('editExpenseModal'));
                editExpenseModal.show();
            @endif
        </script>
    @endpush
