<?php 
require 'connection.php';
session_start();
if (!isset($_SESSION["login"])){
	header("Location: login_page.php");
	exit;
}

?>

<!doctype html>
<html lang="en">

<head>
	<title>Presensi User</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" type="text/css" href="assets/css/calendar.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/LDKOM_mini1.png">
	<link rel="stylesheet" href=https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js> ></link>
	<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#tab_presen").DataTable();
		} );
	</script>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<div class="row">
					<div class="col-md-5">
						<a href="user_dashboard.php"><img src="assets/img/LDKOM_mini1.png" alt="Logo LDKOM" class="img-responsive logo"></a>
					</div>
					<div class="col-md-4">
						<a href="user_dashboard.php">LDKOM</a>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<div class="navbar-form navbar-left">
					 <p style="font-size: 32px; margin-top: 7px;">Presensi User</p>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="assets/img/profilepic.png" class="img-circle" alt="Avatar"> <span><?php echo $_SESSION["nama"]; ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="profile_user.php"><i class="lnr lnr-user"></i> <span>Profile</span></a></li>
								<li><a href="logout.php"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="user_dashboard.php" class=""><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>		
						<li><a href="presensi_user.php" class="active"><i class="lnr lnr-chart-bars"></i> <span>Presensi</span></a></li>
						<li><a href="logout.php" class=""><i class="lnr lnr-cog"></i> <span>Log Out</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Halaman Presensi, 
								<?php echo $_SESSION["nama"];
								?> !
							</h3>
						</div>
					</div>
					<!-- END OVERVIEW -->
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Isi Presensi Asisten</h3>
							<div class="right">
								<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
							</div>
						</div>
						<div class="panel-body">
							<?php
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
							$id = $_SESSION['id_user'];
							$konfir = "SELECT * FROM jadwal_piket JOIN user ON jadwal_piket.id_user = user.id_user WHERE jadwal_piket.id_user = '$id'";
							$kueri = mysqli_query($conn, $konfir);
							while($row = mysqli_fetch_array($kueri)){
								if(($row['hari1']==$day)||($row['hari2']==$day)){
									?>
									<table class="table table-striped table-hover">
										<thead>
										    <tr>
										      	<th scope="col">Nama</th>
										      	<th scope="col">Tanggal</th>
										      	<th scope="col">Hari</th>
										      	<th scope="col">Presensi Pagi</th>
										      	<th scope="col">Presensi Sore</th>
										    </tr>
										</thead>
										<tbody>
										    <tr>
										    	<form action="presensi_user.php" method="POST">
										    	<?php 
									          	$no = 1;
									          	date_default_timezone_set('Asia/Jakarta');
									          	$tanggal = date("Y-m-d");
									          	$waktu = date("H:i:s");

									          	$absen_pagi_awal = strtotime("07:00:00");
												$absen_pagi_awal = date("H:i:s", $absen_pagi_awal);

									          	$absen_pagi_akhir = strtotime("09:00:00");
									          	$absen_pagi_akhir = date("H:i:s", $absen_pagi_akhir);

									          	$absen_sore_awal = strtotime("16:00:00");
									          	$absen_sore_awal = date("H:i:s", $absen_sore_awal);

									          	$absen_sore_akhir = strtotime("17:00:00");
									          	$absen_sore_akhir = date("H:i:s", $absen_sore_akhir);

									          	$limit_absen = strtotime("23:59:59");
									          	$limit_absen = date("H:i:s", $limit_absen);
									          	$tutup = "Belum bisa mengisi presensi";
									            echo "<tr>";
									            echo "<td>".$row['nama']."</td>";
									            echo "<td>".$tanggal."</td>";
									            echo "<td>".$day."</td>";
									            if ($waktu>=$absen_pagi_awal && $waktu<$absen_sore_awal) {
									            	echo "<td>"
													?>
									            	<a class="btn btn-primary" href="hadir_asisten.php" role="button">Hadir</a>
									            	<a class="btn btn-warning" href="izin_asisten.php" role="button">Izin</a>
									        		<?php
									        		"</td>";
									        		echo "<td>".$tutup."</td>";
									       		}
									       		elseif ($waktu>=($absen_sore_awal) && $waktu<=($limit_absen)) {
									       			echo "<td>".$tutup."</td>";
									            	echo "<td>"
									             	?>
									            	<a class="btn btn-primary" href="hadir_asisten.php" role="button">Hadir</a>
									            	<a class="btn btn-warning" href="izin_asisten.php" role="button">Izin</a>
									        		<?php
									        		"</td>";	
									       		}
									       		else{
									       			echo "<td>".$tutup."</td>";
									       			echo "<td>".$tutup."</td>";
									       		}
									            $no++;
									            ?>
										        <input type="hidden" name="id_denda" value="<?php echo $data['id_denda']?>">
										    	</form>
										    </tr>
										</tbody>
									</table>
								<?php
								}
								else if(($row['hari1']!=$day)||($row['hari2']!=$day)){
									?>
								<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
								  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
								    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
								  </symbol>
								</svg>
								<div class="alert alert-warning d-flex align-items-center" role="alert">
								  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
								  <div>
								    Sekarang bukan jadwal piket Anda
								  </div>
								</div> <?php
								}
								else{
									?>
									<div class="alert alert-danger d-flex align-items-center" role="alert">
									  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
									  <div>
									    Pilihan hari salah !!!
									  </div>
									</div> <?php
								}
							}
							?>
						</div>
					</div>
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Detail Presensi Asisten</h3>
							<div class="right">
								<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
							</div>
						</div>
						<div class="panel-body">
							<table id="tab_presen" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
							  <thead>
							    <tr>
							      <th class="th-sm">No</th>
							      <th class="th-sm">Nama</th>
							      <th class="th-sm">Jenis Presensi</th>
							      <th class="th-sm">Kehadiran</th>
							      <th class="th-sm">Waktu Presensi</th>
							      <th class="th-sm">Kegiatan</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      	<?php 
								   	require 'connection.php';
								   	$id2 = $_SESSION['id_user'];
								    $kueri2 = "SELECT * FROM presensi JOIN jadwal_piket ON presensi.id_piket = jadwal_piket.id_piket JOIN user ON jadwal_piket.id_user = user.id_user JOIN kategori ON presensi.id_kategori = kategori.id_kategori WHERE jadwal_piket.id_user = $id2";
							        $query = mysqli_query($conn, $kueri2);
							        $no = 1;  	
							        while($data = mysqli_fetch_array($query)){
							            echo "<tr>";
							            echo "<td>".$no."</td>";
							            echo "<td>".$data['nama']."</td>";
							            echo "<td>".$data['jenis_presensi']."</td>";
							            echo "<td>".$data['kategori']."</td>";
							            echo "<td>".$data['waktu']."</td>";
							            echo "<td>".$data['kegiatan']."</td>";
							            $no++;
							        }
								    ?>
							    </tr>
							  </tbody>
							</table>
						</div>
					</div>	
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="/assets/app.js"></script>
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="assets/vendor/chartist/js/chartist.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
	<script>
	$(function() {
		var data, options;

		// headline charts
		data = {
			labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			series: [
				[23, 29, 24, 40, 25, 24, 35],
				[14, 25, 18, 34, 29, 38, 44],
			]
		};

		options = {
			height: 300,
			showArea: true,
			showLine: false,
			showPoint: false,
			fullWidth: true,
			axisX: {
				showGrid: false
			},
			lineSmooth: false,
		};

		new Chartist.Line('#headline-chart', data, options);


		// visits trend charts
		data = {
			labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			series: [{
				name: 'series-real',
				data: [200, 380, 350, 320, 410, 450, 570, 400, 555, 620, 750, 900],
			}, {
				name: 'series-projection',
				data: [240, 350, 360, 380, 400, 450, 480, 523, 555, 600, 700, 800],
			}]
		};

		options = {
			fullWidth: true,
			lineSmooth: false,
			height: "270px",
			low: 0,
			high: 'auto',
			series: {
				'series-projection': {
					showArea: true,
					showPoint: false,
					showLine: false
				},
			},
			axisX: {
				showGrid: false,

			},
			axisY: {
				showGrid: false,
				onlyInteger: true,
				offset: 0,
			},
			chartPadding: {
				left: 20,
				right: 20
			}
		};

		new Chartist.Line('#visits-trends-chart', data, options);


		// visits chart
		data = {
			labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
			series: [
				[6384, 6342, 5437, 2764, 3958, 5068, 7654]
			]
		};

		options = {
			height: 300,
			axisX: {
				showGrid: false
			},
		};

		new Chartist.Bar('#visits-chart', data, options);


		// real-time pie chart
		var sysLoad = $('#system-load').easyPieChart({
			size: 130,
			barColor: function(percent) {
				return "rgb(" + Math.round(200 * percent / 100) + ", " + Math.round(200 * (1.1 - percent / 100)) + ", 0)";
			},
			trackColor: 'rgba(245, 245, 245, 0.8)',
			scaleColor: false,
			lineWidth: 5,
			lineCap: "square",
			animate: 800
		});

		var updateInterval = 3000; // in milliseconds

		setInterval(function() {
			var randomVal;
			randomVal = getRandomInt(0, 100);

			sysLoad.data('easyPieChart').update(randomVal);
			sysLoad.find('.percent').text(randomVal);
		}, updateInterval);

		function getRandomInt(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}

	});
	</script>
</body>
</html>
