<?php
include('../inc/dbconnect.php');
session_start();
$username = $_SESSION['username'];

$sqlneworder = "SELECT * FROM `purchase` WHERE status = 'in process'";
$resultneworder = $conn->query($sqlneworder);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Order [NEW <?php echo $resultneworder->num_rows ?>]</title>
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/order.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#optionall').css({ 'color': 'white', 'background-color': '#ff0072' });

		});
	</script>
</head>
<body>
	<header>
		<a href="../staff" class="logo">BOOK4U STORE</a>
		<nav>
			<ul>
				<li><a href="../staff">HOME</a></li>
				<li><a href="postBook.php">POST BOOK</a></li>
				<li><a href="order.php"  class="activebar">ORDER [<?php echo $resultneworder->num_rows ?>]</a></li>
				<li><a href="c-19test.php">C-19 TEST</a></li>
				<li><a href="profile.php"><?php echo strtoupper($username); ?></a></li>
				<li><a href="../signOut.php">SIGN OUT</a></li>
			</ul>
		</nav>
		<div class="clearfix"></div>
	</header>
	<div class="boxHolder">
		<div class="option-barholder"> <span class="totalorder"><?php echo $resultneworder->num_rows ?></span>
			<a class="option-bar" id="optionall">ALL</a>
			<a class="option-bar" id="optioninprocess">In Process</a>
			<a class="option-bar" id="optiondelivered">Delivered</a>
			<!--<a class="option-bar" id="optioncustom">Custom</a>-->
		</div>
				
		<div id="resultoption">

		</div>
	</div>
</body>
<script type="text/javascript">
	$(document).ready(function(){

		load_optionAll();

		$('#optionall').click(function(){
			load_optionAll();
			$('#optioninprocess').css({ 'color': 'black', 'background-color': '' });
			$('#optiondelivered').css({ 'color': 'black', 'background-color': '' });
			$('#optioncustom').css({ 'color': 'black', 'background-color': '' });

			$("#optioninprocess").mouseenter(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseleave(function() {
				$(this).css("background-color", "").css("color", "black");
			});
			$("#optiondelivered").mouseenter(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseleave(function() {
				$(this).css("background-color", "").css("color", "black");
			});
			$("#optioncustom").mouseenter(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseleave(function() {
				$(this).css("background-color", "").css("color", "black");
			});

			$('#optionall').css({ 'color': '#fff', 'background-color': '#ff0072' });
			$("#optionall").mouseleave(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseenter(function() {
				$(this).css("background-color", "").css("color", "");
			});
		});

		$('#optioninprocess').click(function(){
			load_optioninprocess();
			$('#optiondelivered').css({ 'color': 'black', 'background-color': '' });
			$('#optionall').css({ 'color': 'black', 'background-color': '' });
			$('#optioncustom').css({ 'color': 'black', 'background-color': '' });

			$("#optiondelivered").mouseenter(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseleave(function() {
				$(this).css("background-color", "").css("color", "black");
			});
			$("#optionall").mouseenter(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseleave(function() {
				$(this).css("background-color", "").css("color", "black");
			});
			$("#optioncustom").mouseenter(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseleave(function() {
				$(this).css("background-color", "").css("color", "black");
			});

			$('#optioninprocess').css({ 'color': '#fff', 'background-color': '#ff0072' });
			$("#optioninprocess").mouseleave(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseenter(function() {
				$(this).css("background-color", "").css("color", "");
			});
		});

		$('#optiondelivered').click(function(){
			load_optiondelivered();
			$('#optioninprocess').css({ 'color': 'black', 'background-color': '' });
			$('#optionall').css({ 'color': 'black', 'background-color': '' });
			$('#optioncustom').css({ 'color': 'black', 'background-color': '' });

			$("#optioninprocess").mouseenter(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseleave(function() {
				$(this).css("background-color", "").css("color", "black");
			});
			$("#optionall").mouseenter(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseleave(function() {
				$(this).css("background-color", "").css("color", "black");
			});
			$("#optioncustom").mouseenter(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseleave(function() {
				$(this).css("background-color", "").css("color", "black");
			});
			
			$('#optiondelivered').css({ 'color': '#fff', 'background-color': '#ff0072' });
			$("#optiondelivered").mouseleave(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseenter(function() {
				$(this).css("background-color", "").css("color", "");
			});

		});

		$('#optioncustom').click(function(){
			load_optioncustom();
			$('#optioninprocess').css({ 'color': 'black', 'background-color': '' });
			$('#optionall').css({ 'color': 'black', 'background-color': '' });
			$('#optiondelivered').css({ 'color': 'black', 'background-color': '' });

			$("#optioninprocess").mouseenter(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseleave(function() {
				$(this).css("background-color", "").css("color", "black");
			});
			$("#optionall").mouseenter(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseleave(function() {
				$(this).css("background-color", "").css("color", "black");
			});
			$("#optiondelivered").mouseenter(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseleave(function() {
				$(this).css("background-color", "").css("color", "black");
			});
			
			$('#optioncustom').css({ 'color': '#fff', 'background-color': '#ff0072' });
			$("#optioncustom").mouseleave(function() {
				$(this).css("background-color", "#ff0072").css("color", "#fff");
			}).mouseenter(function() {
				$(this).css("background-color", "").css("color", "");
			});

		});

		function load_optionAll(){
			$.ajax({
				url:"viewOrder.php",
				method:"POST",
				data:{
					option:'all'
				},
				success:function(data){
					$('#resultoption').html(data);
				}
			});
		}

		function load_optioninprocess(){
			$.ajax({
				url:"viewOrder.php",
				method:"POST",
				data:{
					option:'inprocess'
					
				},
				success:function(data){
					$('#resultoption').html(data);
				}
			});
		}

		function load_optiondelivered(){
			$.ajax({
				url:"viewOrder.php",
				method:"POST",
				data:{
					option:'delivered'
					
				},
				success:function(data){
					$('#resultoption').html(data);
				}
			});
		}

		function load_optioncustom(){
			$.ajax({
				url:"viewOrder.php",
				method:"POST",
				data:{
					custom:'custom'
					
				},
				success:function(data){
					$('#resultoption').html(data);
				}
			});
		}
	});
</script>
<?php
	include('../footer.php');
?>
</html>