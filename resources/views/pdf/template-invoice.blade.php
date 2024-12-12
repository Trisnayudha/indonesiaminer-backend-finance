<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* Styling tetap sama seperti sebelumnya */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header .logo img {
            max-height: 100px;
        }

        .header .company-details {
            text-align: right;
            font-size: 14px;
        }

        .invoice-title {
            text-align: center;
            margin: 20px 0;
            font-size: 24px;
            font-weight: bold;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .invoice-header .to-section {
            width: 60%;
            font-size: 14px;
        }

        .invoice-header .invoice-details {
            width: 35%;
            font-size: 14px;
            border: 1px solid #000;
        }

        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-details th,
        .invoice-details td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #000;
        }

        .invoice-details th {
            background-color: #f4f4f4;
        }

        .invoice-details .highlight {
            text-align: center;
            font-weight: bold;
            background-color: #ffcc00;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #f4f4f4;
        }

        .total-section {
            text-align: right;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .payment-info {
            margin: 20px 0;
            font-size: 14px;
            border: 1px solid #000;
            padding: 10px;
            width: 60%;
        }

        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .footer .signature {
            text-align: center;
            margin-top: 20px;
        }

        .footer .signature .line {
            margin-bottom: 5px;
            width: 150px;
            border-top: 1px solid #000;
            margin: 0 auto;
        }

        .additional-info {
            margin-top: 20px;
            font-size: 14px;
            line-height: 1.5;
        }

        .additional-info strong {
            font-weight: bold;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 12px;
                /* Mengurangi ukuran font agar muat */
            }

            .header,
            .invoice-header,
            .invoice-title,
            .invoice-table,
            .total-section,
            .additional-info,
            .payment-info,
            .footer {
                page-break-inside: avoid;
                /* Menghindari elemen terputus di halaman berbeda */
            }

            .header {
                margin-bottom: 10px;
            }

            .invoice-title {
                margin: 10px 0;
            }

            .invoice-header {
                margin-bottom: 10px;
            }

            .invoice-table th,
            .invoice-table td {
                padding: 5px;
                /* Mengurangi padding untuk menghemat ruang */
            }

            .payment-info {
                width: 50%;
                /* Memastikan elemen membentang penuh */
            }

            .footer {
                margin-top: 20px;
            }

            /* Menghapus margin dan padding dari elemen untuk print */
            @page {
                margin: 10mm;
                /* Margin halaman untuk printer */
            }
        }

        .paid-stamp {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 48px;
            font-weight: bold;
            color: rgba(0, 128, 0, 0.3);
            /* Warna hijau transparan */
            text-transform: uppercase;
            border: 5px solid rgba(0, 128, 0, 0.3);
            padding: 10px 40px;
            border-radius: 10px;
            transform: rotate(-15deg);
        }

        /* Kelas untuk Stempel Unpaid */
        .unpaid-stamp {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-size: 48px;
            font-weight: bold;
            color: rgba(255, 0, 0, 0.3);
            /* Warna merah transparan */
            text-transform: uppercase;
            border: 5px solid rgba(255, 0, 0, 0.3);
            padding: 10px 40px;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">
            <img src="{{ asset('image/logo.png') }}" alt="Logo">
        </div>
        <div class="company-details">
            PT. Media Mitrakarya Indonesia<br>
            Gedung 47, 2nd Floor Suite 201A<br>
            Jl. TB Simatupang No.47 Tanjung Barat, Jakarta 12530, Indonesia<br>
            P: (021) 8062 3711 | E: billing@mmi-indonesia.co.id
        </div>
    </div>

    <div class="invoice-title">INVOICE</div>

    <div class="invoice-header">
        <div class="to-section">
            <p><strong>TO:</strong> {{ $invoice->client_name }}</p>
            <p>{{ $invoice->client_job_title }}<br>
                {{ $invoice->client_address }}<br>
                <strong>T:</strong> {{ $invoice->client_telephone }} | <strong>E:</strong> {{ $invoice->client_email }}
            </p>
        </div>
        <div class="invoice-details">
            <table>
                <tr>
                    <th>Invoice Date</th>
                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('l, F d, Y') }}</td>
                </tr>
                <tr>
                    <th>Invoice Number</th>
                    <td>{{ $invoice->invoice_number }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="highlight">{{ $invoice->notes ?? 'INVOICE DETAILS' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Description</th>
                <th>Type</th>
                <th>Price (IDR)</th>
                @if (isset($invoice->rate_idr) && $invoice->rate_idr > 0)
                    <th>Price (USD)</th>
                @endif
                @if (isset($invoice->rate_idr) && $invoice->rate_idr > 0)
                    <th>Total (USD)</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        {!! nl2br(e($item->description)) !!}
                    </td>
                    <td>{{ strtoupper($item->description) }}</td>
                    <td>{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    @if (isset($invoice->rate_idr) && $invoice->rate_idr > 0)
                        <td>{{ number_format($item->unit_price / $invoice->rate_idr, 2, '.', ',') }}</td>
                    @endif
                    @if (isset($invoice->rate_idr) && $invoice->rate_idr > 0)
                        <td>{{ number_format($item->total / $invoice->rate_idr, 2, '.', ',') }}</td>
                    @endif
                </tr>
            @endforeach

            <!-- Baris Total di Dalam Tabel -->
            <tr>
                <td colspan="3">IDR: {{ $invoice->rate_idr }}</td>

                <td colspan="2" style="text-align: right;"><strong>Total in USD:</strong></td>

                <td>{{ number_format($subtotal / $invoice->rate_idr, 2, '.', ',') }}</td>

            </tr>


            <tr>
                <td colspan="3">KMK Nomor:51/KM.10/KF.4/2024</td>
                <td colspan="2" style="text-align: right;"><strong>Total in IDR:</strong></td>
                <td>{{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>

            @if ($invoice->ppn_rate > 0 && $invoice->ppn_amount > 0)
                <tr>
                    @if (isset($invoice->rate_idr) && $invoice->rate_idr > 0)
                        <td colspan="5" style="text-align: right;"><strong>VAT ({{ $invoice->ppn_rate }}%)
                                IDR:</strong></td>
                    @else
                        <td colspan="4" style="text-align: right;"><strong>VAT ({{ $invoice->ppn_rate }}%)
                                IDR:</strong></td>
                    @endif
                    @if (isset($invoice->rate_idr) && $invoice->rate_idr > 0)
                        <td>{{ number_format($invoice->ppn_amount, 0, ',', '.') }}</td>
                    @else
                        <td>{{ number_format($invoice->ppn_amount, 0, ',', '.') }}</td>
                    @endif
                </tr>
            @endif

            <tr>
                @if (isset($invoice->rate_idr) && $invoice->rate_idr > 0)
                    <td colspan="{{ isset($invoice->rate_idr) && $invoice->rate_idr > 0 ? 5 : 4 }}"
                        style="text-align: right;"><strong>Grand Total:</strong></td>
                @else
                    <td colspan="4" style="text-align: right;"><strong>Grand Total:</strong></td>
                @endif
                @if (isset($invoice->rate_idr) && $invoice->rate_idr > 0)
                    <td>{{ number_format($grandTotal / $invoice->rate_idr, 2, '.', ',') }}</td>
                @else
                    <td>{{ number_format($grandTotal, 0, ',', '.') }}</td>
                @endif
            </tr>
        </tbody>
    </table>

    <div class="additional-info">
        @if (!empty($invoice->ppn_rate))
            <p><strong>Price Excluding VAT</strong></p>
        @endif
        <p>
            All Booking require payment of 100% of total package price within 14 days after invoice date.<br>
            Cancellation: Show management must receive written notice of cancellation. There is a 50% processing fee
            for all cancellations received at least 150 days prior to the event. No refunds within 90 days of the event.
        </p>
    </div>

    <div class="payment-info">
        <strong>Payment Information:</strong><br>
        Bank Name : PT. Bank Mandiri (persero) Tbk<br>
        Account Name : PT. Media Mitrakarya Indonesia<br>
        Branch : Mal Pondok Indah, Jakarta INDONESIA<br>
        IDR Account : 1010009992353<br>
        USD Account : 1010009992346<br>
        SWIFT CODE : BMRIIDJA
    </div>

    @if ($invoice->payment_status === 'Paid')
        <div class="paid-stamp">PAID</div>
    @elseif($invoice->payment_status === 'Unpaid')
        <div class="unpaid-stamp">UNPAID</div>
    @endif

    <div class="footer">
        <div class="signature">
            <div class="line"></div>
            Shofwatunnikmah
        </div>
    </div>

</body>

</html>
