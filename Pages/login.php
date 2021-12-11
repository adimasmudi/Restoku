<?php 

require_once("config.php");

if(isset($_POST['login'])){

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if($username == 'admin'){
        $sql = "SELECT * FROM admin WHERE Username_admin=:username";
    }else{
        $sql = "SELECT * FROM pelanggan WHERE Username_pelanggan=:username";
    }

    
    $stmt = $db->prepare($sql);
    
    // bind parameter ke query
    $params = array(
        ":username" => $username
    );

    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    

    // jika user terdaftar
    if($user){
        if($username == 'admin'){
            // verifikasi password
            if($password == $user["Password_admin"]){
                // buat Session
                session_start();
                $_SESSION["admin"] = $user;
                // login sukses, alihkan ke halaman index pelanggan
                header("Location: admin/index_admin.php");
                
            }else{
                echo '<script>Useranme atau password salah</script>';
            }
        }else{
            // verifikasi password
            if(password_verify(trim($password),trim($user["Password_pelanggan"]))){
                // buat Session
                session_start();
                $_SESSION["user"] = $user;
                // login sukses, alihkan ke halaman index pelanggan
                header("Location: pelanggan/index.php");
                
            }else{
                echo '<script>Useranme atau password salah</script>';
            }
        }
    }else{
        echo '<script>Useranme atau password salah</script>';
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
    <title>Login</title>
</head>
<body>
    <div class="container h-75 w-50 d-flex justify-content-center align-items-center mt-5 ">
        <div class="login-box h-75 w-50 bg-light">
            <h1 class="text-center mt-2">Masuk</h1>
            <form action="#" method="POST" class="d-flex flex-column mt-4">
                <input type="text" name="username" placeholder="username" class="form-control w-50">
                <input type="password" name="password" placeholder="Password" class="form-control w-50">
                <input type="submit" name="login" value="submit" class="w-25 btn bgd-primary">
                <p class="text-center">Belum punya akun? <a href="daftar.php"><span class="text-primary">Daftar</span></a></p>
            </form>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>