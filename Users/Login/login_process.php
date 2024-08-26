<?php
session_start();

// Koneksi ke database
try {
    $pdo = new PDO('mysql:host=localhost;dbname=bank_mini', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil data dari form
    $nisn = $_POST['nisn'];
    $input_password = $_POST['password'];

    // Cari nasabah berdasarkan NISN
    $stmt = $pdo->prepare('SELECT * FROM nasabah WHERE nisn = ?');
    $stmt->execute([$nisn]);
    $nasabah = $stmt->fetch(PDO::FETCH_ASSOC);

    // Cek apakah nasabah ditemukan
    if ($nasabah) {
        // Verifikasi password yang diinput
        if ($input_password === $nasabah['password']) {
            // Jika password benar, simpan data di session
            $_SESSION['loggedin'] = true;
            $_SESSION['nasabah_id'] = $nasabah['id'];
            header('Location: ../?id=' . $nasabah['id']);
            exit;
        } else {
            echo 'Login gagal, password yang Anda masukkan salah!';
        }
    } else {
        echo 'Login gagal, NISN tidak ditemukan!';
    }

} catch (PDOException $e) {
    echo 'Koneksi gagal: ' . $e->getMessage();
}
?>
