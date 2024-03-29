<?php

	include('../inc/dbconnect.php');



	if(isset($_POST['delivered_check'])){

		$date =  date("d-m-Y");
		$receiptID = $_POST['receiptID'];
		$email = $_POST['email'];
		$name = $_POST['name'];

		require_once '../vendor/autoload.php';
				//create transport
		$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
		->setUsername("notify.sbppp@gmail.com")
		->setPassword("SBPPP2020");

				// Create the Mailer using your created Transport
		$mailer = new Swift_Mailer($transport);

				// Create a message
		$message = new Swift_Message();	
		$message->setSubject('[BOOK4U] #'.$receiptID.' Order Has Been Shipped');
		$message->setFrom(['notify.sbppp@gmail.com' => 'BOOK4U Store Notification']);
		$message->setTo($email);
		$message->setBody('<html>' .
			'<body>' .
			'<div style="font-size: 14px; font-family: sans-serif; text-align: justify;">'.
			'Hello, '. strtoupper($name) . 
			'<br><br>'.
			'We are happy to inform that your books from order #'. $receiptID . ' has just been delivered. It should arrive within 3 business days. Please do not hesitate to contact us for more enquiries.' .
			'<br><br>Thanks for shopping second-hands books with us. You did not just get a great deal, --- you also supported the read and buy used books campaign while keeping the books alive and helping the environment.'.
			'<br><br>'.			
			'<table border="0" width="70%" text-align="center">'.					
			'<tr>'.
			'<th>'.
			'<div style="font-family: sans-serif; font-size: 14px; text-align: left">'.
			'	Date '.
			'</div>'.
			'</th>'.
			'<td>'.
			':'.
			'</td>'.
			'<td>'.
			'<div style="font-family: sans-serif; font-size: 14px; padding-left: 25px; text-align: left">'.
			'	'. $date .' '.
			'</div>'.
			'</td>'.
			'</tr>'.
			'<tr>'.
			'<th>'.
			'<div style="font-family: sans-serif; font-size: 14px; text-align: left; text-align: left">'.
			'	Time '.
			'</div>'.
			'</th>'.
			'<td>'.
			':'.
			'</td>'.
			'<td>'.
			'<div style="font-family: sans-serif; font-size: 14px; padding-left: 25px">'.
			'	'.date("H:i A", time()+25200).' '.
			'</div>'.
			'</td>'.
			'</tr>'.
			'</table>'.
			'</div>'.
			'<br><br>'.
			'<div style="font-size: 14px; font-family: sans-serif; text-align: justify;">'.
			'To visit the Book4U Store, please go to <a href="https://webapp.utem.edu.my/student/bitd/b032020035/BOOK4UStore/" style="color: blue">https://webapp.utem.edu.my/student/bitd/b032020035/BOOK4UStore/</a>.<br><br>Thank you and have a good day ahead!.'.
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
		echo "delivered";

		exit();
	}else if(isset($_POST['cancelled_check'])){

		$date =  date("d-m-Y");
		$receiptID = $_POST['receiptID'];
		$email = $_POST['email'];
		$name = $_POST['name'];

		require_once '../vendor/autoload.php';
				//create transport
		$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
		->setUsername("notify.sbppp@gmail.com")
		->setPassword("SBPPP2020");

				// Create the Mailer using your created Transport
		$mailer = new Swift_Mailer($transport);

				// Create a message
		$message = new Swift_Message();	
		$message->setSubject('[BOOK4U] Sorry, #'.$receiptID.' Order Had to be Cancelled');
		$message->setFrom(['notify.sbppp@gmail.com' => 'BOOK4U Store Notification']);
		$message->setTo($email);
		$message->setBody('<html>' .
			'<body>' .
			'<div style="font-size: 14px; font-family: sans-serif; text-align: justify;">'.
			'Hello, '. strtoupper($name) . 
			'<br><br>'.
			'Due to many internal problems, We are sad to inform that your books order #'. $receiptID . ' has just been cancelled. We are very sorry that you are not able to get them delivered. Please buy and continue showing your support to used books. Hoping to see you again.' .
			'<br><br>'.			
			'<table border="0" width="70%" text-align="center">'.					
			'<tr>'.
			'<th>'.
			'<div style="font-family: sans-serif; font-size: 14px; text-align: left">'.
			'	Date '.
			'</div>'.
			'</th>'.
			'<td>'.
			':'.
			'</td>'.
			'<td>'.
			'<div style="font-family: sans-serif; font-size: 14px; padding-left: 25px; text-align: left">'.
			'	'. $date .' '.
			'</div>'.
			'</td>'.
			'</tr>'.
			'<tr>'.
			'<th>'.
			'<div style="font-family: sans-serif; font-size: 14px; text-align: left; text-align: left">'.
			'	Time '.
			'</div>'.
			'</th>'.
			'<td>'.
			':'.
			'</td>'.
			'<td>'.
			'<div style="font-family: sans-serif; font-size: 14px; padding-left: 25px">'.
			'	'.date("H:i A", time()+25200).' '.
			'</div>'.
			'</td>'.
			'</tr>'.
			'</table>'.
			'</div>'.
			'<br><br>'.
			'<div style="font-size: 14px; font-family: sans-serif; text-align: justify;">'.
			'To visit the Book4U Store, please go to <a href="https://webapp.utem.edu.my/student/bitd/b032020035/BOOK4UStore/" style="color: blue">https://webapp.utem.edu.my/student/bitd/b032020035/BOOK4UStore/</a>.<br><br>Thank you and have a good day ahead!.'.
			'</div>'.
			'</div>'.
			'<br>'.
			'<div style="text-align: center; color: gray; font-size: 14px; font-family: sans-serif;">'.
			'<hr>'.
			'	This is an auto-generated email. Please do not reply to this email. '.
			'</div>'.
			'</body>' .
			'</html>',
			'text/html');

						//send the email

		$result = $mailer->send($message);

		echo "cancelled";


		exit();


	}
		



?>