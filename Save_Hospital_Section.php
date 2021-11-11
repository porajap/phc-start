<?php
session_start();
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
	
require 'connect.php';
$HCode = $_SESSION["HCode"];
$HName = $_SESSION["HName"];

$ICode = $_SESSION["ICode"];
$IName = $_SESSION["IName"];

$HSection = $_POST["HSection"];

if($HSection != ""){
	$Sql = "INSERT INTO hospital_section ";
	$Sql .= "(Hospital_Code,Hospital_Section)";
	$Sql .= " VALUES ";
	$Sql .= "('$HCode','$HSection')";
	$meQuery = mysqli_query($conn,$Sql);
}

$AF = $_SESSION["AF"];
if($AF == 0)
	header('location:InAreaSub.php?ICode='.$ICode.'&IName='.$IName);
else
	header('location:AfterAreaSub.php?ICode='.$ICode.'&IName='.$IName);
?>

<body>
<textarea  rows='10' cols='50' ><?php echo $Sql ?></textarea>
</body>