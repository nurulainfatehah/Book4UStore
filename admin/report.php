<?php
include('../inc/dbconnect.php');
session_start();
$username = $_SESSION['username'];



$sqlTotalBook = "SELECT * FROM book";
$resultTotalBook = $conn->query($sqlTotalBook);

$sqlTotalBookSold = "SELECT * FROM book WHERE receiptID IS NOT NULL";
$resultTotalBookSold = $conn->query($sqlTotalBookSold);
$total = $resultTotalBook->num_rows;
$totalSold = $resultTotalBookSold->num_rows;
$bookavailable = $total - $totalSold;

$sqlTotalActiveStaff = "SELECT * FROM staff WHERE accountStatus = 'active'";
$resultTotalStaff = $conn->query($sqlTotalActiveStaff);
$sqlTotalNonActiveStaff = "SELECT * FROM staff WHERE accountStatus = 'inactive'";
$resultTotalNonActiveStaff = $conn->query($sqlTotalNonActiveStaff);


$sqlDelivered = "SELECT * FROM purchase WHERE status = 'delivered'";
$resultDelivered = $conn->query($sqlDelivered);

$sqlInProcess = "SELECT * FROM purchase WHERE status = 'in process'";
$resultInProcess = $conn->query($sqlInProcess);

$sqlCancelled = "SELECT * FROM purchase WHERE status = 'cancelled'";
$resultCancelled = $conn->query($sqlCancelled);

$arrayearning = array();
$monthcounter = 5;

for( $i = 0; $i <= 6 ; $i++) {

	$dateToSearch = date("Y-m", strtotime("-".$monthcounter."month")).'-__%';
	$monthcounter--;
		    //print date("Y-m", strtotime("-".$i." month"));
		    //print_r($dateToSearch);
	$sqlSearchEarning = "SELECT SUM(total) as totalEarning FROM purchase WHERE (status = 'delivered' OR status = 'in process') AND purchase.purchaseDateTime LIKE '".$dateToSearch."'";

	$resultTotal = $conn->query($sqlSearchEarning);
	$row = $resultTotal->fetch_assoc();

	array_push($arrayearning, $row['totalEarning']);

	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Report</title>
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/graph.css">	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<style type="text/css">
		rect[Attributes Style] {
			x: 0;
			y: 0;
			width: 360;
			height: 200;
			stroke: none;
			stroke-width: 0;
		}
		a.printbutton
		{
			color: black;
			float: right;
			margin-top: 0;
			margin-right: -6%;
			font-size: 11px;
			cursor: pointer;
			text-decoration: none;
			padding: 2px 8px 2px 8px;
			border: 1px solid gray;
			background-color: lightgrey;

		}
		a.printbutton:hover
		{
			color: #fff;
			background-color: #ff0072;
			border: 1px solid #ff0072;
		}
	</style>
</head>
<body>
	<header>
		<a href="../admin" class="logo">BOOK4U STORE</a>
		<nav>
			<ul>
				<li><a href="../admin" class="activebar">HOME</a></li>
				<li><a href="staff.php">STAFF</a></li>
				<li><a href="c-19test.php">C-19 TEST</a></li>
				<li><a href="profile.php"><?php echo strtoupper($username); ?></a></li>
				<li><a href="../signOut.php">SIGN OUT</a></li>
			</ul>
		</nav>
		<div class="clearfix"></div>
	</header>
	<script type="text/javascript">
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawpurchase);

		function drawpurchase() {

			var data = google.visualization.arrayToDataTable([
				['Status', 'Total'],
				['Delivered',	<?php echo $resultDelivered->num_rows ?>],
				['In Process',	<?php echo $resultInProcess->num_rows ?>],
				['Cancelled',	<?php echo $resultCancelled->num_rows ?>]
				]);

			var options = {
				title: 'Purchase Status',
				colors: ['green','orange', 'gray']
			};

			var chart = new google.visualization.PieChart(document.getElementById('purchasestatus'));

			chart.draw(data, options);
		}

		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawBook);

		function drawBook() {

			var data = google.visualization.arrayToDataTable([
				['Status', 'Total'],
				['Available',	<?php echo $bookavailable ?>],
				['Sold out',	<?php echo $resultTotalBookSold->num_rows ?>]
				]);

			var options = {
				title: 'Book Records',
				colors: ['#99b898', '#ff6961']
			};

			var chart = new google.visualization.PieChart(document.getElementById('book'));

			chart.draw(data, options);
		}

		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawStaff);

		function drawStaff() {
			var data = google.visualization.arrayToDataTable([
				["Status", "Total Staff" ],
				['active', <?php echo $resultTotalStaff->num_rows ?>],				
				['in active', <?php echo $resultTotalNonActiveStaff->num_rows ?>]
				]);

			var view = new google.visualization.DataView(data);


			var options = {
				title: "Staff availability",
				colors: ['#AFCBFF', '#89AEB2'],
				bar: {groupWidth: "70%"},
				legend: { position: "none" },
			};
			var chart = new google.visualization.ColumnChart(document.getElementById("staff"));
			chart.draw(view, options);

			

			chart.draw(data, options);
		}
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawEarningYearChart);

		function drawEarningYearChart() {
			var data = google.visualization.arrayToDataTable([
				['Month: ', 'Earnings (RM)'],
				<?php
				$monthcounter = 5;
				for( $i = 0; $i <= 5 ; $i++) {

					if($arrayearning[$i] == NULL){

						echo "['". date('M Y', strtotime('-'.$monthcounter.'month')) ."', 0],";

					}else{
						echo "['". date('M Y', strtotime('-'.$monthcounter.'month')) ."'," .$arrayearning[$i] . "],";
					}
					$monthcounter--;	

				}
				?>
				]);

			var options = {
				title: 'Monthly Earnings (RM) of The Past 6 Months (<?php echo date('M Y');?>)',
				legend: { position: 'bottom' },
				vAxis: {
					title: 'Earnings (RM)'
				}
			};

			var chart = new google.visualization.LineChart(document.getElementById('earning-year'));

			chart.draw(data, options);

		}


	</script>
	<div class="boxHolder">
		<center><p style="font-size: 17px">Graphical Report</p></center>
		<hr>
		<a class="printbutton" target="_blank" href="printreport.php">
			Print
		</a>
		<div class="kotakgrafholder" align="center">
			<div class="kotakgraf">
				<div id="purchasestatus" style="height: 220px; width: 370px; "></div>
			</div>	
			<div class="kotakgraf">
				<div id="book" style="height: 220px; width: 370px; "></div>
			</div>
			<div class="kotakgraf">
			    <div id="staff" style="height: 220px; width: 370px; "></div>
			</div>
			<div class="kotakgraf">
			    <div id="earning-year" style="height: 320px; width: 620px; "></div>
			</div>
		</div>
	</div>
</body>
</html>