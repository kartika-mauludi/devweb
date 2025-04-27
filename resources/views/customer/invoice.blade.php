<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Databaseriset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        .invoice-header p { 
            line-height: 1;
            font-size: 15px; 
        }
        .invoice {
			position: relative;
            padding: 2rem;
			color: #333333;
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		}
        .bd-inv{
            border-top: 6px solid #0135A3;
            border-bottom: 9px solid #0135A3;
        }
        .bd-inv-header{
            border-top: 10px solid #007BFF;
        }
        @media print {
            /* Reset body styles for print */
            body {
                background: #fff !important;
                margin: 0 !important;
                padding: 0 !important;
                justify-content: center;
            }
            /* Main receipt styles for print */
            .invoice {
                box-shadow: none !important;
                margin: 0 !important; 
                page-break-after: avoid;
				width: 210mm;
				height: 290mm;
            } 
            .bd-inv{
            border-top: 8px solid #000;
            border-bottom: 10px solid #000;
            }
            .bd-inv-header{
                border-top: 10px solid #ac242f;
            }
            /* Table styles for print */
            table {
                page-break-inside: avoid;
            }
            
            /* Ensure images print properly */
            img {
                max-width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>
    <main class="container mt-5 invoice" id="invoice">
        <div class="card p-4">
            <h2 class="text-center text-success">Databaseriset.com</h2>
            <h4 class="text-center">Invoice</h4>
            <hr class="text-success">
            <div class="invoice-header mb-3">
                <h5 class="mb-3">Invoice To:</h5>
                <p><strong>Nama:</strong> {{ $name }}</p>
                <p><strong>Email:</strong> {{ $email}}</p>
                <p><strong>Invoice ID:</strong> {{ $invoice_id }}</p> 
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th><h5>Deskripsi</h5></th>
                        <th><h5>Detail</h5></th>
                    </tr>
                <tbody>
                    <tr>
                        <td>Paket</td> 
                        <td>{{ $paket }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Mulai</td>
                        <td>@if($start_date != null){{ \Carbon\Carbon::parse($start_date)->format("d F Y") }}@else ---------  @endif</td>
                    </tr>
                    <tr>
                        <td>Tanggal Berakhir</td>
                        <td>@if($end_date != null) {{ \Carbon\Carbon::parse($end_date)->format("d F Y") }}@else --------- @endif</td>
                    </tr>
                    <tr>
                        <td>Metode Pembayaran</td>
                        <td>QRIS [ ALL PAYMENT ]</td>
                    </tr>
                    <tr>
                        <td>Total Harga</td>
                        <td>Rp. {{ number_format($price , 0, ",", ".") }}</td>
                    </tr>
                    <tr>
                        <td>Status Pembayaran:</td>
                        <td>{{ $status }}</td>
                    </tr>
                 
                </tbody>
            </table>
            <hr class="text-success">
            <p class="text-center">Terima kasih telah berlangganan di Databaseriset.com</p>
            <p class="text-center">Jika Anda memiliki pertanyaan, hubungi kami melalui WhatsApp di <a href="https://wa.me/6285236868125">+62 852-3686-8125</a></p>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const element = document.querySelector('.invoice');

            html2pdf(element, {
                margin: 10,
                filename: '{{ $invoice_id }}',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            }).then(() => {
                setTimeout(() => {
                    window.close(); // Tutup halaman setelah cetak
                }, 1000);
            });
        });
    </script>
</body>
</html>
