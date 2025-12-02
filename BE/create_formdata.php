<?php
header("Content-Type: application/json; charset=UTF-8");

// Pastikan method POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'msg' => 'Method salah! Gunakan POST'
    ]);
    exit();
}

// Validasi payload
$errors = [];

$title = $_POST['title'] ?? '';
$author = $_POST['author'] ?? '';
$publisher = $_POST['publisher'] ?? '';
$published_year = $_POST['published_year'] ?? '';
$isbn = $_POST['isbn'] ?? '';

// Validasi title
if (strlen(trim($title)) < 3) {
    $errors['title'] = "Minimal 3 karakter";
}

// Validasi author (tidak boleh angka)
if ($author == '' || preg_match('/\d/', $author)) {
    $errors['author'] = "Tidak boleh angka";
}

// Validasi publisher
if ($publisher == '' || strlen($publisher) > 100) {
    $errors['publisher'] = "Maksimal 100 karakter";
}

// Validasi year
if (!preg_match('/^[0-9]{4}$/', $published_year)) {
    $errors['published_year'] = "Format tahun tidak valid";
}

// Validasi isbn
if (!preg_match('/^[0-9-]{10,}$/', $isbn)) {
    $errors['isbn'] = "Format minimal 10 karakter, hanya angka & '-'";
}

// Validasi cover
$cover_file = null;
if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
    $allowed_ext = ['jpg','jpeg','png'];
    $file_name = $_FILES['cover']['name'];
    $file_tmp = $_FILES['cover']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_ext)) {
        $errors['cover'] = "Format file tidak valid (hanya JPEG, jpeg, jpg, png)";
    } else {
        // simpan file di folder uploads
        $new_name = 'cover_'.time().'.'.$file_ext;
        move_uploaded_file($file_tmp, 'uploads/'.$new_name);
        $cover_file = $new_name;
    }
}

// Jika ada error, kirim respon error
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "msg" => "Data error",
        "errors" => $errors
    ]);
    exit;
}

// Insert ke database
$koneksi = new mysqli('localhost', 'root', '', 'buku_db');

$q = "INSERT INTO buku(title, author, publisher, published_year, isbn, cover) 
      VALUES ('$title', '$author', '$publisher', '$published_year', '$isbn', '$cover_file')";
$koneksi->query($q);
$id = $koneksi->insert_id;

// Response sukses
http_response_code(201);
echo json_encode([
    'status' => 'success',
    'msg' => 'Process success',
    'data' => [
        'id' => $id,
        'title' => $title,
        'author' => $author,
        'publisher' => $publisher,
        'published_year' => intval($published_year),
        'isbn' => $isbn,
        'cover' => $cover_file
    ]
]);
?>
