<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran #{{ $transaction->id }} - BM Studio</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;700;800&family=Syne:wght@800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            color: #0D0D0D;
            background-color: #F4F1EA;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .receipt-container {
            width: 100%;
            max-width: 380px;
            background-color: #fff;
            border: 3px solid #0D0D0D;
            padding: 25px;
            box-shadow: 5px 5px 0px 0px #0D0D0D;
            position: relative;
        }
        /* Top Ticket Notch Decor */
        .receipt-container::before {
            content: '';
            position: absolute;
            top: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 15px;
            background-color: #F4F1EA;
            border-bottom: 3px solid #0D0D0D;
            border-left: 3px solid #0D0D0D;
            border-right: 3px solid #0D0D0D;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            margin-top: 10px;
        }
        .header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 24px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            background-color: #FFC700;
            border: 2px solid #0D0D0D;
            display: inline-block;
            padding: 4px 12px;
            box-shadow: 2px 2px 0px 0px #0D0D0D;
        }
        .header p {
            font-size: 10px;
            font-weight: 700;
            margin: 10px 0 0 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .divider {
            border-top: 3px dashed #0D0D0D;
            margin: 15px 0;
        }
        .meta-info p {
            margin: 4px 0;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
        }
        .meta-info span {
            font-family: monospace;
            font-weight: 800;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 10px;
        }
        .table th, .table td {
            text-align: left;
            padding: 6px 0;
            font-weight: 700;
            border-bottom: 1.5px solid rgba(13, 13, 13, 0.1);
        }
        .table th {
            font-family: 'Syne', sans-serif;
            text-transform: uppercase;
            border-bottom: 2px solid #0D0D0D;
            padding-bottom: 8px;
        }
        .text-right {
            text-align: right !important;
        }
        .total-section {
            font-weight: 800;
            font-size: 12px;
            margin-top: 15px;
        }
        .total-section td {
            border: none;
            padding: 4px 0;
        }
        .grand-total-row {
            font-family: 'Syne', sans-serif;
            font-size: 16px;
            background-color: #FFC700;
            border: 2px solid #0D0D0D !important;
        }
        .grand-total-row td {
            padding: 8px !important;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            line-height: 1.5;
        }
        .actions-bar {
            width: 100%;
            max-width: 380px;
            margin: 20px auto 0 auto;
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }
        .btn {
            font-family: 'Syne', sans-serif;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.15s;
        }
        .btn-print {
            background-color: #FFC700;
            color: #0D0D0D;
            border: 2.5px solid #0D0D0D;
            box-shadow: 2.5px 2.5px 0px 0px #0D0D0D;
        }
        .btn-print:hover {
            box-shadow: none;
            transform: translate(1px, 1px);
        }
        .btn-back {
            background-color: #fff;
            color: #0D0D0D;
            border: 2.5px solid #0D0D0D;
            box-shadow: 2.5px 2.5px 0px 0px #0D0D0D;
        }
        .btn-back:hover {
            box-shadow: none;
            transform: translate(1px, 1px);
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #fff;
                padding: 0;
            }
            .receipt-container {
                border: none;
                max-width: 100%;
                padding: 0;
                box-shadow: none;
            }
            .receipt-container::before {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        
        <!-- Header -->
        <div class="header">
            <h1>BM STUDIO</h1>
            <p>Sewa Studio Musik & Kopi<br>Jl. Melati No. 45, Bandung<br>Telp: 0812-3456-789</p>
        </div>

        <div class="divider"></div>

        <!-- Meta info -->
        <div class="meta-info">
            <p><strong>No. Transaksi:</strong> <span>POS-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</span></p>
            <p><strong>Tanggal:</strong> <span>{{ $transaction->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</span> WIB</p>
            <p><strong>Kasir:</strong> Admin BM Studio</p>
            @if($transaction->booking)
                <p><strong>Pelanggan:</strong> {{ $transaction->booking->user->name }}</p>
            @endif
        </div>

        <div class="divider"></div>

        <!-- Items Table -->
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 55%;">Item</th>
                    <th style="width: 15%; text-align: center;">Qty</th>
                    <th style="width: 30%;" class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <!-- Studio Booking if exists -->
                @if($transaction->booking)
                    <tr>
                        <td>
                            Sewa {{ $transaction->booking->studio->name }}<br>
                            <span style="font-size: 9px; opacity: 0.8; font-family: monospace;">
                                {{ \Carbon\Carbon::parse($transaction->booking->date)->format('d/m/y') }} 
                                ({{ \Carbon\Carbon::parse($transaction->booking->start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($transaction->booking->end_time)->format('H:i') }})
                            </span>
                            @if($transaction->booking->dp_amount > 0)
                                <br><span style="font-size: 9px; opacity: 0.8; color: #E14D2A;">DP sudah dibayar: -Rp {{ number_format($transaction->booking->dp_amount, 0, ',', '.') }}</span>
                            @endif
                        </td>
                        <td style="text-align: center;">1</td>
                        <td class="text-right">
                            @if($transaction->booking->dp_amount > 0)
                                <span style="text-decoration: line-through; font-size: 10px; opacity: 0.6;">Rp {{ number_format($transaction->booking->total_price, 0, ',', '.') }}</span><br>
                                Rp {{ number_format($transaction->booking->total_price - $transaction->booking->dp_amount, 0, ',', '.') }}
                            @else
                                Rp {{ number_format($transaction->booking->total_price, 0, ',', '.') }}
                            @endif
                        </td>
                    </tr>
                @endif

                <!-- Drinks items if exist -->
                @foreach($transaction->posItems as $item)
                    <tr>
                        <td>{{ $item->inventory->name }}</td>
                        <td style="text-align: center;">{{ $item->qty }}</td>
                        <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <!-- Total calculations -->
        <table class="table total-section">
            @if($transaction->booking)
                <tr>
                    <td colspan="2">Sewa Studio:</td>
                    <td class="text-right">
                        @if($transaction->booking->dp_amount > 0)
                            <span style="font-size: 10px; font-weight: normal; opacity: 0.7;">(Total Rp {{ number_format($transaction->booking->total_price, 0, ',', '.') }})</span> 
                            Rp {{ number_format($transaction->booking->total_price - $transaction->booking->dp_amount, 0, ',', '.') }}
                        @else
                            Rp {{ number_format($transaction->booking->total_price, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
            @endif
            @php
                $drinksSum = $transaction->posItems->sum('subtotal');
            @endphp
            @if($drinksSum > 0)
                <tr>
                    <td colspan="2">Total Minuman:</td>
                    <td class="text-right">Rp {{ number_format($drinksSum, 0, ',', '.') }}</td>
                </tr>
            @endif
            
            <tr class="grand-total-row">
                <td colspan="2" style="border: 2px solid #0D0D0D; border-right: none;">GRAND TOTAL:</td>
                <td class="text-right" style="border: 2px solid #0D0D0D; border-left: none;">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
            </tr>
            
            <tr>
                <td colspan="2" style="font-weight: 500; font-size:10px; padding-top: 12px;">Metode Bayar:</td>
                <td class="text-right" style="font-weight: 800; font-size:10px; padding-top: 12px; font-family: monospace;">{{ strtoupper($transaction->payment_method) }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <!-- Footer -->
        <div class="footer">
            <p>TERIMA KASIH ATAS KUNJUNGAN ANDA<br>Latihan Nyaman, Hasil Maksimal!<br>🤘 ROCK ON! 🤘</p>
        </div>

    </div>

    <!-- Actions (Hides on print) -->
    <div class="actions-bar no-print">
        <button onclick="window.history.back()" class="btn btn-back">Kembali</button>
        <button onclick="window.print()" class="btn btn-print">Cetak Struk</button>
    </div>

    <script>
        // Auto trigger print on page load
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>

</body>
</html>
