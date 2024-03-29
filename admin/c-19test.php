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

$sqlswab = "SELECT * FROM c19swabtest JOIN staff ON c19swabtest.staff = staff.username ORDER BY resultDate DESC";
$resultswab = $conn->query($sqlswab);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>C-19 Test</title>
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/c-19.css">	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<body>
		<header>
			<a href="../admin" class="logo">BOOK4U STORE</a>
			<nav>
				<ul>
					<li><a href="../admin">HOME</a></li>
					<li><a href="staff.php">STAFF</a></li>
					<li><a href="c-19test.php" class="activebar">C-19 TEST</a></li>
					<li><a href="profile.php"><?php echo strtoupper($username); ?></a></li>
					<li><a href="../signOut.php">SIGN OUT</a></li>
				</ul>
			</nav>
			<div class="clearfix"></div>
		</header>
		<div class="boxHolder">
			<div class="staff-table">
				<table align="center" width="100%" cellpadding="6" border="1" id="stafftable">
					<th colspan="5" style="font-size: 17px; margin-bottom: 35px; padding: 8px 0;">
						Covid-19 Swab Test Result
					</th>
					<tr align="center">
						<td>
							#
						</td>
						<td>
							<b>Staff</b>
						</td>
						<td>
							<b>Proof</b>
						</td>
						<td>
							<b>Date Time</b>
						</td>
						<td>
							<b>Result</b>
						</td>
					</tr>
					<?php $counter = 0;
					while($row = $resultswab->fetch_assoc()){
						$counter++;
						?>

						<tr>
							<td align="center">
								<?php echo $counter; ?>
							</td>
							<td>
								<?php echo $row['name']; ?>
							</td>
							<td align="center">
								<a href="../imgsource/c-19/<?php echo $row['resultProof']; ?>" target="_blank"><img src="../imgsource/c-19/<?php echo $row['resultProof']?>" alt="<?php echo $row['resultProof'];?>" srcset="" width="100px"></a>
							</td>
							<td align="center">
								<?php echo date("d-m-Y h:i:s", strtotime($row['resultDate'] )) ?>
							</td>
							<td align="center">
								<?php echo $row['result']; ?>
							</td>
						</tr>
						<?php

					}

					?>
				</table>
			</div>
		</div>
	</body>
	</html>