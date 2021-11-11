<?php

session_start();
require 'connect.php';
	if($_SESSION["Area"] == "") header('location:index.html');
	if($_SESSION["Cus_Code"] == "") header('location:index.html');
	
	$DocNo = $_REQUEST["DocNo"];
	$Cus_Code = $_SESSION["Cus_Code"];
	$Area = $_SESSION["Area"];
	$xName = $_SESSION["xName"];
	$xCusFullName =$_SESSION["Cus_Name"];
	
	$Sql = "SELECT sale_detail.Item_Code,item.NameTH,sale_detail.Price,sale.DocDate,sale.DocNo ";
	$Sql .= "FROM sale_detail ";
	$Sql .= "INNER JOIN sale ON sale.DocNo = sale_detail.DocNo ";
	$Sql .= "INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code ";
	$Sql .= "INNER JOIN item ON sale_detail.Item_Code = item.Item_Code ";
	$Sql .= "WHERE customer.AreaCode = '$Area' ";
	$Sql .= "AND customer.Cus_Code = '$Cus_Code' ";
	$Sql .= "AND sale_detail.DocNo = '$DocNo' ";
	$Sql .= "AND sale_detail.IsCancel = 0 AND item.IsSale = 1 ";
		
	$Sql .= "ORDER BY item.Item_Code ASC,sale.DocDate DESC";
	//echo $Sql."<br>";
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$xDocNo[$i] =  $Result["DocNo"];
		$Item_Code[$i] =  $Result["Item_Code"];
		$Item[$i]	=  $Result["DocDate"] . " : " . $Result["NameTH"] . " [ " . number_format($Result["Price"], 2, '.', ','). " ]";
		//echo $Item[$i]."<br>";
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
        <a href="Customer.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : <?= $xCusFullName ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>

	<div class="row">
			<div class="col-12">
				<div class="list-group">
	<?php 	for($j=0;$j<$i;$j++){ ?>
				<a class="list-group-item list-group-item-action" href="ItemDetail2.php?DocNo=<?php echo $xDocNo[$j] ?>&ItemCode=<?php echo $Item_Code[$j] ?>"><?php echo $Item[$j] ?></a>
	<?php } ?>
				</div>
			</div>
	</div>
</body>

</html>
