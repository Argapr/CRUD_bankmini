<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: Login');
    exit;
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=bank_mini', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nasabah_id = $_SESSION['nasabah_id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
    
        // Mendapatkan password lama dari database tanpa hashing
        $stmt = $pdo->prepare('SELECT password FROM nasabah WHERE id = ?');
        $stmt->execute([$nasabah_id]);
        $current_password = $stmt->fetchColumn();

        echo "Password Lama dari Input: " . $old_password . "<br>";
        echo "Password Lama dari Database: " . $current_password . "<br>";
    
        // Memverifikasi password lama tanpa hashing
        if ($old_password === $current_password) {
            if ($new_password === $confirm_password) {
                // Update password baru ke database tanpa hashing
                $update_stmt = $pdo->prepare('UPDATE nasabah SET password = ? WHERE id = ?');
                $update_stmt->execute([$new_password, $nasabah_id]);
    
                echo '<div class="alert alert-success" role="alert">Password berhasil diperbarui!</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Password baru tidak cocok dengan konfirmasi password!</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Password lama tidak sesuai!</div>';
        }
    }
    
    // Mendapatkan data nasabah
    $stmt = $pdo->prepare('SELECT * FROM nasabah WHERE id = ?');
    $stmt->execute([$nasabah_id]);
    $nasabah = $stmt->fetch(PDO::FETCH_ASSOC);

    // Mendapatkan nama kelas
    $stmt = $pdo->prepare('SELECT nama FROM kelas WHERE id = ?');
    $stmt->execute([$nasabah['kelas_id']]);
    $kelas = $stmt->fetch(PDO::FETCH_ASSOC);

    // Mendapatkan nama jurusan
    $stmt = $pdo->prepare('SELECT nama FROM jurusan WHERE id = ?');
    $stmt->execute([$nasabah['jurusan_id']]);
    $jurusan = $stmt->fetch(PDO::FETCH_ASSOC);

    // Mendapatkan transaksi
    $stmt = $pdo->prepare('SELECT * FROM transaksi WHERE no_rekening = ? ORDER BY tanggal DESC');
    $stmt->execute([$nasabah['no_rekening']]);
    $transaksi = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'Koneksi gagal: ' . $e->getMessage();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil Nasabah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .modal-content {
            border-radius: 8px;
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
            display: flex;
            justify-content: center;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function openModal() {
            var modal = new bootstrap.Modal(document.getElementById("editPasswordModal"));
            modal.show();
        }

        function closeModal() {
            var modal = bootstrap.Modal.getInstance(document.getElementById("editPasswordModal"));
            modal.hide();
        }
    </script>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Profil Pengguna</h2>
        <p><strong>Nama:</strong> <?php echo htmlspecialchars($nasabah['nama']); ?></p>
        <p><strong>NISN:</strong> <?php echo htmlspecialchars($nasabah['nisn']); ?></p>
        <p><strong>No. Rekening:</strong> <?php echo htmlspecialchars($nasabah['no_rekening']); ?></p>
        <p><strong>Jenis Kelamin:</strong> <?php echo htmlspecialchars($nasabah['jenis_kelamin']); ?></p>
        <p><strong>Tanggal Pembuatan:</strong> <?php echo htmlspecialchars($nasabah['tanggal_pembuatan']); ?></p>
        <p><strong>Saldo:</strong> <?php echo number_format($nasabah['saldo'], 2); ?></p>
        <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($nasabah['status'])); ?></p>
        <p><strong>Kelas:</strong> <?php echo htmlspecialchars($kelas['nama']); ?></p>
        <p><strong>Jurusan:</strong> <?php echo htmlspecialchars($jurusan['nama']); ?></p>
        <p>
            <strong>Password:</strong> ******
            <button type="button" class="btn btn-primary btn-sm ms-3" onclick="openModal()">Edit Password</button>
        </p>

        <h2 class="mt-5">Riwayat Transaksi</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Tipe</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $t): ?>
                <tr>
                    <td><?php echo htmlspecialchars($t['tanggal']); ?></td>
                    <td><?php echo number_format($t['jumlah'], 2); ?></td>
                    <td><?php echo ucfirst(htmlspecialchars($t['tipe'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="Logout" class="btn btn-danger mt-4">Logout</a>
    </div>

    <!-- Modal untuk edit password -->
    <!-- Modal untuk edit password -->
<div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPasswordModalLabel">Edit Password</h5>
                <button type="button" class="btn-close" aria-label="Close" onclick="closeModal()"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="old_password" class="form-label">Password Lama:</label>
                        <input type="password" id="old_password" name="old_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru:</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Update Password">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
