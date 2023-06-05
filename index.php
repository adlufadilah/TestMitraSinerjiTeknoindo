<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departemen Produksi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Daftar Transaksi</h2>
        <a class="btn btn-primary" href="/transaksi_test_masuk/create.php" role="button">Tambah Transaksi Baru</a>
        <a class="btn btn-primary" href="/transaksi_test_masuk/detil.php" role="button">Detil Transaksi</a>

        <br>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Transaksi</th>
                    <th>Tanggal</th>
                    <th>Nama Customer</th>
                    <th>Jumlah Barang</th>
                    <th>Sub Total</th>
                    <th>Diskon</th>
                    <th>Ongkir</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "transaksi_test_masuk";

                $connection = new mysqli($servername, $username, $password, $database);

                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->$connect_error);
                }

                $sql = "SELECT ts.*, mc.name FROM t_sales ts JOIN m_customer mc ON (ts.cust_id = mc.id)";
                $result = $connection->query($sql);

                $i = 1;

                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>$i</td>
                        <td>$row[kode]</td>
                        <td>$row[tgl]</td>
                        <td>$row[name]</td>
                        <td>$row[jumlah_barang]</td>
                        <td>$row[subtotal]</td>
                        <td>$row[diskon]</td>
                        <td>$row[ongkir]</td>
                        <td>$row[total_bayar]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/transaksi_test_masuk/edit.php?id=$row[id]'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='/transaksi_test_masuk/delete.php?id=$row[id]'>Delete</a>
                        </td>
                    </tr>
                    ";
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>