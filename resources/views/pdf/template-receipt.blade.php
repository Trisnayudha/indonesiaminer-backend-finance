<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
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

        .receipt-title {
            text-align: center;
            margin: 20px 0;
            font-size: 24px;
            font-weight: bold;
            color: green;
        }

        .receipt-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .receipt-header .to-section {
            width: 60%;
            font-size: 14px;
        }

        .receipt-header .receipt-details {
            width: 35%;
            font-size: 14px;
            border: 1px solid #000;
        }

        .receipt-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .receipt-details th,
        .receipt-details td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #000;
        }

        .receipt-details th {
            background-color: #f4f4f4;
        }

        .receipt-details .highlight {
            text-align: center;
            font-weight: bold;
            background-color: #ffcc00;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .receipt-table th,
        .receipt-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .receipt-table th {
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

    <div class="receipt-title">RECEIPT</div>

    <div class="receipt-header">
        <div class="to-section">
            <p><strong>TO:</strong> SCANTECH INTERNATIONAL PTY LTD</p>
            <p>Mr. Ryan Khoo<br>
                Sales & Marketing Officer<br>
                143 Mooringe Avenue, Camden Park, South Australia, Australia 5038<br>
                <strong>T:</strong> +61438830954 | <strong>E:</strong> R.Khoo@scantech.com.au
            </p>
        </div>
        <div class="receipt-details">
            <table>
                <tr>
                    <th>Receipt Date</th>
                    <td>Tuesday, August 27, 2024</td>
                </tr>
                <tr>
                    <th>Receipt Number</th>
                    <td>R-02501</td>
                </tr>
                <tr>
                    <td colspan="2" class="highlight">INDONESIA MINER CONFERENCE 2025</td>
                </tr>
            </table>
        </div>
    </div>

    <table class="receipt-table">
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
                </td>
                <td>STANDARD PLUS</td>
                <td>5,000</td>
                <td>5,000</td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <p><strong>Total Paid (USD):</strong> 5,000</p>
        <p><strong>Total Paid (IDR):</strong> 78,945,000</p>
    </div>

    <div class="paid-stamp">PAID</div>

    <div class="footer">
        <div class="signature">
            <div class="line"></div>
            Shofwatunnikmah
        </div>
    </div>

</body>

</html>
