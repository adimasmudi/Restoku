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
        <form action="#" method="POST">
            <div class="row mb-4">
                <h2 class="text-center">Tambah Menu</h2>
            </div>
            <div class="row mb-4 justify-content-between">
                <div class="col-md-3">
                    <input type="file" value="upload foto" class="form-control" style="height:35px; margin:10px">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Nama Menu">
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
                    <textarea class="form-control" placeholder="Masukkan Komposisi" id="Komposisi" style="height: 100px"></textarea>
                    <label for="Komposisi">Komposisi</label>
                </div>
            </div>
            <div class="row mb-4 justify-content-between">
                <div class="col-3">
                    <input type="text" class="form-control" placeholder="Harga Menu">
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" placeholder="Diskon">
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" placeholder="Ketersediaan">
                </div>
            </div>
            <div class="row mt-2 justify-content-center">
                <div class="col-md-4">
                    <input type="submit" value="Tambahkan Menu" class="btn bgd-primary w-50">
                </div>
            </div>
        </form>
    </div>
    
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>