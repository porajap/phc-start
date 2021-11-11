<?php
session_start();
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
	
require 'connect.php';
$xID = $_SESSION["xID"];
$ICode = $_REQUEST["ICode"];

$Sql = "DELETE FROM area_note_sub WHERE AreaNoteCode = " . $xID . " AND ItemCode = '".$ICode."'";
$objQuery2 = mysqli_query($conn,$Sql) ;

$AF = $_SESSION["AF"];

if($AF == 1)
	header('location:AfterArea.php');
else
	header('location:InArea.php');

?>
<body>
<textarea  rows='10' cols='50' ><?php echo $Cnt ?> : <?php echo $Sql ?></textarea>
</body>