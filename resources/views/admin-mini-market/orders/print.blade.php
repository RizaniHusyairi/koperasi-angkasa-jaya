<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->code }} - Koperasi Angkasa Jaya</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #eee;
            padding: 30px;
            background-color: #fff;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .bg-logo {
            max-height: 60px;
            margin-bottom: 10px;
        }
        .company-info h2 {
            margin: 0;
            color: #2c3e50;
        }
        .company-info p {
            margin: 5px 0;
            color: #7f8c8d;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-details h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 24px;
            text-transform: uppercase;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        .billing-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .billing-to, .shipping-to {
            width: 48%;
        }
        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            color: #7f8c8d;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 15px;
            font-size: 12px;
        }
        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .info-table td:first-child {
            padding-right: 15px;
            color: #7f8c8d;
            width: 80px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #f8f9fa;
            color: #2c3e50;
            font-weight: bold;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            color: #555;
        }
        .items-table th:last-child, .items-table td:last-child {
            text-align: right;
        }
        .totals-section {
            display: flex;
            justify-content: flex-end;
        }
        .totals-table {
            width: 300px;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .totals-table td:last-child {
            text-align: right;
            font-weight: bold;
        }
        .grand-total {
            font-size: 18px;
            color: #2c3e50;
            border-bottom: none !important;
            padding-top: 15px !important;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #95a5a6;
            font-size: 12px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        @media print {
            body {
                background-color: #fff;
                padding: 0;
            }
            .invoice-container {
                border: none;
                padding: 0;
                width: 100%;
                max-width: 100%;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="company-info">
                <img src="{{ asset('assets/logo/logo_koperasi.png') }}" alt="Koperasi Logo" class="bg-logo">
                <h2>Koperasi Angkasa Jaya</h2>
                <p>Jalan Raya Angkasa No. 123, Jakarta</p>
                <p>Email: koperasi@angkasajaya.com | Telepon: (021) 1234-5678</p>
            </div>
            <div class="invoice-details">
                <h1>Invoice</h1>
                <p>No: #{{ $order->code }}</p>
                <p>Tanggal: {{ $order->created_at->format('d/m/Y') }}</p>
                <p>Status: <span style="font-weight: bold; text-transform: uppercase;">{{ $order->status }}</span></p>
            </div>
        </div>

        <div class="billing-info">
            <div class="billing-to">
                <div class="section-title">Tagihan Kepada</div>
                <table class="info-table">
                    <tr>
                        <td>Nama</td>
                        <td>{{ $order->user->name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $order->user->email }}</td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td>
                            @if($order->user->anggota && $order->user->anggota->nomor_wa)
                                {{ $order->user->anggota->nomor_wa }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="shipping-to">
                <div class="section-title">Info Pembayaran</div>
                <table class="info-table">
                    <tr>
                        <td>Metode</td>
                        <td>{{ $order->payment_method }}</td>
                    </tr>
                    <tr>
                        <td>Waktu</td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 50%;">Deskripsi Barang</th>
                    <th style="width: 15%;">Jumlah</th>
                    <th style="width: 15%;">Harga Satuan</th>
                    <th style="width: 15%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div style="font-weight: bold;">{{ $item->product->name }}</div>
                        <div style="font-size: 12px; color: #7f8c8d;">{{ $item->product->category }}</div>
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td>Subtotal</td>
                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="grand-total">Total</td>
                    <td class="grand-total">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Terima kasih telah berbelanja di Koperasi Angkasa Jaya!</p>
            <p>Faktur ini dibuat secara otomatis oleh komputer dan sah tanpa tanda tangan.</p>
        </div>
    </div>
</body>
</html>
