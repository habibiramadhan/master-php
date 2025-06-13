{{-- resources/views/public/receipt-pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt - {{ $pesanan->kode_pesanan }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
        }
        
        .receipt {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .company-info {
            font-size: 10px;
            margin-bottom: 2px;
        }
        
        .receipt-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 8px;
        }
        
        .section {
            margin-bottom: 15px;
        }
        
        .section-title {
            font-size: 11px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin-bottom: 5px;
        }
        
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 10px;
        }
        
        .row.main {
            font-size: 11px;
            font-weight: bold;
        }
        
        .row.total {
            font-size: 12px;
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        
        .center {
            text-align: center;
        }
        
        .dashed {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }
        
        .footer {
            text-align: center;
            font-size: 9px;
            margin-top: 15px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }
        
        .status-box {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            margin: 10px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <div class="company-name">{{ strtoupper($pengaturan['nama_perusahaan'] ?? 'CV SEWA ALAT BERAT') }}</div>
            <div class="company-info">{{ $pengaturan['alamat_perusahaan'] ?? 'Jakarta, Indonesia' }}</div>
            <div class="company-info">Telp: {{ $pengaturan['telepon_perusahaan'] ?? '021-123456789' }}</div>
            <div class="receipt-title">RECEIPT SEWA ALAT</div>
        </div>

        <!-- Receipt Info -->
        <div class="section">
            <div class="row main">
                <span>No. Receipt:</span>
                <span>{{ $pesanan->kode_pesanan }}</span>
            </div>
            <div class="row">
                <span>Tracking ID:</span>
                <span>{{ $pesanan->kode_tracking }}</span>
            </div>
            <div class="row">
                <span>Tanggal:</span>
                <span>{{ now()->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <div class="dashed"></div>

        <!-- Customer -->
        <div class="section">
            <div class="section-title">CUSTOMER</div>
            <div class="row">
                <span>Nama:</span>
                <span>{{ $pesanan->nama_pelanggan }}</span>
            </div>
            <div class="row">
                <span>Telepon:</span>
                <span>{{ $pesanan->telepon_pelanggan }}</span>
            </div>
        </div>

        <!-- Equipment -->
        <div class="section">
            <div class="section-title">PERALATAN</div>
            <div class="row main">
                <span>{{ $pesanan->peralatan->nama }}</span>
            </div>
            <div class="row">
                <span>Kategori:</span>
                <span>{{ $pesanan->peralatan->kategori }}</span>
            </div>
        </div>

        <!-- Period -->
        <div class="section">
            <div class="section-title">PERIODE SEWA</div>
            <div class="row">
                <span>Mulai:</span>
                <span>{{ $pesanan->tanggal_mulai->format('d/m/Y') }}</span>
            </div>
            <div class="row">
                <span>Selesai:</span>
                <span>{{ $pesanan->tanggal_selesai->format('d/m/Y') }}</span>
            </div>
            <div class="row">
                <span>Jumlah Hari:</span>
                <span>{{ $pesanan->jumlah_hari }} hari</span>
            </div>
        </div>

        <div class="dashed"></div>

        <!-- Payment -->
        <div class="section">
            <div class="section-title">RINCIAN PEMBAYARAN</div>
            <div class="row">
                <span>Harga per Hari:</span>
                <span>Rp {{ number_format($pesanan->harga_per_hari, 0, ',', '.') }}</span>
            </div>
            <div class="row">
                <span>Jumlah Hari:</span>
                <span>{{ $pesanan->jumlah_hari }}</span>
            </div>
            
            <div class="row total">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Status -->
        <div class="status-box">
            STATUS: {{ strtoupper($pesanan->nama_status) }}
            @if($pesanan->status == 'selesai')
                - LUNAS
            @elseif($pesanan->waktu_verifikasi)
                - TERVERIFIKASI
            @endif
        </div>

        @if($pesanan->catatan_admin)
            <div class="section">
                <div class="section-title">CATATAN</div>
                <div style="font-size: 10px;">{{ $pesanan->catatan_admin }}</div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <div>TERIMA KASIH</div>
            <div>{{ $pengaturan['nama_perusahaan'] ?? 'CV SEWA ALAT BERAT' }}</div>
            <div style="margin-top: 5px;">
                Dicetak: {{ now()->format('d/m/Y H:i') }}
            </div>
            <div style="margin-top: 5px;">
                Bantuan: {{ $pengaturan['whatsapp_perusahaan'] ?? '+62812-3456-789' }}
            </div>
        </div>
    </div>
</body>
</html>