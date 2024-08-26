<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Setor Tabungan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .autocomplete-suggestions {
            border: 1px solid #ddd;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            background-color: #fff;
            z-index: 1000;
        }
        .autocomplete-suggestion {
            padding: 10px;
            cursor: pointer;
        }
        .autocomplete-suggestion:hover {
            background-color: #ddd;
        }
    </style>
    <script>
        function fetchSuggestions(query) {
            if (query.length < 1) {
                document.getElementById('suggestions').innerHTML = '';
                return;
            }

            fetch('proses_transaksi.php?search=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    let suggestions = data.map(item => 
                        `<div class="autocomplete-suggestion" onclick="selectSuggestion('${item.nama}', '${item.no_rekening}', '${item.saldo}')">${item.nama}</div>`
                    ).join('');
                    document.getElementById('suggestions').innerHTML = suggestions;
                })
                .catch(error => console.error('Error:', error));
        }

        function selectSuggestion(name, noRekening, saldo) {
            document.getElementById('nama').value = name;
            document.getElementById('no_rekening').value = noRekening;
            document.getElementById('saldo').value = saldo;
            document.getElementById('suggestions').innerHTML = '';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const namaInput = document.getElementById('nama');
            namaInput.addEventListener('input', () => fetchSuggestions(namaInput.value));
            namaInput.addEventListener('focus', () => fetchSuggestions(namaInput.value));
        });
    </script>
</head>
<body>
    <div class="container pt-4">
        <h2>Setor Tabungan</h2>
            <?php
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            $nama = isset($_GET['nama']) ? $_GET['nama'] : '';
            $saldo = isset($_GET['saldo']) ? $_GET['saldo'] : '';
            $no_rekening = isset($_GET['no_rekening']) ? $_GET['no_rekening'] : '';

            if ($id && $nama && $saldo && $no_rekening) {
            } else {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "bank_mini";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                if ($id) {
                    $stmt = $conn->prepare("SELECT nama, no_rekening, saldo FROM nasabah WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->bind_result($nama, $no_rekening, $saldo);
                    $stmt->fetch();
                    $stmt->close();
                }

                $conn->close();
            }
            ?>
             <form action="proses_transaksi.php" method="POST">
                <input type="hidden" name="tipe" value="setor">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required autocomplete="off">
                    <div id="suggestions" class="autocomplete-suggestions"></div>
                </div>
                <div class="mb-3">
                    <label for="no_rekening" class="form-label">No Rekening</label>
                    <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="<?php echo htmlspecialchars($no_rekening); ?>" required readonly>
                </div>
                <div class="mb-3">
                    <label for="saldo" class="form-label">Saldo</label>
                    <input type="text" class="form-control" id="saldo" name="saldo" value="<?php echo htmlspecialchars($saldo); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Setor</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" step="0.01" min="0" required>
                </div>
                <button type="submit" class="btn btn-primary">Setor</button>
            </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
