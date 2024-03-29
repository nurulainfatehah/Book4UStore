<?php
$servername="localhost";
$username="root";
$password="";
$dbname="book4u";
//$dbname="student_b032020035";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}



?>