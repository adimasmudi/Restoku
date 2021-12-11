<?php

require_once('../config.php');
require_once('../auth.php');

// Program to display URL of current page.
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
$link = "https";
else $link = "http";

// Here append the common URL characters.
$link .= "://";

// Append the host(domain name, ip) to the URL.
$link .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
$link .= $_SERVER['REQUEST_URI'];

$tgl = str_replace("%20"," ",explode('?',$link)[1]);

$get_data = $db->prepare("SELECT * FROM detail_pesanan WHERE Tgl_pesanan=:tgl_pesanan");

$get_data->execute([
    ":tgl_pesanan" => $tgl
]);

$menu_pesanan = $get_data->fetch(PDO::FETCH_ASSOC);

$get_pelanggan = $db->prepare("SELECT * FROM pelanggan WHERE ID_Pelanggan=:ID_Pelanggan");

$get_pelanggan->execute([
    ":ID_Pelanggan" => $menu_pesanan["ID_pelanggan"]
]);

$pelanggan = $get_pelanggan->fetch(PDO::FETCH_ASSOC);

$get_menu = $db->prepare("SELECT * FROM menu WHERE ID_menu=:ID_menu");

$get_menu->execute([
    ":ID_menu" => $menu_pesanan["ID_menu"]
]);

$menu = $get_menu->fetch(PDO::FETCH_ASSOC);



// udah bayar
if(isset($_POST["kirim-bukti"])){
    if(array_key_exists('upload-bayar',$_FILES)){
        if($_FILES['upload-bayar']['name']){
            $temp = explode(".", $_FILES["upload-bayar"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            move_uploaded_file($_FILES['upload-bayar']['tmp_name'], "../../Assets/Images/bayar/".$newfilename);
            $img = "../../Assets/Images/bayar/".$newfilename;
        }else{
            echo "<script>alert('upload bukti bayar terlebih dahulu')</script>";
        }
    }else{
        echo "hmm";
    }

    // tanggal
    // // header('Location')
    $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
    $tanggal = $date->format('y-m-d H:i:s');

    $sql = "INSERT INTO pembayaran (ID_admin,ID_pesanan,tgl_bayar,bukti_bayar)
    VALUES (:id_admin, :id_pesanan, :tgl_bayar, :bukti_bayar)
    ";

    $stmt = $db->prepare($sql);

    // bind
    $params = array(
        ":id_admin" => 1,
        ":id_pesanan" => $menu_pesanan["ID_pesanan"],
        ":tgl_bayar" => $tanggal,
        ":bukti_bayar" => $img
    );

    // eksekusi dan simpan ke database
    $saved = $stmt->execute($params);


    if($saved) header('Location:finish.php');
}




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
    <title>wellcome</title>
</head>
<body>
    <div class="container text-center paid-box bg-light pt-4 pb-4 ps-4 pe-4 mt-4 mb-5">
        <form action="#" method="POST" enctype="multipart/form-data" >
            <div class="row">
                <div class="col">
                    <h1>Pembayaran</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <p>Nama Pemesan : <?php echo $pelanggan['Nama_pelanggan']; ?></p>
                    <p>Nomer telepon : <?php echo $pelanggan['No_tlp_pelanggan']; ?></p>
                    <p>Dikirimkan ke Alamat : <?php echo $pelanggan['Alamat']; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <h4>Jenis Pesanan</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <img src="<?php echo $menu["Gambar_menu"];?>" class="size img-fluid" alt="<?php echo $menu["Nama_menu"];?>">
                </div>
                <div class="col-6">
                    <p>Nama menu: <?php echo $menu['Nama_menu']; ?></p>
                    <p>Kategori : 
                        <?php 
                            if($menu["ID_kategori"] == 1){
                                echo "makanan";
                            }else if($menu["ID_kategori"] == 2){
                                echo "minuman";
                            }else{
                                echo "camilan";
                            }
                        ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <h4>Pembayaran</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>Harga menu : <?php echo $menu["Harga_menu"]; ?></p>
                    <p>Diskon : <?php echo $menu["Diskon"]; ?></p>
                    <p>Ongkir : <?php echo $menu_pesanan["ongkir"]; ?></p>
                    <p>Total Harga :  <?php echo $menu_pesanan["Total_harga"]; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div>Untuk melakukan pembayaran terhadap pesanan anda, Silahkan transfer ke No Rekening berikut:</div>
                    <h5>BRI : 996 - 432453 - 45345 - 211323</h5>
                    <div>A.N Masmudi</div>
                </div>
            </div>
            <div class="row justify-content-evenly">
                <div class="col-5 d-flex flex-row">
                    <label for="bayar-upload">Upload bukti bayar</label>
                    <input type="file" id="bayar-upload" name="upload-bayar" class="form-control w-50 ms-3">
                </div>
                <div class="col-5">
                    <input type="submit" name="kirim-bukti" class="btn bgd-primary" value="selesai">
                </div>
            </div>
        </form>
        

        
    </div>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
