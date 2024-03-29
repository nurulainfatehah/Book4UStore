<?php

include('../inc/dbconnect.php');

$username = $_POST['username'];
$name = strtoupper($_POST['name']);
$email = $_POST['email'];
$phone = $_POST['phone'];
$status = $_POST['status'];
$admin = $_POST['admin'];
$password = 'pass1234';


$sqlInsert = "INSERT INTO staff(username,password,name,accountStatus,email, phone, registeredBy) VALUES('$username','$password','$name','$status','$email','$phone','$admin')";


if($conn->query($sqlInsert) === TRUE){

		?>
		<script type="text/javascript">
			alert("New staff <?php echo $username?> has been registered successfully!");
			window.location.replace('staff.php');
		</script>
		<?php

}else{
	?>
	<script type="text/javascript">
		alert("There was a problem to register staff. Please try again");
		window.location.replace('staff.php');
	</script>
	<?php
}



?>