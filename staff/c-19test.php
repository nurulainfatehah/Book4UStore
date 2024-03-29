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


$sqlneworder = "SELECT * FROM `purchase` WHERE status = 'in process'";
$resultneworder = $conn->query($sqlneworder);

$sqlswab = "SELECT * FROM c19swabtest WHERE staff = '".$username."' ORDER BY resultDate DESC";
$resultswab = $conn->query($sqlswab);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>C-19 Test</title>
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/c-19.css">	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	
	<style type="text/css">

		.error{
			margin-left: 20px;
		}
		.postResult table{
			width: 40%;
			margin-left: auto;
			margin-right: auto;
			text-align: left;
		}

		.postResult tr
		{
			background-color: white;
		}


	</style>
</head>
<body>
	<header>
		<a href="../staff" class="logo">BOOK4U STORE</a>
		<nav>
			<ul>
				<li><a href="../staff">HOME</a></li>
				<li><a href="postBook.php">POST BOOK</a></li>
				<li><a href="order.php">ORDER [<?php echo $resultneworder->num_rows ?>]</a></li>
				<li><a href="c-19test.php" class="activebar">C-19 TEST</a></li>
				<li><a href="profile.php"><?php echo strtoupper($username); ?></a></li>
				<li><a href="../signOut.php">SIGN OUT</a></li>
			</ul>
		</nav>
		<div class="clearfix"></div>
	</header>
	<div class="boxHolder">
		<div class="postResult">
		<form method="post" enctype="multipart/form-data" action="insert_result.php" id="form">

				<table align="center" cellpadding="6" width="50%">
					<th colspan="2" align = 'left' style="font-size: 20px;  border-bottom: 5px solid rgba(103, 128, 159, 1); margin-bottom: 35px; padding: 8px 0;">
						C-19 SWAB TEST RESULT
					</th>
					<tr>
						<th align = 'left' >RESULT 
							
						</th>
						<td><select style="width: 70%;" name="result" >
								<option selected value="Negative">NEGATIVE</option>
								<option value="Positive">POSITIVE</option>
								
							</select>
						</td>
					</tr>
					<tr>	
					<th align = 'left'>PROOF
						
					</th>
					<td><input type="file" id="resultProof" name="resultProof" accept="image/png, image/gif, image/jpeg, image/jpg, application/pdf" ><span class="asterisk_input" style="margin-left: 56px; "></span>
					</td>
					</tr>
					
					<tr>
						<th colspan="2" style="text-align: center;">
							<input type="reset" name="reset" value="CLEAR FORM" class="submit">
							<input type="submit" value="SUBMIT FORM" name="submit" class="submit">		
						</th>
					</tr>
				</table>
		</form>
		</div>
		<br><br><br>
		<table align="center" style="text-align: center;" width="80%" border="1">
			<tr align="center">
				<td>
					#
				</td>
				<td>
					Swab Test Result
				</td>
				<td>
					Proof
				</td>
				<td>
					Date
				</td>
				<td>
					Delete
				</td>
			</tr>
			<?php $counter = 0;
			while($row = $resultswab->fetch_assoc()){
				$counter++;
				$resultID = $row['resultID'];
				?>

				<tr>
					<td>
						<?php echo $counter; ?>
					</td>
					<td>
						<?php echo $row['result']; ?>
					</td>
					<td>
						<a href="../imgsource/c-19/<?php echo $row['resultProof']; ?>" target="_blank"><?php echo $row['resultProof']; ?></a>
					</td>
					<td>
						<?php echo date("d-m-Y h:i:s", strtotime($row['resultDate'] ));?>
					</td>
					<td style="font-size: 18px;">
						
						<a onClick="return confirm('Are you sure you want to delete this?')" href="delete_result.php?resultID=<?php echo $row['resultID'] ?>" title="delete result?"><i id="delete" class="fa fa-trash-o"></i></a>

					</td>
				</tr>
				<?php

			}

			?>
		</table>




	</div>
	</body>
</html>

<?php

include("../footer.php");
?>