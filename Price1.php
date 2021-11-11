<?php

session_start();
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
	$xMonth = $_POST["xMonth"];
	$xYear = $_POST["xYear"];
	$xMonth2 = $_POST["xMonth1"];
	$xYear2 = $_POST["xYear1"];
	
	$sDate = date("$xYear-$xMonth-01") ;
	$eDate = date("$xYear2-$xMonth2-t", strtotime("$xYear2-$xMonth2-26"));

	//$ff = date("Y-m-1", strtotime("-1 month") )  . " - " . date("Y-m-t", strtotime("-1 month") );

	$xD = $sDate." - ".$eDate ;
	
	if($_SESSION["Area"] == "") header('location:index.html');
	
	$Area = $_SESSION["Area"];
	$xName = $_SESSION["xName"];
	
	$chk1 = substr( ($sDate ),0,4);
	$chk2 = substr( ($eDate ),0,4);
	
	if($chk1>2000 && $chk2>2000){
		$sDate = $chk1.substr($sDate,4,8);
		$eDate = $chk2.substr($eDate,4,8);
	}
	//echo $sDate . " : " . $eDate . "<br>";
	$Sql = "SELECT sale_detail.Item_Code,item.NameTH,sale_detail.Price,sale.DocDate,sale.DocNo,customer.FName ";
	$Sql .= "FROM sale_detail ";
	$Sql .= "INNER JOIN sale ON sale.DocNo = sale_detail.DocNo ";
	$Sql .= "INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code ";
	$Sql .= "INNER JOIN item ON sale_detail.Item_Code = item.Item_Code ";
	$Sql .= "WHERE customer.AreaCode = '$Area' ";
	$Sql .= "AND  sale.DocDate BETWEEN '$sDate' AND '$eDate' ";
	$Sql .= "AND sale.IsCancel = 0 AND item.IsSale = 1 ";
	$Sql .= "ORDER BY item.Item_Code ASC,sale.DocDate DESC";
	// echo $Sql . "<br>";
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$xDocNo[$i] =  $Result["DocNo"];
		$Item_Code[$i] =  $Result["Item_Code"];
		$FName[$i] =  $Result["FName"];
		$Item[$i] =  $Result["DocDate"] . " : " . $FName[$i] . " : " . $Result["NameTH"] . " [ " .number_format($Result["Price"], 2, '.', ','). " ]";
		//echo $xDocNo[$i]."<br>";
		$i++;
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>PHC</title>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="icon/icon.ico">
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/sweetalert2.min.css">
	<link rel="stylesheet" href="css/topnav.css">
	<link rel="stylesheet" href="css/hr.css">
	<link rel="stylesheet" href="css/all.css">
	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
</head>

<body>
    <div class="topnav">
        <a href="Date01.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : ราคาสินค้า</div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>

		<?php 
			if( ($_REQUEST["ItemCode"] != "") && ($_REQUEST["DocNo"] != "") ){
				$_SESSION["DocNo"] = $_REQUEST["DocNo"];
				$_SESSION["ItemCode"] = $_REQUEST["ItemCode"];
			

				echo "<script>
				window.location.href = 'ItemDetail.php';
				</script>
				";
			}
		?>
	<div class="row">
		<div class="col-12">
			<div class="list-group">
<?php
	for($j=0;$j<$i;$j++){
?>
		<a class="list-group-item list-group-item-action" href="Price1.php?DocNo=<?php echo $xDocNo[$j] ?>&ItemCode=<?php echo $Item_Code[$j] ?>"><?php echo $Item[$j] ?></a>
<?php } ?>
			</div>
		</div>
	</div>
</body>

</html>
