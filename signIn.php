<?php
session_start();

if (isset($_SESSION['username']))
{
	$_SESSION = array();
		session_destroy();
}

?>
<html>
<head>
<title>Sign In</title>
<link rel="stylesheet" type="text/css" href="css/header.css">
<link rel="stylesheet" type="text/css" href="css/signIn.css">
<style>
	p.center
	{
		text-align:center;
	}
	.submit
	{
		background: pink;
		height: 30px;
		width: 180px;
		font: helvetica;
		cursor: pointer;
		border: none;
	
	}
	.submit:hover
	{
		background: #ff0072;
		color: white;
		border: none;
	}

</style>
<script type="text/javascript">
	function checkform(){
		var username = form.username.value;
		var password = form.password.value;

		if(username.length == 0){
			alert("Please enter username");
			return false;
		}else if(password.length == 0){
			alert("Please enter password");
			return false;
		}else if(password.length < 7){
			alert("Invalid length of password. Password must be atleast 7 characters");
			return false;
		}else{
			return true;
		}
	}
</script>
</head>
<body >
	
	<header>
		<a href="index.php" class="logo">BOOK4U STORE</a>
		<nav>
			<ul>
				<li><a href="#" onclick="window.alert('Please Sign In First')">CART</a></li>
				<li><a class="activebar" href="signIn.php">SIGN IN</a></li>
				<li><a href="signUp.php">CREATE ACCOUNT</a></li>
			</ul>
		</nav>
		<div class="clearfix"></div>
	</header>

	<fieldset>
		<div class="login-box">
			<table  width="30%" align="center" style= "margin-top:30px; background-color: transparent; font-size: 20px;">
				<h1>Sign In</h1>
			<form name="form" action="signinprocess.php" method="POST"  onsubmit="return checkform()">
			<tr><th><img src="imgsource/basic/profile.png" class="picsize"/></th><td><div class="textbox">
				
				<input type="text" name="username" placeholder="USERNAME" style="width: 100%;">
				<span class="asterisk_input"></span>
				</div></td></tr>
			<tr><th><img src="imgsource/basic/padlock.png" class="picsize" /></th><td><div class="textbox">
				
				<input type="password" placeholder="********" name="password" style="padding-left: 4px;width: 100%;"><span class="asterisk_input"></span></div></td></tr><th></th><th></th><th><th>
			<tr><tr></tr><tr></tr><th colspan="2"><input class="submit" type="submit" value="SIGN IN" name="submit"></th>
			</form>
			</table>

				<p class="center"><b style="color: white;">New User? </b><a href="signUp.php" style="color: pink; font-family:"> register now </a></p>
		</div>
	</fieldset>
<?php include("footer.php")?>
</body>
</html>

