<?php
include('inc/dbconnect.php');

?>
<title>Account Registeration</title>
<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/header.css">
<script type="text/javascript">
	
	function invalid(){
		alert("Sorry, there was a problem to register your account. Please try again");
		window.location.replace('signUp.php');
	}

	function pictTooBig(){
		alert("Picture is too big. Please try again");
		window.location.replace('signUp.php');
	}

	function pictNotFound(){
		alert("Picture not found. Please try again");
		window.location.replace("signUp.php");
	}

	function succeed(){
		alert("Successfully Registered! You may sign in with the registered account");
		window.location.replace('signIn.php');
	}


</script>

<?php

	if(isset($_POST['submit']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$name = strtoupper($_POST['name']);
		$gender = strtoupper($_POST['gender']);
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$address = strtoupper($_POST['address']);

		$hash_password = password_hash($password, PASSWORD_DEFAULT); // password hashing


		if($_FILES["picture"]["error"] == 4) //USER DOES NOT WANT TO UPLOAD A PICTURE!! IT IS OKAY. INSERT OTHER COLUMN
		{
			//INSERT EVERY COLUMN EXCEPT PICTURE
			$sqlRegister = "INSERT INTO CUSTOMER (username, password, name, gender, email, phone, address) VALUES('".$username."', '".$hash_password."', '".$name."', '".$gender."' , '".$email."' , '".$phone."', '".$address."')";

			if($conn->query($sqlRegister) === TRUE)
			{
				//send email function
				require_once 'vendor/autoload.php';
						//create transport
				$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
				->setUsername("notify.sbppp@gmail.com")
				->setPassword("SBPPP2020");

								// Create the Mailer using your created Transport
				$mailer = new Swift_Mailer($transport);

								// Create a message
				$message = new Swift_Message();	

				$message->setSubject('[B4U] Account Registration at BOOK4U STORE');
				$message->setFrom(['notify.sbppp@gmail.com' => 'BOOK4U Store Notification']);
				$message->setTo($email);
				$message->setBody('<html>' .
					'<body>' .
						'<div style="font-size: 14px; font-family: sans-serif; text-align: justify;">'.
							'Hi, <b>'. $username.'</b>, '. 
							'<br><br><br>'.
							'Thank you for signing up to keep in touch with the no.1 used book dealer in community. We offer numerous used, second-hand books in great price! Feel free to login into our system and catch your book! '.
							'<br><br>'.			
											
						'</div>'.
						'<br><br>'.
						'<div style="font-size: 14px; font-family: sans-serif; text-align: justify;">'.
							'To visit the mainpage of BOOK4U Store, please go to <a href="http://localhost/BOOK4UStore" style="color: blue">http://localhost/BOOK4UStore</a>.<br><br>Thank you and have a good day ahead!.'.
						'</div>'.
					'</div>'.
					'<br>'.
					'<div style="text-align: center; color: gray; font-size: 14px; font-family: sans-serif;">'.
						'<hr>'.
						'	This is an auto-generated email. Please do not reply to this email. '.
					'</div>'.
					'</body>' .
					'</html>',
					'text/html'

				);

				//send the email

				$result = $mailer->send($message);
				?>				
				<body onload="return succeed();"></body>
				<?php 
			}
			else
			{
				?>
				<body onload="invalid();"></body>
				<?php
			}
		}
		else //USER WANTS TO UPLOAD A PICTURE
		{
			$file = $_FILES["picture"];
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
					$fileDestination = 'imgsource/profile/'.$fileNameNew;
					move_uploaded_file($fileTmpName, $fileDestination);

					//INSERT EVERY COLUMN
					$sqlRegister = "INSERT INTO CUSTOMER (username, password, name, picture, gender, email, phone, address) VALUES('".$username."', '".$hash_password."', '".$name."', '".$fileNameNew."', '".$gender."' , '".$email."' , '".$phone."', '".$address."')";


					if($conn->query($sqlRegister) === TRUE)
					{
						//send email function
						require_once 'vendor/autoload.php';
										//create transport
						$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
						->setUsername("notify.sbppp@gmail.com")
						->setPassword("SBPPP2020");

										// Create the Mailer using your created Transport
						$mailer = new Swift_Mailer($transport);

										// Create a message
						$message = new Swift_Message();	

						$message->setSubject('[B4U] Account Registration at BOOK4U STORE');
						$message->setFrom(['notify.sbppp@gmail.com' => 'BOOK4U Store Notification']);
						$message->setTo($email);
						$message->setBody('<html>' .
							'<body>' .
								'<div style="font-size: 14px; font-family: sans-serif; text-align: justify;">'.
									'Hi, <b>'. $username.'</b>, '. 
									'<br><br><br>'.
									'Thank you for signing up to keep in touch with the no.1 used book dealer in community. We offer numerous used, second-hand books in great price! Feel free to login into our system and catch your book! '.
									'<br><br>'.			
													
								'</div>'.
								'<br><br>'.
								'<div style="font-size: 14px; font-family: sans-serif; text-align: justify;">'.
									'To visit the mainpage of BOOK4U Store, please go to <a href="http://localhost/BOOK4UStore" style="color: blue">http://localhost/BOOK4UStore</a>.<br><br>Thank you and have a good day ahead!.'.
								'</div>'.
							'</div>'.
							'<br>'.
							'<div style="text-align: center; color: gray; font-size: 14px; font-family: sans-serif;">'.
								'<hr>'.
								'	This is an auto-generated email. Please do not reply to this email. '.
							'</div>'.
							'</body>' .
							'</html>',
							'text/html'

						);

						//send the email

						$result = $mailer->send($message);
						?>
						<body onload="return succeed();"></body>
						<?php 
					}
					else
					{
						?>
						<body onload="invalid();"></body>
						<?php
					}
				}
				else
				{
					?>
					<body onload="pictTooBig();"></body>
					<?php 
				}
			}
			else
			{
				?>
				<body onload="pictNotFound();"></body>
				<?php
			}
			
		}

	}else{
		?>
		<body onload="invalid()"></body>
		<?php
	}
?>