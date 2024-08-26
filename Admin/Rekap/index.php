<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Nasabah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Rekap Jurusan</h1>

        <form method="GET" action="">
            <div class="mb-3">
                <label for="jurusanFilter" class="form-label">Filter Jurusan</label>
                <select name="jurusan" id="jurusanFilter" class="form-select">
                    <option value="">Semua Jurusan</option>
                    <option value="Manajemen Perkantoran Layanan Bisnis">Manajemen Perkantoran Layanan Bisnis</option>
                    <option value="Bisnis Daring dan Pemasaran">Bisnis Daring dan Pemasaran</option>
                    <option value="Teknik Logistik">Teknik Logistik</option>
                    <option value="Desain Komunikasi Visual">Desain Komunikasi Visual</option>
                    <option value="Teknik Otomotif">Teknik Otomotif</option>
                    <option value="Akuntansi dan Keuangan Lembaga">Akuntansi dan Keuangan Lembaga</option>
                    <option value="Teknik Pemesinan">Teknik Pemesinan</option>
                    <option value="Kuliner">Kuliner</option>
                    <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
                    <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>

        <div class="mt-4">
            <?php
            // Include database connection
            include 'db_connect.php';
            
            // Fetch selected jurusan from GET request
            $selected_jurusan = isset($_GET['jurusan']) ? $_GET['jurusan'] : '';
            
            // SQL query to fetch data based on selected jurusan
            $sql = "
                SELECT nasabah.id, nasabah.no_rekening, nasabah.nama, kelas.nama AS kelas_nama, jurusan.nama AS jurusan_nama, nasabah.saldo
                FROM nasabah
                LEFT JOIN kelas ON nasabah.kelas_id = kelas.id
                LEFT JOIN jurusan ON nasabah.jurusan_id = jurusan.id
                WHERE 1=1
            ";
            
            if ($selected_jurusan != '') {
                $sql .= " AND jurusan.nama = '" . $conn->real_escape_string($selected_jurusan) . "'";
            }
            
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                echo '<table class="table">';
                echo '<thead><tr><th>No</th><th>No Rekening</th><th>Nama</th><th>Kelas</th><th>Jurusan</th><th>Saldo</th></tr></thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['no_rekening']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['nama']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['kelas_nama']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['jurusan_nama']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['saldo']) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo 'No records found.';
            }
            
            $conn->close();
            ?>
            
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
