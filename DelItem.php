<?php
require 'connect.php';
$xDocNo = $_REQUEST["DocNo"];
$xItemCode = $_REQUEST["ItemCode"];

//echo $xDocNo . " : " . $xItemCode ."<br>";
$Sql = "DELETE FROM saleorder_detail WHERE DocNo = '$xDocNo' AND Item_Code = '$xItemCode'";
//echo $Sql;
$meQuery = mysqli_query($conn,$Sql);
header('location:Order_DocNo.php');
?>