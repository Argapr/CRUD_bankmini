<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../db_connect.php';

    $nama = $_POST["nama"];

    $sql = "INSERT INTO jurusan (nama) VALUES ('$nama')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Jurusan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script>
    function validateForm() {
      let isValid = true;
      const inputs = document.querySelectorAll("#jurusanForm input");
      const errorMessages = [];

      inputs.forEach(input => {
        if (input.value.trim() === "") {
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
          document.getElementById("jurusanForm").submit();
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
          <span class="navbar-brand mb-0 h1">Add Jurusan</span>
        </div>
      </nav>
      <form id="jurusanForm" action="" method="POST" onsubmit="confirmSubmission(event)">
        <div class="container text-center">
          <div class="row mt-4">
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama Jurusan">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3 ms-3">
            <input type="submit" class="btn btn-primary" value="Submit">
          </div>
        </div>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>