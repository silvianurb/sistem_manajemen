<?php
require_once '../../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf();

session_start();
require_once('../../config/config.php');

// Mendapatkan bulan yang dipilih
$month = isset($_GET['month']) ? $_GET['month'] : date('m');

// Query untuk mendapatkan data berdasarkan bulan yang dipilih
$query = "SELECT idInvoice, tanggal_invoice, nama_barang, nama_pelanggan, total_bayar
          FROM invoice WHERE MONTH(tanggal_invoice) = '$month'";

$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo 'no_data';  // Jika tidak ada data, kirimkan 'no_data'
    exit;
}

$totalBayar = 0;  // Variabel untuk menyimpan total pembayaran

$html = "
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 0.7; }
        h1 { text-align: center; font-size: 24px; font-weight: bold; }
        h2 { text-align: center; font-size: 20px; margin-top: 5px; }
        h3 { text-align: center; font-size: 18px; margin-top: 5px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { padding: 8px; border: 1px solid #ddd; text-align: center; }
        .table th { background-color: rgb(32, 52, 154); color: white; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; }
        .total { text-align: right; font-weight: bold; font-size: 18px; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>CV Karna Kalani Gemilang</h1>
    <h3>Laporan Invoice Bulan " . date("F", mktime(0, 0, 0, $month, 10)) . "</h3>
    <h3>Tahun " . date('Y') . "</h3>
    
    <table class='table'>
        <thead>
            <tr>
                <th>ID Invoice</th>
                <th>Tanggal Invoice</th>
                <th>Nama Barang</th>
                <th>Nama Pelanggan</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>";

while ($row = mysqli_fetch_assoc($result)) {
    // Menambahkan nilai total_bayar untuk dihitung totalnya
    $totalBayar += $row['total_bayar'];

    $html .= "
    <tr>
        <td>" . $row['idInvoice'] . "</td>
        <td>" . $row['tanggal_invoice'] . "</td>
        <td>" . $row['nama_barang'] . "</td>
        <td>" . $row['nama_pelanggan'] . "</td>
        <td>Rp " . number_format($row['total_bayar'], 0, ',', '.') . "</td>
    </tr>";
}

$html .= "
        </tbody>
    </table>

    <!-- Total Pembayaran di sebelah kanan -->
    <div class='total'>
        <p>Total Pembayaran: Rp " . number_format($totalBayar, 0, ',', '.') . "</p>
    </div>

    <div class='footer'>
        <p>Generated on " . date('d F Y') . "</p>
    </div>
</body>
</html>
";

// Load HTML ke Dompdf
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');

// Rendering PDF
$dompdf->render();

// Tentukan path untuk menyimpan PDF
$pdfOutput = $dompdf->output();
$filePath = '../../assets/uploads/laporan_invoice_bulan_' . date("F", mktime(0, 0, 0, $month, 10)) . '.pdf';
file_put_contents($filePath, $pdfOutput);

// Mengembalikan path file PDF
echo "http://localhost/manajemen/assets/uploads/laporan_invoice_bulan_" . date("F", mktime(0, 0, 0, $month, 10)) . ".pdf";
?>
