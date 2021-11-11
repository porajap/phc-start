<?php
require 'connect.php';
$xDocNo = $_REQUEST["DocNo"];
$xId = $_REQUEST["Id"];

//echo $xDocNo . " : " . $xItemCode ."<br>";
$Sql = "DELETE FROM borrow_detail WHERE DocNo = '$xDocNo' AND Id = $xId";
//echo $Sql;
$meQuery = mysqli_query($conn,$Sql);
header('location:Borrow_DocNo.php?DocNo='.$xDocNo.'&add=1');
?>