<?php
session_start();
include('inc/dbconnect.php');
include('processValidateUsername.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/signIn.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<style>
		
		.form
		{	
			margin-top: 20px;
			align-content: center;
			align-items: center;
			width: 100%;
			height: 100%;

		}
		.submit
		{
			background: pink;
			height: 30px;
			width: 180px;
			font: inherit;
			border: none;
			cursor: pointer;

		}
		.submit:hover
		{
			background: #ff0072;
			color: white;
			border: none;
		}

		.fa
		{
			font-size: 18px;
			color: pink;
		}
		input[type="text"], input[type="email"], input[type="number"], input[type="password"], textarea{
			border:none;
			outline: none;
			background: none;
			color: white;
			border-bottom: 1px solid  pink;
		}

		input[type="text"], textarea{
			text-transform: uppercase;
		}

		body{
			padding-bottom: 20px;
		}

	</style>

	<script> 

		function namecheck()
		{
			x = form.name.value; 
			e = form.email.value;

			if (x == "") 
			{
				alert("Name must be filled out");
				document.getElementById("errorfn").innerHTML = "*";
				return false;
			}
			else if(x.length < 5 || x.length > 100)
			{
				alert("Name must be in between 5 to 100 characters only.");
				document.getElementById("errorfn").innerHTML = "*";
				return false;
			}
			else if (e == "")
			{
				alert("Email must be filled out");
				document.getElementById("errore").innerHTML = "*";
				return false;
			}

			result = true;
			return result;

		}


		function phonecheck()
		{	
			var phoneno = /^\d{11}$/;
			var phoneno1 = /^\d{10}$/;
			phone1 = form.phone.value;
			if(phone1.match(phoneno) || phone1.match(phoneno1))
			{
				result = true;
				return result;
			}
			else
			{
				alert("invalid length of phone number. must be between 10-11 numbers");
				document.getElementById("errorphone").innerHTML = "*";
				return false;
			}
		}


		function addresscheck()
		{
			add = form.address.value;
			if(add == "")
			{
				alert("Address must be filled out");
				document.getElementById("erroraddress").innerHTML = "*";
				return false;
			}
			else if(add.length < 10 || add.length > 200)
			{
				alert("Invalid address. Address must be between 10 to 200 characters");
				document.getElementById("erroraddress").innerHTML = "*";
				return false;
			}
			result = true;
			return result;
		}

		function usernamecheck()
		{
			un = form.username.value;
			if(un == "")
			{
				alert("Please enter username");
				document.getElementById("errorusername").innerHTML = "*";
				return false;
			}
			result = true;
			return result;
		}

		function passwordcheck()
		{
			password = form.password.value; 
			password1 = form.password1.value; 

			if (password == '')
			{
				alert ("Please enter password");  
				document.getElementById("errorpw").innerHTML = "*";
				return false;
			}
			else if (password1 == '') 
			{
				alert ("Please enter confirm password");
				document.getElementById("errorpw1").innerHTML = "*";
				return false;
			}
			else if (password != password1) 
			{ 
				alert ("\nConfirm password does not match with password");
				document.getElementById("errorpw").innerHTML = "*";
				document.getElementById("errorpw1").innerHTML = "*";
				return false;
			}
			else if (password == "12345" || password == "1234567890" )
			{
				alert("Password is too predictable. Change for security purpose.");
				document.getElementById("errorpw").innerHTML = "*";
				document.getElementById("errorpw1").innerHTML = "*";
				return false;
			}
			else if(password.length < 7)
			{
				alert("Password must be at least 7 characters!");
				document.getElementById("errorpw").innerHTML = "*";
				return false;
			}else if(password.length > 50)
			{
				alert("Password must not exceed 50 characters!");
				document.getElementById("errorpw").innerHTML = "*";
				return false;
			}

			result = true;
			return result;
		}


		function check(form){
			document.getElementById("errorfn").innerHTML = "";
			document.getElementById("errore").innerHTML = "";
			document.getElementById("errorphone").innerHTML = "";
			document.getElementById("erroraddress").innerHTML = "";
			document.getElementById("errorusername").innerHTML = "";
			document.getElementById("errorpw").innerHTML = "";
			document.getElementById("errorpw1").innerHTML = "";
			var result = false;

			if(usernamecheck() == true){
				if (passwordcheck() == true){
					if(namecheck() == true)
					{
						if(phonecheck() == true)
						{
							if(addresscheck() == true)
							{
								return true;
							}
						}
					}
				}
			}
			
			return false;
		}
	</script>
</head>
<body>
	<header>
		<a href="index.php" class="logo">BOOK4U STORE</a>
		<nav>
			<ul>
				<li><a href="#" onclick="window.alert('Please Sign In First')">CART</a></li>
				<li><a href="signIn.php">SIGN IN</a></li>
				<li><a class="activebar" href="signUp.php">CREATE ACCOUNT</a></li>
			</ul>
		</nav>
		<div class="clearfix"></div>
	</header>
	<form action="register.php" enctype="multipart/form-data" method="POST" id="form" onsubmit="return check(this);">
		<div class="form">
			<fieldset class="fieldset1">
				<h1 style="float: left; margin-right: 30px; font-size: 30px; color: white;border-bottom: 6px solid pink;padding: 13px 20px;">
					SIGN UP
				</h1>
				<table  align="center" cellpadding="5" style="padding-top: 30px; margin-left: 0; margin-right: 0; width: 70%">
					<tr>
						<td style="color: white">
							USERNAME
						</td>
						<td>&nbsp;
							<input type="text" style="text-transform: none;" name="username" id="username" size="20" placeholder="USERNAME" title="pick a unique username. it cannot be changed later!">
							<span id="errorusername" class="error">*</span>
						</td>
					</tr>


					<tr>
						<td style="color: white">
							PASSWORD
						</td>
						<td>&nbsp;
							<input type="password" name="password" id="password" placeholder="*******" title="Password must be at least 7 characters with mixture of alphabets and at least a number">
							<span id="errorpw" class="error">*</span>
						</td>
					</tr>


					<tr>
						<td style="color: white">
							CONFIRM PASSWORD
						</td>
						<td>&nbsp;
							<input type="password" name="password1" id="password1" placeholder="*******" title="Password must be at least 7 characters with mixture of alphabets and at least a number">
							<span id="errorpw1" class="error">*</span>
						</td>
					</tr>
					<tr>
						<td style="color: white">
							NAME
						</td>
						<td>&nbsp;
							<input type="text" name="name" id="name" size="30" placeholder="NAME" >
							<span id="errorfn" class="error">*</span>
						</td>
					</tr>
					<tr>
						<td style="color: white">PICTURE</td>
						<td>
							<input type="file" style="color: gray;" accept="image/png, image/gif, image/jpeg, image/jpg" name="picture" /><br>
							<p class="warning"><strong>Note:</strong>Only picture of type .png, .gif, .jpeg and .jpg are allowed.</p>
						</td>
					</tr>
					<tr>
						<td style="color: white">
							EMAIL
						</td>
						<td>&nbsp;
							<input type="email" name="email" size="30" id="email" placeholder="example@example.com" >
							<span id="errore" class="error">*</span>
						</td>
					</tr>
					<tr>
						<td style="color: white">
							GENDER 
						</td>

						<td>&nbsp;
							<input type="radio" checked="" name="gender" title="Female"  required="" 
							<?php if (isset($gender) && $gender=="female") echo "checked";?>
							value="Female" >
							<i class="fa fa-venus" aria-hidden="true" title="Female"></i>

							<input type="radio" name="gender" title="Male" 
							<?php if (isset($gender) && $gender=="male") echo "checked";?>
							value="Male">
							<i class="fa fa-mars" aria-hidden="true" title="Male"></i>

						</td>
					</tr>

					<tr>
						<td style="color: white; ">
							PHONE
						</td>
						<td>&nbsp;
							<input type="number" name="phone" id="phone" placeholder="PHONE" title="must be a 10-11 lengthed phone number!" >
							<span id="errorphone" class="error">*</span>
						</td>
					</tr>


					<tr>
						<td style="color: white">
							ADDRESS
						</td>
						<td>&nbsp;
							<textarea  cols="34" rows="3" name="address" id="address" title="house no/ street no/ region/ postal code/ city, state " placeholder="ADDRESS"></textarea>
							<span id="erroraddress" class="error">*</span>
						</td>
					</tr>
				</table>
				<div style="width: 60%; text-align: right; margin-top: 10px; margin-left: 30%; margin-bottom: 10px">
					<input id="reset" class="submit" type="reset" name="clear" value="RESET"><input type="submit" class="submit" id="submit" name="submit" value="CREATE ACCOUNT"/>
				</div>
			</form>
		</div>
	</fieldset>

	<?php
	include ("footer.php");?>


</body>
</html>

<script src="js/validateUsername.js"></script>