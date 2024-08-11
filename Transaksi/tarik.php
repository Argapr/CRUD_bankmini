<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Tarik Tabungan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        /* Styling untuk dropdown rekomendasi */
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
                        `<div class="autocomplete-suggestion" onclick="selectSuggestion('${item.nama}', '${item.no_rekening}')">${item.nama}</div>`
                    ).join('');
                    document.getElementById('suggestions').innerHTML = suggestions;
                })
                .catch(error => console.error('Error:', error));
        }

        function selectSuggestion(name, noRekening) {
            document.getElementById('nama').value = name;
            document.getElementById('no_rekening').value = noRekening;
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
        <div class="shadow mb-5 bg-body">
            <nav class="navbar shadow-sm">
                <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Tarik Tabungan</span>
                </div>
            </nav>
            <form action="proses_transaksi.php" method="POST">
                <div class="container text-center">
                    <div class="row mt-4">
                        <div class="col-md-4 mb-3">
                            <input type="hidden" name="tipe" value="tarik">
                            <label for="nama">Nama:</label>
                            <input type="text" id="nama" name="nama" required autocomplete="off">
                            <div id="suggestions" class="autocomplete-suggestions"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="no_rekening">No Rekening:</label>
                            <input type="text" id="no_rekening" name="no_rekening" required readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="jumlah">Jumlah Setor:</label>
                            <input type="number" id="jumlah" name="jumlah" step="0.01" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3 ms-3">
                        <input type="submit" class="btn btn-primary" value="Tarik">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
