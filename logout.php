<?php
  session_start();
  include('mysql_connect_inc.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Timetable</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body style="font-family: DFKai-sb;">
<?php	


include("header.php");
unset($_SESSION['Step']);
unset($_SESSION['Username']);
unset($_SESSION['Year']);
unset($_SESSION['item_']);
unset($_SESSION['Year_']);
unset($_SESSION['item_1']);
unset($_SESSION['Name_array']);


echo '<meta http-equiv=REFRESH CONTENT=0;url=index.php>';
?>