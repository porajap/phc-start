<?php
session_start();
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
	
require 'connect.php';
$xID = $_SESSION["xID"];

$t3 = $_POST["t3"];
$t4 = $_POST["t4"];

$Sql = "INSERT INTO area_note_sub_note ";
$Sql .= "(AreaNoteCode,Section_ID,note)";
$Sql .= " VALUES ";
$Sql .= "('".$xID."','".$t3."','".$t4."')";

$meQuery = mysqli_query($conn,$Sql);

$AF = $_SESSION["AF"];

if($AF == 0)
	header('location:InArea.php');
else
	header('location:AfterArea.php');

?>

<body>
<textarea  rows='10' cols='50' ><?php echo $AF ?> : <?php echo $HCode ?> : <?php echo $HName ?> : <?php echo $Sql ?></textarea>
</body>