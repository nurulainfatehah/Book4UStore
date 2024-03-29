
<?php session_start();
include('inc/dbconnect.php');

if(!isset($_SESSION['username']))
{
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
	$password = $_POST['password'];
}else{
	?>
	<script type="text/javascript">	
		alert("Incorrect username or password. Please try again.");
		window.location.replace('signIn.php');
		
	</script>
	<?php
}

?>
<html>
	<head>
	<title>Validating..</title>
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<script type="text/javascript">
		function wrongpwusername()
		{
			alert("Incorrect username or password. Please try again.");
			window.location.replace('signIn.php');
		}
	</script>

	</head>
<?php
$sql = "SELECT * FROM admin WHERE username ='" . $_SESSION['username'] . "'";
$sql1 = "SELECT * FROM staff WHERE username ='" . $_SESSION['username'] . "'";
$sql2 = "SELECT * FROM customer WHERE username ='" . $_SESSION['username'] . "'";

$result=$conn->query($sql);
$result1=$conn->query($sql1);
$result2=$conn->query($sql2);

if(($result->num_rows == 0) && ($result1->num_rows == 0) && ($result2->num_rows == 0))
{

	?>
	
	<body onload= "wrongpwusername();">
	</body>


<?php 	
}
else if($result->num_rows == 1)
{
	$row = $result->fetch_assoc();
	$pw = $row['password'];

	if(password_verify($password,$pw)){
		?>
		<script type="text/javascript">	
			alert("Welcome, <?php echo $_SESSION['username'] ?>");
			window.location.replace('admin');
			
		</script>
		<?php
	}else{
		?>
		<body onload= "wrongpwusername();"></body>
		<?php
	}
	
}
else if($result1->num_rows == 1)
{
	$row = $result1->fetch_assoc();
	$pw = $row['password'];
	if($row['accountStatus'] == "inactive"){
		?>
		<script type="text/javascript">	
			alert("Sorry <?php echo $_SESSION['username'] ?>, your account had been deactivated by the administrator. Please reach the administrator if you think this is a mistake");
			window.location.replace('signIn.php');
			
		</script>
		<?php
	}else{
		if(password_verify($password,$pw)){
		?>
		<script type="text/javascript">	
			alert("Welcome, <?php echo $_SESSION['username'] ?>");
			window.location.replace('staff');
			
		</script>
			<?php
		}else{
			?>
			<body onload= "wrongpwusername();"></body>
			<?php
		}
		?>
		
		<?php
	}

}
else if($result2->num_rows == 1)
{
	$row = $result2->fetch_assoc();
	$pw = $row['password'];
	if(password_verify($password,$pw)){
		?>
		<script type="text/javascript">	
			alert("Welcome, <?php echo $_SESSION['username'] ?>");
			window.location.replace('customer');
			
		</script>
			<?php
	}else{
		?>
		<body onload= "wrongpwusername();"></body>
		<?php
	}
	?>
	
	<?php
}


$conn->close();


?>