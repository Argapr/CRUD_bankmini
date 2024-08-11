<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank_mini";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    
    $sql = "SELECT nama, no_rekening FROM nasabah WHERE nama LIKE CONCAT('%', ?, '%')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($nama, $no_rekening);
    
    $response = array();
    while ($stmt->fetch()) {
        $response[] = array('nama' => $nama, 'no_rekening' => $no_rekening);
    }
    
    echo json_encode($response);
    $stmt->close();
    $conn->close();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $no_rekening = $_POST['no_rekening'];
    $jumlah = $_POST['jumlah'];
    $tipe = $_POST['tipe'];

    $sql = "SELECT saldo FROM nasabah WHERE no_rekening = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $no_rekening);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($saldo);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        if ($tipe == 'setor') {
            $saldo_baru = $saldo + $jumlah;
            $sql_update = "UPDATE nasabah SET saldo = ? WHERE no_rekening = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ds", $saldo_baru, $no_rekening);
            $stmt_update->execute();

            $message = "Setoran berhasil!";
        } elseif ($tipe == 'tarik') {
            if ($saldo >= $jumlah) {
                $saldo_baru = $saldo - $jumlah;
                $sql_update = "UPDATE nasabah SET saldo = ? WHERE no_rekening = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("ds", $saldo_baru, $no_rekening);
                $stmt_update->execute();

                $message = "Penarikan berhasil!";
            } else {
                $message = "Saldo tidak cukup!";
            }
        }

        $sql_transaksi = "INSERT INTO transaksi (nama, no_rekening, tipe, jumlah) VALUES (?, ?, ?, ?)";
        $stmt_transaksi = $conn->prepare($sql_transaksi);
        $stmt_transaksi->bind_param("sssd", $nama, $no_rekening, $tipe, $jumlah);
        $stmt_transaksi->execute();

        echo "<script>
                alert('$message');
                window.location.href = '../';
              </script>";
    } else {
        echo "<script>
                alert('Data nasabah tidak ditemukan!');
                window.location.href = '../';
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>