<?php

if(isset($_POST['updatestaff_check'])){
	$username = $_POST['username'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$password = $_POST['password'];
	$realpassword = $_POST['realpassword'];
	$passVerify = $_POST['passVerify'];

	if(password_verify($passVerify,$realpassword)){

		if($password == ""){
			$sql = "UPDATE staff SET email = '".$email."', phone = '".$phone."' WHERE username = '".$username."'";
		}else{
			$hash_password = password_hash($password, PASSWORD_DEFAULT);
			$sql = "UPDATE staff SET email = '".$email."', phone = '".$phone."', password = '".$hash_password."' WHERE username = '".$username."'";
		}

		if($conn->query($sql) === TRUE){
			echo "updated";	

		}else{
			echo "notupdated";	
		}

	}else{
		echo "wrongpassword";
		exit();
	}

	exit();
}else if(isset($_POST['updateadmin_check'])){
	$username = $_POST['username'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$password = $_POST['password'];
	$realpassword = $_POST['realpassword'];
	$passVerify = $_POST['passVerify'];

	if(password_verify($passVerify,$realpassword)){

		if($password == ""){
			$sql = "UPDATE admin SET email = '".$email."', phone = '".$phone."' WHERE username = '".$username."'";
		}else{
			$hash_password = password_hash($password, PASSWORD_DEFAULT);
			$sql = "UPDATE admin SET email = '".$email."', phone = '".$phone."', password = '".$hash_password."' WHERE username = '".$username."'";
		}

		if($conn->query($sql) === TRUE){
			echo "updated";	

		}else{
			echo "notupdated";	
		}

	}else{
		echo "wrongpassword";
		exit();
	}

	exit();

	
}else if(isset($_POST['updatecustomer_check'])){
	$username = $_POST['username'];
	$name = strtoupper($_POST['name']);
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$password = $_POST['password'];
	$address = strtoupper($_POST['address']);
	$realpassword = $_POST['realpassword'];
	$passVerify = $_POST['passVerify'];

	if(password_verify($passVerify,$realpassword)){

		if($password == ""){
			$sql = "UPDATE customer SET name = '".$name."', email = '".$email."', phone = '".$phone."', address = '".$address."' WHERE username = '".$username."'";
		}else{
			$hash_password = password_hash($password, PASSWORD_DEFAULT);
			$sql = "UPDATE customer SET name = '".$name."', email = '".$email."', phone = '".$phone."', password = '".$hash_password."', address = '".$address."' WHERE username = '".$username."'";
		}

		if($conn->query($sql) === TRUE){
			echo "updated";	

		}else{
			echo "notupdated";	
		}

	}else{
		echo "wrongpassword";
		exit();
	}

	exit();
}



?>