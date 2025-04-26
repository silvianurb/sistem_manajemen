<?php
require_once '../../vendor/autoload.php'; // Sesuaikan dengan lokasi Dompdf

use Dompdf\Dompdf;
use Dompdf\Options;

// Membuat instance Dompdf
$dompdf = new Dompdf();

if (isset($_GET['id'])) {
    $id_suratjalan = $_GET['id'];

    // Ambil data Surat Jalan dari database
    require_once('../../config/config.php');
    $query = "SELECT * FROM suratjalan WHERE idsuratjalan = '$id_suratjalan'"; 
    $result = mysqli_query($conn, $query);

    if ($data = mysqli_fetch_assoc($result)) {
        // Ambil nama pelanggan berdasarkan id pelanggan
        $nama_pelanggan = $data['nama_pelanggan']; // Ambil nama pelanggan dari data surat jalan
        $alamat_pelanggan = $data['alamat_pelanggan']; // Menambahkan alamat tujuan

        // Hitung Total berdasarkan size S, M, L, XL, XXL
        $total = $data['size_s_kirim'] + $data['size_m_kirim'] + $data['size_l_kirim'] + $data['size_xl_kirim'] + $data['size_xxl_kirim'];

        // Generate HTML untuk PDF dengan layout baru
        $html = "
        <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.4; } /* Mengurangi line height untuk rapat */
                    h1 { text-align: center; font-size: 24px; font-weight: bold; }
                    .container { width: 100%; margin: 0 auto; }
                    .header { display: flex; justify-content: space-between; }
                    .header div { width: 48%; } /* Menyebar 'From' dan 'To' */
                    .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    .table th, .table td { border: 1px solid #000; padding: 8px; text-align: center; }
                    .table th { background-color: #3c8dbc; color: white; }
                    .footer { text-align: right; margin-top: 30px; }
                    .signature { width: 150px; height: 80px; }
                    p { margin: 0; padding: 0; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <div>
                            <p><strong>From:</strong><br> MICROZIDE MANUFACTURE</p>
                        </div>
                        <div>
                            <p><strong>To:</strong><br> $nama_pelanggan</p> <!-- Nama Pelanggan yang diambil dari database -->
                        </div>
                    </div>

                    <h1>SURAT JALAN BARANG</h1>

                    <div class='header'>
                        <div>
                            <p><strong>No. Ref. :</strong> " . $data['idsuratjalan'] . "</p>
                        </div>
                        <div>
                            <p><strong>Date :</strong> " . date('d F Y') . "</p>
                        </div>
                    </div>

                    <p><strong>Alamat Tujuan:</strong> $alamat_pelanggan</p> <!-- Menampilkan alamat tujuan -->

                    <table class='table'>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>BARANG</th>
                                <th>S</th>
                                <th>M</th>
                                <th>L</th>
                                <th>XL</th>
                                <th>XXL</th>
                                <th>Total</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>" . $data['nama_barang'] . "</td>
                                <td>" . $data['size_s_kirim'] . "</td>
                                <td>" . $data['size_m_kirim'] . "</td>
                                <td>" . $data['size_l_kirim'] . "</td>
                                <td>" . $data['size_xl_kirim'] . "</td>
                                <td>" . $data['size_xxl_kirim'] . "</td>
                                <td>$total</td> <!-- Total dari ukuran S, M, L, XL, XXL -->
                                <td>PCS</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class='footer'>
                        <p>Hormat Kami,</p>
                        <p>Koordinator Produksi</p>
                    </div>
                </div>
            </body>
        </html>
        ";

        // Load HTML ke Dompdf
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A5', 'landscape'); // Mengatur kertas A4 Landscape

        // Render PDF
        $dompdf->render();

        // Tentukan path untuk menyimpan PDF
        $filePath = '../../assets/uploads/surat_jalan_' . $data['idsuratjalan'] . '.pdf';
        file_put_contents($filePath, $dompdf->output());

        // Kirimkan URL file PDF yang dihasilkan ke browser
        echo "http://localhost/manajemen/assets/uploads/surat_jalan_" . $data['idsuratjalan'] . ".pdf"; // Mengembalikan URL file PDF untuk akses
    } else {
        echo "Data Surat Jalan tidak ditemukan.";
    }
} else {
    echo "ID Surat Jalan tidak ditemukan.";
}
?>
