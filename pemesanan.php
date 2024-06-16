<?php

session_start();
include 'connect.php';
if (!isset($_SESSION['username']) || $_SESSION['roles'] !== 'Kasir') {
    header('Location: login_form.php?pesan=bukan_kasir');
    exit();
}

$jenis_barang_list = [];
$jenis_barang_query = "SELECT DISTINCT jenis_barang FROM databarang";
$jenis_barang_result = mysqli_query($koneksi, $jenis_barang_query);
while ($row = mysqli_fetch_assoc($jenis_barang_result)) {
    $jenis_barang_list[] = $row['jenis_barang'];
}


$idpesanan = "";
$idbarang = "";
$nobon = "";
$tglpesanan = date("d/m/Y");
$namabarang = "";
$jumlah = "";
$harga = "";
$jenis = "";
$total = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'pilih') {
    $idbarang = $_GET['id'];
    $qpilih = "SELECT * FROM databarang WHERE id_barang = '$idbarang'";
    $qr = mysqli_query($koneksi, $qpilih);
    
    if ($qr) {
        $r = mysqli_fetch_array($qr);

        if ($r) {
            $idbarang = $r['id_barang'];
            $namabarang = $r['nama_barang'];
            $jumlah = $r['jumlah_barang'];
            $jenis = $r['jenis_barang'];
            $harga = $r['harga_barang'];
        } else {
            $error = "Data tidak ditemukan";
        }
    } else {
        $error = "Terjadi kesalahan dalam query";
    }
    
    if (isset($error)) {
        echo $error;
    }
}


