<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank_mini";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil filter dan pencarian dari URL
$search_name = isset($_GET['search_name']) ? $_GET['search_name'] : '';
$filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : '';
$filter_date_from = isset($_GET['filter_date_from']) ? $_GET['filter_date_from'] : '';
$filter_date_to = isset($_GET['filter_date_to']) ? $_GET['filter_date_to'] : '';

// Bangun query SQL dengan filter dan pencarian
$sql = "SELECT * FROM transaksi WHERE 1=1";

if ($search_name != '') {
    $sql .= " AND nama LIKE '%" . $conn->real_escape_string($search_name) . "%'";
}

if ($filter_type != '') {
    $sql .= " AND tipe = '" . $conn->real_escape_string($filter_type) . "'";
}

if ($filter_date_from != '' && $filter_date_to != '') {
    $sql .= " AND tanggal BETWEEN '" . $conn->real_escape_string($filter_date_from) . "' AND '" . $conn->real_escape_string($filter_date_to) . "'";
} elseif ($filter_date_from != '') {
    $sql .= " AND tanggal >= '" . $conn->real_escape_string($filter_date_from) . "'";
} elseif ($filter_date_to != '') {
    $sql .= " AND tanggal <= '" . $conn->real_escape_string($filter_date_to) . "'";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e2e2e2;
        }
    </style>
</head>
<body>
    <h2>Data Transaksi</h2>
    <form method="GET" action="">
        <label for="search_name">Cari Nama:</label>
        <input type="text" id="search_name" name="search_name" value="<?php echo htmlspecialchars($search_name); ?>">

        <label for="filter_type">Tipe:</label>
        <select id="filter_type" name="filter_type">
            <option value="">Semua</option>
            <option value="setor" <?php echo $filter_type == 'setor' ? 'selected' : ''; ?>>Setor</option>
            <option value="tarik" <?php echo $filter_type == 'tarik' ? 'selected' : ''; ?>>Tarik</option>
        </select>

        <label for="filter_date_from">Tanggal Dari:</label>
        <input type="date" id="filter_date_from" name="filter_date_from" value="<?php echo htmlspecialchars($filter_date_from); ?>">

        <label for="filter_date_to">Tanggal Sampai:</label>
        <input type="date" id="filter_date_to" name="filter_date_to" value="<?php echo htmlspecialchars($filter_date_to); ?>">

        <button type="submit">Cari</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>No Rekening</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data dari setiap baris
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["nama"] . "</td>";
                    echo "<td>" . $row["no_rekening"] . "</td>";
                    echo "<td>" . $row["tipe"] . "</td>";
                    echo "<td>" . number_format($row["jumlah"], 2) . "</td>";
                    echo "<td>" . $row["tanggal"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data transaksi</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    $conn->close();
    ?>
</body>
</html>
