<?php 
session_start();
include('mysql_connect_inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(isset($_POST['Year'])){
		$_SESSION['Year_']=$_POST['Year'];
	}
	if (isset($_POST['item_'])){
        for($i=0;$i<count($_POST['item_']);$i++){
          if ($_POST['item_']!=''){
            $_SESSION['item_1'][]=$_POST['item_'];
          }
        }	
        $item_1 = @array_shift(array_shift($_SESSION['item_1']));
        $_SESSION['item_1']=$item_1;
        $Name_array=array();
        #print_r($_SESSION['item_1']); 
        for($t=0;$t<count($_SESSION['item_1']);$t++){
			$sql = "SELECT `Name` FROM `member` WHERE `Username`='{$_SESSION['item_1'][$t]}'";
			#echo $sql;
	    	$result = mysqli_query($con,$sql);
	    	$row = mysqli_fetch_assoc($result);
	    	$Name_array[$t]=$row['Name'];
		}
		$_SESSION['Name_array']=$Name_array;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Timetable</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  
</head>
<body style="font-family: DFKai-sb;">
<?php
include('header.php');
?>
	<div class="container">
		<div class="row">
      		<div class="col-sm-12">
<?php      	echo "<form method=\"post\" action=\"\">";	
      			echo "<div class=\"form-group\">";
	            	echo "<label for=\"Year\"><h4>請選擇課程學年度:</h4></label>";
	            	echo "<select class=\"form-control\" id=\"Year\" name=\"Year\">";

	$sql = "SELECT `Year` FROM `timetable` WHERE 1 GROUP BY `Year` ORDER BY `Year` ASC";
	$result = mysqli_query($con,$sql);
	for($i=1; $i<=mysqli_num_rows($result); $i++){
		$row = mysqli_fetch_assoc($result);
		if (isset($_SESSION['Year_'])){
			if ($row['Year']==$_SESSION['Year_']){
				echo "<option value=\"".$row['Year']."\" selected>".$row['Year']."</option>\n";
			} else {
				echo "<option value=\"".$row['Year']."\">".$row['Year']."</option>\n";
			} 
		} else{
			echo "<option value=\"".$row['Year']."\">".$row['Year']."</option>\n";
		} 
	}

            		echo "</select>";
        		echo "</div>";

    if(isset($_SESSION['Year_'])){
    	echo "<h4>請選擇人員:</h4>";
    	echo "<div class=\"form-group\">";
    	$sql="SELECT * FROM `timetable` WHERE `Year`='{$_SESSION['Year_']}'";
    	$result = mysqli_query($con,$sql);
    	
    	for($i=1; $i<=mysqli_num_rows($result); $i++){
    		$row = mysqli_fetch_assoc($result);
    		$sql2="SELECT `Name` FROM `member` WHERE `Username`='{$row['Username']}'";
    		$result2 = mysqli_query($con,$sql2);
    		$row2 = mysqli_fetch_assoc($result2);
    		$Username=$row['Username'];
    		$Name=$row2['Name'];
    		echo "<label for=\"member_{$i}\"><input type=\"checkbox\" id=\"member_{$i}\" name=\"item_[0][]\" value=\"$Username\">".$Name."</label><br>";
    	}
    	echo "</div>";
    	
    }

        		echo "<div class=\"form-group\">";
			        echo "<center>";
			        	echo "<input type=\"submit\" role=\"button\" class=\"btn btn-info\" value=\"Submit\">";
			        echo "</center>";
        		echo "</div>";
        	echo "</form>";

    if(isset($_SESSION['item_1'])){
    	for($t=0;$t<count($_SESSION['item_1']);$t++){
    		$sql = "SELECT * FROM `timetable` WHERE `Username`='{$_SESSION['item_1'][$t]}' AND `Year`='{$_SESSION['Year_']}'";
	        $result = mysqli_query($con,$sql);
	        $row = mysqli_fetch_assoc($result);

	        $i=0;
	        $j=0;
	        for($k=0;$k<60;$k++){
	          if($k==0 || $k%5!=0){
	            $A[$t][$i][$j]=$row[sprintf('item_%02d',$k)];
	            $j+=1;
	            #echo "k=".$k."\n";
	          }else{
	            $i+=1;
	            $j=0;
	            $A[$t][$i][$j]=$row[sprintf('item_%02d',$k)];
	            #echo "k~~=".$k."\n";
	            $j+=1;
	          }
	        }
    	}
    	include('time_array.php');
    	echo "<table class=\"table table-hover\">";
          echo "<thead>";
            echo "<tr>";
              echo "<th>五</th>";
              echo "<th>四</th>";
              echo "<th>三</th>";
              echo "<th>二</th>";
              echo "<th>一</th>";
              echo "<th></th>";
            echo "</tr>";
          echo "</thead>";

          for($i=0;$i<=11;$i++){
            echo "<tr>";
            for($j=0;$j<=4;$j++){
              echo "<td>";
              for($t=0;$t<count($_SESSION['item_1']);$t++){
              	if($A[$t][$i][$j]!=''){
              		echo $_SESSION['Name_array'][$t].":".$A[$t][$i][$j]."<br>"; 
              	}
              }
              echo "</td>";
            }
            echo "<td>".$time_array[$i]."</td>";
            echo "</tr>";
          }
        echo "</table>";
        unset($_SESSION['Year_']);
		unset($_SESSION['item_1']);
		unset($_SESSION['Name_array']);
 
    }
?>

      		</div>
		</div>
	</div>
</body>
</html>