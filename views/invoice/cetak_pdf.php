<?php
require_once '../../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf();

session_start();
require_once('../../config/config.php');

// Ambil ID Invoice dari parameter GET
$idInvoice = $_GET['idInvoice'];

// Query untuk mendapatkan data invoice berdasarkan ID
$query = "SELECT * FROM invoice WHERE idInvoice = '$idInvoice'";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

// Pastikan data ditemukan
if ($row) {
    $dateFormatted = date('d F Y', strtotime($row['tanggal_invoice']));
    $dueDateFormatted = date('d F Y', strtotime('+30 days'));  // Tanggal jatuh tempo (30 hari setelah tanggal invoice)

    $html = "
    <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.2; }
                h1 { text-align: center; font-size: 24px; font-weight: bold; }
                .container { width: 100%; margin: 0 auto; }
                .header { display: flex; justify-content: space-between; }
                .header div { width: 48%; }
                .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                .table th, .table td { padding: 8px; border: 1px solid #ddd; text-align: center;  }
                .table th { background-color:rgb(45, 153, 59); color: white; }
                .total { text-align: right; font-weight: bold; font-size: 16px; margin-top: 20px; }
                .footer { text-align: center; margin-top: 20px; font-size: 12px; }
                .footer p { margin: 5px 0; }
                .invoice-header { display: flex; justify-content: space-between; margin-bottom: 5px;}
                .invoice-header div { width: 48%; }
    
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='invoice-header'>
                    <div>
                        <p><strong>Dari:</strong><br> MICROZIDE MANUFACTURE</p>
                        <p><strong>Kepada:</strong><br> {$row['nama_pelanggan']}</p>
                    </div>
                </div>

                <h1>INVOICE</h1>

                <!-- Invoice Information -->
                <div class='invoice-header'>
                    <div>
                        <p><strong>No Invoice:</strong> {$row['idInvoice']} - {$row['idSuratJalan']}</p>
                        <p><strong>Tanggal:</strong> $dateFormatted</p>
                        <p><strong>Jatuh Tempo:</strong> $dueDateFormatted</p>
                    </div>
                </div>

                <table class='table'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Ukuran</th>
                            <th>Harga Satuan</th>
                            <th>Kuantita</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- S -->
                        <tr>
                            <td>1</td>
                            <td>{$row['nama_barang']}</td>
                            <td>S</td>
                            <td>Rp. " . number_format($row['harga_s'], 0, ',', '.') . "</td>
                            <td>{$row['size_s']}</td>
                            <td>Rp. " . number_format($row['size_s'] * $row['harga_s'], 0, ',', '.') . "</td>
                        </tr>
                        <!-- M -->
                        <tr>
                            <td></td>
                            <td></td>
                            <td>M</td>
                            <td>Rp. " . number_format($row['harga_m'], 0, ',', '.') . "</td>
                            <td>{$row['size_m']}</td>
                            <td>Rp. " . number_format($row['size_m'] * $row['harga_m'], 0, ',', '.') . "</td>
                        </tr>
                        <!-- L -->
                        <tr>
                            <td></td>
                            <td></td>
                            <td>L</td>
                            <td>Rp. " . number_format($row['harga_l'], 0, ',', '.') . "</td>
                            <td>{$row['size_l']}</td>
                            <td>Rp. " . number_format($row['size_l'] * $row['harga_l'], 0, ',', '.') . "</td>
                        </tr>
                        <!-- XL -->
                        <tr>
                            <td></td>
                            <td></td>
                            <td>XL</td>
                            <td>Rp. " . number_format($row['harga_xl'], 0, ',', '.') . "</td>
                            <td>{$row['size_xl']}</td>
                            <td>Rp. " . number_format($row['size_xl'] * $row['harga_xl'], 0, ',', '.') . "</td>
                        </tr>
                        <!-- XXL -->
                        <tr>
                            <td></td>
                            <td></td>
                            <td>XXL</td>
                            <td>Rp. " . number_format($row['harga_xxl'], 0, ',', '.') . "</td>
                            <td>{$row['size_xxl']}</td>
                            <td>Rp. " . number_format($row['size_xxl'] * $row['harga_xxl'], 0, ',', '.') . "</td>
                        </tr>
                    </tbody>
                </table>

                <div class='total'>
                    <p><strong>Total Pembayaran: Rp. " . number_format($row['total_bayar'], 0, ',', '.') . "</strong></p>
                </div>

                <div class='footer'>
                    <p>A/C BCA 3460696398 HERU KHOERUMAN FARID</p>
                    <p>Thank you for your business!</p>
                    <p>Komp Angkasa Mekar No 46, Bandung, Jawa Barat, 0812-2046-3393</p>
                </div>
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
    $filePath = '../../assets/uploads/invoice_' . $row['idInvoice'] . '.pdf';
    file_put_contents($filePath, $dompdf->output());

    // Kirimkan URL file PDF yang dihasilkan ke browser
    echo "http://localhost/manajemen/assets/uploads/invoice_" . $row['idInvoice'] . ".pdf"; // Mengembalikan URL file PDF untuk akses
} else {
    echo "Data invoice tidak ditemukan.";
}
?>
