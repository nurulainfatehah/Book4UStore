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
include('../ajaxs/updateProfile.php');
$sqlMe = "SELECT * FROM customer WHERE username = '".$username."'";
$resultMe = $conn->query($sqlMe);
$rowMe = $resultMe->fetch_assoc();


if(isset($_POST['submitpicture'])){

	$file = $_FILES["file_picture"];
	$fileName = $file['name'];
	$fileTmpName = $file['tmp_name'];
	$fileSize = $file['name'];
	$fileError = $file['error'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

		if($fileError == 0) //PICTURE HAS NO PROBLEM 
		{
			if($fileSize < 10000) //PICTURE DOES NOT EXCEED 10MB
			{
				$fileNameNew = $username . "_profile." . $fileActualExt ;
				$fileDestination = '../imgsource/profile/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);

						//INSERT EVERY COLUMN
				$sqlRegister = "UPDATE customer SET picture = '".$fileNameNew."' WHERE username = '".$username."'";

				if($conn->query($sqlRegister) === TRUE)
				{
					unset($_POST['submitpicture']);
					echo("<script>location.href = 'profile.php?changed';</script>");
				}else{
					?>
					<script>
						invalid();
					</script>
					<?php 
				}

			}else{
				?>
				<script>
					pictTooBig();
				</script>
				<?php 
			}
		}else{
			?>
			<script>
				pictNotFound();
			</script>
			<?php 
		}

	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Profile - <?php echo $username; ?></title>
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/book.css">
	<link rel="stylesheet" type="text/css" href="../css/profile.css">	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function (){

			$('#name').css('border','1px solid transparent');
			$('#email').css('border','1px solid transparent');
			$('#phone').css('border','1px solid transparent');
			$('#address').css('border','1px solid transparent');
			$('#pass1').css('border','1px solid transparent');
			$('#pass2').css('border','1px solid transparent');
			$('#name').prop('readonly',true);
			$('#email').prop('readonly',true);
			$('#phone').prop('readonly',true);
			$('#address').prop('readonly',true);
			$('#pass1').prop('readonly',true);
			$('#pass2').prop('readonly',true);

			$('#changepic').click(function(){
				$('#file_picture').toggle();
				$('#submitpicture').toggle();
			});

			$('#hideUpload').click(function(){
				$('#file_picture').val('');
				$('#file_picture').toggle();
				$('#submitpicture').toggle();
			 
			});

			$('#edit').click(function(){
				$('#name').css('border','1px solid #ccc');
				$('#email').css('border','1px solid #ccc');
				$('#phone').css('border','1px solid #ccc');
				$('#address').css('border','1px solid #ccc');
				$('#pass1').css('border','1px solid #ccc');
				$('#pass2').css('border','1px solid #ccc');
				$('#name').prop('readonly',false);
				$('#email').prop('readonly',false);
				$('#phone').prop('readonly',false);
				$('#address').prop('readonly',false);
				$('#pass1').prop('readonly', false);
				$('#pass2').prop('readonly', false);
				$('#cancelEdit').show();
				$('#edit').hide();
				$('#update').css('visibility', 'visible');
			});

			$('#cancelEdit').click(function(){
				$('#cancelEdit').hide();
				$('#edit').show();

				$('#update').css('visibility', 'hidden');
				$('#email').val("<?php echo $rowMe['name']?>");
				$('#email').val("<?php echo $rowMe['email']?>");
				$('#phone').val("<?php echo $rowMe['phone']?>");
				$('#address').val("<?php echo $rowMe['address']?>");
				$('#pass1').val("");
				$('#pass2').val("");
				$('#name').css('border','1px solid transparent');
				$('#email').css('border','1px solid transparent');
				$('#phone').css('border','1px solid transparent');
				$('#address').css('border','1px solid transparent');
				$('#pass1').css('border','1px solid transparent');
				$('#pass2').css('border','1px solid transparent');
				$('#name').prop('readonly',true);
				$('#email').prop('readonly',true);
				$('#phone').prop('readonly',true);
				$('#address').prop('readonly',true);
				$('#pass1').prop('readonly',true);
				$('#pass2').prop('readonly',true);
			});


			/*$('#pass2').on('blur', function(){
				var pass1 = $('#pass1').val();
				var pass2 = $('#pass2').val();

				
				if(pass2!=pass1){
					$("#pass1").val("");
					$("#pass2").val("");

					alert("Password and confirm password is mismatch. Please try again.");
					$("#pass1").focus();
					$('#update').prop('disabled', true);					
					$('#update').css({ 'color': 'white', 'background-color': 'gray' });
				} else if(pass1.length < 8 || pass1.length > 50){
					alert("Invalid length of password! Password must be between 8 to 50 characters only.");
					$('#pass1').focus();
					$('#update').prop('disabled', true);					
					$('#update').css({ 'color': 'white', 'background-color': 'gray' });
				}else{
					$('#update').prop('disabled', false);
			        $('#update').css({ 'color': 'black', 'background-color': 'pink' });
				}
			});*/

			$('#email').on('blur', function(){
				var email = $('#email').val();
				if (email == '') {
					alert("Please fill in all fields");
					$('#update').prop('disabled', true);					
					$('#update').css({ 'color': 'white', 'background-color': 'gray' });
				}else if (/\s/.test(email)) {
					
					alert("Email shall not have any whitespaces. Please try again");
					$('#update').prop('disabled', true);					
					$('#update').css({ 'color': 'white', 'background-color': 'gray' });
				}else{
					$('#update').prop('disabled', false);
			        $('#update').css({ 'color': 'black', 'background-color': 'pink' });
			        $("#update").mouseenter(function() {
			          $(this).css("background-color", "#ff0072").css("color", "white");
			        }).mouseleave(function() {
			         $(this).css("background-color", "pink").css("color", "black");
			       });
				}
			});

			function succeed(){
				window.location.replace("profile.php");	
			}

		});

		function validatePic(){

			if(document.getElementById("file_picture").files.length == 0 ){
				alert("Please upload your picture to continue.");
				return false;
			}else{
				return true;
			}
		}

		function showpass(){
			var showpass1 = document.getElementById('pass1');
			var showpass2 = document.getElementById('pass2');

			if(showpass1.type == "password")
			{
				showpass1.type = "text";
				showpass2.type = "text";
			}
			else
			{
				showpass1.type = "password";
				showpass2.type = "password";
			}
		}

		function update(password){
			var passVerify = password;
			var username = $('#hiddenusername').val();
			var name = $('#name').val();
			var email = $('#email').val(); 
			var phone = $('#phone').val();
			var password = $('#pass1').val();
			var address = $('#address').val();
			var realpassword = $('#hiddenpw').val();

			$.ajax({

				url: "profile.php",
				type: "POST",
				cache: false,
				data:{
					updatecustomer_check : 1,
					username: username,
					name: name,
					email: email,
					phone: phone,
					password: password,
					address: address,
					passVerify: passVerify,
					realpassword: realpassword

				},
				success: function(response){
					if (response == 'updated' ) {
						alert("Successfully updated");
						location.reload();
						
					}else if (response == 'notupdated') {
						alert("Failed to update. Please try again");
					}else if(response == 'wrongpassword'){
						alert("Password entered does not match with your current password. Please try again.");
					}else{
						alert(response);
					}
				}
			});
		}

		function validateUpdate(){
			var email = $('#email').val();
			var phone = $('#phone').val();
			var password = $('#pass1').val();
			var pass1 = $('#pass1').val();
			var pass2 = $('#pass2').val();
			var address = $('#address').val();


			if(email.length < 3 || email.length > 200){

				alert("Email must be between 3 to 200 characters only. Please try again");
				return false;
			}else if(phone.length < 10 || phone.length > 11){
				alert("Phone must be between 10 to 11 digits only. Please try again");
				return false;
				
			}else if(address.length < 10 || address.length > 200){
				alert("Invalid address. Address must be between 10 to 200 characters. Please try again");
				return false;

			}else{
				if(pass1.length > 0){
					if(pass1.length < 7){
						alert("Invalid length of password! Password must be between 7 to 50 characters.");
						return false;
					}else if(pass1 != pass2){
						alert("Password and confirm password is mismatch. Please try again.");
						return false;
					}
				}
				$.confirm({
					boxWidth: '27%',
					typeAnimated: true,
				    useBootstrap: false,
				    autoClose: 'cancel|15000',
				    title: 'Are you sure to update?',
				    content: '' +
				    '<form action="" class="formName" id="formdialog">' +
				    '<div class="form-group">' +
				    '<label>Enter your current password to continue</label>' +
				    '<input style="padding-top: 10px; padding-bottom: 10px" type="password" placeholder="current password" class="name form-control" required />' +
				    '</div>' +
				    '</form>',
				    buttons: {
				        formSubmit: {
				            text: 'Submit',
				            btnClass: 'btn-blue',
				            action: function () {
				                var currentpass = this.$content.find('.name').val();
				                
				                update(currentpass);
				                /*if(currentpass != passform){
				                   alert("Password entered does not match with your current password. Please try again.");
				                }else{
				                	update();
				                }*/
				                
				            }
				        },
				        cancel: function () {
				        },
				    },
				    onContentReady: function () {
				        // bind to events
				        var jc = this;
				        this.$content.find('#formdialog').on('submit', function (e) {
				            // if the user submits the form by pressing enter in the field.
				            e.preventDefault();
				            jc.$$formSubmit.trigger('click'); // reference the button and click it
				        });
				    }
				});
			}
		}

	</script>
</head>
<body>
	<header>
		<a href="../customer" class="logo">BOOK4U STORE</a>
		<nav>
			<ul>
				<li><a href="../customer">HOME</a></li>
				<li><a href="cart.php">CART</a></li>
				<li><a href="myorder.php">MY ORDER</a></li>
				<li><a href="profile.php" class="activebar"><?php echo strtoupper($username); ?></a></li>
				<li><a href="../signOut.php">SIGN OUT</a></li>
			</ul>
		</nav>
		<div class="clearfix"></div>
	</header>

	<div class="boxHolder">
		<div class="profileholder">
			<a class="changePicture" id="changepic" aria-label="Change Profile Picture">
				<?php
				if(empty($rowMe['picture']))
				{
					?>
					<div class="profile-pic" style="background-image: url('../imgsource/basic/profilecustomer.png');" >
						<?php 
					}
					else
					{
						?>
						<div class="profile-pic" style="background-image: url('../imgsource/profile/<?php echo $rowMe['picture']?>');" >
							<?php 
						}
						?>  	
						<span id="changespan">Change</span>
					</div>
				</a>
				<form name="formpicture" onsubmit="return validatePic()" action="" id="formpicture" method="POST" enctype="multipart/form-data">
					<div style="display: inline-flex;width: 60%; margin-left: 15%; margin-right: auto;">
						<input accept="image/jpeg, image/png, image/jpg" type="file" id="file_picture" name="file_picture" style="margin-left: 15%; margin-top: 8px; display: none; ">
						<input type="submit" id="submitpicture" name="submitpicture" class="submit" value="Save" style="cursor: pointer; display: none;" >
					</div>

				</form>	
			</div>
			<p id="edit" class="hide" style="width: 22%;">edit</p><p id="cancelEdit" class="hide" style="display: none; width: 22%;">cancel</p>
			<div class="informationHolder" >
				INFORMATION
			</div>

			<div class="information">
				<table align="center" width="90%" cellpadding="6">
					<tr>
						<td style="width: 37%">
							USERNAME
						</td>
						<td>
							<?php echo $username; ?>
						</td>
					</tr>
					<tr>
						<td style="width: 37%">
							FULL NAME
						</td>
						<td>
							<input type="text" value="<?php echo $rowMe['name']; ?>" id="name" style="text-transform: uppercase;" />
						</td>
					</tr>
					<tr>
						<td style="width: 37%">
							E-MAIL
						</td>
						<td>
							<input type="email" name="email" id="email" value="<?php echo $rowMe['email']?>">
						</td>
					</tr>
					<tr>
						<td style="width: 37%">
							PHONE
						</td>
						<td>
							<input type="number" id="phone" name="phone" value="<?php echo $rowMe['phone']; ?>">
						</td>
					</tr>
					<tr>
						<td style="width: 37%">
							ADDRESS
						</td>
						<td>
							<textarea rows="2" id="address" style="text-transform:uppercase;" name="address"><?php echo $rowMe['address']; ?></textarea>
						</td>
					</tr>
				</table>
			</div>
			<div class="informationHolder" align="center">
				CHANGE PASSWORD
			</div>
			<div class="information">
				<table align="center" width="90%" cellpadding="6">
					<tr>
						<td style="width: 37%">
							PASSWORD
						</td>
						<td>
							<input id="pass1" type="password" name="pass1" placeholder="PASSWORD">
							<span><i onclick="showpass()" style="margin-left: 4px; cursor: pointer;" class="fa fa-eye" aria-hidden="true"></i></span>
						</td>
					</tr>
					<tr>
						<td style="width: 37%">
							CONFIRM PASSWORD
						</td>
						<td>
							<input id="pass2" type="password" name="pass2" placeholder="CONFIRM PASSWORD">
						</td>
					</tr>
				</table>
			</div>
			<center>
				<input onclick="return validateUpdate()" type="submit" name="update" id="update" value="Save" class="submit" style="visibility: hidden;">
				<input type="hidden" name="hiddenusername" id="hiddenusername" value="<?php echo $username ?>"><input type="hidden" name="hiddenpw" id="hiddenpw" value="<?php echo $rowMe['password'] ?>">
			</center>
		</div>
	</body>
</html>

<?php

include("../footer.php");
?>