<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['username']) || ($_SESSION['roles'] !== 'Manajer' && $_SESSION['roles'] !== 'Kasir')) {
    header('Location: login_form.php?pesan=bukan_manajer');
    exit();
}
$idpesanan = "";
$idbarang = "";
$nobon = "";
$tglpesanan = date("d/m/Y");
$namabarang = "";
$jumlah = "";
$jenis = "";
$total = "";
$sukses = "";
$error = "";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat datang</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
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

                        <?php
                        include 'connect.php';
                        if (!isset($_SESSION['username']) || $_SESSION['roles'] == 'Manajer') { ?>
                            <a class="nav-link" href="index.php?cari=">Data barang</a>
                            <a class="nav-link" href="barangmasuk.php?cari=">Barang masuk</a>
                            <a class="nav-link" href="barangkeluar.php?cari=">Barang keluar</a>
                            <?php
                        } else { ?>
                            <a class="nav-link" href="pemesanan.php?cari=">Data barang</a>
                            <a class="nav-link" href="barangkeluar.php?cari=">Barang keluar</a>
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
                    <h1 class="mt-4">Laporan</h1>
                    <div class="mx-auto">
                        <div class="card">
                            <div class="card-header text-white bg-secondary">
                                Data barang keluar
                            </div>

                            <div class="card-body">
                                <form method="GET" action="barangkeluar.php">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input class="form-control" id="cari" name="cari"
                                                placeholder="Masukkan tanggal atau no bon">
                                        </div>
                                        <div class="col-md">
                                            <button type="submit" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </form>
                                <br>

                                <?php
                                include 'connect.php';
                                $pencarian = "";
                                if (isset($_GET['cari'])) {
                                    $pencarian = $_GET['cari'];
                                    $nobon = $_GET['cari'];
                                    $qc = "select * from pesanan where tgl_pesanan like '%$pencarian%' or no_bon like '%$nobon%' order by tgl_pesanan ASC, no_bon ASC";
                                    $cr = mysqli_query($koneksi, $qc);

                                    $data_by_date = [];
                                    while ($r = mysqli_fetch_array($cr)) {
                                        $tglpesanan = $r['tgl_pesanan'];
                                        if (!isset($data_by_date[$tglpesanan])) {
                                            $data_by_date[$tglpesanan] = [];
                                        }
                                        $data_by_date[$tglpesanan][] = $r;
                                    }
                                    ?>

                                    <div class="accordion" id="accordionExample">
                                        <?php
                                        $sorted_data = [];
                                        foreach ($data_by_date as $date => $orders) {
                                            $sorted_data[] = [
                                                'date' => DateTime::createFromFormat('d/m/Y', $date),
                                                'orders' => $orders
                                            ];
                                        }

                                        usort($sorted_data, function ($a, $b) {
                                            return $b['date']->format('Ym') <=> $a['date']->format('Ym');
                                        });

                                        foreach ($sorted_data as $data) {
                                            $date = $data['date']->format('d/m/Y');
                                            $orders = $data['orders'];
                                            $unique_id = str_replace('/', '-', $date);
                                            ?>
                                            <div class="card">
                                                <div class="card-header" id="heading<?php echo $unique_id; ?>">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                                            data-target="#collapse<?php echo $unique_id; ?>"
                                                            aria-expanded="true"
                                                            aria-controls="collapse<?php echo $unique_id; ?>">
                                                            <?php echo $date; ?>
                                                        </button>
                                                    </h2>
                                                </div>

                                                <div id="collapse<?php echo $unique_id; ?>" class="collapse"
                                                    aria-labelledby="heading<?php echo $unique_id; ?>"
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">No. Bon</th>
                                                                    <th scope="col">Nama barang</th>
                                                                    <th scope="col">Jumlah barang</th>
                                                                    <th scope="col">Jenis barang</th>
                                                                    <th scope="col">Total harga</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $nomor = 1;
                                                                foreach ($orders as $order) {
                                                                    $idpesanan = $order['id'];
                                                                    $nobon = $order['no_bon'];
                                                                    $namabarang = $order['nama_barang'];
                                                                    $jumlah = $order['jumlah_barang'];
                                                                    $jenis = $order['jenis_barang'];
                                                                    $total = $order['total_harga'];
                                                                    ?>
                                                                    <tr>
                                                                        <td scope="row"><?php echo $nomor++; ?></td>
                                                                        <td scope="row"><?php echo $nobon; ?></td>
                                                                        <td scope="row"><?php echo $namabarang; ?></td>
                                                                        <td scope="row"><?php echo $jumlah; ?></td>
                                                                        <td scope="row"><?php echo $jenis; ?></td>
                                                                        <td scope="row"><?php echo $total; ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>


                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>