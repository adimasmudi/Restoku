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

$details = explode('?',$link)[1];

$id_pelanggan = explode('=',explode('-',$details)[0])[1];
$id_menu = explode('=',explode('-',$details)[1])[1];

$sql = "SELECT * FROM pelanggan WHERE ID_Pelanggan=:id_pelanggan";

$stmt = $db->prepare($sql);

$stmt->execute([
    ":id_pelanggan" => $id_pelanggan
]);

$pelanggan = $stmt->fetch(PDO::FETCH_ASSOC);


$get_menu = "SELECT * FROM menu WHERE ID_menu=:id_menu";

$preparation = $db->prepare($get_menu);

$preparation->execute([
    ":id_menu" => $id_menu
]);

$menu = $preparation->fetch(PDO::FETCH_ASSOC);

// update status pesanan
$sql_update = "UPDATE pemesanan set status=:status WHERE ID_pelanggan=:id_pelanggan AND ID_menu=:id_menu";
$update_prepare = $db->prepare($sql_update);

$update_prepare->execute([
    ":status" => "Di proses",
    ":id_pelanggan" => $id_pelanggan,
    ":id_menu" => $id_menu
]);

if(isset($_POST["bayar"])){
    $kuantitas = filter_input(INPUT_POST, 'kuantitas', FILTER_SANITIZE_STRING);

    // // header('Location')
    $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
    $tgl = $date->format('y-m-d H:i:s');

    // $date = new Datetime();
    $prepare_data = $db->prepare("INSERT INTO detail_pesanan (ID_pelanggan, ID_menu, Nama_pesanan, Tgl_pesanan, jumlah_pesanan, ongkir, Total_harga)
    VALUES (:id_pelanggan, :id_menu, :nama_pesanan, :tgl_pesanan, :jumlah_pesanan, :ongkir, :total_harga)
    ");

    $saved = $prepare_data->execute([
        ":id_pelanggan" => $id_pelanggan,
        ":id_menu" => $id_menu,
        ":nama_pesanan" => $menu["Nama_menu"],
        ":tgl_pesanan" => $tgl,
        ":jumlah_pesanan" => $kuantitas,
        ":ongkir" => 5000,
        ":total_harga" => ($menu["Harga_menu"]*intval($kuantitas)) - ($menu["Diskon"]*intval($kuantitas)) + 5000
    ]);

    // alihkan ke halaman bukti bayar
    if($saved) header("Location:bukti_pembayaran.php?".$tgl);
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
    <title>Detail Pembayaran</title>
</head>
<body style='overflow : hidden'>
   <div class="paid-box bg-light w-75 h-75" style="margin:100px auto;border-radius:10px;padding:20px">
        <h1 class="text-center">Detail Pesanan</h1>
        <form action="" method="POST" class="text-center mt-2">
            <div class="container">
                <div class="row row-menu bg-light mb-5pt-4 pb-4 pe-4 ps-4" style="border-radius:10px">
                    <div class="col-lg-2 col-md-12 col-15 ">
                        <img class="size img-fluid" src="<?php echo $menu["Gambar_menu"]; ?>" alt="<?php echo $menu["Nama_menu"]; ?>">
                    </div>
                    <div class="col-8">
                        <h3><?php echo $menu["Nama_menu"]; ?></h3>
                        <h6><?php echo $menu["Komposisi"]; ?></h6>
                        <div>
                            <input type="number" class="kuantitas" name="kuantitas" placeholder="kuantitas">
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>Pesanan anda adalah <?php echo $menu["Nama_menu"]; ?> sebanyak <span class="quantity">0</span></p>
                        <p>harga : <input type="text" name="price"  class="price" disabled value="<?php echo $menu["Harga_menu"]; ?>"></p>
                        <p>Diskon :<input type="text"  name="diskon" class="disc" disabled value="<?php echo $menu["Diskon"]; ?>"></p>
                        <p>Ongkir :<input type="text"  name="ongkir" class="ongkir" disabled value="<?php echo 5000 ?>"></input></p>
                        <!-- <p>Total Harga :<input type="text"  name="total_harga" class="total" disabled></input></p> -->
                    </div>

                </div>
            </div>
            <input type="submit" name="bayar" class="submit w-25 btn bgd-primary" value="Lakukan Pembayaran"></input>
        </form>
   </div>

    <script>
        // let kuantitas = document.querySelector(".kuantitas");
        // let quantity = document.querySelector(".quantity");
        // let price = document.querySelector(".price");
        // let disc = document.querySelector(".disc");
        // let ongkir = document.querySelector(".ongkir");
        // let total = document.querySelector(".total");

        // const submitted = document.querySelector('.submit');

        
        // let attOngkir = document.createAttribute('value');
        // attOngkir.value = 5000;
        // ongkir.setAttributeNode(attOngkir);
        // ongkir.innerHTML = 5000;

        // kuantitas.addEventListener("change",function(){
        //     let attquantity = document.createAttribute('value');
        //     attquantity.value = Number(this.value);
        //     quantity.setAttributeNode(attquantity);
        //     quantity.innerHTML = Number(this.value);

        
        //     let atttotal = document.createAttribute('value');
        //     atttotal.value = (Number(price.value) * this.value) + Number(ongkir.value) - (Number(disc.value) * this.value);
        //     total.setAttributeNode(atttotal);
        //     total.innerHTML = (Number(price.value) * this.value) + Number(ongkir.value) - (Number(disc.value) * this.value);
             
        // })

        

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
