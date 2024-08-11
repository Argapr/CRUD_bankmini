<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank_mini";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form
    $nama = $conn->real_escape_string($_POST['nama']);
    $no_rekening = $conn->real_escape_string($_POST['no_rekening']);
    $jumlah = (float)$_POST['jumlah'];  // Pastikan jumlah adalah float
    $tipe = $conn->real_escape_string($_POST['tipe']);

    // Mengambil saldo saat ini
    $sql = "SELECT saldo FROM nasabah WHERE no_rekening = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
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
            if ($stmt_update === false) {
                die("Error preparing statement: " . $conn->error);
            }
            $stmt_update->bind_param("ds", $saldo_baru, $no_rekening);
            $stmt_update->execute();

            $message = "Setoran berhasil!";
        } elseif ($tipe == 'tarik') {
            if ($jumlah < 50000) {
                $message = "Minimal penarikan adalah 50.000!";
            } elseif ($saldo - $jumlah < 10000) {
                $message = "Saldo harus tersisa minimal 10.000!";
            } else {
                $saldo_baru = $saldo - $jumlah;
                $sql_update = "UPDATE nasabah SET saldo = ? WHERE no_rekening = ?";
                $stmt_update = $conn->prepare($sql_update);
                if ($stmt_update === false) {
                    die("Error preparing statement: " . $conn->error);
                }
                $stmt_update->bind_param("ds", $saldo_baru, $no_rekening);
                $stmt_update->execute();

                $message = "Penarikan berhasil!";
            }
        } else {
            $message = "Tipe transaksi tidak valid!";
        }

        // Menyimpan transaksi
        $sql_transaksi = "INSERT INTO transaksi (nama, no_rekening, tipe, jumlah) VALUES (?, ?, ?, ?)";
        $stmt_transaksi = $conn->prepare($sql_transaksi);
        if ($stmt_transaksi === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt_transaksi->bind_param("sssd", $nama, $no_rekening, $tipe, $jumlah);
        $stmt_transaksi->execute();

    } else {
        $message = "Data nasabah tidak ditemukan!";
    }

    // Menutup statement
    $stmt->close();
    if (isset($stmt_update)) {
        $stmt_update->close();
    }
    if (isset($stmt_transaksi)) {
        $stmt_transaksi->close();
    }
    $conn->close();

    // Mengarahkan dan memberikan umpan balik
    echo "<script>
            alert('$message');
            window.location.href = '../';
          </script>";
    exit;
}

if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    
    $sql = "SELECT nama, no_rekening FROM nasabah WHERE nama LIKE CONCAT('%', ?, '%')";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
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
?>
