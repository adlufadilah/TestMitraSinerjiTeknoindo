<?php
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

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $kode = $_POST["kode"];
    $tgl = $_POST["tgl"];
    $cust_id = $_POST["cust_id"];
    $barang_id = $_POST["barang_id"];
    $jumlah_barang = $_POST["jumlah_barang"];
    $subtotal = $_POST["subtotal"];
    $diskon = $_POST["diskon"];
    $ongkir = $_POST["ongkir"];
    $total_bayar = $_POST["total_bayar"];

    do {
        if ( empty($kode) || empty($tgl) || empty($cust_id) || empty($jumlah_barang) || empty($subtotal) || empty($diskon) || empty($ongkir) || empty($total_bayar)) {
            $errorMessage = "Tidak boleh ada bagian yang kosong!";
            break;
        }

        $sql = "INSERT INTO t_sales (kode, tgl, cust_id, jumlah_barang, subtotal, diskon, ongkir, total_bayar) " .
               "VALUES ('$kode','$tgl','$cust_id','$jumlah_barang','$subtotal','$diskon','$ongkir','$total_bayar')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Query error: " . $connection->error;
            break;
        }

        $sales_id = $connection->insert_id;
        $barang = explode(";",$barang_id);
        $barang_id = $barang[0];
        $harga_brandol = $barang[1];
        $diskon_nilai = $harga_brandol * ($diskon / 100);
        $harga_diskon = $harga_brandol * ((100 - $diskon) / 100);

        $sql2 = "INSERT INTO t_sales_det (sales_id, barang_id, harga_brandol, qty, diskon_pct, diskon_nilai, harga_diskon, total) " .
               "VALUES ('$sales_id','$barang_id','$harga_brandol','$jumlah_barang','$diskon','$diskon_nilai','$harga_diskon','$total_bayar')";
        $result2 = $connection->query($sql2);

        if (!$result2) {
          $errorMessage = "Query error: " . $connection->error;
          break;
        }

        $id = "";
        $kode = "";
        $tgl = "";
        $cust_id = "";
        $jumlah_barang = "";
        $subtotal = "";
        $diskon = "";
        $ongkir = "";
        $total_bayar = "";

        $successMessage = "Transaksi baru berhasil di tambah.";

        header("location: /transaksi_test_masuk/index.php");
        exit;

    } while (false);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $customerQuery = "SELECT id, name FROM m_customer";
  $resultCustomer = $connection->query($customerQuery);

  $barangQuery = "SELECT id, nama, harga FROM m_barang";
  $resultBarang = $connection->query($barangQuery);
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
        <form method="post" action="create.php">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">No Transaksi</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" name="kode" value="<?php echo $kode; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Tanggal</label>
                <div class="cols-sm-6">
                    <input type="date" class="form-control" name="tgl" value="<?php echo $tgl; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">ID Customer</label>
                <select name="cust_id">
                <option value="-">Pilih Customer</option>
                  <?php while($row = $resultCustomer->fetch_assoc()) { ?>
                    <option value=<?php echo $row["id"] ?>><?php echo $row["id"] . " - " . $row["name"] ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Barang</label>
                <select id="barang_id" name="barang_id" onChange="onBarangChange()">
                <option value="-">Pilih Barang</option>
                  <?php while($row = $resultBarang->fetch_assoc()) { ?>
                    <option value=<?php echo $row["id"] . ";" . $row["harga"] ?>><?php echo $row["id"] . " - " . $row["nama"] ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Jumlah Barang</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" id="jumlah_barang" name="jumlah_barang" oninput="onJumlahChange()">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Sub Total</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" id="subtotal" name="subtotal">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Diskon</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" id="diskon" name="diskon" value="<?php echo $diskon; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Ongkir</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" id="ongkir" name="ongkir" oninput="calculateTotal()" value="<?php echo $ongkir; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Total</label>
                <div class="cols-sm-6">
                    <input type="text" class="form-control" id="total_bayar" name="total_bayar" value="<?php echo $total_bayar; ?>">
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
    <script>
      var harga = 0;
      function onBarangChange() {
        const barangValue = document.getElementById("barang_id").value;
        if (barangValue !== "-") harga = barangValue.split(";")[1];
      }

      function onJumlahChange() {
        const qty = document.getElementById("jumlah_barang").value;
        document.getElementById("subtotal").value = harga * qty;
      }

      function calculateTotal() {
        const subTotal = document.getElementById("subtotal").value;
        const diskon = document.getElementById("diskon").value;
        const ongkir = document.getElementById("ongkir").value;
        console.log(subTotal);
        console.log(diskon);
        console.log(ongkir);
        document.getElementById("total_bayar").value = subTotal * ((100 - diskon) / 100) + parseInt(ongkir);
      }
    </script>
</body>
</html>