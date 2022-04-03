<?php 
session_start();
include('mysql_connect_inc.php');
if(!isset($_SESSION['Step'])){
  $_SESSION['Step']=0;
}

?>

<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if($_SESSION['Step']==0){
      $Year = $_POST['Year'];
      $Username = $_POST['Username'];
      $_SESSION['Year'] = $Year;
      $_SESSION['Username'] = $Username;


      $sql = "SELECT * FROM `timetable` WHERE `Username`='$Username' AND `Year`='$Year'";
      $result = mysqli_query($con,$sql);
      if(mysqli_num_rows($result)==0){
        $_SESSION['Step']=1;
      }else{
        $_SESSION['Step']=2;
      }
      
      //echo "<meta http-equiv=REFRESH CONTENT=0;url=\"{$_SERVER['PHP_SELF']}\">";
    }if($_SESSION['Step']==1){
      $Year=$_SESSION['Year'];
      $_SESSION['item_']=array();
      if (isset($_POST['item_'])){
        for($i=0;$i<count($_POST['item_']);$i++){
          if ($_POST['item_']!=''){
            $_SESSION['item_'][]=$_POST['item_'];
          }
        }
        
        $_SESSION['item_'] = @array_shift(array_shift($_SESSION['item_']));
        $item_=$_SESSION['item_'];
        $Username=$_SESSION['Username'];
      
        $sql="INSERT INTO `timetable` (`ID`,`Year`, `Username`, `Time`, `item_00`, `item_01`, `item_02`, `item_03`, `item_04`, `item_05`, `item_06`, `item_07`, `item_08`, `item_09`, `item_10`, `item_11`, `item_12`, `item_13`, `item_14`, `item_15`, `item_16`, `item_17`, `item_18`, `item_19`, `item_20`, `item_21`, `item_22`, `item_23`, `item_24`, `item_25`, `item_26`, `item_27`, `item_28`, `item_29`, `item_30`, `item_31`, `item_32`, `item_33`, `item_34`, `item_35`, `item_36`, `item_37`, `item_38`, `item_39`, `item_40`, `item_41`, `item_42`, `item_43`, `item_44`, `item_45`, `item_46`, `item_47`, `item_48`, `item_49`, `item_50`, `item_51`, `item_52`, `item_53`, `item_54`, `item_55`, `item_56`, `item_57`, `item_58`, `item_59`) VALUES (NULL,'$Year', '$Username', CURRENT_TIME(), '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);";
        if(mysqli_query($con,$sql)){
          $ID=mysqli_insert_id($con);
          for($i=0;$i<60;$i++){
            $sql = sprintf("UPDATE `timetable` SET `item_%02d`='{$item_[$i]}'",$i);
            $sql = $sql ." WHERE `ID`='{$ID}'";
            mysqli_query($con,$sql);
          }
        }
        $_SESSION['Step']=2;
      }
    }else if($_SESSION['Step']==2){
      if(isset($_POST['reset'])){
        if($_POST['reset']==1){
          $_SESSION['Step']=10;
        }
      }
    }else if($_SESSION['Step']==10){
      $Year=$_SESSION['Year'];
      $_SESSION['item_']=array();
      if (isset($_POST['item_'])){
        for($i=0;$i<count($_POST['item_']);$i++)
        if ($_POST['item_']!=''){
          $_SESSION['item_'][]=$_POST['item_'];
        }
        $_SESSION['item_'] = @array_shift(array_shift($_SESSION['item_']));
        $item_=$_SESSION['item_'];
        $Username=$_SESSION['Username'];
      
        for($i=0;$i<60;$i++){
          $sql = sprintf("UPDATE `timetable` SET `item_%02d`='{$item_[$i]}'",$i);
          $sql = $sql ." WHERE `Year`='{$Year}' AND `Username`='{$Username}'";
          mysqli_query($con,$sql);
        }
        
        $_SESSION['Step']=2;
      }
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
<?php 
      if($_SESSION['Step']==0){
        echo "<form action=\"\" method=\"POST\">";
          echo "<div class=\"form-group\">";
              echo "<label for=\"Year\"><h4>請選擇課表學年度：</h4></label>";
              echo "<select class=\"form-control\" id=\"Year\" name=\"Year\" required>";

        for ($i=108; $i <= 111; $i++) {
                echo "<option value=\"{$i}-01\">{$i}-01</option>\n";
                echo "<option value=\"{$i}-02\">{$i}-02</option>\n";
        }
              echo "</select>";
          echo "</div>";

          echo "<div class=\"form-group\">";
            echo "<label for=\"Username\"><h4>請選擇登入身分:</h4></label>";
              echo "<select class=\"form-control\" id=\"Username\" name=\"Username\">";

        $sql = "SELECT * FROM `member` WHERE 1";
        $result = mysqli_query($con,$sql);
        for($i=1; $i<=mysqli_num_rows($result); $i++){
          $row = mysqli_fetch_assoc($result);
          if (isset($_SESSION['Username'])){
            if ($row['Username']==$_SESSION['Username']){
              echo "<option value=\"".$row['Username']."\" selected>".$row['Name']."</option>\n";
            } else {
              echo "<option value=\"".$row['Username']."\">".$row['Name']."</option>\n";
            } 
        } else{
            echo "<option value=\"".$row['Username']."\">".$row['Name']."</option>\n";
          } 
        }
              echo "</select>";
          echo "</div>";
          echo "<div class=\"text-center\">";
            echo "<button type=\"submit\" class=\"btn btn-primary\">送出選擇</button>";
          echo "</div>";
        echo "</form>";
      }else if($_SESSION['Step']==1){
        include('time_array.php');
        echo "<form method=\"post\" action=\"\">";
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
                echo "<div class=\"form-group\">";
                  echo "<label for=\"item_{$i}{$j}\"></label>";
                  echo "<input type=\"text\" class=\"form-control\" id=\"item_{$i}{$j}\" placeholder=\"課程名稱\" name=\"item_[0][]\" >";
                echo "<div class=\"form-group\">";
              echo "</td>";
            }
            echo "<td>".$time_array[$i]."</td>";
            echo "</tr>";
          }
        echo "</table>";
        echo "<div class=\"form-group\">";
          echo "<center>";
          echo "<input type=\"submit\" role=\"button\" class=\"btn btn-info\" value=\"Submit\">";
          echo "</center>";
        echo "</div>";
        echo "</form>";
      }else if($_SESSION['Step']==2){
        include('time_array.php');
        
        $Year=$_SESSION['Year'];
        $Username=$_SESSION['Username'];

        $sql = "SELECT * FROM `timetable` WHERE `Username`='$Username' AND `Year`='$Year'";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($result);

        $i=0;
        $j=0;
        for($k=0;$k<60;$k++){
          if($k==0 || $k%5!=0){
            $A[$i][$j]=$row[sprintf('item_%02d',$k)];
            $j+=1;
            #echo "k=".$k."\n";
          }else{
            $i+=1;
            $j=0;
            $A[$i][$j]=$row[sprintf('item_%02d',$k)];
            #echo "k~~=".$k."\n";
            $j+=1;
          }
        }        
        #print_r($A);
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
              echo $A[$i][$j];  
              echo "</td>";
            }
            echo "<td>".$time_array[$i]."</td>";
            echo "</tr>";
          }
        echo "</table>";

        echo "<form method=\"post\" action=\"\">";
        echo "<div class=\"form-group\">";
          echo "<center>";
          echo "<input type=\"hidden\" name=\"reset\" value=\"1\">";
          echo "<input type=\"submit\" role=\"button\" class=\"btn btn-info\" value=\"重設課表\">";
          echo "</center>";
        echo "</div>";
        echo "</form>";
      }else if($_SESSION['Step']==10){
        include('time_array.php');
        $Year=$_SESSION['Year'];
        $Username=$_SESSION['Username'];

        $sql = "SELECT * FROM `timetable` WHERE `Username`='$Username' AND `Year`='$Year'";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($result);

        $i=0;
        $j=0;
        for($k=0;$k<60;$k++){
          if($k==0 || $k%5!=0){
            $A[$i][$j]=$row[sprintf('item_%02d',$k)];
            $j+=1;
            #echo "k=".$k."\n";
          }else{
            $i+=1;
            $j=0;
            $A[$i][$j]=$row[sprintf('item_%02d',$k)];
            #echo "k~~=".$k."\n";
            $j+=1;
          }
        }       
        echo "<form method=\"post\" action=\"\">";
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
                echo "<div class=\"form-group\">";
                  echo "<label for=\"item_{$i}{$j}\"></label>";
                  echo "<input type=\"text\" class=\"form-control\" id=\"item_{$i}{$j}\" placeholder=\"課程名稱\" name=\"item_[0][]\" value=\"{$A[$i][$j]}\" >";
                echo "<div class=\"form-group\">";
              echo "</td>";
            }
            echo "<td>".$time_array[$i]."</td>";
            echo "</tr>";
          }
        echo "</table>";
        echo "<div class=\"form-group\">";
          echo "<center>";
          echo "<input type=\"submit\" role=\"button\" class=\"btn btn-info\" value=\"Submit\">";
          echo "</center>";
        echo "</div>";
        echo "</form>";
      }
?>
      </div>
		</div>
	</div>
</body>
</html>


