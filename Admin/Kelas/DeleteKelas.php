<?php
include '../db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $check_sql = "SELECT COUNT(*) as count FROM nasabah WHERE kelas_id = $id";
    $check_result = $conn->query($check_sql);
    $check_row = $check_result->fetch_assoc();

    if ($check_row['count'] > 0) {
        echo "<script>alert('Tidak dapat menghapus data kelas karena ada nasabah terkait'); window.location.href='index.php';</script>";
    } else {
        $sql = "DELETE FROM kelas WHERE id = $id";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Data berhasil dihapus'); window.location.href='index.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
} else {
    echo "ID tidak ditemukan.";
}
?>
