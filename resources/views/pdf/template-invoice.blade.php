<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
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
            <p><strong>TO:</strong> SCANTECH INTERNATIONAL PTY LTD</p>
            <p>Mr. Ryan Khoo<br>
                Sales & Marketing Officer<br>
                143 Mooringe Avenue, Camden Park, South Australia, Australia 5038<br>
                <strong>T:</strong> +61438830954 | <strong>E:</strong> R.Khoo@scantech.com.au
            </p>
        </div>
        <div class="invoice-details">
            <table>
                <tr>
                    <th>Invoice Date</th>
                    <td>Tuesday, August 27, 2024</td>
                </tr>
                <tr>
                    <th>Invoice Number</th>
                    <td>02501</td>
                </tr>
                <tr>
                    <td colspan="2" class="highlight">INDONESIA MINER CONFERENCE 2025</td>
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
                <th>Price (USD)</th>
                <th>Total (USD)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>
                    Indonesia Miner Conference & Exhibition 2025: June 10 - 12, 2025<br>
                    Standard Plus booth package (Basic Design) - Booth No. 10<br>
                    <ul>
                        <li>Basic Design (3m x 2m / 6 SQM) - equipped with Walls, Carpet, Fascia, 1 Table, 2 Chairs, 2
                            Amp Electricity</li>
                        <li>2 Exhibitor Passes</li>
                        <li>50 Wishlist for Mining Passes</li>
                        <li>Listing at Indonesia Miner Directory</li>
                        <li>Company Logo and Profile on Event Booklet</li>
                        <li>Social Media Promotional Content</li>
                    </ul>
                </td>
                <td>STANDARD PLUS</td>
                <td>5,000</td>
                <td>5,000</td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <p><strong>Total in USD:</strong> 5,000</p>
        <p><strong>Total in IDR:</strong> 78,945,000</p>
    </div>

    <div class="additional-info">
        <p><strong>Price Excluding VAT</strong></p>
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

    <div class="footer">
        <div class="signature">
            <div class="line"></div>
            Shofwatunnikmah
        </div>
    </div>


</body>

</html>
