<?php
require_once '../../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf();

session_start();
require_once('../../config/config.php');

$month = isset($_GET['month']) ? $_GET['month'] : date('m');

// Query untuk mendapatkan tanggal pertama dan terakhir berdasarkan bulan yang dipilih
$queryTanggal = "SELECT MIN(tanggal_invoice) AS tanggal_awal, MAX(tanggal_invoice) AS tanggal_akhir
                 FROM invoice WHERE MONTH(tanggal_invoice) = '$month'";

$resultTanggal = mysqli_query($conn, $queryTanggal);
$rowTanggal = mysqli_fetch_assoc($resultTanggal);

// Pastikan data tanggal ditemukan
if ($rowTanggal) {
    $tanggal_awal = $rowTanggal['tanggal_awal'];
    $tanggal_akhir = $rowTanggal['tanggal_akhir'];
} else {
    echo 'no_data';
    exit;
}

$query = "SELECT idInvoice, tanggal_invoice, nama_barang, nama_pelanggan, total_bayar
          FROM invoice WHERE MONTH(tanggal_invoice) = '$month'";

$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo 'no_data';
    exit;
}

$totalBayar = 0;

$html = "
<html>
<head>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #4a4a4a;
            font-size: 12px;
        }
        .header-text {
            flex-grow: 1;
        }
        .header-text h1 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }
        .header-text h2 {
            font-size: 16px;
            font-weight: 600;
            margin: 5px 0;
        }
        .header-text p {
            font-size: 11px;
            margin: 0;
            color: #6b7280;
        }
        .divider {
            border-bottom: 2px double #4a4a4a;
            margin: 15px 0 20px 0;
        }
        .document-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: underline;
            margin-bottom: 10px;
        }
        .date-range {
            font-size: 12px;
            text-align: left;
            margin-left: 10px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 6px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #20349a;
            color: white;
        }
        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 15px;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #888;
        }
    </style>
</head>
<body>
        <div class='header'>
            <div class='header-text'>
                <h1>CV KARYA KALANI GEMILANG</h1>
                <h2>Ahli Produksi Pakaian</h2>
                <p>Komp. Angkasa Mekar, Jl. Cisirung No.110 kav 109 Cangkung Kulon<br>
                Kota Bandung, Jawa Barat, 40239</p>
            </div>
        </div>
        <div class='divider'></div>

        <div class='document-title'>Laporan Invoice Bulan " . date("F", mktime(0, 0, 0, $month, 10)) . " Tahun " . date('Y') . "</div>
        <br>
        <div class='date-range'>Laporan yang dicetak di bulan ini mencakup tanggal " . date("d F Y", strtotime($tanggal_awal)) . " hingga " . date("d F Y", strtotime($tanggal_akhir)) . "</div>

        <table>
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

        <div class='total'>Total Pembayaran: Rp " . number_format($totalBayar, 0, ',', '.') . "</div>

        <div class='footer'>Generated on " . date('d F Y') . "</div>
    
</body>
</html>
";

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$pdfOutput = $dompdf->output();
$filePath = '../../assets/uploads/laporan_invoice_bulan_' . date("F", mktime(0, 0, 0, $month, 10)) . '.pdf';
file_put_contents($filePath, $pdfOutput);

echo "http://localhost/manajemen/assets/uploads/laporan_invoice_bulan_" . date("F", mktime(0, 0, 0, $month, 10)) . ".pdf";
?>