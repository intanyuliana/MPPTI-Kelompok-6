<?php 
session_start();
if (!isset($_SESSION["login"])){
	header("Location: login_page.php");
	exit;
}
require 'connection.php';

if(isset($_POST['Hapus'])){
  $id_piket = $_POST['id_piket'];
  $sql = "DELETE FROM jadwal_piket WHERE id_piket='$id_piket'";
    $query = mysqli_query($conn, $sql);
      if( $query ){
          $message = "Data Sukses Dihapus";
      } else {
          $message = "Data Gagal Dihapus";
      }
}

$piket = $_REQUEST['id_piket'];
$sql = 'SELECT user.nama, jadwal_piket.id_piket, jadwal_piket.id_user FROM jadwal_piket JOIN user ON jadwal_piket.id_user = user.id_user WHERE jadwal_piket.id_piket='.$piket;

if(!$result = $conn->query($sql)){
  die("Gagal Query");
}

$data = $result->fetch_assoc();

if(isset($_POST['Edit'])){
    $id_piket = $_POST['id_piket'];
    $hari1 = $_POST['hari1'];
    $hari2 = $_POST['hari2'];


    if($hari1 == $hari2){
   		echo '<script type ="text/JavaScript">';  
       	echo 'alert("Pilihan Hari Sama")';  
       	echo '</script>';
    }
    else{
    	$statement = $conn->prepare('UPDATE jadwal_piket SET hari1 = ?, hari2 = ? WHERE id_piket=?');
	    $statement->bind_param('ssi', $hari1, $hari2, $id_piket);
	    $statement->execute();

	    if( $conn->affected_rows > 0 ) { 
	      $message = "Data sukses disimpan!";
	      header('Location:presensi_admin.php');
	    } else {
	      $message = "Data gagal disimpan!";
	    }
    }  
  }
?>

<!doctype html>
<html lang="en">

<head>
	<title>Kelola Presensi</title>
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
						<a href="admin_dashboard.php"><img src="assets/img/LDKOM_mini1.png" alt="Logo LDKOM" class="img-responsive logo"></a>
					</div>
					<div class="col-md-4">
						<a href="admin_dashboard.php">LDKOM</a>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<div class="navbar-form navbar-left">
					 <p style="font-size: 32px; margin-top: 7px;">Kelola Presensi</p>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="assets/img/profilepic.png" class="img-circle" alt="Avatar"> <span><?php echo $_SESSION["nama"]; ?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="profile_admin.php"><i class="lnr lnr-user"></i> <span>Profile</span></a></li>
								<li><a href="logout.php"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
							</ul>
						</li>
						<!-- <li>
							<a class="update-pro" href="https://www.themeineed.com/downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
						</li> -->
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
						<li><a href="admin_dashboard.php" class=""><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
						<li><a href="asisten_admin.php" class=""><i class="lnr lnr-file-empty"></i> <span>Asisten</span></a></li>		
						<li><a href="presensi_admin.php" class="active"><i class="lnr lnr-chart-bars"></i> <span>Presensi</span></a></li>
						<li><a href="denda_admin.php" class=""><i class="lnr lnr-code"></i> <span>Denda</span></a></li>
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
							<h3 class="panel-title">Halaman Kelola Presensi, 
								<?php echo $_SESSION["nama"];
								?> !
							</h3>
						</div>
					</div>
					<!-- END OVERVIEW -->
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title">Edit Jadwal Presensi Asisten</h3>
							<div class="right">
								<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
								<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
							</div>
						</div>
						<div class="panel-body">
							<h4>Nama Asisten : <?php echo $data['nama']; ?></h4></br>
							<form action="editjadwal_admin.php" method="POST">
								<input type="hidden" name="id_piket" value="<?php echo $data['id_piket']; ?>">
						      	<div class="form-group">
						        	<label>Pilih Jadwal 1 :</label>
						        	<select class="form-control" name="hari1" required="">
						          		<option value="Senin">1. Senin</option>
						          		<option value="Selasa">2. Selasa</option>
						          		<option value="Rabu">3. Rabu</option>
						          		<option value="Kamis">4. Kamis</option>
						          		<option value="Jumat">5. Jumat</option>
						          		<option value="Sabtu">6. Sabtu</option>
						          		<option value="Minggu">7. Minggu</option>
						        	</select>
						      	</div><br>
						      	<div class="form-group">
						        	<label>Pilih Jadwal 2 :</label>
						        	<select class="form-control" name="hari2" required="">
						          		<option value="Senin">1. Senin</option>
						          		<option value="Selasa">2. Selasa</option>
						          		<option value="Rabu">3. Rabu</option>
						          		<option value="Kamis">4. Kamis</option>
						          		<option value="Jumat">5. Jumat</option>
						          		<option value="Sabtu">6. Sabtu</option>
						          		<option value="Minggu">7. Minggu</option>
						        	</select>
						      	</div><br>
						      	<button onclick="return confirm('Apakah anda ingin menginput data?');" type="submit" class="btn btn-primary" name="Edit">Simpan</button>
						      	<button type="reset" class="btn btn-danger">Hapus</button>
						      	<a class="btn btn-outline-warning" href="presensi_admin.php">Kembali</a>
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
				<p class="copyright">Shared by <i class="fa fa-love"></i><a href="https://bootstrapthemes.co">BootstrapThemes</a>
</p>
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
