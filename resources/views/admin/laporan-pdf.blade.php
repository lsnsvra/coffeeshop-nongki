<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan NONGKI</title>
    <style>
        /* Setup Kertas & Font */
        body { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 8pt; color: #222; margin: 0; }
        @page { margin: 12mm 15mm; size: A4 portrait; }

        /* Kotak Summary (Total, Volume, Terlaris) */
        .summary { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .summary td { border: 1px solid #ddd; padding: 8px; text-align: center; width: 33.33%; background: #fafafa; }
        .summary .label { display: block; font-size: 7pt; text-transform: uppercase; color: #777; margin-bottom: 4px; letter-spacing: 1px; }
        .summary .value { font-size: 11pt; font-weight: bold; color: #000; }

        /* Tabel Utama (Anti Terpotong) */
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table.data th { background-color: #f4f4f4; color: #000; font-size: 7pt; text-transform: uppercase; padding: 6px; border-bottom: 1px solid #000; border-top: 1px solid #000; text-align: left; }
        table.data td { padding: 6px; border-bottom: 1px solid #eee; vertical-align: top; }
        
        /* JURUS ANTI HALAMAN TERPOTONG */
        table.data tr { page-break-inside: avoid; } 
        
        /* Helper Class */
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .font-bold { font-weight: bold; color: #000; }
        
        /* Tanda Tangan */
        .footer-ttd { width: 100%; margin-top: 20px; page-break-inside: avoid; }
        .footer-ttd td { vertical-align: top; }
    </style>
</head>
<body>

   <!-- KOP SURAT DENGAN LOGO (PERFECT CENTERED) -->
    <table style="width: 100%; border-bottom: 3px double #000; margin-bottom: 20px; padding-bottom: 10px;">
        <tr>
            <td style="width: 20%; text-align: center; vertical-align: middle;">
                @php
                    $paths = [
                        base_path('storage/app/public/images/logo-nongki.jpg'),
                        storage_path('app/public/images/logo-nongki.png'),
                        public_path('images/logo-nongki.jpg')
                    ];
                    $imageSrc = '';
                    foreach ($paths as $path) {
                        if (file_exists($path)) {
                            $base64 = base64_encode(file_get_contents($path));
                            $imageSrc = 'data:image/jpeg;base64,' . $base64;
                            break;
                        }
                    }
                @endphp
                
                @if($imageSrc)
                    <img src="{{ $imageSrc }}" style="width: 250px; height: auto; margin-left: -20px;">
                @else
                    <span style="font-size: 8px; color: red;">Logo tidak ditemukan!</span>
                @endif
            </td>
            
            <td style="width: 60%; text-align: center; vertical-align: middle;">
                <h1 style="margin: 0; font-size: 18pt; font-weight: 900; letter-spacing: 2px; color: #000; text-transform: uppercase;">NONGKI COFFEE</h1>
                <p style="margin: 4px 0 0; font-size: 9pt; color: #333; letter-spacing: 1px;">Premium Coffee & Exclusive Space</p>
                <p style="margin: 2px 0 0; font-size: 8pt; color: #555;">Industrial Estate Area, Bekasi Regency, West Java</p>
                
                <div style="margin: 8px auto; width: 50%; border-top: 1px solid #ccc;"></div>
                
                <p style="margin: 5px 0 0; font-weight: bold; font-size: 10pt; color: #000;">LAPORAN PENJUALAN PRODUK</p>
                <p style="margin: 2px 0 0; font-size: 8pt; color: #000;">Periode: {{ \Carbon\Carbon::parse($start)->format('d F Y') }} - {{ \Carbon\Carbon::parse($end)->format('d F Y') }}</p>
            </td>

            <td style="width: 20%;"></td>
        </tr>
    </table>

    <!-- SUMMARY CARD -->
    <table class="summary">
        <tr>
            <td>
                <span class="label">Total Pendapatan</span>
                <span class="value">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</span>
            </td>
            <td>
                <span class="label">Volume Pesanan</span>
                <span class="value">{{ $jumlahTransaksi }} Transaksi</span>
            </td>
            <td>
                <span class="label">Produk Terlaris</span>
                <span class="value">{{ $terlaris->NamaKopi ?? '—' }}</span>
            </td>
        </tr>
    </table>

    <!-- TABEL LOG TRANSAKSI -->
    <table class="data">
        <thead>
            <tr>
                <th width="12%">ID Order</th>
                <th width="15%">Waktu</th>
                <th width="20%">Pelanggan</th>
                <th width="35%">Detail Produk</th>
                <th width="18%" class="text-right">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksiTerakhir as $t)
                @php
                    // Mengambil detail produk dari order saat ini
                    $details = \Illuminate\Support\Facades\DB::table('order_details')
                        ->join('products', 'order_details.ProductID', '=', 'products.ProductID')
                        ->where('order_details.OrderID', $t->OrderID)
                        ->get();
                @endphp
                <tr>
                    <td style="color: #555;">#{{ str_pad($t->OrderID, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->TanggalOrder)->format('d/m/y H:i') }}</td>
                    <td>{{ $t->nama_pembeli ?? 'Tamu / Kasir' }}</td>
                    <td>
                        @foreach($details as $d)
                            <div style="margin-bottom: 2px;">• {{ $d->NamaKopi ?? ($d->NamaProduct ?? '—') }} ({{ $d->Qty }}x)</div>
                        @endforeach
                    </td>
                    <td class="text-right font-bold">Rp {{ number_format($t->TotalHarga, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px;">Tidak ada data transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right font-bold" style="border-top: 1px solid #000; padding: 10px 6px;">GRAND TOTAL KESELURUHAN</td>
                <td class="text-right font-bold" style="border-top: 1px solid #000; padding: 10px 6px; font-size: 9pt;">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- FOOTER & TANDA TANGAN -->
    <table class="footer-ttd">
        <tr>
            <td style="font-size: 7pt; color: #777; width: 60%;">
                Dicetak oleh sistem pada: {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIB<br>
                Dokumen ini sah dan digenerate otomatis oleh NONGKI Management.
            </td>
            <td class="text-center" style="width: 40%;">
                <p style="margin-bottom: 50px;">Bekasi, {{ \Carbon\Carbon::now()->format('d F Y') }}<br>Administrator,</p>
                <p class="font-bold">( _______________________ )</p>
                <p style="font-size: 7pt; color: #555;">Admin Sistem</p>
            </td>
        </tr>
    </table>

</body>
</html>