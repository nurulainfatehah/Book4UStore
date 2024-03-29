<?php
session_start();

include('../inc/dbconnect.php');
include('placedOrderEmail.php');

$customer = $_SESSION['username'];
$username = $_SESSION['username'];
$recipient = strtoupper($_POST['recipient']);
$quantity = $_POST['quantity'];
$total = $_POST['total'];
$recipientAddress = strtoupper($_POST['delivery_add']);
?>
<title>Checking out..</title>
<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>

<?php
$sql = "INSERT INTO purchase (recipient, quantity, total, recipientAddress, customer) VALUES ('".$recipient."', '".$quantity."', '".$total."', '".$recipientAddress."', '".$customer."');";

	if($conn->query($sql) === TRUE){
		$sqlReceiptID = "SELECT email, receiptID from purchase JOIN customer ON customer.username = purchase.customer ORDER BY receiptID DESC LIMIT 1;";
		$result = $conn->query($sqlReceiptID);
		$row = $result->fetch_assoc();


		$receipt = $row['receiptID'];
		$email = $row['email'];

		$sql1 = "SELECT * FROM cart, book WHERE customer = '".$username."' AND cart.bookID = book.bookID";
		$result1 = $conn->query($sql1);
		if($result1->num_rows > 0)
		{
			while($row1 = $result1->fetch_assoc())
			{
				$sqlUpdateReceipt = "UPDATE book SET receiptID = '".$receipt."' WHERE bookID = '".$row1['bookID']."'";
				$conn->query($sqlUpdateReceipt);
			}

			$sqlBukuBukuPurchased = "SELECT bookID from book where receiptID = '".$receipt."'";
			$resultBukuBukuPurchased = $conn->query($sqlBukuBukuPurchased);

			while($rowBukuBukuPurchased = $resultBukuBukuPurchased->fetch_assoc())
			{
				$sqlDeleteBookFromCart = "
				DELETE from cart
				WHERE cart.customer = '".$username."' OR
				cart.bookID = '".$rowBukuBukuPurchased['bookID']."' ";

				$conn->query($sqlDeleteBookFromCart);
			}


			?>
			<script type="text/javascript">
				$(document).ready(function(){
					var receiptID = "<?php echo $receipt ?>";
					var email = "<?php echo $email ?>";

					$.ajax({
						url: "checkingout.php",
						type: "POST",
						cache: false,
						data:{
							placed_check : 1,
							receiptID: receiptID,
							email: email
						},
						success: function(response){
							if (response == 'delivered' ) {
								alert("Your purchase had been placed and a confirmation e-mail is sent. Click OK to continue");	
								window.location.replace("order.php?receiptID=<?php echo $receipt ?>");
							}else if (response == 'notdelivered') {


							}
						}
					});
				});
			</script>
			<body style= "background: rgba(103, 128, 159, 0.2);">
			</body>

			<?php
		}
		else
		{
					echo "Cannot update receipt at book"; //error testing
					echo "<meta http-equiv=\"refresh\" content=\"6; URL =cart.php\">";
		}

	}else{

	}

?>