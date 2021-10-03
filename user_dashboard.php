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
	<title>Dashboard</title>
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

	<style>
		hr.garis{
			border-top: 3px solid;
		}
	</style>
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
					 <p style="font-size: 32px; margin-top: 7px;">Dashboard</p>
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
						<li><a href="user_dashboard.php" class="active"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>		
						<li><a href="presensi_user.php" class=""><i class="lnr lnr-chart-bars"></i> <span>Presensi</span></a></li>
						<li><a href="denda_user.php" class=""><i class="lnr lnr-code"></i> <span>Denda</span></a></li>
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
							<h3 class="panel-title">Selamat Datang, 
								<?php echo $_SESSION["nama"];
								?> !
							</h3>
						</div>
					</div>
					<!-- END OVERVIEW -->
					<div class="row">
						<div class="col-md-8">
							<!-- Data User -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">User Profil</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
									</div>
								</div>
								<div class="panel-body no-padding">
									<div class="row">
										<div class="col-md-5">
											<img src="assets/img/profilepic.svg" style="width: 150px; margin-left: 25px; margin-bottom: 25px">
										</div>
										<div class="col-md-5">
											<h2 style="text-align: center;"><?php echo $_SESSION["nama"] ?></h2>
											<hr class="garis">
											<h3 style="text-align: center; color: #00aaff"><?php $id = $_SESSION["id_user"];
											$sql = "SELECT jabatan FROM user WHERE id_user = '$id'";
											$query = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_array($query)){
												echo $row["jabatan"];
											}
											?></h3>	
										</div>
									</div>
								</div>
							</div>
							<!-- END RECENT PURCHASES -->
						</div>
						<div class="col-md-4">
							<!-- Date & Time -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Date & Time</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
									</div>
								</div>
								<div class="panel-body">
									<div class="calendar">
										<div class="header">
											<a data-action="prev-month" href="javascript:void(0)" title="Previous Month"><i></i></a>
											<div class="text" data-render="month-year"></div>
											<a data-action="next-month" href="javascript:void(0)" title="Next Month"><i></i></a>
										</div>
										<div class="months" data-flow="left">
											<div class="month month-a">
												<div class="render render-a"></div>
											</div>
											<div class="month month-b">
												<div class="render render-b"></div>
											</div>
										</div>
									</div>
									<!-- <div class="calendar">
								        <div class="calendar-header">
								            <span class="month-picker" id="month-picker">February</span>
								            <div class="year-picker">
								                <span class="year-change" id="prev-year">
								                    <pre><</pre>
								                </span>
								                <span id="year">2021</span>
								                <span class="year-change" id="next-year">
								                    <pre>></pre>
								                </span>
								            </div>
								        </div>
								        <div class="calendar-body">
								            <div class="calendar-week-day">
								                <div>Sun</div>
								                <div>Mon</div>
								                <div>Tue</div>
								                <div>Wed</div>
								                <div>Thu</div>
								                <div>Fri</div>
								                <div>Sat</div>
								            </div>
								            <div class="calendar-days"></div>
								        </div>
								        <div class="calendar-footer">
								            <div class="toggle">
								                <span>Dark Mode</span>
								                <div class="dark-mode-switch">
								                    <div class="dark-mode-switch-ident"></div>
								                </div>
								            </div>
								        </div>
								        <div class="month-list"></div>
								    </div>
								    <script src="/scripts/app.js"></script> -->
								</div>
							</div>
							<!-- End Date & Time -->
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<!-- Jadwal Piket -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Jadwal Piket Minggu Ini</h3>
									<div class="right">
										<button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
										<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
									</div>
								</div>
								<div class="panel-body">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>Hari</th>
												<th>Jam</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$id = $_SESSION["id_user"];
											$sql = "SELECT hari FROM jadwal_piket WHERE id_user = '$id'";
											$query = mysqli_query($conn, $sql);
											while($row = mysqli_fetch_array($query)){
											?>
											<tr>
												<td><?php echo $row["hari"] ?></td>
												<td>08.00 - 16.00</td>
												<td><span class="label label-success">COMPLETED</span></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
							<!-- Jadwal Piket -->
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
