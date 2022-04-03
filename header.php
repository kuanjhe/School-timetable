<?php
	echo "<!------------------------------header.php:begin------------------------------>\n";
	echo "<div class=\"jumbotron text-center\">\n";
	echo "<h1>國立嘉義大學應用數學系</h1>\n";
  	echo "<h3>學生課表頁面</h3>\n";
	include_once('phpqrcode/qrlib.php');
	if (!file_exists("QRCode/timetable.png")){
		QRcode::png("http://120.113.174.17/student/s1042653/timetable/index.php", "QRCode/timetable.png");
	}
	echo "<p style=\"text-align:center\"><img src=\"QRCode/timetable.png\"></p>"; 
  	if (isset($_SESSION['Username'])){
  		$sql = "SELECT `Name` FROM `member` WHERE `Username` = '".$_SESSION['Username']."'";
  		$result = mysqli_query($con,$sql);
  		$row = mysqli_fetch_assoc($result);
  		echo "<h3>登入身分:{$row['Name']}</h3>\n";
  	} 
	include('top_sider_bar.php');
			
	
	echo "</div>\n";
	echo "<!------------------------------header.php:end-------------------------------->\n";
?>