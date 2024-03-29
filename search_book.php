<?php

include('inc/dbconnect.php');
$output = '';
$total = 0;


if(isset($_POST['genre']) && $_POST['genre'] != ""){
	$genre = $_POST['genre'];
	$querySearch = "SELECT * FROM book JOIN genre_book ON book.bookID = genre_book.bookID
					JOIN genre ON genre_book.genreID = genre.genreID WHERE genre.name = '".$genre."' ORDER BY title ASC";

}else if(isset($_POST['querySearch'])){

	$search = mysqli_real_escape_string($conn, $_POST["querySearch"]);
	$querySearch = "";


	if($_POST['par'] == "titleAZ"){

		$querySearch = "SELECT DISTINCT * FROM book JOIN genre_book ON book.bookID = genre_book.bookID
						JOIN genre ON genre_book.genreID = genre.genreID
						WHERE genre.name LIKE '%".$search."%' OR title LIKE '%".$search."%' OR yearOfPublication = '".$search."' OR AUTHOR LIKE '%".$search."%'
						GROUP BY book.bookID ORDER BY book.title";

	}else if($_POST['par'] == "titleZA"){

		$querySearch = "SELECT DISTINCT * FROM book JOIN genre_book ON book.bookID = genre_book.bookID
						JOIN genre ON genre_book.genreID = genre.genreID
						WHERE genre.name LIKE '%".$search."%' OR title LIKE '%".$search."%' OR yearOfPublication = '".$search."' OR AUTHOR LIKE '%".$search."%'
						GROUP BY book.bookID ORDER BY book.title DESC";

	}else if($_POST['par'] == "authorAZ"){
		$querySearch = "SELECT DISTINCT * FROM book JOIN genre_book ON book.bookID = genre_book.bookID
						JOIN genre ON genre_book.genreID = genre.genreID
						WHERE genre.name LIKE '%".$search."%' OR title LIKE '%".$search."%' OR yearOfPublication = '".$search."' OR AUTHOR LIKE '%".$search."%'
						GROUP BY book.bookID ORDER BY book.author";
	}else if($_POST['par'] == "authorZA"){
		$querySearch = "SELECT DISTINCT * FROM book JOIN genre_book ON book.bookID = genre_book.bookID
						JOIN genre ON genre_book.genreID = genre.genreID
						WHERE genre.name LIKE '%".$search."%' OR title LIKE '%".$search."%' OR yearOfPublication = '".$search."' OR AUTHOR LIKE '%".$search."%'
						GROUP BY book.bookID ORDER BY book.author DESC";
	}else{
		$querySearch = "SELECT DISTINCT * FROM book JOIN genre_book ON book.bookID = genre_book.bookID
						JOIN genre ON genre_book.genreID = genre.genreID
						WHERE genre.name LIKE '%".$search."%' OR title LIKE '%".$search."%' OR yearOfPublication = '".$search."' OR AUTHOR LIKE '%".$search."%'
						GROUP BY book.bookID ORDER BY book.title";
	}
	
}else{
	$querySearch = "SELECT * FROM book ORDER BY title ASC";
}

$result = $conn->query($querySearch);
if($result->num_rows > 0)
{
	$output .= '
	
	'; 

	while($row = $result->fetch_assoc())
	{
		$total++;
		$output .= 

		'<div class="bookcontainer">
			<div class="pic">';

		if(empty($row['receiptID'])){
			$output .= '<img src="imgsource/bookcover/'.  $row["picture"] .'">';
		}else{
			$output .= '<img style="filter: blur(1px);" src="imgsource/bookcover/'.  $row["picture"] .'">' .
			'<img class="soldImgList" src="imgsource/basic/soldout.png" />';
		}
		
		$output .= '</div>
			<div class="title">
				'. $row["title"] .'
			</div>
			<div class="price">
				RM ' . $row["price"] . '
			</div>
			<div class="description" title="">
				'. $row["description"] .'
			</div>
			<button class="submit" onclick="viewBook(this)" id="'. $row["bookID"] .'">View</button>

			<img src="imgsource/basic/cart.png" class="carticon" align="center" onclick="signInFirst()" />

		</div>
		';

	}
	$output .='</table>' ;
	//$output .='<br><center style="font-style: italic">'. $total . ' record(s) found.</center>';
	echo $output;
}
else
{
	$output ='<center style="font-size: 25px; font-style: italic; color: white; font-weight: bold">NO RECORD FOUND FOR ' . $search . '</center>';
	echo $output;
}
?>