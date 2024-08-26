<?php
ob_start();

include '../db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM nasabah WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Nasabah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script>
        function confirmEdit(event) {
            if (!confirm("Apakah Anda yakin untuk mengubah data ini?")) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <div class="container pt-4">
        <div class="shadow mb-5 bg-body">
            <nav class="navbar shadow-sm">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Edit Nasabah</span>
                </div>
            </nav>
            <form action="" method="POST" onsubmit="confirmEdit(event)">
                <div class="container text-center">
                    <div class="row mt-5">
                        <div class="col-md-4 mb-3">
                            <input type="text" id="nama" class="form-control" name="nama" required value="<?php echo htmlspecialchars($row['nama']); ?>" placeholder="Masukan Username">
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" id="no_rekening" class="form-control" name="no_rekening" required value="<?php echo htmlspecialchars($row['no_rekening']); ?>" placeholder="Masukan Nomor Rekening">
                        </div>
                        <div class="col-md-4 mb-3">
                            <select name="kelas" id="kelas" required class="form-control">
                                <option value="">Pilih Kelas Anda</option>
                                <?php
                                    $kelasQuery = "SELECT * FROM kelas";
                                    $kelasResult = $conn->query($kelasQuery);
                                    while ($kelasRow = $kelasResult->fetch_assoc()) {
                                        $selected = ($kelasRow['id'] == $row['kelas_id']) ? 'selected' : '';
                                        echo '<option value="' . $kelasRow['id'] . '" ' . $selected . '>' . htmlspecialchars($kelasRow['nama']) . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4 mb-3">
                            <div class="form-group d-flex">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="laki_laki" name="jenis_kelamin" value="L" <?php if ($row['jenis_kelamin'] == 'L') { echo 'checked'; } ?> required>
                                    <label class="form-check-label" for="laki_laki">Laki-Laki</label>
                                </div>
                                <div class="form-check ms-4">
                                    <input class="form-check-input" type="radio" id="perempuan" name="jenis_kelamin" value="P" <?php if ($row['jenis_kelamin'] == 'P') { echo 'checked'; } ?> required>
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="number" step="0.01" id="saldo" class="form-control" name="saldo" required value="<?php echo htmlspecialchars($row['saldo']); ?>" placeholder="Saldo Anda">
                        </div>
                        <div class="col-md-4 mb-3">
                            <select name="jurusan" id="jurusan" required class="form-control">
                                <option value="">Pilih Jurusan Anda</option>
                                <?php
                                    $jurusanQuery = "SELECT * FROM jurusan";
                                    $jurusanResult = $conn->query($jurusanQuery);
                                    while ($jurusanRow = $jurusanResult->fetch_assoc()) {
                                        $selected = ($jurusanRow['id'] == $row['jurusan_id']) ? 'selected' : '';
                                        echo '<option value="' . $jurusanRow['id'] . '" ' . $selected . '>' . htmlspecialchars($jurusanRow['nama']) . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <select id="status" name="status" class="form-control" required>
                                <option value="">Pilih status anda</option>
                                <option value="active" <?php if ($row['status'] == 'active') { echo 'selected'; } ?>>Active</option>
                                <option value="inactive" <?php if ($row['status'] == 'inactive') { echo 'selected'; } ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="date" id="tanggal_pembuatan" class="form-control" name="tanggal_pembuatan" required value="<?php echo htmlspecialchars($row['tanggal_pembuatan']); ?>" placeholder="Tanggal Pembuatan">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3 ms-3">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>
                </div>
            </form>
            <?php
        } else {
            echo "Data tidak ditemukan.";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST["nama"];
        $kelas_id = $_POST["kelas"];
        $jurusan_id = $_POST["jurusan"];
        $jenis_kelamin = $_POST["jenis_kelamin"];
        $tanggal_pembuatan = $_POST["tanggal_pembuatan"];
        $saldo = $_POST["saldo"];
        $status = $_POST["status"];

        $sql = "UPDATE nasabah 
                SET nama='$nama', kelas_id='$kelas_id', jurusan_id='$jurusan_id', jenis_kelamin='$jenis_kelamin', tanggal_pembuatan='$tanggal_pembuatan', saldo='$saldo', status='$status' 
                WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            ob_end_clean();
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
