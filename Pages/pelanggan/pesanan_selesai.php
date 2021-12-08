<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../../Assets/style/style.css">
    <title>Halaman Menu</title>
</head>
<body style='overflow : hidden'>

    <div class="main-tab">
        <div class="container-fluid">
           <div class="d-flex justify-content-center bgd-NonActive">
                <div class="col d-flex justify-content-center ">
                    <a href="pesanan_belum_bayar.php">Belum Bayar</a>
                </div>
                <div class="col d-flex justify-content-center ">
                    <a href="pesanan_diproses.php">Di proses</a>
                </div>
                <div class="col d-flex justify-content-center bgd-Active">
                    <a href="pesanan_selesai.php">Selesai</a>
            </div>
        </div>
    </div>
    <div>
        <h3 class="display_text">Riwayat Pesanan</h3> 
        <h6 class="display_text">Jika Pesanan anda sudah diterima dalam keadaaan baik silahkan klik Pesanan Selesai</h6>
    </div>
    <a class="tombol3" href="index.html">Pesanan Selesai</a>

    <div class="main-menu">
        <div class="container-fluid" style="height:100px">
            <div class="row bgd-secondary">
                <div class="col d-flex justify-content-center">
                    <a href="index.php"><span>Wellcome</span></a>
                </div>
                <div class="col d-flex justify-content-center ">
                    <a href="menu_makanan.php"><span>menu</span></a>
                </div>
                <div class="col d-flex justify-content-center bgd-primary">
                    <a href="pesanan_belum_bayar.php"><span>Pesanan</span></a>
                </div>
                <div class="col d-flex justify-content-center ">
                    <a href="profil.php"><span>Update Profil</span></a>
                </div>
                <div class="col d-flex justify-content-center ">
                    <a href="../logout.php"><span>Logout</span></a>
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>