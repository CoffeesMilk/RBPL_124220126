<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-log">
    <div class="form-container">

        <form action="db.php" method="POST">
            <h3>Login</h3>
            <?php
            if (isset($error)) {
                    echo '<span class="error-msg">' . $error . '</span>';
            }
            if (isset($_GET['pesan'])) {
                if ($_GET['pesan'] == "gagal") {
                    echo '<a class="text-danger"><b>Login gagal! username atau password salah!</b></a>';
                } elseif ($_GET['pesan'] == "logout") {
                    echo '<a class="text-success"><b>Anda telah berhasil logout</b></a>';
                } elseif ($_GET['pesan'] == "bukan_manajer") {
                    echo '<a class="text-danger"><b>Maaf, sepertinya anda tidak memiliki akses manajer</b></a>';
                } elseif ($_GET['pesan'] == "bukan_staffgudang") {
                    echo '<a class="text-danger"><b>Maaf, sepertinya anda tidak memiliki akses staffgudang</b></a>';
                } elseif ($_GET['pesan'] == "bukan_kasir") {
                    echo '<a class="text-danger"><b>Maaf, sepertinya anda tidak memiliki akses kasir</b></a>';
                } elseif ($_GET['pesan'] == "daftar_berhasil") {
                    echo '<a class="text-success"><b>Sukses daftar akun, silahkan login!</b></a>';
                }
            }
            ?>
            <input type="username" name="username" required placeholder="enter your username">
            <input type="password" name="password" required placeholder="enter your password">
            <button type="submit" name="submit" class="btn btn-primary">Login</button>


        </form>

    </div>

</body>

</html>