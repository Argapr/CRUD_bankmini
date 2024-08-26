<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Jurusan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .kelas-card {
            transition: transform 0.2s;
            position: relative;
            overflow: hidden;
            padding-bottom: 30px;
        }
        .kelas-card:hover {
            transform: scale(1.05);
        }
        .kelas-card .btn {
            position: absolute;
            bottom: 10px;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 1;
        }
        .kelas-card:hover .btn {
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
            <a class="navbar-brand">Data Jurusan</a>
            <div class="">
              <a class="navbar-brand" href="../">Nasabah</a>
              <a class="navbar-brand" href="../Kelas">Kelas</a>
              <a class="navbar-brand" href="#">Jurusan</a>
            </div>
            <a href="AddJurusan.php" class="btn btn-primary">Add Jurusan</a>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row">
            <div class="col-4">
                <div class="shadow p-3 mb-5 bg-body rounded">
                    <h3>
                        <?php
                        include '../db_connect.php';
                        $count_sql = "SELECT COUNT(*) as total FROM jurusan";
                        $count_result = $conn->query($count_sql);
                        if ($count_result->num_rows > 0) {
                            $count_row = $count_result->fetch_assoc();
                            echo $count_row['total'];
                        } else {
                            echo "0";
                        }
                        ?>
                        Jurusan
                    </h3>
                    <p>Cari Jurusan</p>
                    <form method="GET" action="">
                        <input type="text" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button type="submit">Cari</button>
                    </form>
                </div>
            </div>
            <div class="col-8">
                <div class="container">
                    <?php
                    include '../db_connect.php';

                    $search = isset($_GET['search']) ? $_GET['search'] : '';

                    $sql = "SELECT * FROM jurusan WHERE 1=1";

                    if ($search != '') {
                        $sql .= " AND nama LIKE '%" . $conn->real_escape_string($search) . "%'";
                    }

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $count = 0;
                        echo '<div class="row">';
                        while($row = $result->fetch_assoc()) {
                            if ($count > 0 && $count % 3 == 0) {
                                echo '</div><div class="row">';
                            }
                            echo '<div class="col-md-4 mb-4">';
                            echo '<div class="card kelas-card shadow-sm">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . htmlspecialchars($row["nama"]) . '</h5>';
                            echo '</div>';
                            echo '<a href="EditJurusan.php?id=' . $row["id"] . '" class="btn btn-warning btn-sm btn-edit">Edit</a>';
                            echo '<a href="#" onclick="confirmDelete(' . $row["id"] . ')" class="btn btn-danger btn-sm btn-delete">Delete</a>';
                            echo '</div>';
                            echo '</div>';
                            $count++;
                        }
                        echo '</div>';
                    } else {
                        echo "0 results";
                    }
                    $conn->close();
                    ?>
                    <script>
                        function confirmDelete(id) {
                            if (confirm("Apakah Anda yakin untuk menghapus data ini?")) {
                                window.location.href = "DeleteJurusan.php?id=" + id;
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
