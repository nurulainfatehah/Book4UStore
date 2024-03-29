<?php

	include('../inc/dbconnect.php');



	if(isset($_POST['placed_check'])){

		$date =  date("d-m-Y");
		$receiptID = $_POST['receiptID'];
		$email = $_POST['email'];

		require_once '../vendor/autoload.php';
				//create transport
		$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
		->setUsername("notify.sbppp@gmail.com")
		->setPassword("SBPPP2020");

				// Create the Mailer using your created Transport
		$mailer = new Swift_Mailer($transport);

				// Create a message
		$message = new Swift_Message();	
		$message->setSubject('[BOOK4U] #'.$receiptID.' We Have Received Your Order');
		$message->setFrom(['notify.sbppp@gmail.com' => 'BOOK4U Store Notification']);
		$message->setTo($email);
		$message->setBody('<html>' .
			'<body>' .
			'<div style="font-size: 14px; font-family: sans-serif; text-align: justify;">'.
			'Hello, '. 
			'<br><br>'.
			'Thank you for shopping at BOOK4U Store. You may find your recent purchase in my order section. Please allow up to 2 business day (excluding weekends, holidays and sales day) for us to process and ship your order. You will receive another email when your order has been shipped! Stay tuned. Keep saving the earth by buying used books.'.
			'<br><br>'.			
			'<table border="0" width="70%" text-align="center">'.
			'<tr>'.
			'<th>'.
			'<div style="font-family: sans-serif; font-size: 14px; text-align: left">'.
			'	Order No. '.
			'</div>'.
			'</th>'.
			'<td>'.
			':'.
			'</td>'.
			'<td>'.
			'<div style="font-family: sans-serif; font-size: 14px; padding-left: 25px; text-align: left">'.
			'	'. $receiptID .' '.
			'</div>'.
			'</td>'.
			'</tr>'.					
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
	}
		



?>