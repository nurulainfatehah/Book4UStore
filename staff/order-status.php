<?php

include('../inc/dbconnect.php');
session_start();
$username = $_SESSION['username'];

if(isset($_GET['action'])){
	
	$receiptID = $_GET['receiptID'];
	if($_GET['action'] == "delivered"){

		$sql = "UPDATE purchase SET status = 'delivered' WHERE receiptID = '".$receiptID."'";
		if($conn->query($sql) === TRUE){
			?>
			<script type="text/javascript">
				alert("Order #<?php echo $receiptID ?> had been successfully delivered.");
				window.location.replace("view-order.php?receiptID=<?php echo $receiptID ?>");
			</script>
			<?php
		}else{
			?>
			<script type="text/javascript">
				alert("There was a problem to change the status of order #<?php echo $receiptID ?>. Please try again");
				window.location.replace("view-order.php?receiptID=<?php echo $receiptID ?>");
			</script>
			<?php
		}

	}else if($_GET['action'] == "cancelled"){
		$sql = "UPDATE purchase SET status = 'cancelled' WHERE receiptID = '".$receiptID."'";
		if($conn->query($sql) === TRUE){
			?>
			<script type="text/javascript">
				alert("Order #<?php echo $receiptID ?> had been successfully cancelled. Money is refunded to the customer.");
				window.location.replace("view-order.php?receiptID=<?php echo $receiptID ?>");
			</script>
			<?php
		}else{
			?>
			<script type="text/javascript">
				alert("There was a problem to change the status of order #<?php echo $receiptID ?>. Please try again");
				window.location.replace("view-order.php?receiptID=<?php echo $receiptID ?>");
			</script>
			<?php
		}
	}
}

?>