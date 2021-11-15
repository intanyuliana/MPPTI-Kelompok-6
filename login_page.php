<?php 
session_start();
require 'connection.php';

if (isset($_SESSION["login"])){
	header("Location: user_dashboard.php");
	exit;
}

date_default_timezone_set('Asia/Jakarta');
$today = date('l');
if ($today == "Monday") {
	$day = "Senin";
} 
elseif ($today == "Tuesday") {
	$day = "Selasa";
}
 elseif ($today == "Wednesday") {
	$day = "Rabu";
}
elseif ($today == "Thursday") {
	$day = "Kamis";
}
elseif ($today == "Friday") {
	$day = "Jumat";
}
elseif ($today == "Saturday") {
	$day = "Sabtu";
}
elseif ($today == "Sunday") {
	$day = "Minggu";
}

$cekdata = "SELECT * FROM jadwal_piket WHERE hari1 = '$day' OR hari2 = '$day'";
$run = mysqli_query($conn, $cekdata);
while($row = mysqli_fetch_array($run)){
	$pkt = $row['id_piket'];
	$jm = strtotime("00:00:00");
	$jm = date("H:i:s", $jm);
	$cektgl = date("Y-m-d");
	$inpttgl = date('Y-m-d H:i:s', strtotime("$cektgl $jm"));
	$inptktg = 8;
	$inptst = "Belum Bayar";
	$jp1 = "Pagi";
	$jp2 = "Sore";

	
	$cekdb = mysqli_query($conn, "SELECT * FROM presensi WHERE id_piket = '$pkt' AND waktu = '$inpttgl'") or die(mysqli_error($conn));
	$qcdb = mysqli_fetch_row($cekdb);
	if(!isset($qcdb) || empty($qcdb)){
		echo "asdada";
		$msk = "INSERT INTO presensi (id_piket, id_kategori, status_denda, jenis_presensi, waktu) VALUES ('$pkt', '$inptktg', '$inptst', '$jp1', '$inpttgl')";
		$qmsk = mysqli_query($conn, $msk)or die(mysqli_error($conn));

		$msk2 = "INSERT INTO presensi (id_piket, id_kategori, status_denda, jenis_presensi, waktu) VALUES ('$pkt', '$inptktg', '$inptst', '$jp2', '$inpttgl')";
		$qmsk2 = mysqli_query($conn, $msk2)or die(mysqli_error($conn));
	}
}


if (isset($_POST["login"])) {
	$email = $_POST["email"];
	$password = $_POST["password"];

	$result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");

	//cek username
	if(mysqli_num_rows($result) == 1){
		//cek password
		$row = mysqli_fetch_assoc($result);
		if (password_verify($password, $row["password"])) {
			if ($row["email"] == "demo@gmail.com"){
				//set session
				$_SESSION["login"] = true;
				$_SESSION["email"] = $_POST["email"];
				$_SESSION["nama"] = $row["nama"];
				$_SESSION["jabatan"] = $row["jabatan"];
				$_SESSION["id_user"] = $row["id_user"];
  				header("Location: admin_dashboard.php");
				exit;
			}
			else{
				//set session
				$_SESSION["login"] = true;
				$_SESSION["email"] = $_POST["email"];
				$_SESSION["nama"] = $row["nama"];
				$_SESSION["jabatan"] = $row["jabatan"];
				$_SESSION["id_user"] = $row["id_user"];
				header("Location: user_dashboard.php");
				exit;
			}
		}
		$error = true;
	}

}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="assets/img/wave1.png">
	<div class="container">
		<div class="img">
			<img src="assets/img/phone.svg">
		</div>
		<div class="login-content">
			<form action="login_page.php" method="post">
				<img src="assets/img/profilepic.svg">
				<h2 class="title">Login</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Email</h5>
           		   		<input type="text" class="input" name="email">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" class="input" name="password">
            	   </div>
            	</div>
            	<input type="submit" class="btn" name="login">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="assets/scripts/main.js"></script>
</body>
</html>
