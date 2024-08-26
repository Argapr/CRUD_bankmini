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
        // Jika password masih NULL (pengguna baru pertama kali login)
        if (is_null($nasabah['password'])) {
            // Set password acak yang diinput pengguna sebagai password baru
            $hashed_password = password_hash($input_password, PASSWORD_DEFAULT);

            // Update password di database
            $update_stmt = $pdo->prepare('UPDATE nasabah SET password = ? WHERE id = ?');
            $update_stmt->execute([$hashed_password, $nasabah['id']]);

            // Simpan data di session
            $_SESSION['loggedin'] = true;
            $_SESSION['nasabah_id'] = $nasabah['id'];
            header('Location: ../?id=' . $nasabah['id']);
            exit;
        } else {
            // Jika password sudah ada, verifikasi password yang diinput
            if (password_verify($input_password, $nasabah['password'])) {
                // Jika password benar, simpan data di session
                $_SESSION['loggedin'] = true;
                $_SESSION['nasabah_id'] = $nasabah['id'];
                header('Location: ../?id=' . $nasabah['id']);
                exit;
            } else {
                echo 'Login gagal, NISN atau password salah!';
            }
        }
    } else {
        echo 'Login gagal, NISN tidak ditemukan!';
    }

} catch (PDOException $e) {
    echo 'Koneksi gagal: ' . $e->getMessage();
}
?>
