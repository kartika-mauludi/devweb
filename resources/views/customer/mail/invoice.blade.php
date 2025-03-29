ini invoice<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Toolify.id</title>
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
                <p><strong>Nama:</strong> Andre</p>
                <p><strong>Email:</strong> andre@gmail.com</p>
                <p><strong>Invoice ID:</strong> INV-1742651791</p> 
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
                        <td>Paket 1 Bulan</td>
                    </tr>
                    <tr>
                        <td>Tanggal Mulai</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Tanggal Berakhir</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Metode Pembayaran</td>
                        <td>QRIS [ ALL PAYMENT ]</td>
                    </tr>
                    <tr>
                        <td>Total Harga</td>
                        <td>Rp 50.265</td>
                    </tr>
                    <tr>
                        <td>Status Pembayaran:</td>
                        <td>Pending</td>
                    </tr>
                    <tr>
                        <td>Status Langganan</td>
                        <td>Pending</td>
                    </tr>
                </tbody>
            </table>
            <hr class="text-success">
            <p class="text-center">Terima kasih telah berlangganan di Databaseriset.com</p>
            <p class="text-center">Jika Anda memiliki pertanyaan, hubungi kami melalui WhatsApp di <a href="https://wa.me/6287770507775">+62 877-7050-7775</a></p>
        </div>
    </main>

    <script>
const element = document.querySelector('.invoice');
    const opt = {
        margin: [0, 0, 0, 0],
        filename: 'invoice.pdf',
        image: {
            type: 'jpg',
            quality: 1
        },
        html2canvas: {
            scale: 2,
            bottom: 20
        },
        jsPDF: {
            unit: 'in',
            format: 'a4',
            orientation: 'portrait'
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        html2pdf().set(opt).from(element).save();
    }); 
    </script>
</body>
</html>
