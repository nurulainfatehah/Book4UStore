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

$sqlstaff = "SELECT * FROM staff";
$resultstaff = $conn->query($sqlstaff);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Staff </title>
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/book.css">	
	<link rel="stylesheet" type="text/css" href="../css/staff.css">	
	<link rel="stylesheet" type="text/css" href="../css/viewBook.css">	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	

	<script type="text/javascript">
		function viewBook(obj){
			var bookID = obj.id;
			window.location.href = "viewBook.php?bookID=" + bookID;
		}

		$(document).ready(function(){

		    $('.delete').click(function(){
		       // Delete id
		        var id = $(this).data('id');
		        
		        var ask = confirm("Are you sure to delete "+id+"?");
		        if (ask == true) {
		            // AJAX Request
		            $.ajax({
		                url: 'delete_staff.php',
		                type: 'POST',
		                data: { id:id },
		                success: function(data){
		                   if(data == 1) {
		                   		alert("This staff cannot be deleted!");
								window.location.replace("staff.php");
		                   }
		                   else if (data == 2) {
		                   		alert("Staff " + id + " had successfully deleted");
								window.location.replace("staff.php");
		                   }
		                   else if (data == 3) {
		                   		alert("There was a problem to delete the staff. Please try again");
								window.location.replace("staff.php");
		                   }
		                }
		            });
		        }
		    });

		    $('.status-update').change(function(){
		       // Delete id
		        var status = $(this).val();
		        var id = $(this).data('id');

		        var ask = confirm("Are you sure to update status "+id+" to "+status+"?");
		        if (ask == true) {
		            
		            $.ajax({
		                url: 'update_staff_status.php',
		                type: 'POST',
		                data: { id:id, status:status },
		                success: function(data){
		                   if (data == 1) {
		                   		alert("Account status for " + id + " had successfully update");
								window.location.replace("staff.php");
		                   }
		                   else if (data == 0) {
		                   		alert("There was a problem to update the staff account status. Please try again");
								window.location.replace("staff.php");
		                   }
		                }
		            });
		        }
		    });
		});

	</script>
</head>
<body>
	<header>
		<a href="../admin" class="logo">BOOK4U STORE</a>
		<nav>
			<ul>
				<li><a href="../admin">HOME</a></li>
				<li><a href="staff.php"  class="activebar">STAFF</a></li>
				<li><a href="c-19test.php">C-19 TEST</a></li>
				<li><a href="profile.php"><?php echo strtoupper($username); ?></a></li>
				<li><a href="../signOut.php">SIGN OUT</a></li>
			</ul>
		</nav>
		<div class="clearfix"></div>
	</header>

	<div class="maincontainer" style="margin-bottom: 10px;">
		<div class="boxHolder">
			<form method="post" enctype="multipart/form-data" action="insert_staff.php" id="form">

				<table align="center" cellpadding="10" width="45%">
					<th colspan="2" style="font-size: 20px; margin-bottom: 35px; padding: 8px 0;">
						STAFF REGISTRATION
					</th>
					<tr>
						<th align = 'left' style="width: 30%">USERNAME 
							
						</th>
						<td><input type="text" cols="40" name="username" placeholder="USERNAME" >
							<span class="asterisk_input"></span>
						</td>
					</tr>
					<tr>	
						<th align = 'left'>NAME
							
						</th>
						<td><input type="text" cols="40" name="name" style="text-transform: uppercase;" placeholder="NAME" >
							<span class="asterisk_input"></span>
						</td>
					</tr>
					<tr>
						<th align = 'left' >STATUS 
							
						</th>
						<td><select style="width: 82%;" name="status" >
								<option selected value="active">ACTIVE</option>
								<option value="inactive">INACTIVE</option>
								
							</select>
						</td>
					</tr>
					<tr>
						<th align = 'left' >EMAIL 
							
						</th>
						<td><input type="text" cols="40" name="email" placeholder="EMAIL">
							<span class="asterisk_input"></span>
						</td>
							
					</tr>
					<tr>
						<th align = 'left' >PHONE  
							
						</th>
						<td><input type="text" cols="40" name="phone" placeholder="PHONE">
							<input type="hidden" cols="40" name="admin" value="<?php echo $username?>">
							<span class="asterisk_input"></span>
						</td>
					</tr>
					
					<tr>
						<th colspan="2" style="text-align: center;">
							<input type="reset" name="reset" value="CLEAR FORM" class="submit">
							<input type="submit" value="REGISTER STAFF" name="submit" class="submit" style="width: 30%">		
						</th>
					</tr>
				</table>
			</form>
		</div>
	<center>
		<div class="staff-table">
			<table align="center" width="100%" border="1" id="stafftable">
				<th colspan="7" style="font-size: 17px; margin-bottom: 35px; padding: 8px 0;">
						STAFF
					</th>
				<tr align="center">
					<td>
						#
					</td>
					<td>
						<b>Username</b>
					</td>
					<td>
						<b>Name </b>
					</td>
					<td>
						<b>Email</b>
					</td>
					<td>
						<b>Phone</b>
					</td>
					<td>
						<b>Status</b>
					</td>
					<td>
						
					</td>

				</tr>
				<?php $counter = 0;
				while($row = $resultstaff->fetch_assoc()){
					$counter++;
					$id = $row['username'];
					$sqlGet = "SELECT * FROM book WHERE uploadedBy = '".$row['username']."'";
					$resultGet = $conn->query($sqlGet);

					$sqlST = "SELECT * FROM c19swabtest WHERE staff = '".$row['username']."'";
					$resultST = $conn->query($sqlST);
					?>

					<tr>
						<td>
							<?php echo $counter; ?>
						</td>
						<td>
							<?php echo $row['username']; ?>
						</td>
						<td>
							<?php echo $row['name']; ?>
						</td>
						<td>
							<?php echo $row['email']; ?>
						</td>
						<td>
							<?php echo $row['phone']; ?>
						</td>
						<td>
							<select class="status-update" data-id='<?= $id; ?>'>
								<?php if ($row['accountStatus'] == "active") { ?>
									<option value="active" selected>Active</option>
									<option value="inactive" >Inactive</option>
								<?php } else { ?>
									<option value="active" >Active</option>
									<option value="inactive" selected>Inactive</option>
								<?php } ?>
							</select>
						</td>
						<td style="font-size: 18px;">
							<?php
							if($resultGet->num_rows > 0){
							?>
								<span data-id='<?= $id; ?>' title='cannot delete <?php echo $row['username'] ?> as it associates with previous book records.'><i class="fa fa-trash-o"></i></span>
								<?php
							}else if($resultST->num_rows > 0){?>
								<span data-id='<?= $id; ?>' title='cannot delete <?php echo $row['username'] ?> as it associates with previous swab test records.'><i class="fa fa-trash-o"></i></span><?php
							}else{
								?>
								<span class='delete' title="delete <?php echo $row['username'] ?>?" data-id='<?= $id; ?>' style="cursor: pointer;"><i class="fa fa-trash-o"></i></span>
								<?php
							}
							?>
							
						</td>
					</tr>
					<?php

				}

				?>
			</table>
		</div>
	</center>
	<br><br>
	</div>

</body>

</html>

<?php

include("../footer.php");
?>