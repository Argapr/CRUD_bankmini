<?php
session_start();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=bank_mini', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nisn = $_POST['nisn'];
    $input_password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM nasabah WHERE nisn = ?');
    $stmt->execute([$nisn]);
    $nasabah = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($nasabah) {
        if ($input_password === $nasabah['password']) {
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
