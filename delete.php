<?php
if ( isset($_GET["id"]) ) {
    $id = $_GET["id"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "transaksi_test_masuk";

    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "DELETE FROM t_sales WHERE id=$id";
    $connection->query($sql);
}

header("location: /transaksi_test_masuk/index.php");
exit;
?>