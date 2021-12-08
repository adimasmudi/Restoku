<?php

require_once('../auth.php');
require_once('../config.php');

$username_pelanggan = $_SESSION["user"]["Username_pelanggan"];

$pelanggan = 'SELECT * FROM pelanggan WHERE Username_pelanggan=:username';
$stmt = $db->prepare($pelanggan);

// bind parameter ke query
$params = array(
    ":username" => $username_pelanggan
);

$stmt->execute($params);

$profil = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['edit'])){
    // filter data yang diinputkan
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    $username = $profil['Username_pelanggan'];
    
    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // alamat dan pekerjaan
    $alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);
    $pekerjaan = filter_input(INPUT_POST, 'pekerjaan', FILTER_SANITIZE_STRING);
    $nomer_hp = filter_input(INPUT_POST, 'nomer-hp', FILTER_VALIDATE_INT);
    
    // image upload
    if(array_key_exists('photo',$_FILES)){
        if($_FILES['photo']['name']){
            unlink("../".$profil['Foto_Pelanggan']);
            move_uploaded_file($_FILES['photo']['tmp_name'], "../../Assets/Images/user/$username/".$_FILES['photo']['name']);
            $img="../../Assets/Images/user/$username/".$_FILES['photo']['name'];
        }
    }else{
        echo "<script>alert('Anda harus mengupload foto');</script>";
        
    }

    // menyiapkan query
    $sql = "UPDATE pelanggan set Nama_pelanggan=:nama,Username_pelanggan=:username,Foto_Pelanggan=:photo,Email_pelanggan=:email,Password_pelanggan=:password,Alamat=:alamat,Pekerjaan=:pekerjaan,No_tlp_pelanggan=:no_tlp WHERE Username_pelanggan=:username";
    $stmt = $db->prepare($sql);

    // bind parameter ke query
    $params = array(
        ":nama" => $nama,
        ":username" => $username,
        ":photo" => $img,
        ":email" => $email,
        ":password" => $password,
        ":alamat" => $alamat,
        ":pekerjaan" => $pekerjaan,
        ":no_tlp" => $nomer_hp
    );

    // eksekusi query untuk menyimpan ke database
    $saved = $stmt->execute($params);

    // jika query simpan berhasil, maka user sudah terupdate
    // maka alihkan ke halaman wellcome
    if($saved) header("Location: index.php");
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
    <title>Profil</title>
</head>
<body style="overflow:hidden">
    <div class="container-fluid mt-5 profile-box">
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="text-center mt-4">Edit Profil</h1>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 d-flex flex-row">
                    <?php 
                    $old_path = $profil["Foto_Pelanggan"];
                    $path_split = explode('/',$old_path);
                    if($path_split[0] == '..' AND $path_split[1] == '..'){
                        $path = $old_path;
                    }else{
                        $path = "../".$old_path;
                    }
                    ?>
                    <img src="<?php echo $path; ?>" alt="profil" class="foto-profil">
                    
                    <input type="file" name="photo" value="upload foto" class="form-control" style="height:35px; margin:10px">
                </div>
                <div class="col-md-6 d-flex justify-content-center"></div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 d-flex justify-content-center">
                    <input type="text" name="nama" placeholder="nama" class="form-control " value="<?php echo $profil["Nama_pelanggan"]?>">
                </div>
                <div class="col-md-6 ps-5">
                    <input type="email" name="email" placeholder="email" class="form-control " value="<?php echo $profil["Email_pelanggan"]?>">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 d-flex justify-content-center">
                    <input type="password" name="password" placeholder="password" class="form-control ">
                </div>
                <div class="col-md-6 ps-5">
                    <input type="text" name="alamat" placeholder="alamat" class="form-control " value="<?php echo $profil["Alamat"] ?>">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 d-flex justify-content-center">
                    <input type="text" name="pekerjaan" placeholder="pekerjaan" class="form-control " value="<?php echo $profil["Pekerjaan"] ?>">
                </div>
                <div class="col-md-6 d-flex justify-content-center">
                    <divc class="d-flex flex-row ps-5">
                        <input type="text" disabled value="+62" class="w-25 form-control mx-2">
                        <input type="number" name="nomer-hp" placeholder="nomer hp" class="w-50 form-control " value="<?php echo $profil["No_tlp_pelanggan"]?>">
                    </divc>
                </div>
            </div>
            <div class="row mb-4 justify-content-center">
                <div class="col-md-6 d-flex justify-content-center">
                    <input type="submit" name="edit" value="ubah profil" class="btn bgd-primary w-50">
                </div>
            </div>
            
        </form>
    </div>

    <div class="main-menu">
        <div class="container-fluid" style="height:100px">
            <div class="row bgd-secondary">
                <div class="col d-flex justify-content-center">
                    <a href="index.php"><span>Wellcome</span></a>
                </div>
                <div class="col d-flex justify-content-center ">
                    <a href="menu_makanan.php"><span>menu</span></a>
                </div>
                <div class="col d-flex justify-content-center ">
                    <a href="pesanan_belum_bayar.php"><span>Pesanan</span></a>
                </div>
                <div class="col d-flex justify-content-center bgd-primary">
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