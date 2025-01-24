<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');

        body {
            background-color: #DCE7F4;
            color: #ADEFD1;
            font-family: 'Righteous', sans-serif;
        }

        h2 {
            color: #003366;
        }

        #btn-cancel {
            position: relative;
            bottom: 36px;
            left: 160px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #56CCF2, #2F80ED);
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2D9CDB, #4A90E2);
        }

        .form-container {
            background-color: #003366;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        .form-control {
            background: linear-gradient(145deg, #d4e6f1, #a9cce3);
            color: #003366;
            border: 1px solid #4A90E2;
        }

        .form-control:focus {
            background-color: #2A2A3B;
            color: #003366;
            border-color: #00A6FB;
            box-shadow: 0 0 5px rgba(0, 166, 251, 0.5);
        }

        label {
            color: #ADEFD1;
        }

        .btn-danger {
            background-color: #E63946;
        }

        .btn-danger:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Tambah Minuman</h2>
        <div class="form-container">
            <form>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Minuman</label>
                    <input type="text" class="form-control" id="nama" placeholder="Masukkan nama minuman">
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga Minuman</label>
                    <input type="number" class="form-control" id="harga" name="harga_produk" placeholder="Masukkan harga minuman">
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Kuantiti Makanan</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Masukkan kuantiti minuman">
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Minuman</label>
                    <textarea class="form-control" id="deskripsi" rows="4" placeholder="Masukkan deskripsi minuman"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Minuman</button>
            </form>
            <a href="daftar-minuman.php"><button class="btn btn-danger btn-sm3" id="btn-cancel">
                    <i class="fas fa-cancel me-1"></i>Batal
                </button></a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>