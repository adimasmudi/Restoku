<?php
require_once('../auth.php');
require_once('../config.php');

if(isset($_POST['tambah_menu'])){
    // inputan
    $nama_menu = filter_input(INPUT_POST, 'nama_menu', FILTER_SANITIZE_STRING);
    $kategori = $_POST["kategori"];
    $komposisi = filter_input(INPUT_POST, 'komposisi', FILTER_SANITIZE_STRING);

    // bagian number
    $harga_menu = filter_input(INPUT_POST, 'harga_menu', FILTER_VALIDATE_INT);
    $diskon = filter_input(INPUT_POST, 'diskon', FILTER_VALIDATE_INT);
    $ketersediaan = filter_input(INPUT_POST, 'ketersediaan', FILTER_VALIDATE_INT);

    if(array_key_exists('foto_menu',$_FILES)){
        if($_FILES['foto_menu']['name']){
            mkdir("../../Assets/Images/menu/".$kategori."/".$nama_menu);
            $temp = explode(".", $_FILES["foto_menu"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            move_uploaded_file($_FILES['foto_menu']['tmp_name'], "../../Assets/Images/menu/$kategori/".$nama_menu."/".$newfilename);
            $img = "../../Assets/Images/menu/$kategori/".$nama_menu."/".$newfilename;
        }
    }

    // mengambil id_kategori
    $GET_id_kat = $db->prepare("SELECT * FROM kategori WHERE Nama_kategori=:nama_kategori");
    $GET_id_kat->execute([
        ':nama_kategori' => $kategori
    ]);

    $id_kategori = $GET_id_kat->fetch(PDO::FETCH_ASSOC);
    

    // menyiapkan query
    $sql = "INSERT INTO menu (ID_kategori, Nama_menu, Gambar_menu, Komposisi, Harga_menu, Diskon, Ketersediaan)
        VALUES (:id_kategori, :nama_menu, :gambar_menu, :komposisi, :harga_menu, :diskon, :ketersediaan)
    ";

    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":id_kategori" => $id_kategori["ID_Kategori"],
        ":nama_menu" => $nama_menu,
        ":gambar_menu" => $img,
        ":komposisi" => $komposisi,
        ":harga_menu" => $harga_menu,
        ":diskon" => $diskon,
        ":ketersediaan" => $ketersediaan
    );

    // eksekusi dan simpan ke database
    $saved = $stmt->execute($params);

    // alihkan ke halaman wellcome jika berhasil
    if($saved) header("Location:index_admin.php");
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
    <title>Tambah Menu Menu</title>
</head>
<body style='overflow : hidden'>
    <div class="container-md mt-5">
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="row mb-4">
                <h2 class="text-center">Tambah Menu</h2>
            </div>
            <div class="row mb-4 justify-content-between">
                <div class="col-md-3">
                    <input type="file" name="foto_menu" value="upload foto" class="form-control" style="height:35px; margin:10px">
                </div>
                <div class="col-md-3">
                    <input type="text" name="nama_menu" class="form-control" placeholder="Nama Menu">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-5">
                    <span>Kategori : </span>
                    <label for="Makanan">Makanan</label>
                    <input type="radio" id="Makanan" name="kategori" value="Makanan">
                    <label for="Minuman">Minuman</label>
                    <input type="radio" id="Minuman" name="kategori" value="Minuman">
                    <label for="Camilan">Camilan</label>
                    <input type="radio" id="Camilan" name="kategori" value="Camilan">
                </div>
            </div>
            <div class="row mb-4">
                <div class="form-floating">
                    <textarea class="form-control" name="komposisi" placeholder="Masukkan Komposisi" id="Komposisi" style="height: 100px"></textarea>
                    <label for="Komposisi">Komposisi</label>
                </div>
            </div>
            <div class="row mb-4 justify-content-between">
                <div class="col-3">
                    <input type="number" name="harga_menu" class="form-control" placeholder="Harga Menu">
                </div>
                <div class="col-3">
                    <input type="number" name="diskon" class="form-control" placeholder="Diskon">
                </div>
                <div class="col-3">
                    <input type="number" name="ketersediaan" class="form-control" placeholder="Ketersediaan">
                </div>
            </div>
            <div class="row mt-2 justify-content-center">
                <div class="col-md-4">
                    <input type="submit" name="tambah_menu" value="Tambahkan Menu" class="btn bgd-primary w-50">
                </div>
            </div>
        </form>
    </div>
    
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>