<?php
	echo "<!------------------------------header.php:begin------------------------------>\n";
	echo "<div class=\"jumbotron text-center\">\n";
	echo "<h1>國立嘉義大學應用數學系</h1>\n";
  	echo "<h3>學生課程意見調查</h3>\n";
  	include_once('../phpqrcode/qrlib.php');
	if (!file_exists("../QRCode/QRCode_System.png")){
		QRcode::png("http://120.113.174.17/student/s1042653/M20180419/index.php", "../QRCode/QRCode_System.png");
	}
	echo "<p style=\"text-align:center\"><img src=\"../QRCode/QRCode_System.png\"></p>"; 
  	if (isset($_SESSION['Course_ID'])){
  		$sql = "SELECT `Course_CName` FROM `course_list` WHERE `Course_ID` = '".$_SESSION['Course_ID']."'";
  		$result = mysqli_query($con,$sql);
  		$row = mysqli_fetch_assoc($result);
  		echo "<h3>{$row['Course_CName']}課程頁面</h3>\n";
  	} else{
		if(isset($_SESSION['display_top_side_bar'])){
			if ($_SESSION['display_top_side_bar']==1){
				include('left_top_bar.php');
			}
		}	
	}
	echo "</div>\n";
	echo "<!------------------------------header.php:end-------------------------------->\n";
?>