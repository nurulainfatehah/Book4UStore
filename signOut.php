<?php
session_start();

$_SESSION = array();
	
echo "<meta http-equiv=\"refresh\" content=\"0;URL=signIn.php\">";
session_destroy();
?>