if (isset($_POST['simpan'])) {
    $idpesanan = $_POST['id_pesanan'];
    $nobon = $_POST['no_bon'];
    $tglpesanan = $_POST['tgl_pesanan'];
    $namabarang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah_barang'];
    $jenis = $_POST['jenis_barang'];
    $harga = $_POST['harga_barang'];
    $total = (int)$jumlah * (int)$harga;


    if ($harga && $jumlah > 0) {
        $sql_cek_stock = "select jumlah_barang from databarang where nama_barang = '$namabarang'";
        $result = mysqli_query($koneksi, $sql_cek_stock);
        $row = mysqli_fetch_assoc($result);
        $stock = $row['jumlah_barang'];

        if ($stock > 0 && $stock >= $jumlah) {
            $sql1 = "insert into pesanan(id,id_barang,no_bon,tgl_pesanan,nama_barang,jumlah_barang,jenis_barang,total_harga) values ('$idpesanan','$idbarang','$nobon','$tglpesanan','$namabarang','$jumlah','$jenis','$total')";
            if (mysqli_query($koneksi, $sql1)) {
                $sql_update_barang = "update databarang set jumlah_barang = jumlah_barang - $jumlah where nama_barang = '$namabarang'";
                if (mysqli_query($koneksi, $sql_update_barang)) {
                    $sukses = "Berhasil memasukkan data baru";
                } else {
                    $error = "Tidak dapat mengupdate";
                }
            } else {
                $error = "Gagal memasukkan data pesanan";
            }
        } else {
            $error = "Stock barang tidak mencukupi untuk melakukan pesanan";
        }
    } else {
        $error = "Silakan masukkan semua data";
    }

}
?>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Selamat datang</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3">Selamat datang</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="pemesanan.php?cari=">Data barang</a>
                        <a class="nav-link" href="barangkeluar.php?cari=">Barang keluar</a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as: <br>
                        <?php echo $_SESSION['username'] . ' (' . $_SESSION['roles'] . ')'; ?></div>
                    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;Logout</a>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="mx-auto">
                        <br>
                        <div class="card">
                            <div class="card-header">
                                Buat pesanan
                            </div>
                            <div class="card-body">
                                <?php if ($error) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error ?>
                                    </div>
                                    <?php
                                    header("refresh:5;url=pemesanan.php?cari=");
                                } ?>
                                <?php if ($sukses) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <?php echo $sukses ?>
                                    </div>
                                    <?php
                                    header("refresh:5;url=pemesanan.php?cari=");
                                } ?>


                                <form action="" method="POST">
                                    <div class="mb-3 row" hidden>
                                        <label for="id_pesanan" class="col-sm-2 col-form-label">ID pesanan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="id_pesanan" name="id_pesanan"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="no_bon" class="col-sm-2 col-form-label">No. Bon</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="no_bon" name="no_bon" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="tgl_pesanan" class="col-sm-2 col-form-label">Tanggal pesanan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="tgl_pesanan" name="tgl_pesanan"
                                                readonly>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById("tgl_pesanan").value = "<?php echo $tglpesanan; ?>";
                                    </script>

                                    <div class="mb-3 row">
                                        <label for="namabarang" class="col-sm-2 col-form-label">Nama barang</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                                value="<?php echo $namabarang ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="jenis" class="col-sm-2 col-form-label">Jenis barang</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="jenis_barang" id="jenis_barang"
                                                value="<?php echo $jenis ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="jumlah_barang" class="col-sm-2 col-form-label">Jumlah barang</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="jumlah_barang"
                                                name="jumlah_barang" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="harga" class="col-sm-2 col-form-label">Harga satuan</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="harga_barang" id="harga_barang"
                                                value="<?php echo $harga ?>" readonly>
                                        </div>
                                    </div>
                                    <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                                </form>
                            </div>
                        </div>
                        <br>

                        <div class="card">
                            <div class="card-header text-white bg-secondary">
                                Data barang
                            </div>

                            <div class="card-body">
                                <form method="GET" action="pemesanan.php">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input class="form-control" id="cari" name="cari"
                                                placeholder="Masukkan nama barang">
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="jenis" name="jenis">
                                                <option value="">Semua Jenis</option>
                                                <?php foreach ($jenis_barang_list as $jenis_barang) { ?>
                                                    <option value="<?php echo $jenis_barang; ?>" <?php if (isset($_GET['jenis']) && $_GET['jenis'] == $jenis_barang)
                                                           echo 'selected'; ?>>
                                                        <?php echo $jenis_barang; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </form>
                                    <?php
                                    $pencarian = "";
                                    $jenis_barang_filter = "";

                                    if (isset($_GET['cari'])) {
                                        $pencarian = $_GET['cari'];
                                    }

                                    if (isset($_GET['jenis'])) {
                                        $jenis_barang_filter = $_GET['jenis'];
                                    }

                                    $qc = "SELECT * FROM databarang WHERE (nama_barang LIKE '%$pencarian%')";

                                    if (!empty($jenis_barang_filter)) {
                                        $qc .= " AND jenis_barang = '$jenis_barang_filter'";
                                    }

                                    $qc .= " ORDER BY id_barang ASC";
                                    $cr = mysqli_query($koneksi, $qc);
                                    ?>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Nama barang</th>
                                                <th scope="col">Jumlah barang</th>
                                                <th scope="col">Jenis barang</th>
                                                <th scope="col">Harga satuan</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($r = mysqli_fetch_array($cr)) {
                                                $idbarang = $r['id_barang'];
                                                $namabarang = $r['nama_barang'];
                                                $jumlah = $r['jumlah_barang'];
                                                $jenis = $r['jenis_barang'];
                                                $harga = $r['harga_barang'];
                                                ?>
                                                <tr>
                                                    <td scope="row"><?php echo $idbarang ?></td>
                                                    <td scope="row"><?php echo $namabarang ?></td>
                                                    <td scope="row"><?php echo $jumlah ?></td>
                                                    <td scope="row"><?php echo $jenis ?></td>
                                                    <td scope="row"><?php echo $harga ?></td>
                                                    <td scope="row">
                                                        <a href="pemesanan.php?op=pilih&cari=&id=<?php echo $idbarang ?>"><button
                                                                type="button" class="btn btn-success">Pilih</button></a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                            </div>

                        </div>

                    </div>
</body>

</html>