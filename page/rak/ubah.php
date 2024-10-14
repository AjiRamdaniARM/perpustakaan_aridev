<?php 

// menangkap id_buku di url
$id_rak = $_GET['id'];

// menampilkan data db sesuai id_buku
$sql = $conn->query("SELECT * FROM tb_rak WHERE id_rak = $id_rak") or die(mysqli_error($conn));
$pecahSql = $sql->fetch_assoc();

if(isset($_POST['ubah'])) {
	$nama_rak = htmlspecialchars($_POST['nama_rak']);
	$tgl_create = htmlspecialchars($_POST['tgl_create']);

    if(empty($nama_rak && $tgl_create)) {
        echo "<script>alert('Pastikan anda sudah mengisi semua formulir.');window.location='?p=buku';</script>";
    }

	$sql = $conn->query("UPDATE tb_rak SET nama_rak = '$nama_rak',tgl_create = '$tgl_create' WHERE id_rak = $id_rak") or die(mysqli_error($conn));
	if($sql) {
		echo "<script>alert('Data Berhasil Diubah.');window.location='?p=rak';</script>";
	} else {
		echo "<script>alert('Data Gagal Diubah.');window.location='?p=rak';</script>";
	}
}
?>

<h1 class="mt-4">Ubah Data Buku</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">ubah data buku</li>
</ol>
<div class="card-header mb-5">
	
	<form action="" method="post">
    <div class="form-group">
        <label class="small mb-1" for="judul_buku">Nama Rak</label>
        <input class="form-control" id="nama_rak" name="nama_rak" type="text" placeholder="Masukan nama_rak buku" value="<?= $pecahSql['nama_rak']; ?>" />
    </div>
   
    <div class="form-group">
    	<label for="tgl_input">Tanggal Input</label>
    	<input type="date" name="tgl_create" id="tgl_create" class="form-control" value="<?= $pecahSql['tgl_create']; ?>">
    </div>
    <div class="form-group">
    	<button type="submit" class="btn btn-primary" name="ubah">Ubah Data</button>
    </div>
	</form>
</div>