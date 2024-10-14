<?php 
require_once 'koneksi.php';

function upload() {
    $namaFoto = $_FILES['foto']['name'];
    $ukuranFoto = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpFoto = $_FILES['foto']['tmp_name'];

    // Memastikan file di-upload
    if ($error === 4) {
        echo "<script>alert('Pilih gambar terlebih dahulu.');</script>";
        return false;
    }

    // Validasi ekstensi file
    $fotoValid = ['jpg', 'jpeg', 'png'];
    $ektensiFoto = explode('.', $namaFoto);
    $ektensiFoto = strtolower(end($ektensiFoto));

    if (!in_array($ektensiFoto, $fotoValid)) {
        echo "<script>alert('Yang Anda upload bukan gambar.');</script>";
        return false;
    }

    // Cek ukuran file
    if ($ukuranFoto > 1000000) {
        echo "<script>alert('Ukuran gambar terlalu besar.');</script>";
        return false;
    }

    // Buat nama file baru dan upload
    $fileNameBaru = uniqid() . '.' . $ektensiFoto;
    move_uploaded_file($tmpFoto, '../img/' . $fileNameBaru);
    return $fileNameBaru;
}

function register($data) {
    global $conn;
    $nama = htmlspecialchars($data['nama']);
    $username = $conn->real_escape_string($data['username']);
    $password = $conn->real_escape_string($data['password']);
    $password2 = $conn->real_escape_string($data['password2']);

    // Jika username sudah terdaftar
    $result = $conn->query("SELECT * FROM tb_user WHERE username = '$username'");
    if ($result->num_rows > 0) {
        echo "<script>alert('Username sudah terdaftar!'); window.location='register.php';</script>";
        return false;
    }

    if ($password != $password2) {
        echo "<script>alert('Konfirmasi password salah.'); window.location='register.php';</script>";
        return false;
    }

    if (strlen($password) < 6) {
        echo "<script>alert('Password terlalu pendek, minimal 6 digit.'); window.location='register.php';</script>";
        return false;
    }

    // Cek gambar
    $foto = upload();
    if (!$foto) {
        return false;
    }

    // Hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Simpan data ke database
    $sql = "INSERT INTO tb_user (username, password, nama, foto) VALUES ('$username', '$passwordHash', '$nama', '$foto')";
    if ($conn->query($sql) === TRUE) {
        // Redirect setelah berhasil
        header("Location: login.php"); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        die("Error: " . $conn->error);
    }
}

// Memanggil fungsi register di tempat yang sesuai
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    register($_POST);
}
?>
