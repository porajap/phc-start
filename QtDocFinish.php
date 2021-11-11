<?php
require 'connect.php';
$xDocNo = $_POST["tDocNo"];
$xDetail = $_POST["tDetail"];
$xDetail2 = $_POST["tDetail2"];
$tDate = $_POST["tDate"];
$xPO = $_POST["xPO"];

$IsQT = $_POST["xQT"];
$IsST = $_POST["xST"];
$IsBV = $_POST["xBV"];

//echo $xDocNo . "  :  " . $xDetail;
$Sql = "UPDATE saleorder_sale SET ";
$Sql .= "IsSave=1,IsPO='$xPO',IsQT='$IsQT',IsBV='$IsBV',tDate='$tDate',IsST='$IsST',Detail='$xDetail',Detail2='$xDetail2' ";
$Sql .= "WHERE DocNo = '$xDocNo'";

$meQuery = mysqli_query($conn,$Sql);

	$_SESSION["DocNo"] = "";
	$_SESSION["ItemCode"] = "";
	$_SESSION["Qty"] = "";
	$_SESSION["Price"] = "";
	$_SESSION["Detail"] = "";
	
	
header('location:Quotation.php');
?>
<body>
<textarea  rows='10' cols='50' ><?php echo $Sql ?></textarea>
</body>