<?php
require 'connect.php';
$Area = $_POST["Area"];
$xYear = $_POST["xYear"];
$xMonth = $_POST["xMonth"];
$cMonth = $_POST["cMonth"];
$Hospital = $_POST["Hospital"];
$Product = $_POST["Product"];
$xSt = $_POST["xSt"];

if( $Area <> "" && $xYear <> "" && $xMonth <> "" && $Hospital <> "" && $Product <> "" ){
	$Sql = "INSERT INTO product_intonext_month (Area,YY,MM,Hotpital,Product,St,xMM) VALUES ('$Area','$xYear','$xMonth','$Hospital','$Product','$xSt','$cMonth')";
	$meQuery = mysqli_query($conn,$Sql);
}
if($xSt == 0 ){
	header('location:ProductNew.php');
}else{
	header('location:ProductNewNext.php');
}
?>
<body>
<textarea  rows='10' cols='50' ><?php echo $Sql ?></textarea>
</body>