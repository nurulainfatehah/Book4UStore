<?php

include('../inc/dbconnect.php');

$output = 0;
$username = '';
if(isset($_POST['id'])){
   $username = $_POST['id'];
}


$sqlsearch = "SELECT * FROM book WHERE uploadedBy = '$username'";
$resultsearch = mysqli_query($conn, $sqlsearch);

if ($resultsearch-> num_rows > 0)  {
	$output = 1;
	
}

else {
	$sqlDeletestaff = "DELETE FROM staff WHERE username = '".$username."'";
	if($conn->query($sqlDeletestaff) === TRUE){
		$output = 2;

		
	}else{
		$output = 3;
		
	}
}

echo $output;
?>