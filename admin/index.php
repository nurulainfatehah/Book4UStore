<?php
session_start();
include('../inc/dbconnect.php');
$username = "";

if(isset($_SESSION['username'])){
	$username = $_SESSION['username'];
}
else{
	?>
	<script type="text/javascript">	
		alert("Invalid session. Please try sign in again.");
		window.location.replace('signIn.php');
		
	</script>
	<?php
}

$sqlneworder = "SELECT * FROM `purchase` WHERE status = ''";
$resultneworder = $conn->query($sqlneworder);


$sqlTotalBook = "SELECT * FROM book";
$resultTotalBook = $conn->query($sqlTotalBook);

$sqlTotalBookSold = "SELECT * FROM book WHERE receiptID IS NOT NULL";
$resultTotalBookSold = $conn->query($sqlTotalBookSold);


$sqlEarning = "SELECT SUM(total) as totalearnings FROM purchase WHERE status != 'cancelled' ";
$resultEarning = $conn->query($sqlEarning);
$rowEarning = $resultEarning->fetch_assoc();
$rowEarning = $rowEarning['totalearnings'];


$sqlTotalStaff = "SELECT * FROM staff WHERE accountStatus = 'active'";
$resultTotalStaff = $conn->query($sqlTotalStaff);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home - <?php echo $username; ?></title>
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/book.css">
	<link rel="stylesheet" type="text/css" href="../css/graph.css">	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

	<script type="text/javascript">
		function viewBook(obj){
			var bookID = obj.id;
			window.location.href = "viewBook.php?bookID=" + bookID;
		}

		function goReport(){
			window.location.href = "report.php";
		}
	</script>
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
	<div align="center" class="sortSearchHolder" style="margin-bottom: 20px; padding: 20px 20px 20px 20px; width: 87%;">
		<div class="titleTextHolder">
			Report Analysis
		</div>
		<hr>
		<div class="kotakcategory">
			<p id="textHeader">
				General<br><br>Total <br>Books</p>
			<p class="textkotakcategory">
				<?php echo $resultTotalBook->num_rows ?></p>
			<div align="center" class="kotakgambar" >
				<i class="fa fa-book" style="font-size: 30px; vertical-align: center; padding-top: 22px;" aria-hidden="true"></i>
			</div>
		</div>
		<div class="kotakcategory">
			<p id="textHeader">
				Book<br><br>Total <br>Sold</p>
			<p class="textkotakcategory">
				<?php echo $resultTotalBookSold->num_rows ?></p>
			<div align="center" class="kotakgambar" >
				<i class="fa fa-book" style="font-size: 30px; vertical-align: center; padding-top: 22px;" aria-hidden="true"></i>
			</div>
		</div>
		<div class="kotakcategory">
			<p id="textHeader" style="width: 23%;">
				Earnings<br>(RM)<br><br><br></p>
			<p class="textkotakcategory">
				<?php echo $rowEarning ?></p>
			<div align="center" class="kotakgambar" >
				<i class="fa fa-usd" style="font-size: 30px; vertical-align: center; padding-top: 22px;" aria-hidden="true"></i>
			</div>
		</div>
		<div class="kotakcategory">
			<p id="textHeader">
				General<br><br>Total <br>Staff</p>
			<p class="textkotakcategory">
				<?php echo $resultTotalStaff->num_rows ?></p>
			<div align="center" class="kotakgambar" >
				<i class="fa fa-user-circle-o" style="font-size: 30px; vertical-align: center; padding-top: 22px;" aria-hidden="true"></i>
			</div>
		</div>
		
		<br><br><button class="submit" style="margin-left: 88%;" onclick="goReport()">Graphical Report</button>
	</div>
	<div class="sortSearchHolder" style="margin-bottom: 10px;">
		<div style="width:50%; margin-left:auto; margin-right: auto;">
			<select style="width: 40%;" id="sortBook" title="sort">
				<option selected value="titleAZ">Title A-Z</option>
				<option value="titleZA">Title Z-A</option>
				<option value="authorAZ">Author A-Z</option>
				<option value="authorZA">Author Z-A</option>
			</select>
			<input style="width: 40%; margin-left: 3%;" placeholder="Search" type="text" name="searchBook" id="searchBook">
			<i class="fa fa-times" id="clearsearch" aria-hidden="true" style="display: none;margin-left:-20px; font-size: 12px"></i>
		</div>
	</div>

	<div class="bookHolder">
		
		<div id="display_book">

		</div>
	</div>
</body>

<script type="text/javascript">
	$(document).ready(function(){

		load_book();

		//=======================================================================================

			function load_book(querySearch, par, genre){
				$.ajax({
					url:"search_book.php",
					method:"POST",
					data:{querySearch:querySearch,
						par:par,
						genre: genre
					},
					success:function(data)
					{
						$('#display_book').html(data);
					}
				});
			}

			$('#searchBook').keyup(function(){
				var search = $(this).val();
				var opt = $('#sortBook :selected').val();
				if(search != '')
				{
					$('#clearsearch').show();
					load_book(search, opt);
				}
				else
				{
					$('#clearsearch').hide();
					load_book();
				}
			});

			$('#sortBook').change(function (){
				var search = $('#searchBook').val();
				var opt = $('#sortBook :selected').val();
				if(opt != '')
				{
					load_book(search, opt);
				}
				else
				{
					load_book();
				}

			});

			$('#clearsearch').click(function(){
				$('#searchBook').val("");
				$('#clearsearch').hide();
				load_book();
			});

			<?php
			if(isset($_GET['genre'])){
				?>
				load_book("", "", "<?php echo $_GET['genre'] ?>");
				$('#searchBook').val("<?php  echo $_GET['genre'] ?>");
				$('#clearsearch').show();
				<?php
				unset($_GET['genre']);
			}

			?>
		});

</script>
</html>

<?php

include("../footer.php");
?>