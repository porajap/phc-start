<?php
session_start();
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
require 'connect.php';
$xID = $_SESSION["xID"];
$t1 = $_POST["t0"];
$t2 = $_POST["t2"];
$t3 = $_POST["t3"];
$t4 = $_POST["t4"];
$t5 = $_POST["t5"];
$t6 = $_POST["t6"];
/*
$Sql = "INSERT INTO area_note ";
$Sql .= "(xdate,Hospital_Code,Dt,Section_ID,note,modify_date,t6,AreaCode)";
$Sql .= " VALUES ";
$Sql .= "('".date("Y-m-d")."','$t1','$t2','$t3','$t4','".date("Y-m-d H:i:s")."',$t6,'$Area')";
*/
$Cnt = 0;
$Sql1 = "UPDATE area_note SET ";
$Sql1 .= "Dt='" . $t2 . "',";
$Sql1 .= "modify_date='" . date("Y-m-d H:i:s") . "',";
$Sql1 .= "t6='" . $t6 . "' ";
$Sql1 .= "WHERE ID = " . $xID;
$meQuery = mysqli_query($conn,$Sql1);

$Sql = "SELECT COUNT(*) AS Cnt FROM area_note_sub WHERE AreaNoteCode = " . $xID;
$objQuery2 = mysqli_query($conn,$Sql) ;
while($objResult2 = mysqli_fetch_assoc($objQuery2))
{											
	$Cnt = $objResult2["Cnt"];						
}

if($Cnt == 0){
	$Sql = "INSERT INTO area_note_sub ";
	$Sql .= "(AreaNoteCode,ItemCode)";
	$Sql .= " VALUES ";
	$Sql .= "('".$xID."','999999')";
	$meQuery = mysqli_query($conn,$Sql);	
}

$_SESSION["xID"]="";
$HCode = $_SESSION["HCode"];
$HName = $_SESSION["HName"];
$AF = $_SESSION["AF"];

header('location:ListAreaNote.php?HCode='.$HCode.'&HName='.$HName);
?>
<body>
<textarea  rows='10' cols='50' ><?php echo $Cnt ?> : <?php echo $Sql1 ?></textarea>
</body>