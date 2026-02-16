<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; line-height: 1.4; }
        
        /* Kop Surat */
        .header-table { width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { width: 80px; } /* Sesuaikan ukuran logo */
        .company-name { font-size: 18px; font-weight: bold; color: #E85D04; text-transform: uppercase; }
        .company-sub { font-size: 14px; font-weight: bold; color: #E85D04; }
        .address { font-size: 10px; margin-top: 5px; }
        
        /* Info Invoice */
        .info-table { width: 100%; margin-bottom: 20px; }
        .date-right { text-align: right; margin-bottom: 10px; }
        
        /* Tabel Tagihan */
        .invoice-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .invoice-table th { border: 1px solid #000; padding: 8px; background-color: #f0f0f0; text-align: center; font-weight: bold; }
        .invoice-table td { border-left: 1px solid #000; border-right: 1px solid #000; padding: 5px 10px; vertical-align: top; }
        .invoice-table tr:last-child td { border-bottom: 1px solid #000; }
        
        /* Styling Item (Nesting) */
        .type-header { font-weight: bold; }
        .type-subheader { padding-left: 20px; }
        .type-item { padding-left: 40px; }
        
        /* Total & Terbilang */
        .total-row td { border: 1px solid #000; font-weight: bold; }
        .terbilang { font-style: italic; margin-bottom: 20px; font-weight: bold; }
        
        /* Footer / Pembayaran */
        .payment-box { border: 1px solid #000; padding: 10px; width: 60%; margin-bottom: 30px; }
        .signature { text-align: center; width: 200px; float: right; margin-top: 20px; }
        .signature-name { font-weight: bold; text-decoration: underline; margin-top: 70px; }
        
        /* Helper Utilities */
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .text-bold { font-weight: bold; }
        .no-border { border: none !important; }
        .w-100 { width: 100%; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="15%"><img src="{{ public_path('assets/logo/logo_koperasi.png') }}" class="logo" alt="Logo"></td>
            <td width="85%">
                <div class="company-name">PT. ANGKASA JAYA SERVIS</div>
                <div class="company-sub">Airport Service</div>
                <div class="address">
                    Jalan Poros Bontang-Samarinda, Kel Sungai Siring Samarinda Utara, Kalimantan Timur<br>
                    Bandar Udara Aji Pangeran Tumenggung Pranoto Samarinda<br>
                    Telp: (0541) 2831593 | Email: ops@angkasajayaservis.co.id
                </div>
            </td>
        </tr>
    </table>

    <div class="date-right">
        Samarinda, {{ \Carbon\Carbon::parse($invoice->date)->locale('id')->isoFormat('D MMMM Y') }}
    </div>

    <table class="w-100 mb-20">
        <tr>
            <td width="15%">No. Invoice</td>
            <td width="2%">:</td>
            <td width="83%" class="text-bold">{{ $invoice->invoice_number }}</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td>Tagihan {{ $invoice->type }}</td> </tr>
    </table>

    <div style="margin-bottom: 15px;">
        Kepada Yth.<br>
        <strong>{{ $invoice->partner_name }}</strong><br>
        Di Tempat
    </div>

    <div style="margin-bottom: 15px; text-align: justify;">
        Dengan Hormat,<br>
        Sehubungan dengan adanya kegiatan {{ $invoice->activity }}, 
        bersama ini kami mengirimkan invoice tagihan <strong>{{ $invoice->type }}</strong> dengan nomor invoice {{ $invoice->invoice_number }}.
        <br><br>
        Kami berharap agar Bapak/Ibu segera melakukan pembayaran selambat-lambatnya 5 (lima) hari setelah surat tagihan ini diterima.
        Berikut kami sampaikan rincian tagihan dimaksud :
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="65%">Uraian</th>
                <th width="30%">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $index => $item)
            <tr>
                <td class="text-center">
                    {{-- Hanya tampilkan nomor jika tipe Header --}}
                    {{ $item->item_type == 'header' ? $loop->iteration . '.' : '' }}
                </td>
                <td class="
                    @if($item->item_type == 'header') type-header @endif
                    @if($item->item_type == 'subheader') type-subheader @endif
                    @if($item->item_type == 'item') type-item @endif
                ">
                    {{ $item->description }}
                </td>
                <td class="text-end">
                    @if($item->amount > 0)
                        Rp. {{ number_format($item->amount, 0, ',', '.') }},-
                    @endif
                </td>
            </tr>
            @endforeach
            
            <tr class="total-row">
                <td colspan="2" class="text-center">TOTAL</td>
                <td class="text-end">Rp. {{ number_format($invoice->total_amount, 0, ',', '.') }},-</td>
            </tr>
        </tbody>
    </table>

    <div class="terbilang">
        Terbilang: {{ terbilang($invoice->total_amount) }} Rupiah
    </div>

    <p>Pembayaran dapat ditransfer ke:</p>
    <div class="payment-box">
        <table width="100%">
            <tr>
                <td width="30%"><strong>BANK</strong></td>
                <td>: BANK TABUNGAN NEGARA (BTN)</td>
            </tr>
            <tr>
                <td><strong>NO. REKENING</strong></td>
                <td>: 200-188-000-1341</td>
            </tr>
            <tr>
                <td><strong>A.N</strong></td>
                <td>: PT ANGKASA JAYA SERVIS</td>
            </tr>
        </table>
    </div>

    <div class="signature">
        Hormat kami,<br>
        PT. Angkasa Jaya Servis
        <div class="signature-name">Risna Amalia</div> <div>Account Receivable</div>
    </div>

</body>
</html>