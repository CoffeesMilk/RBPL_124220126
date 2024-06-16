<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login form</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <script src="js/scripts.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body class="bg-log">



    <div class="form-container">

        <form action="db.php" method="POST">
            <h3>Login</h3>
            <?php
            if (isset($error)) {
                    echo '<span class="error-msg">' . $error . '</span>';
            }
            ;
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
            <button type="submit" name="submit" class="btn btn-outline-primary">Login</button>


        </form>

    </div>

</body>

</html>