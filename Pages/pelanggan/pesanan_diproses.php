<?php 

require_once('../auth.php');
require_once('../config.php');

$id_pelanggan = $_SESSION["user"]["ID_Pelanggan"];

// ambil menu yang dipesan
$menu = $db->prepare("SELECT * FROM pemesanan WHERE status=:status");

$menu->execute([
    ":status" => "Di proses"
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
                <div class="col d-flex justify-content-center ">
                    <a href="pesanan_belum_bayar.php">Belum Bayar</a>
                </div>
                <div class="col d-flex justify-content-center bgd-Active">
                    <a href="pesanan_diproses.php">Di proses</a>
                </div>
                <div class="col d-flex justify-content-center ">
                    <a href="pesanan_selesai.php">Selesai</a>
            </div>
        </div>
    </div>
    <!--content-->
    <!--Proses Pesanan -->
    <form action="#" method="POST">
        
        <section class="container my-3 pt-3 pb-3" >
            <?php
                while($row = $menu->fetch()){
                    $get_menu = $db->prepare("SELECT * FROM menu WHERE ID_menu=:id_menu");
                    $params = array(
                        ":id_menu" => $row["ID_menu"]
                    );


                    $get_menu->execute($params);
                    $menu_display= $get_menu->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="row row-menu bg-light mb-5pt-4 pb-4 pe-4 ps-4" style="border-radius:10px">
                <div class=" col-lg-1">
                    
                </div>
                <div class="col-lg-2 col-md-12 col-15 ">
                    <img class="size img-fluid" src="<?php echo $menu_display["Gambar_menu"]; ?>" alt="<?php echo $menu_display["Nama_menu"]; ?>">
                </div>
                <div class="col-8">
                    <div class="row justify-content-between">
                        <div class="col-5">
                            <h3><?php echo $menu_display["Nama_menu"]; ?></h3> 
                        </div>
                        <div class="col-1">
                            <span class="text-danger text-right">
                                <?php
                                    if($menu_display["ID_kategori"] == 1){
                                        echo "makanan";
                                    }else if($menu_display["ID_kategori"] == 2){
                                        echo "minuman";
                                    }else{
                                        echo "camilan";
                                    }
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <del>Rp. <?php echo $menu_display["Harga_menu"]; ?></del> &nbsp &nbsp Rp.<?php echo $menu_display["Harga_menu"]-$menu_display["Diskon"]; ?>
                        </div>
                    </div>
                   <div class="row">
                        <div class="col-6 mt-4">
                            <a href="pesanan_selesai.php?id_pelanggan=<?php echo $id_pelanggan; ?>-id_menu=<?php echo $menu_display["ID_menu"]; ?>" name="proses_pesanan" class="btn tombol2">Tandai Selesai</a>
                        </div>
                   </div>
                    
                </div>
                
                
            </div>
            <br>
            <?php } ?>
        </section>
    </form>
    
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