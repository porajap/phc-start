<?php
session_start();
require 'connect.php';
	$xMonth = $_POST["xMonth"];
	$xYear = $_POST["xYear"];
	$xMonth1 = $_POST["xMonth1"];
	$xYear1 = $_POST["xYear1"];
	
	$xPr = $_POST["item_Search"];
	
	$xPr = str_replace(' ', '%', $xPr);
	$xCusName = $_POST["Cus_Search"];
	$xCusName = str_replace(' ', '%', $xCusName);

	if (isset($_POST['xDispenser'])) {
		$Dispenser = 1;
	} else {
		$Dispenser = 0;
	}

	$xArea = $_SESSION["Area"];
	
	// echo  "item : ".$xPr . "<br>";
	// echo  "CusName : ".$xCusName . "<br>";
	// echo "1>" . $xMonth . "-";
	// echo  $xYear . "<br>";
	// echo  "2>" . $xMonth1 . "-";
	// echo  $xYear1 . "<br>";
	// echo  "Area : " . $xArea . "<br>";
	// echo  "Dispenser : " . $Dispenser . "<br>";

if($xArea == "psbkk"){
	$Sql = "SELECT sDate,eDate FROM perioddallycall WHERE `Month` = '$xMonth' AND `Year` = '$xYear' ";

	$meQuery = mysqli_query($conn,$Sql);
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$sDate	=  $Result["sDate"];
		$eDate	=  $Result["eDate"];
	}
}else{
    $Sql = "SELECT sDate,eDate FROM perioddallycall WHERE `Month` = '$xMonth' AND `Year` = '$xYear' ";

	$meQuery = mysqli_query($conn,$Sql);
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$sDate	=  $Result["sDate"];
	}
	
	$Sql = "SELECT eDate FROM perioddallycall WHERE `Month` = '$xMonth1' AND `Year` = '$xYear1' ";
	$meQuery = mysqli_query($conn,$Sql);
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$eDate	=  $Result["eDate"];
	}	
	
	//$sDate = date("$xYear-$xMonth-1") ;
	//$eDate = date("$xYear1-$xMonth1-t", strtotime("$xYear1-$xMonth1-26"));
}

	$_SESSION["MY1"] = $sDate ;
	$_SESSION["MY2"] = $eDate ;
	$_SESSION["xPr"] = $xPr ;
	$_SESSION["xCusName"] = $xCusName ;
	$_SESSION["xArea"] = $xArea;
	$_SESSION["Dispenser"] = $Dispenser;	
	
	//$Sql = "UPDATE xdate SET YM = '$ss' WHERE Id = 1";
	//$meQuery = mysqli_query($conn,$Sql);

	header('location:dailycall01.php');
?>
<body>
	<!-- <textarea  rows='10' cols='50' ><?php echo $Sql ?></textarea> -->
</body>