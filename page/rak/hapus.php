<?php 
// menangkap id_buku di url
$id_rak = $_GET['id'];

$conn->query("DELETE FROM tb_rak WHERE id_rak = $id_rak") or die(mysqli_error($conn));
echo "<script>alert('Data Berhasil Dihapus.');window.location='?p=rak';</script>";
?>