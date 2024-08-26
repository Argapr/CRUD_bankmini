<?php
ob_start();

include '../db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM jurusan WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Kelas</title>
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
                    <span class="navbar-brand mb-0 h1">Edit Jurusan</span>
                </div>
            </nav>
            <form action="" method="POST" onsubmit="confirmEdit(event)">
                <div class="container text-center">
                    <div class="row mt-5">
                        <div class="col-md-4 mb-3">
                            <input type="text" id="nama" class="form-control" name="nama" required value="<?php echo htmlspecialchars($row['nama']); ?>" placeholder="Masukan Username">
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

        $sql = "UPDATE jurusan SET nama='$nama' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            ob_end_clean();
            header("Location: index.php");
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
