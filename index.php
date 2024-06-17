<?php

session_start();
include 'connect.php';
if (!isset($_SESSION['username']) || ($_SESSION['roles'] !== 'Manajer' && $_SESSION['roles'] !== 'Staff Gudang')) {
    header('Location: login_form.php?pesan=bukan_manajer');
    exit();
}

$jenis_barang_list = [];
$jenis_barang_query = "select distinct jenis_barang from databarang";
$jenis_barang_result = mysqli_query($koneksi, $jenis_barang_query);
while ($row = mysqli_fetch_assoc($jenis_barang_result)) {
    $jenis_barang_list[] = $row['jenis_barang'];
}


$idbarang = "";
$namabarang = "";
$jumlah = "";
$jenis = "";
$harga = "";
$idmasuk = "";
$tglmasuk = date("d/m/Y");
$jumlahmasuk = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $idbarang = $_GET['id'];
    $qdel = "delete from databarang where id_barang = '$idbarang'";
    $qr = mysqli_query($koneksi, $qdel);
    if ($qr) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $idbarang = $_GET['id'];
    $qedit = "select * from databarang where id_barang = '$idbarang'";
    $qr = mysqli_query($koneksi, $qedit);

    if (mysqli_num_rows($qr) > 0) {
        $r = mysqli_fetch_array($qr);
        $idbarang = $r['id_barang'];
        $namabarang = $r['nama_barang'];
        $jumlah = $r['jumlah_barang'];
        $jenis = $r['jenis_barang'];
        $harga = $r['harga_barang'];
    } else {
        $error = "Data tidak ditemukan";
        $idbarang = '';
        $namabarang = '';
        $jumlah = '';
        $jenis = '';
        $harga = '';
    }
}

