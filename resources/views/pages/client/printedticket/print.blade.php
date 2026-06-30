<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Tiket - {{ $antrian->nomor_antrian }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
            width: 100%;
        }
        .ticket {
            padding: 8px 10px;
            text-align: center;
        }
        .header {
            border-bottom: 2px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header p {
            font-size: 10px;
            margin-top: 4px;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        .queue-number {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 3px;
            padding: 10px 0;
            border: 2px dashed #000;
            margin: 8px 0;
        }
        .info {
            font-size: 11px;
            text-align: left;
            padding: 4px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
        }
        .info-row .label {
            font-weight: bold;
        }
        .footer {
            border-top: 2px dashed #000;
            padding-top: 8px;
            margin-top: 8px;
            font-size: 9px;
        }
        .footer p {
            margin: 2px 0;
        }
        .highlight {
            background: #000;
            color: #fff;
            padding: 2px 6px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <!-- Header -->
        <div class="header">
            <h1>{{ $company->company_name ?? 'Antrians' }}</h1>
            <p>{{ $company->address ?? 'Sistem Antrian Online' }}</p>
        </div>

        <!-- Layanan -->
        <p style="font-size: 13px; font-weight: bold; text-transform: uppercase;">
            {{ $layanan->nama_layanan }}
        </p>

        <div class="divider"></div>

        <!-- Nomor Antrian -->
        <p style="font-size: 10px; margin-bottom: 2px;">NOMOR ANTRIAN</p>
        <div class="queue-number">
            {{ $antrian->nomor_antrian }}

            <p style="font-size: 13px; font-weight: bold; text-transform: uppercase;">
                {{ $loket->nama_loket }} ({{ $loket->kode_loket }})
            </p>
           
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Mohon ambil nomor antrian baru jika nomor antrian anda terlewat </strong></p>
            <p>"Terima kasih atas kunjungan anda"</p>
            <p style="margin-top: 4px; font-size: 8px;">{{ $antrian->waktu_ambil->format('d F Y') }} / {{ $antrian->waktu_ambil->format('H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
