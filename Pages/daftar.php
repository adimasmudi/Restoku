<?php

require_once("config.php");

if(isset($_POST['daftar'])){

    // filter data yang diinputkan
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);

    
    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // alamat dan pekerjaan
    $alamat = filter_input(INPUT_POST, 'alamat', FILTER_SANITIZE_STRING);
    $pekerjaan = filter_input(INPUT_POST, 'pekerjaan', FILTER_SANITIZE_STRING);
    $nomer_hp = filter_input(INPUT_POST, 'nomer-hp', FILTER_VALIDATE_INT);

    
    // cek ketersediaan username
    $stmt = $db->prepare("SELECT Username_pelanggan FROM pelanggan WHERE Username_pelanggan = :username");
    $stmt->execute([
        'username' => $username
    ]);
    $user_exists = $stmt->fetch(PDO::FETCH_ASSOC);

    if(isset($user_exists) && !empty($user_exists)){
        echo '<script>alert("Username tersebut sudah ada");</script>';
    }else{

        // image upload
        if(array_key_exists('photo',$_FILES)){
            if($_FILES['photo']['name']){
                mkdir("../Assets/Images/user/".$username);
                move_uploaded_file($_FILES['photo']['tmp_name'], "../Assets/Images/user/$username/".$_FILES['photo']['name']);
                $img="../Assets/Images/user/$username/".$_FILES['photo']['name'];
            }
        }else{
            echo "tidak ada foto";
        }

        // menyiapkan query
        $sql = "INSERT INTO pelanggan (Nama_pelanggan, Username_pelanggan, Foto_Pelanggan  , Email_pelanggan, Password_pelanggan, Alamat, Pekerjaan, No_tlp_pelanggan) 
            VALUES (:nama, :username,:photo, :email, :password, :alamat, :pekerjaan, :no_tlp)";
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

        // jika query simpan berhasil, maka user sudah terdaftar
        // maka alihkan ke halaman login
        if($saved) header("Location: login.php");
    }

    
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

    <link rel="stylesheet" href="../Assets/style/style.css">
    <title>Daftar</title>
</head>
<body style="overflow:hidden">
    <div class="container-md bg-light mt-5 h-75 w-50" style="border-radius:10px">
        <form action="#" method="POST" enctype="multipart/form-data">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="text-center mt-4">Daftar</h1>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <input type="file" name="photo" value="upload foto" class="form-control">
                </div>
                <div class="col-md-6 ps-5">
                    <input type="text" name="username" placeholder="username" class="form-control ">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 d-flex justify-content-center">
                    <input type="text" name="nama" placeholder="nama" class="form-control ">
                </div>
                <div class="col-md-6 ps-5">
                    <input type="email" name="email" placeholder="email" class="form-control ">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 d-flex justify-content-center">
                    <input type="password" name="password" placeholder="password" class="form-control ">
                </div>
                <div class="col-md-6 ps-5">
                    <input type="text" name="alamat" placeholder="alamat" class="form-control ">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 d-flex justify-content-center">
                    <input type="text" name="pekerjaan" placeholder="pekerjaan" class="form-control ">
                </div>
                <div class="col-md-6 d-flex justify-content-center">
                    <divc class="d-flex flex-row ps-5">
                        <input type="text" disabled value="+62" class="w-25 form-control mx-2">
                        <input type="number" name="nomer-hp" placeholder="nomer hp" class="w-50 form-control ">
                    </divc>
                </div>
            </div>
            <div class="row mb-4 justify-content-center">
                <div class="col-md-6 d-flex justify-content-center">
                    <input type="submit" name="daftar" value="daftar" class="btn bgd-primary w-50">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 d-flex justify-content-center">
                    <p>sudah punya akun? <a href="login.php"><span>masuk</span></a></p>
                </div>
            </div>
        </form>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>