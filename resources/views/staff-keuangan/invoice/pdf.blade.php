<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        /* 1. Hapus Margin Halaman agar Background Full */
        @page {
            margin: 0px; 
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.3;
            margin: 0px; /* Hapus margin body default */
        }

        /* 2. Setting Background Image Full Page */
        .background-template {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            z-index: -1000; /* Taruh di paling belakang */
        }

        /* 3. Container Utama untuk Konten (Agar teks tidak nabrak background) */
        .content-container {
            /* Sesuaikan margin ini dengan area kosong di gambar background Anda */
            margin-top: 40px;    /* Jarak dari atas */
            margin-left: 50px;   /* Jarak dari kiri */
            margin-right: 50px;  /* Jarak dari kanan */
            margin-bottom: 120px; /* Jarak dari bawah (untuk menghindari grafis footer oranye) */
        }

        /* --- Styling Konten Invoice --- */

        /* Kop Surat (Header Text) */
        .header-table { width: 100%; margin-bottom: 5px; }
        .logo { width: 80px; }
        .company-name { font-size: 18px; font-weight: bold; color: #E85D04; text-transform: uppercase; }
        .company-sub { font-size: 14px; font-weight: bold; color: #E85D04; }
        .address { font-size: 10px; margin-top: 5px; color: #555; }

        /* Garis Pemisah Kop (Opsional, karena background sudah ada grafis, mungkin ini bisa ditipiskan atau dihapus) */
        .header-line {
            border-bottom: 2px solid #E85D04;
            margin-bottom: 15px;
        }

        /* Info Tanggal & Nomor */
        .date-right { text-align: right; margin-bottom: 15px; font-weight: bold; }
        
        /* Tabel Utama Invoice */
        .invoice-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; margin-top: 10px; }
        .invoice-table th { 
            border: 1px solid #000; 
            padding: 8px; 
            background-color: #ffe6d5; /* Warna agak oranye muda biar senada */
            text-align: center; 
            font-weight: bold; 
        }
        .invoice-table td { 
            border-left: 1px solid #000; 
            border-right: 1px solid #000; 
            padding: 5px 10px; 
            vertical-align: top; 
        }
        .invoice-table tr:last-child td { border-bottom: 1px solid #000; }

        /* Styling Item Hierarki */
        .type-header { font-weight: bold; }
        .type-subheader { padding-left: 20px; }
        .type-item { padding-left: 40px; }
        
        /* Total & Terbilang */
        .total-row td { border: 1px solid #000; font-weight: bold; background-color: #f9f9f9; }
        .terbilang { 
            font-style: italic; 
            margin-bottom: 15px; 
            font-weight: bold; 
            background-color: #eee; 
            padding: 5px; 
            border-radius: 4px;
        }
        
        /* Info Pembayaran */
        .payment-box { 
            border: 1px solid #ccc; 
            padding: 10px; 
            width: 60%; 
            margin-bottom: 20px;
            background-color: #fff;
        }

        /* Tanda Tangan */
        .signature { text-align: center; width: 200px; float: right; margin-top: 10px; }
        .signature-name { font-weight: bold; text-decoration: underline; margin-top: 70px; }

        /* Utilities */
        .text-bold { font-weight: bold; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .w-100 { width: 100%; }
        .mb-20 { margin-bottom: 20px; }

    </style>
</head>
<body>

    <img src="{{ public_path('assets/images/template/template_invoice.jpg') }}" class="background-template" alt="Background">

    <div class="content-container">

        <table class="header-table">
            <tr>
                <td width="15%">
                    <img src="{{ public_path('assets/logo/logo_koperasi.png') }}" class="logo" alt="Logo">
                </td>
                <td width="85%">
                    <div class="company-name">PT. ANGKASA JAYA SERVIS</div>
                    <div class="company-sub">Airport Service</div>
                    <div class="address">
                        Jalan Poros Bontang-Samarinda, Kel Sungai Siring Samarinda Utara<br>
                        Bandar Udara Aji Pangeran Tumenggung Pranoto Samarinda, Kalimantan Timur<br>
                        Telp: (0541) 2831593 | Email: ops@angkasajayaservis.co.id
                    </div>
                </td>
            </tr>
        </table>
        
        <div class="header-line"></div>

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
                <td>Tagihan {{ $invoice->type }}</td>
            </tr>
        </table>

        <div style="margin-bottom: 15px;">
            Kepada Yth.<br>
            <strong style="font-size: 14px;">{{ $invoice->partner_name }}</strong><br>
            Di Tempat
        </div>

        <div style="margin-bottom: 10px; text-align: justify;">
            Dengan Hormat,<br>
            Sehubungan dengan adanya kegiatan {{ $invoice->activity }}, bersama ini kami mengirimkan invoice tagihan 
            <strong>{{ $invoice->type }}</strong>. Mohon pembayaran dilakukan selambat-lambatnya 5 (lima) hari setelah tagihan diterima.
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
            Terbilang:  {{ terbilang($invoice->total_amount) }} Rupiah 
        </div>

        <p style="margin-bottom: 5px;">Pembayaran dapat ditransfer ke:</p>
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
            <br><br><br><br> <div class="signature-name">Risna Amalia</div>
            <div>Account Receivable</div>
        </div>

    </div> </body>
</html>