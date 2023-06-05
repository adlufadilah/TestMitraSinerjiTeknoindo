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

    <br>
    <a class="btn btn-primary" href="/transaksi_test_masuk/index.php" role="button">Beranda</a>
    <div>
    <table class="table">
            <thead>
                <tr>
                    <th>ID Detil</th>
                    <th>ID Sales</th>
                    <th>ID Barang</th>
                    <th>Harga Bandrol</th>
                    <th>Jumlah Barang</th>
                    <th>Diskon dalam persen</th>
                    <th>Diskon dalam rupiah</th>
                    <th>Harga setelah diskon</th>
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

                $sql = "SELECT * FROM t_sales_det";
                $result = $connection->query($sql);

                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>$row[det_id]</td>
                        <td>$row[sales_id]</td>
                        <td>$row[barang_id]</td>
                        <td>$row[harga_brandol]</td>
                        <td>$row[qty]</td>
                        <td>$row[diskon_pct]</td>
                        <td>$row[harga_diskon]</td>
                        <td>$row[diskon_nilai]</td>
                        <td>$row[total]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/transaksi_test_masuk/edit.php?id=$row[det_id]'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='/transaksi_test_masuk/delete.php?id=$row[det_id]'>Delete</a>
                        </td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
    </div>
</body>
</html>

