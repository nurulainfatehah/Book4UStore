<?php

include('../inc/dbconnect.php');

	if(isset($_GET['resultID']))
	{
		$querySelect = "SELECT * FROM c19swabtest WHERE resultID = ".$_GET['resultID'];
		$ResultSelectStmt = mysqli_query($conn,$querySelect);
		$fetchRecords = mysqli_fetch_assoc($ResultSelectStmt);
		
		$fetchImgTitleName = $fetchRecords['resultProof'];
		
		$createDeletePath = "../imgsource/c-19/".$fetchImgTitleName;
		
		if(unlink($createDeletePath))
		{
			$sql = "DELETE FROM c19swabtest WHERE resultID = ".$fetchRecords['resultID'];
			$rsDelete = mysqli_query($conn, $sql);	
			
			if($rsDelete)
			{
				?>
        			<script type="text/javascript">
        				alert('Record had successfully deleted');
        				window.location.href='c-19test.php?success';
        			</script> 
	
				<?php
			}
		}
		else
		{
			$displayErrMessage = "Unable to delete File";
		}
		
	}



?>