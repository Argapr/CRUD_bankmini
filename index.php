<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Nasabah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .biodata-card {
            transition: transform 0.2s;
            position: relative;
            overflow: hidden;
            padding-bottom: 30px;
        }
        .biodata-card:hover {
            transform: scale(1.05);
        }
        .biodata-card .btn {
            position: absolute;
            bottom: 10px;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 1;
        }
        .biodata-card:hover .btn {
            opacity: 1;
        }
        .btn-edit {
            left: 10px;
        }
        .btn-delete {
            right: 10px;
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .card-text {
            margin-bottom: 0.5rem;
        }
        .icon-title {
            font-size: 1.1rem;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">Data Nasabah</a>
            <div>
              <a class="navbar-brand" href="#">Nasabah</a>
              <a class="navbar-brand" href="Kelas">Kelas</a>
              <a class="navbar-brand" href="Jurusan">Jurusan</a>
            </div>
            <div>
                <a href="Transaksi/setor.php" class="btn btn-primary">Setor</a>
                <a href="Transaksi/tarik.php" class="btn btn-primary me-3">Tarik</a>
                <a href="Add" class="btn btn-primary">Add Nasabah</a>
            </div>
        </div>
    </nav>
    <div class="container mt-2">
        <div class="row">
            <div class="col-4">
                <div class="shadow p-3 mb-5 bg-body rounded">
                    <h3>
                        <?php
                        include 'db_connect.php';
                        $count_sql = "SELECT COUNT(*) as total FROM nasabah";
                        $count_result = $conn->query($count_sql);
                        $count_row = $count_result->fetch_assoc();
                        $total_records = $count_row['total'];
                        echo $total_records;
                        ?>
                        Nasabah
                    </h3>   
                    <form method="GET" action="">
                        <label for="search">Cari Nasabah</label><br>
                        <input type="text" id="search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"><br><br>
                        <label for="filter">Filter</label><br>
                        <div class="d-flex justify-content-between">
                            <select name="status" id="filter">
                                <option value="">show all</option>
                                <option value="active" <?php echo isset($_GET['status']) && $_GET['status'] == 'active' ? 'selected' : ''; ?>>active</option>
                                <option value="inactive" <?php echo isset($_GET['status']) && $_GET['status'] == 'inactive' ? 'selected' : ''; ?>>inactive</option>
                            </select>
                            <button type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-8">
                <div class="container">
                    <?php
                    $records_per_page = 6;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $records_per_page;

                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $status = isset($_GET['status']) ? $_GET['status'] : '';

                    $sql = "
                        SELECT nasabah.id, nasabah.nama, nasabah.no_rekening, nasabah.jenis_kelamin, 
                               nasabah.tanggal_pembuatan, nasabah.saldo, nasabah.status, 
                               kelas.nama AS kelas_nama, jurusan.nama AS jurusan_nama
                        FROM nasabah
                        LEFT JOIN kelas ON nasabah.kelas_id = kelas.id
                        LEFT JOIN jurusan ON nasabah.jurusan_id = jurusan.id
                        WHERE 1=1
                    ";

                    if ($search != '') {
                        $sql .= " AND nasabah.nama LIKE '%" . $conn->real_escape_string($search) . "%'";
                    }

                    if ($status != '') {
                        $sql .= " AND nasabah.status = '" . $conn->real_escape_string($status) . "'";
                    }

                    $sql .= " LIMIT $records_per_page OFFSET $offset";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $count = 0;
                        echo '<div class="row">';
                        while($row = $result->fetch_assoc()) {
                            if ($count > 0 && $count % 3 == 0) {
                                echo '</div><div class="row">';
                            }
                            echo '<div class="col-md-4 mb-4">';
                            echo '<div class="card biodata-card shadow-sm">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . htmlspecialchars($row["nama"]) . '</h5>';
                            echo '<p class="card-text"><i class="fas fa-graduation-cap icon-title"></i> ' . htmlspecialchars($row["no_rekening"]) . '</p>';
                            echo '<p class="card-text"><i class="fas fa-graduation-cap icon-title"></i> ' . htmlspecialchars($row["kelas_nama"]) . '</p>';
                            echo '<p class="card-text"><i class="fas fa-book icon-title"></i> ' . htmlspecialchars($row["jurusan_nama"]) . '</p>';
                            echo '<p class="card-text"><i class="fas fa-genderless icon-title"></i> ' . ($row["jenis_kelamin"] == 'L' ? 'Laki-Laki' : 'Perempuan') . '</p>';
                            echo '<p class="card-text"><i class="fas fa-calendar-alt icon-title"></i> ' . htmlspecialchars($row["tanggal_pembuatan"]) . '</p>';
                            echo '<p class="card-text"><i class="fas fa-wallet icon-title"></i> ' . htmlspecialchars($row["saldo"]) . '</p>';
                            echo '<p class="card-text"><i class="fas fa-tag icon-title"></i> ' . htmlspecialchars($row["status"]) . '</p>';
                            echo '</div>';
                            echo '<a href="Edit?id=' . $row["id"] . '" class="btn btn-warning btn-sm btn-edit">Edit</a>';
                            echo '<a href="#" onclick="confirmDelete(' . $row["id"] . ')" class="btn btn-danger btn-sm btn-delete">Delete</a>';
                            echo '</div>';
                            echo '</div>';
                            $count++;
                        }
                        echo '</div>';

                        $total_pages = ceil($total_records / $records_per_page);
                        echo '<nav aria-label="Page navigation">';
                        echo '<ul class="pagination">';
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&search=' . htmlspecialchars($search) . '&status=' . htmlspecialchars($status) . '">Previous</a></li>';
                        }
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '&search=' . htmlspecialchars($search) . '&status=' . htmlspecialchars($status) . '">' . $i . '</a></li>';
                        }
                        if ($page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&search=' . htmlspecialchars($search) . '&status=' . htmlspecialchars($status) . '">Next</a></li>';
                        }
                        echo '</ul>';
                        echo '</nav>';
                    } else {
                        echo "0 results";
                    }
                    $conn->close();
                    ?>
                    <script>
                        function confirmDelete(id) {
                            if (confirm("Apakah Anda yakin untuk menghapus data ini?")) {
                                window.location.href = "Delete?id=" + id;
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
