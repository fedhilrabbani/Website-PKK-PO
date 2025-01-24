<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Makanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');

        body {
            background-color: #00203F;
            color: #ADEFD1;
            font-family: 'Righteous', sans-serif;
        }

        h2 {
            color: #ADEFD1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #56CCF2, #2F80ED);
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2D9CDB, #4A90E2);
        }

        table {
            background-color: #003865;
            border-radius: 20px;
            color: #ADEFD1;
        }

        table thead {
            background-color: #00509E;
        }

        table thead th {
            color: #FFFFFF;
        }

        .btn {
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .btn-info {
            background-color: #00A6FB;
        }

        .btn-warning {
            background-color: #F4D160;
        }

        .btn-danger {
            background-color: #E63946;
        }

        .btn-info:hover,
        .btn-warning:hover,
        .btn-danger:hover {
            opacity: 0.9;
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Minuman</h2>
            <a href="tambah-minuman.php"><button class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Minuman
                </button></a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Foto Minuman</th>
                        <th>ID Minuman</th>
                        <th>Nama Minuman</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Quantity</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Images</td>
                        <td>1</td>
                        <td>Soda Gembira</td>
                        <td>Nasi goreng khas Indonesia</td>
                        <td>Rp 20.000</td>
                        <td>10</td>
                        <td>
                            <a href="lihat-makanan.php"><button class="btn btn-info btn-sm me-1">
                                    <i class="fas fa-eye"></i>
                                </button></a>
                            <a href="edit-makanan.php"><button class="btn btn-warning btn-sm me-1">
                                    <i class="fas fa-edit"></i>
                                </button></a>
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>