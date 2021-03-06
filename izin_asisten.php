<?php 
require 'connection.php';
session_start();
if (!isset($_SESSION["login"])){
	header("Location: login_page.php");
	exit;
}

date_default_timezone_set('Asia/Jakarta');
$id_user = $_SESSION['id_user'];
$sql = 'SELECT * FROM jadwal_piket JOIN presensi ON jadwal_piket.id_piket = presensi.id_piket WHERE jadwal_piket.id_user='.$id_user;

if(!$result = $conn->query($sql)){
  die("Gagal Query");
}

$data = $result->fetch_assoc();

if(isset($_POST['Edit'])){
	$id_piket = $_POST['id_piket'];
    $waktuabsen = $_POST['waktuabsen'];
    $keterangan = $_POST['keterangan'];
    $status_denda = "Belum Bayar";

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

	if ($waktuabsen>=$absen_pagi_awal && $waktuabsen<=$absen_pagi_akhir) {
		$id_kategori = 11;
		$jenis_presensi = "Pagi";
	}
	elseif ($waktuabsen>$absen_pagi_akhir && $waktuabsen<$absen_sore_awal) {
		$id_kategori = 10;
		$jenis_presensi = "Pagi";
	}
	elseif ($waktuabsen>=$absen_sore_awal && $waktuabsen<=$absen_sore_akhir) {
		$id_kategori = 11;
		$jenis_presensi = "Sore";
	}
	elseif ($waktuabsen>$absen_sore_akhir && $waktuabsen<$limit_absen) {
		$id_kategori = 10;
		$jenis_presensi = "Sore";
	}

	$tgl = date("Y-m-d");
	$tglgabung = date('Y-m-d H:i:s', strtotime("$tgl $waktuabsen"));
	$kegiatan = "-";

    $statement = $conn->prepare('UPDATE presensi SET id_kategori = ?, status_denda = ?, waktu = ?, kegiatan = ?, keterangan = ? WHERE id_piket =? AND jenis_presensi = ?');
    $statement->bind_param('issssis', $id_kategori, $status_denda, $tglgabung, $kegiatan, $keterangan, $id_piket, $jenis_presensi);
    $statement->execute();

    if( $conn->affected_rows > 0 ) { 
      $message = "Data sukses disimpan!";
      header('Location:presensi_user.php');
    } else {
      $message = "Data gagal disimpan!";
    }
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
							<h3 class="panel-title">Form Izin Presensi Asisten</h3>
							<div class="right">
								<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
							</div>
						</div>
						<div class="panel-body">
							<form action="izin_asisten.php" method="POST">
								<input type="hidden" name="id_piket" value="<?php echo $data['id_piket']; ?>">
								<input type="hidden" name="waktuabsen" value="<?php echo date("H:i:s"); ?>">
						      	<div class="form-group">
						            <label>Keterangan</label>
						            <input type="text" name="keterangan" class="form-control" placeholder="Masukkan Kegiatan" required="">
						        </div>
						      	<button onclick="return confirm('Apakah anda ingin menginput data?');" type="submit" class="btn btn-primary" name="Edit">Simpan</button>
						      	<a class="btn btn-outline-warning" href="presensi_user.php">Kembali</a>
						    </form>
						</div>
					</div>	
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">Shared by <i class="fa fa-love"></i><a href="https://bootstrapthemes.co">BootstrapThemes</a></p>
			</div>
		</footer>
	</div>
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
