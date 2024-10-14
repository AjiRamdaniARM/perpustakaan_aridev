<?php 
if(isset($_POST['tambah'])) {
	$nama_rak = htmlspecialchars($_POST['nama_rak']);
	$tgl_create = htmlspecialchars($_POST['tgl_create']);

    // Cek apakah kedua input kosong
    if(empty($nama_rak) || empty($tgl_create)) {
        echo "<script>alert('Pastikan anda sudah mengisi semua formulir.');window.location='?p=rak';</script>";
        exit; // Berhenti eksekusi jika input kosong
    }

    // Query INSERT sesuai dengan kolom yang ada
    $sql = $conn->query("INSERT INTO tb_rak (nama_rak, tgl_create) VALUES ('$nama_rak', '$tgl_create')") 
           or die(mysqli_error($conn));
           
	if($sql) {
		echo "<script>alert('Data Berhasil Ditambahkan.');window.location='?p=rak';</script>";
	} else {
		echo "<script>alert('Data Gagal Ditambahkan.')</script>";
	}
}


?>

<h1 class="mt-4">Tambah Data Buku</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">tambah data rak</li>
</ol>
<div class="card-header mb-5">
	
	<form action="" method="post">
    <div class="form-group">
        <label class="small mb-1" for="judul_buku">Nama Rak</label>
        <input class="form-control" id="nama_rak" name="nama_rak" type="text" placeholder="Masukan nama rak buku"/>
    </div>

    <div class="form-group">
    	<label for="tgl_input">Tanggal Input</label>
    	<input type="date" name="tgl_create" id="tgl_create" class="form-control">
    </div>
    <div class="form-group">
    	<button type="submit" class="btn btn-primary" name="tambah">Tambah Data</button>
    </div>
	</form>
</div>