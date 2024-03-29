<?php

include('../inc/dbconnect.php');

$output = 0;
$username = '';
$status = '';

if(isset($_POST['id']) && isset($_POST['status']) ){
   $username = $_POST['id'];
   $status = $_POST['status'];
}


$sqlupdate = "UPDATE staff SET accountStatus = '$status' WHERE username = '$username'";
$resultupdate = mysqli_query($conn, $sqlupdate);

if($conn->query($sqlupdate) === TRUE){
		$output = 1;
		
		
	}
	else{
		$output = 0;
		
	}

echo $output;
?>