if (isset($_POST['simpan'])) {
    $idbarang = $_POST['id_barang'];
    $namabarang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah_barang'];
    $jenis = $_POST['jenis_barang'];
    $harga = $_POST['harga_barang'];

    $idmasuk = $_POST['id_masuk'];
    $tglmasuk = $_POST['tgl_masuk'];
    $jumlahmasuk = $_POST['jumlah_masuk'];

    if ($idbarang || $namabarang) {
        if ($op == 'edit') {
            $qedit = "insert into barangmasuk(id,id_barang,tgl_masuk,nama_barang,jumlah_barang,jenis_barang) values ('$idmasuk','$idbarang','$tglmasuk','$namabarang','$jumlahmasuk','$jenis')";
            if (mysqli_query($koneksi, $qedit)) {
                $qup = "update databarang set nama_barang = '$namabarang', harga_barang = '$harga', jumlah_barang = jumlah_barang + $jumlahmasuk where id_barang = '$idbarang'";
                if (mysqli_query($koneksi, $qup)) {
                    $sukses = "Data berhasil diupdate";
                } else {
                    $error = "Gagal memasukan data masuk";
                }

            } else {
                $error = "Data gagal diupdate";
            }
        } else {
            $qin = "insert into databarang(id_barang,nama_barang,jumlah_barang,jenis_barang,harga_barang) values ('$idbarang','$namabarang','$jumlahmasuk','$jenis','$harga')";
            if (mysqli_query($koneksi, $qin)) {
                $qadd = "insert into barangmasuk(id,id_barang,tgl_masuk,nama_barang,jumlah_barang,jenis_barang) values ('$idmasuk','$idbarang','$tglmasuk','$namabarang','$jumlahmasuk','$jenis')";
                if (mysqli_query($koneksi, $qadd)) {
                    $sukses = "Berhasil memasukkan data baru";
                } else {
                    $error = "Gagal update data";
                }
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat datang</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="js/scripts.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
                        <?php
                        include 'connect.php';
                        if (!isset($_SESSION['username']) || $_SESSION['roles'] == 'Manajer') { ?>
                            <a class="nav-link" href="index.php?cari=">Data barang</a>
                            <a class="nav-link" href="barangmasuk.php?cari=">Barang masuk</a>
                            <a class="nav-link" href="barangkeluar.php?cari=">Barang keluar</a>
                            <?php
                        } else { ?>
                            <a class="nav-link" href="index.php?cari=">Data barang</a>
                            <a class="nav-link" href="barangmasuk.php?cari=">Barang masuk</a>
                            <?php
                        } ?>
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
                                Buat / Edit Data
                            </div>
                            <div class="card-body">
                                <?php if ($error) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error ?>
                                    </div>
                                    <?php
                                    header("refresh:5;url=index.php?cari=");
                                } ?>
                                <?php if ($sukses) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <?php echo $sukses ?>
                                    </div>
                                    <?php
                                    header("refresh:5;url=index.php?cari=");
                                } ?>

                                <?php
                                include 'connect.php';
                                if (!isset($_SESSION['username']) || $_SESSION['roles'] == 'Manajer') { ?>
                                    <form action="" method="POST">
                                        <div class="mb-3 row" hidden>
                                            <label for="id_masuk" class="col-sm-2 col-form-label">ID masuk</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="id_masuk" name="id_masuk"
                                                    value="">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="tgl_masuk" class="col-sm-2 col-form-label">Tanggal masuk</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tgl_masuk" name="tgl_masuk"
                                                    readonly>
                                            </div>
                                        </div>
                                        <script>
                                            document.getElementById("tgl_masuk").value = "<?php echo $tglmasuk; ?>";
                                        </script>
                                        <div class="mb-3 row">
                                            <label for="idbarang" class="col-sm-2 col-form-label">ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="id_barang" name="id_barang"
                                                    value="<?php echo $idbarang ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="namabarang" class="col-sm-2 col-form-label">Nama barang</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                                    value="<?php echo $namabarang ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="jumlahmasuk" class="col-sm-2 col-form-label">Jumlah barang
                                                masuk</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="jumlah_masuk"
                                                    name="jumlah_masuk">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="jenis" class="col-sm-2 col-form-label">Jenis barang</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="jenis_barang" id="jenis_barang"
                                                    value="<?php echo $jenis ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="harga" class="col-sm-2 col-form-label">Harga satuan</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="harga_barang" id="harga_barang"
                                                    value="<?php echo $harga ?>">
                                            </div>
                                        </div>
                                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                                    </form>

                                    <?php
                                } else { ?>
                                    <form action="" method="POST">
                                        <div class="mb-3 row" hidden>
                                            <label for="id_masuk" class="col-sm-2 col-form-label">ID masuk</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="id_masuk" name="id_masuk"
                                                    value="">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="tgl_masuk" class="col-sm-2 col-form-label">Tanggal masuk</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tgl_masuk" name="tgl_masuk"
                                                    readonly>
                                            </div>
                                        </div>
                                        <script>
                                            document.getElementById("tgl_masuk").value = "<?php echo $tglmasuk; ?>";
                                        </script>
                                        <div class="mb-3 row">
                                            <label for="idbarang" class="col-sm-2 col-form-label">ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="id_barang" name="id_barang"
                                                    value="<?php echo $idbarang ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="namabarang" class="col-sm-2 col-form-label">Nama barang</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                                    value="<?php echo $namabarang ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="jumlahmasuk" class="col-sm-2 col-form-label">Jumlah barang
                                                masuk</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="jumlah_masuk"
                                                    name="jumlah_masuk">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="jenis" class="col-sm-2 col-form-label">Jenis barang</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="jenis_barang" id="jenis_barang"
                                                    value="<?php echo $jenis ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row" hidden>
                                            <label for="harga" class="col-sm-2 col-form-label">Harga satuan</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" name="harga_barang" id="harga_barang"
                                                    value="<?php echo $harga ?>">
                                            </div>
                                        </div>
                                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header text-white bg-secondary">
                                Data barang
                            </div>

                            <div class="card-body">
                                <form method="GET" action="index.php">
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

                                <br>
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

                                    <?php
                                    $pencarian = "";
                                    $jenis_barang_filter = "";

                                    if (isset($_GET['cari'])) {
                                        $pencarian = $_GET['cari'];
                                    }

                                    if (isset($_GET['jenis'])) {
                                        $jenis_barang_filter = $_GET['jenis'];
                                    }

                                    $qc = "select * from databarang where (nama_barang like '%$pencarian%')";

                                    if (!empty($jenis_barang_filter)) {
                                        $qc .= " and jenis_barang = '$jenis_barang_filter'";
                                    }

                                    $qc .= " order by id_barang asc";
                                    $cr = mysqli_query($koneksi, $qc);
                                    ?>
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
                                                    <a href="index.php?op=edit&cari=&id=<?php echo $idbarang ?>"><button
                                                            type="button" class="btn btn-warning">Edit</button></a>
                                                    <a href="index.php?op=delete&cari=&id=<?php echo $idbarang ?>"
                                                        onclick="return confirm('Yakin mau delete data?')"><button
                                                            type="button" class="btn btn-danger">Delete</button></a>
                                                </td>
                                            </tr>
                                            <?php
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
</body>

</html>