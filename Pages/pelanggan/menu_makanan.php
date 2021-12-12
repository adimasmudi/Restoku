<?php
require_once('../auth.php');
require_once('../config.php');
// mengambil data makanan
$makanan = $db->prepare("SELECT * FROM menu WHERE ID_kategori=:id_kategori");

$makanan->execute([
    ':id_kategori' => 1
]);

?>
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
<body>

    <div class="main-tab">
        <div class="container-fluid">
            <div class="d-flex justify-content-center bgd-NonActive">
                <div class="col d-flex justify-content-center bgd-Active">
                    <a href="menu_makanan.php"> Makanan</a>
                </div>
                <div class="col d-flex justify-content-center ">
                    <a href="menu_minuman.php">Minuman</a>
                </div>
                <div class="col d-flex justify-content-center ">
                    <a href="menu_camilan.php">Camilan</a>
            </div>
        </div>
    </div>
    <section class="container my-3 pt-3 pb-3" >
        <?php
                
                while($row=$makanan->fetch()){
                
        ?>
        <div class="row row-menu bg-light mb-5pt-4 pb-4 pe-4 ps-4" style="border-radius:10px">
            <div class="col-lg-2 col-md-12 col-15 ">
                <img class="size img-fluid" src="<?php echo $row['Gambar_menu']; ?>" alt="<?php echo $row['Nama_menu']; ?>">
            </div>
            <div class="col">
                <h3><?php echo $row['Nama_menu']; ?></h3>
                <h6><?php echo $row['Komposisi']; ?></h6>
                <h6 class=" clr mt-3">Tersedia : <?php echo $row['Ketersediaan']; ?> porsi</h6>
                <div class="d-flex justify-content-end">
                    <p><del>Rp. <?php echo $row['Harga_menu']; ?></del>  Rp.<?php echo $row['Harga_menu']-$row['Diskon']; ?></p>
                    <a class="tombol" href="pesanan_belum_bayar.php?<?php echo $row["ID_menu"]; ?>">Pesan</a>
                </div>
                
            </div>
        </div>
        <br>
        <?php } ?>
    </section>

    <div class="main-menu">
        <div class="container-fluid" style="height:100px">
            <div class="row bgd-secondary">
                <div class="col d-flex justify-content-center">
                    <a href="index.php"><span>Wellcome</span></a>
                </div>
                <div class="col d-flex justify-content-center bgd-primary">
                    <a href="menu_makanan.php"><span>menu</span></a>
                </div>
                <div class="col d-flex justify-content-center ">
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