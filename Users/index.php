<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: Login');
    exit;
}

// Koneksi ke database
try {
    $pdo = new PDO('mysql:host=localhost;dbname=bank_mini', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nasabah_id = $_SESSION['nasabah_id'];

    // Proses pembaruan password jika formulir dikirim
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_password'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Validasi konfirmasi password
        if ($new_password === $confirm_password) {
            // Hash password baru
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password di database
            $update_stmt = $pdo->prepare('UPDATE nasabah SET password = ? WHERE id = ?');
            $update_stmt->execute([$hashed_password, $nasabah_id]);

            echo '<p>Password berhasil diperbarui!</p>';
        } else {
            echo '<p>Password tidak cocok dengan konfirmasi password!</p>';
        }
    }

    // Ambil data nasabah
    $stmt = $pdo->prepare('SELECT * FROM nasabah WHERE id = ?');
    $stmt->execute([$nasabah_id]);
    $nasabah = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ambil data transaksi berdasarkan no_rekening
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #333;
        }

        p {
            font-size: 16px;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .button {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px 0;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
        }

        .modal-body {
            margin: 20px 0;
        }

        .modal-body label {
            display: block;
            margin-bottom: 5px;
        }

        .modal-body input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .modal-body input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal-body input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function openModal() {
            document.getElementById("editPasswordModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("editPasswordModal").style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("editPasswordModal")) {
                closeModal();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Profil Pengguna</h2>
        <p><strong>Nama:</strong> <?php echo htmlspecialchars($nasabah['nama']); ?></p>
        <p><strong>No. Rekening:</strong> <?php echo htmlspecialchars($nasabah['no_rekening']); ?></p>
        <p><strong>Jenis Kelamin:</strong> <?php echo htmlspecialchars($nasabah['jenis_kelamin']); ?></p>
        <p><strong>Tanggal Pembuatan:</strong> <?php echo htmlspecialchars($nasabah['tanggal_pembuatan']); ?></p>
        <p><strong>Saldo:</strong> <?php echo number_format($nasabah['saldo'], 2); ?></p>
        <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($nasabah['status'])); ?></p>

        <!-- Tambahkan ikon edit password -->
        <p>
            <strong>Password:</strong> ******
            <a href="javascript:void(0)" class="button" onclick="openModal()">Edit</a>
        </p>

        <h2>Riwayat Transaksi</h2>
        <table>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Tipe</th>
            </tr>
            <?php foreach ($transaksi as $t): ?>
            <tr>
                <td><?php echo htmlspecialchars($t['tanggal']); ?></td>
                <td><?php echo number_format($t['jumlah'], 2); ?></td>
                <td><?php echo ucfirst(htmlspecialchars($t['tipe'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <a href="Logout" class="button">Logout</a>
    </div>

    <!-- Popup form untuk edit password -->
    <div id="editPasswordModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Password</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <label for="new_password">Password Baru:</label>
                    <input type="password" id="new_password" name="new_password" required>
                    <label for="confirm_password">Konfirmasi Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <input type="submit" value="Update Password">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
