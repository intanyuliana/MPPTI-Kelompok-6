<?php  
$conn = mysqli_connect("localhost", "root", "", "presensi_ldkom");
// mengecek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>