<?php
session_start();
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
	
require 'connect.php';
$xID = $_SESSION["xID"];
$ICode = $_REQUEST["ICode"];
$IName = $_REQUEST["IName"];

	$Sql = "INSERT INTO area_note_sub ";
	$Sql .= "(AreaNoteCode,ItemCode)";
	$Sql .= " VALUES ";
	$Sql .= "('".$xID."','".$ICode."')";
	$meQuery = mysqli_query($conn,$Sql);	

$AF = $_SESSION["AF"];
if($AF == 1)
	header('location:AfterArea.php');
else
	header('location:InArea.php');
// header('location:ListAreaNote.php?HCode='.$HCode.'&HName='.$HName);
?>
<body>
<textarea  rows='10' cols='50' ><?php echo $Cnt ?> : <?php echo $Sql ?></textarea>
</body>