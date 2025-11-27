<?php  
header("content-type: application/json; charset=UTF-8");
if ($_SERVER['REQUEST_METHOD']!='POST'){
    http_response_code (405);
    $res = [
        'status' => 'error',
        'msg' => 'methode salah!'
    ];
    echo json_encode($res);
    exit();
}
 

//validasi payload
$errors = [];
if(!isset($_POST['nim'])){
    $errors ['nim'] = "NIM belum dikirim";
}else{
    if ($_POST['nim'] == ''){
        $errors ['nim'] = " NIM tidak boleh kosong";
    }else{
        if(!preg_match('/^[1-9][0-9]{9}$/', $_POST['nim'])) {
            $errors ['nim'] = " format NIM harus angka 10 digit, angka awal tidak boleh 0 ";
        } 
    }
}

$errors = [];

// Validasi untuk nim
if(!isset($_POST['nim'])){
    $errors['nim'] = "NIM belum dikirim";
}else{
    if ($_POST['nim'] == ''){
        $errors['nim'] = "NIM tidak boleh kosong";
    }else{
        if(!preg_match('/^[1-9][0-9]{9}$/', $_POST['nim'])) {
            $errors['nim'] = "Format NIM harus angka 10 digit, angka awal tidak boleh 0";
        }
    }
}

// Validasi untuk nama
if(!isset($_POST['nama'])){
    $errors['nama'] = "Nama belum dikirim";
}else{
    if ($_POST['nama'] == ''){
        $errors['nama'] = "Nama tidak boleh kosong";
    }
}

if(count($errors) > 0){
    http_response_code(400);
    $res = [
        'status' => 'error',
        'msg' => "Error data",
        'errors' => $errors
    ];
    echo json_encode($res);
    exit();
}


//insert ke db
$koneksi = new mysqli('localhost','root', '', 'be');
$nim = $_POST ['nim'];
$nama = $_POST ['nama'];
$q = "INSERT INTO mahasiswa(nim,nama) VALUES ('$nim','$nama')";
$koneksi->query($q);
$id = $koneksi -> insert_id;

echo json_encode([
    'status' => 'success',
    'msg' => 'proses berhasil',
    'data' => [
        'id' => $id,
        'nim' => $nim,
        'nama' =>  $nama
    ]
]);