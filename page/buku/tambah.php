<?php 
$query = "SELECT id_rak, nama_rak FROM tb_rak";
$result = $conn->query($query);

if (isset($_POST['tambah'])) {
    $judul = htmlspecialchars($_POST['judul_buku']);
    $pengarang = htmlspecialchars($_POST['pengarang_buku']);
    $penerbit = htmlspecialchars($_POST['penerbit_buku']);
    $tahun_terbit = htmlspecialchars($_POST['tahun_terbit']);
    $isbn = htmlspecialchars($_POST['isbn']);
    $jumlah = htmlspecialchars($_POST['jumlah_buku']);
    $lokasi = htmlspecialchars($_POST['lokasi']); // ID rak yang dipilih
    $tgl_input = htmlspecialchars($_POST['tgl_input']);

    // Validasi input kosong
    if (empty($judul) || empty($pengarang) || empty($penerbit) || empty($tahun_terbit) || empty($isbn) || empty ($jumlah) || empty($lokasi) || empty($tgl_input)) {
        echo "<script>alert('Pastikan anda sudah mengisi semua formulir.');window.location='?p=buku';</script>";
    } else {
        // 1. Simpan buku baru ke tabel buku
        $sql_buku = "INSERT INTO tb_buku (judul_buku, pengarang_buku, penerbit_buku, tahun_terbit, isbn, jumlah_buku, lokasi, tgl_input) 
                    VALUES ('$judul', '$pengarang', '$penerbit', '$tahun_terbit', '$isbn','$jumlah' ,'$lokasi', '$tgl_input')";
        if ($conn->query($sql_buku) === TRUE) {

            // 2. Update jumlah buku di tabel rak
            $sql_update_rak = "UPDATE tb_rak SET jumlah_buku = jumlah_buku + 1 WHERE id_rak = '$lokasi'";
            if ($conn->query($sql_update_rak) === TRUE) {
                echo "<script>alert('Buku berhasil ditambahkan dan jumlah buku di rak diperbarui!');window.location='?p=buku';</script>";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "Error: " . $sql_buku . "<br>" . $conn->error;
        }
    }
}
?>

<h1 class="mt-4">Tambah Data Buku</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
    <li class="breadcrumb-item active">tambah data buku</li>
</ol>
<div class="card-header mb-5">
	
	<form action="" method="post">
    <div class="form-group">
        <label class="small mb-1" for="judul_buku">Judul Buku</label>
        <input class="form-control" id="judul_buku" name="judul_buku" type="text" placeholder="Masukan judul buku"/>
    </div>
    <div class="form-group">
        <label class="small mb-1" for="pengarang_buku">Pengarang</label>
        <input class="form-control" id="pengarang_buku" name="pengarang_buku" type="text" placeholder="Masukan pengarang buku"/>
    </div>
    <div class="form-group">
        <label class="small mb-1" for="penerbit_buku">Penerbit</label>
        <input class="form-control" id="penerbit_buku" name="penerbit_buku" type="text" placeholder="Masukan penerbit buku"/>
    </div>
    <div class="form-group">
        <label class="small mb-1" for="tahun_terbit">Tahun Terbit</label>
        <select name="tahun_terbit" id="tahun_terbit" class="form-control">
        	<option value="">-- Pilih Tahun --</option>
        	<?php 
        	// menampilkan tahun terbit dari tahun 1991- hingga tahun sekarang
        	$tahun = date('Y');

        	for ($i = $tahun - 29; $i <= $tahun ; $i++) { ?>
        		<option value="<?= $i ?>"><?= $i ?></option>
        	<?php
        	}
        	?>
        </select>
    </div>
    <div class="form-group">
        <label class="small mb-1" for="isbn">ISBN</label>
        <input class="form-control" id="isbn" name="isbn" type="text" placeholder="Masukan isbn buku"/>
    </div>
   <div class="form-group">
        <label class="small mb-1" for="jumlah_buku">Jumlah Buku</label>
        <input class="form-control" id="jumlah_buku" name="jumlah_buku" type="number" placeholder="Masukan jumlah buku"/>
    </div>
    <div class="form-group">
    	<label for="lokasi">Lokasi</label>
    	<select name="lokasi" id="lokasi" class="form-control">
    <option value="">-- Pilih Rak --</option>
    <?php
    // Looping hasil query untuk mengisi dropdown
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['id_rak'] . '">' . $row['nama_rak'] . '</option>';
        }
    } else {
        echo '<option value="">Data rak tidak tersedia</option>';
    }
    ?>
</select>

    </div>
    <div class="form-group">
    	<label for="tgl_input">Tanggal Input</label>
    	<input type="date" name="tgl_input" id="tgl_input" class="form-control">
    </div>
    <div class="form-group">
    	<button type="submit" class="btn btn-primary" name="tambah">Tambah Data</button>
    </div>
	</form>
</div>