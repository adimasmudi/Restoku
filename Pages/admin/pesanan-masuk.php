<?php

require_once('../auth.php');
require_once('../config.php');

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
    <title>Pesanan Masuk</title>
</head>
<body>
    <div class="main-tab">
        <div class="container-fluid w-50">
            <div class="d-flex justify-content-center bgd-NonActive" >
                <div class="col d-flex justify-content-center bgd-Active">
                    <a href="pesanan-masuk.php">Pesanan Masuk</a>
                </div>
                <div class="col d-flex justify-content-center ">
                    <a href="pesanan-siap.php">Pesanan Siap</a>
                </div>
            </div>
        </div>
    </div>
   <!--content-->
    <!--Proses Pesanan -->
    <form action="#" method="POST">
        
        <section class="container my-3 pt-3 pb-3" >
            <?php
                while($row = $menu->fetch()){

                    // get Pelanggan
                    $pelanggan = $db->prepare("SELECT * FROM pelanggan WHERE ID_Pelanggan=:id_pelanggan");

                    $pelanggan->execute([
                        ":id_pelanggan" => $row["ID_pelanggan"]
                    ]);

                    $data_pelanggan = $pelanggan->fetch(PDO::FETCH_ASSOC);

    

                    // get menu
                    $get_menu = $db->prepare("SELECT * FROM menu WHERE ID_menu=:id_menu");
                    $params = array(
                        ":id_menu" => $row["ID_menu"]
                    );


                    $get_menu->execute($params);
                    $menu_display= $get_menu->fetch(PDO::FETCH_ASSOC);


                    // get detail pesanan
                    $get_detail = $db->prepare("SELECT * FROM detail_pesanan WHERE ID_pelanggan=:id_pelanggan AND ID_menu=:id_menu");
                    $parameter = array(
                        ":id_pelanggan" => $row["ID_pelanggan"],
                        ":id_menu" => $row["ID_menu"]
                    );


                    $get_detail->execute($parameter);
                    $detail_display= $get_detail->fetch(PDO::FETCH_ASSOC);


        

            ?>
            <div class="row row-menu bg-light mb-5pt-4 pb-4 pe-4 ps-4" style="border-radius:10px">
                <div class=" col-lg-1">
                    
                </div>
                
                <div class="col-8">
                    <div class="row justify-content-between">
                        <div class="col-5">
                            <h3>Nama Pemesan : <?php echo $data_pelanggan["Nama_pelanggan"]; ?></h3>
                            <h3>Pesanan : <?php echo $menu_display["Nama_menu"]; ?></h3> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p>Kuantitas : <?php echo $detail_display["jumlah_pesanan"]; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <p>Total sudah di bayar : <?php echo $detail_display["Total_harga"]; ?></p>
                        </div> 
                    </div>
                   <div class="row">
                        <div class="col-6 mt-4">
                            <a href="pesanan-siap.php?id_pelanggan=<?php echo $data_pelanggan["ID_Pelanggan"]; ?>-id_menu=<?php echo $menu_display["ID_menu"]; ?>" name="verifikasi" class="btn tombol2">Verifikasi</a>
                        </div>
                   </div>
                    
                </div>
                
                
            </div>
            <br>
            <?php } ?>
        </section>
    </form>
    <!-- CONTENT -->
    <div class="main-menu">
        <div class="container-fluid" style="height:100px">
            <div class="row bgd-secondary">
                <div class="col d-flex justify-content-center ">
                    <a href="index_admin.php"><span>Wellcome</span></a>
                </div>
                <div class="col d-flex justify-content-center ">
                    <a href="menu_makanan_admin.php"><span>menu</span></a>
                </div>
                <div class="col d-flex justify-content-center bgd-primary">
                    <a href="pesanan-masuk.php"><span>Pesanan</span></a>
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