<?php
require 'connect.php';
$xDocNo = $_POST["tDocNo"];
$xDetail = $_POST["tDetail"];
$tDate = $_POST["tDate"];
$xPO = $_POST["xPO"];

$IsQT = $_POST["xQT"];
$IsST = $_POST["xST"];
$IsBV = $_POST["xBV"];

$ssName     = $_POST["ssName"];
$ssLocation = $_POST["ssLocation"];
$ssAddress1 = $_POST["ssAddress1"];
$ssAddress2 = $_POST["ssAddress2"];

//echo $xDocNo . "  :  " . $xDetail;
$Sql = "UPDATE br_dispenser SET ";
$Sql .= "IsSave=1,IsPO='$xPO',IsQT='$IsQT',IsBV='$IsBV',tDate='$tDate',IsST='$IsST',Detail='$xDetail',";
$Sql .= "ssName='$ssName',ssLocation='$ssLocation',ssAddress1='$ssAddress1',ssAddress2='$ssAddress2' ";
$Sql .= "WHERE DocNo = '$xDocNo'";

$meQuery = mysqli_query($conn,$Sql);
$Cnt = 0;
if( $meQuery ){
	$Sql = "SELECT Cus_Code,Area_Code FROM br_dispenser WHERE DocNo = '$xDocNo'";
	$result = mysqli_query($conn,$Sql);
    while ($row = $result->fetch_assoc()) {
        $AreaCode = $row["Area_Code"];
        $CusCode  = $row["Cus_Code"];
	}
	// $xSql = str_replace("'","",$Sql);
	// mysqli_query($conn, "INSERT INTO log (log) VALUES ('$xSql')");
	$Sql = "SELECT COUNT(*) AS Cnt FROM br_dispenser_address WHERE ssName = '$ssName' AND AreaCode = '$AreaCode' AND CusCode = '$CusCode'";
	$result = mysqli_query($conn, $Sql);
	while ($row = $result->fetch_assoc()){
		$Cnt = $row["Cnt"]; 
	}
	$xSql = str_replace("'","",$Sql);
	// mysqli_query($conn, "INSERT INTO log (log) VALUES ('$xSql')");
	if($Cnt==0){
		$Sql = "INSERT INTO br_dispenser_address ";
		$Sql .= "(ssName,ssLocation,ssAddress1,ssAddress2,AreaCode,CusCode) ";
		$Sql .= "VALUES ";
		$Sql .= "('$ssName','$ssLocation','$ssAddress1','$ssAddress2','$AreaCode','$CusCode') ";
		mysqli_query($conn, $Sql);
	}
}

$_SESSION["DocNo"] = "";
$_SESSION["ItemCode"] = "";
$_SESSION["Qty"] = "";
$_SESSION["Price"] = "";
$_SESSION["Detail"] = "";
	
	
header('location:Dispenser.php');
?>
<body>
<textarea  rows='10' cols='50' ><?php echo $Sql ?></textarea>
</body>