<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: borehouse.php");
    exit();
}

if (isset($_POST['login_btn'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    
    if ($user == 'admint' && $pass == 'admint12345') {
        $_SESSION['sudah_login'] = true;
        header("Location: borehouse.php"); 
        exit();
    } else {
        $error_login = "Username atau Password salah!";
    }
}

if (!isset($_SESSION['sudah_login'])) {
?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - BoreHouse</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Poppins', sans-serif; background: #e0eafc; height: 100vh; display: flex; align-items: center; justify-content: center; }
            .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
            .btn-primary { background-color: #1e3a8a; border: none; }
        </style>
    </head>
    <body>
        <div class="card p-4 mx-3">
            <div class="text-center mb-4">
                <h2 class="fw-bold" style="color: #1e3a8a;">🔐 Login</h2>
                <p class="text-muted">Sistem Inventaris BoreHouse</p>
            </div>
            <?php if(isset($error_login)): ?>
                <div class="alert alert-danger text-center p-2 small"><?= $error_login ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan Username..." required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan Password..." required>
                </div>
                <div class="d-grid">
                    <button type="submit" name="login_btn" class="btn btn-primary py-2 fw-bold">MASUK</button>
                </div>
            </form>
        </div>
    </body>
    </html>
<?php
    exit(); 
}

$conn = new mysqli("localhost", "admin", "123", "gudang");
if ($conn->connect_error) { die("Koneksi Gagal: " . $conn->connect_error); }

$id_edit = ""; $nama_edit = ""; $stok_edit = ""; $update_mode = false; $pesan = "";

if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit']; $update_mode = true;
    $result = $conn->query("SELECT * FROM barang WHERE id=$id_edit");
    if ($result->num_rows > 0) { $row = $result->fetch_assoc(); $nama_edit = $row['nama']; $stok_edit = $row['stok']; }
}
if (isset($_GET['hapus'])) {
    $conn->query("DELETE FROM barang WHERE id=" . $_GET['hapus']);
    header("Location: borehouse.php"); exit();
}
if (isset($_POST['submit'])) {
    $nama = $_POST['nama']; $stok = $_POST['stok']; $id = $_POST['id'];
    if ($id != "") { 
        $conn->query("UPDATE barang SET nama='$nama', stok='$stok' WHERE id=$id");
        $teks_sukses = "Data Berhasil Di-Update!";
    } else { 
        $conn->query("INSERT INTO barang (nama, stok) VALUES ('$nama', '$stok')");
        $teks_sukses = "Data Baru Berhasil Disimpan!";
    }
    $pesan = $teks_sukses; $nama_edit = ""; $stok_edit = ""; $update_mode = false; $id_edit = "";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif !important; background-color: #f4f6f9 !important; }
        h1.text-primary { color: #1e3a8a !important; font-weight: 800 !important; letter-spacing: -1px; }
        .card { border: none !important; border-radius: 15px !important; box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important; }
        .card-header { border-radius: 15px 15px 0 0 !important; padding: 15px; font-weight: 600; }
        .btn { border-radius: 10px !important; font-weight: 600; padding: 10px; }
        .table-dark th { background-color: #343a40 !important; font-weight: 600; text-transform: uppercase; font-size: 0.9rem; }
        .table td { vertical-align: middle; padding: 15px 10px; }
    </style>
</head>
<body class="bg-light">

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            
            <div class="d-flex justify-content-between align-items-center mb-4 pt-2">
                <div class="d-flex align-items-center">
                    <img src="https://img.sanishtech.com/u/c88f44f76b1ecd3d8086b73b65a0256c.png" alt="Logo" width="50" height="50" class="me-3 rounded">
                    <div>
                        <h1 class="fw-bold text-primary m-0 fs-2">BoreHouse</h1>
                        <p class="text-muted m-0 small">Manajemen Stok Barang</p>
                    </div>
                </div>
                <div>
                    <a href="?logout=true" class="btn btn-danger btn-sm px-3 shadow-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header text-white <?= $update_mode ? 'bg-warning' : 'bg-primary' ?>">
                    <h5 class="mb-0">
                        <i class="fas <?= $update_mode ? 'fa-edit' : 'fa-plus-circle' ?>"></i> 
                        <?= $update_mode ? 'Edit Data Barang' : 'Input Barang Baru' ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if ($pesan): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <?= $pesan ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="row g-3">
                        <input type="hidden" name="id" value="<?= $id_edit ?>">

                        <div class="col-md-7">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="nama" class="form-control" value="<?= $nama_edit ?>" placeholder="Masukkan nama barang" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jumlah Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?= $stok_edit ?>" placeholder="0" required>
                        </div>
                        <div class="col-md-2 d-grid">
                            <label class="form-label text-white">.</label>
                            <button type="submit" name="submit" class="btn <?= $update_mode ? 'btn-warning text-dark' : 'btn-success' ?>">
                                <i class="fas fa-save"></i> <?= $update_mode ? 'Update' : 'Simpan' ?>
                            </button>
                        </div>
                        
                        <?php if($update_mode): ?>
                            <div class="col-12 text-end">
                                <a href="borehouse.php" class="text-decoration-none text-muted small">Batal Edit</a>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Nama Barang</th>
                                    <th class="text-center">Stok</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $conn->query("SELECT * FROM barang ORDER BY id DESC");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td class='text-center'>" . $row['id'] . "</td>
                                                <td><strong>" . $row['nama'] . "</strong></td>
                                                <td class='text-center'><span class='badge bg-info text-dark'>" . $row['stok'] . "</span></td>
                                                <td class='text-center text-nowrap'>
                                                    <a href='?edit=" . $row['id'] . "' class='btn btn-warning btn-sm me-1'><i class='fas fa-pen'></i></a>
                                                    <a href='?hapus=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin hapus data ini?\")'><i class='fas fa-trash'></i></a>
                                                </td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Data tidak ditemukan.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
