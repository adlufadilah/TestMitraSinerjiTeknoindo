<?php
$id = "";
$kode = "";
$tgl = "";
$cust_id = "";
$jumlah_barang = "";
$subtotal = "";
$diskon = "";
$ongkir = "";
$total_bayar = "";

$servername = "localhost";
$username = "root";
$password = "";
$database = "transaksi_test_masuk";

$connection = new mysqli($servername, $username, $password, $database);

$errorMessage = "";
$successMessage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
    // get method: menampilkan data
    if ( !isset($_GET["id"]) ) {
        header("location: /transaksi_test_masuk/index.php");
        exit;
    }

    $id = $_GET["id"];

    $sql = "SELECT * FROM t_sales WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /transaksi_test_masuk/index.php");
        exit;
    }

    $id = $row["id"];
    $kode = $row["kode"];
    $tgl = $row["tgl"];
    $cust_id = $row["cust_id"];
    $jumlah_barang = $row["jumlah_barang"];
    $subtotal = $row["subtotal"];
    $diskon = $row["diskon"];
    $ongkir = $row["ongkir"];
    $total_bayar = $row["total_bayar"];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // post method: mengupdate data
    $id = $_POST["id"];
    $kode = $_POST["kode"];
    $tgl = $_POST["tgl"];
    $cust_id = $_POST["cust_id"];
    $jumlah_barang = $_POST["jumlah_barang"];
    $subtotal = $_POST["subtotal"];
    $diskon = $_POST["diskon"];
    $ongkir = $_POST["ongkir"];
    $total_bayar = $_POST["total_bayar"];

    do {
        if ( empty($id) || empty($kode) || empty($tgl) || empty($cust_id) || empty($jumlah_barang) || empty($subtotal) || empty($diskon) || empty($ongkir) || empty($total_bayar)) {
            $errorMessage = "Tidak boleh ada bagian yang kosong!";
            break;
        }

        $sql = "UPDATE t_sales " .
               "SET kode = '$kode', tgl = '$tgl', cust_id = '$cust_id', jumlah_barang = '$jumlah_barang', subtotal = '$subtotal', diskon = '$diskon', ongkir = '$ongkir', total_bayar = '$total_bayar'" .
               "WHERE id = $id";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Query error: " . $connection->error;
            break;
        }

        $successMessage = "Data Transaksi berhasil diubah.";

        header("location: /transaksi_test_masuk/index.php");
        exit;
        
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departemen Produksi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Transaksi Baru</h2>
        <p><?php echo $errorMessage; ?></p>
        <form method="post" action="edit.php">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">No Transaksi</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" name="kode" value="<?php echo $kode; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Tanggal</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" name="tgl" value="<?php echo $tgl; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nama Customer</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" name="cust_id" value="<?php echo $cust_id; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Jumlah Barang</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" name="jumlah_barang" value="<?php echo $jumlah_barang; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Sub Total</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" name="subtotal" value="<?php echo $subtotal; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Diskon</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" name="diskon" value="<?php echo $diskon; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Ongkir</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" name="ongkir" value="<?php echo $ongkir; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Total</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" name="total_bayar" value="<?php echo $total_bayar; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Sumbit</button>
                </div>
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/transaksi_test_masuk/index.php" role=button>Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>