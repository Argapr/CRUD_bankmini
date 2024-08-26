<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../db_connect.php';

    $nama = $_POST["nama"];
    $no_rekening = $_POST["no_rekening"];
    $nisn = $_POST["nisn"];
    $kelas_id = $_POST["kelas_id"];
    $jurusan_id = $_POST["jurusan_id"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $tanggal_pembuatan = $_POST["tanggal_pembuatan"];
    $saldo = $_POST["saldo"];
    $status = $_POST["status"];
    
    $password = "123455";

    // Check if NISN already exists
    $check_nisn_stmt = $conn->prepare("SELECT COUNT(*) FROM nasabah WHERE nisn = ?");
    $check_nisn_stmt->bind_param("s", $nisn);
    $check_nisn_stmt->execute();
    $nisn_count = $check_nisn_stmt->get_result()->fetch_column();
    
    if ($nisn_count > 0) {
        echo '<div class="alert alert-danger" role="alert">NISN sudah digunakan!</div>';
    } else {
        // Insert new nasabah
        $sql = "INSERT INTO nasabah (nama, no_rekening, nisn, kelas_id, jurusan_id, jenis_kelamin, tanggal_pembuatan, saldo, status, password)
                VALUES ('$nama', '$no_rekening', '$nisn', '$kelas_id', '$jurusan_id', '$jenis_kelamin', '$tanggal_pembuatan', '$saldo', '$status', '$password')";

        if ($conn->query($sql) === TRUE) {
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Nasabah</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script>
    function validateForm() {
      let isValid = true;
      const inputs = document.querySelectorAll("#nasabahForm input, #nasabahForm select");
      const errorMessages = [];

      inputs.forEach(input => {
        if (input.type === "radio" && !document.querySelector(`input[name="${input.name}"]:checked`)) {
          isValid = false;
          errorMessages.push(`Tolong pilih ${input.name}`);
        } else if (input.value.trim() === "") {
          isValid = false;
          errorMessages.push(`Tolong isi kolom ${input.name}`);
        }
      });

      if (!isValid) {
        alert("Peringatan:\n" + errorMessages.join("\n"));
      }

      return isValid;
    }

    function confirmSubmission(event) {
      if (validateForm()) {
        event.preventDefault();
        if (confirm("Apakah Anda yakin menambahkan data ini?")) {
          document.getElementById("nasabahForm").submit();
        }
      } else {
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
          <span class="navbar-brand mb-0 h1">Add Nasabah</span>
        </div>
      </nav>
      <form id="nasabahForm" action="" method="POST" onsubmit="confirmSubmission(event)">
        <div class="container text-center">
          <div class="row mt-4">
            <div class="col-md-4 mb-3">
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama">
            </div>
            <div class="col-md-4 mb-3">
              <input type="text" class="form-control" id="no_rekening" name="no_rekening" placeholder="Masukan No Rekening">
            </div>
            <div class="col-md-4 mb-3">
              <input type="text" class="form-control" id="nisn" name="nisn" placeholder="Masukan NISN">
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-4 mb-3">
              <div class="form-group d-flex">
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="laki_laki" name="jenis_kelamin" value="L">
                  <label class="form-check-label" for="laki_laki">Laki-Laki</label>
                </div>
                <div class="form-check ms-4">
                  <input class="form-check-input" type="radio" id="perempuan" name="jenis_kelamin" value="P">
                  <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <input type="number" step="0.01" class="form-control" id="saldo" name="saldo" placeholder="Saldo Anda">
            </div>
            <div class="col-md-4 mb-3">
              <select name="jurusan_id" id="jurusan" class="form-control">
                <option value="">Pilih Jurusan Anda</option>
                <?php
                include '../db_connect.php';  
                $jurusanQuery = "SELECT * FROM jurusan";
                $jurusanResult = $conn->query($jurusanQuery);
                while ($row = $jurusanResult->fetch_assoc()):
                ?>
                  <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-4 mb-3">
              <select id="status" name="status" class="form-control">
                <option value="">Pilih status anda</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <input type="date" class="form-control" id="tanggal_pembuatan" name="tanggal_pembuatan" placeholder="Tanggal Pembuatan">
            </div>
            <div class="col-md-4 mb-3">
              <select name="kelas_id" id="kelas" class="form-control">
                <option value="">Pilih Kelas Anda</option>
                <?php
                include '../db_connect.php';
                $kelasQuery = "SELECT * FROM kelas";
                $kelasResult = $conn->query($kelasQuery);
                while ($row = $kelasResult->fetch_assoc()):
                ?>
                  <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3 ms-3">
            <input type="submit" class="btn btn-primary" value="Submit">
          </div>
        </div>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
