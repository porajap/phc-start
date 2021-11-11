<?php
session_start();
require 'connect.php';

	function getPrice($conn,$xIt,$Cus_Code,$Area)
	{
		$Sql = "SELECT sale_detail.Price AS Price ";
		$Sql .= "FROM sale_detail ";
		$Sql .= "INNER JOIN sale ON sale.DocNo = sale_detail.DocNo ";
		$Sql .= "INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code ";
		$Sql .= "INNER JOIN item ON sale_detail.Item_Code = item.Item_Code ";
		$Sql .= "WHERE customer.AreaCode = '$Area' ";
		$Sql .= "AND customer.Cus_Code = '$Cus_Code' ";
		$Sql .= "AND customer.Cus_Code = '$Cus_Code' ";
		$Sql .= "AND sale_detail.Item_Code = '$xIt' ";
		$Sql .= "AND item.IsCancel = 0 AND item.IsSale = 1 ";
		
		$Sql .= "ORDER BY sale.DocDate DESC LIMIT 1";	
		//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";
		$meQuery1 = mysqli_query($conn,$Sql);
		while ($Result1 = mysqli_fetch_assoc($meQuery1))
		{	
			$Price = $Result1["Price"];
		}
		//echo "<textarea  rows='10' cols='50' >$Cnt : $SqlX </textarea>";
		return $Price;
	}

	$sel =  $_REQUEST["sel"];
	$Search =   str_replace(" ","%",$_POST["Search"]) ;
	
	$Cus_Code = $_SESSION["Cus_Code"];
	$Area = $_SESSION["Area"];
	$xTitle = $_SESSION["xTitle"];
	// echo $Cus_Code . ":::" . $Area;
	
	if($_SESSION["Area"] == "") header('location:index.html');
	if($_SESSION["Cus_Code"] == "") header('location:index.html');
	
	if($_REQUEST["ItemCode"] != ""){
		$_SESSION["ItemCode"] = $_REQUEST["ItemCode"];
		$_SESSION["Price"] = $_REQUEST["Price"];
		header('location:Qty01.php');
	}
	
	
	$xName = $_SESSION["xName"];
	$xCusFullName =$_SESSION["CusFullName"];
	
	if($sel==1){
		$Sql = "SELECT sale_detail.Item_Code,item.NameTH,sale.DocDate";
		$Sql .= ",sale_detail.Price AS Price ";
		$Sql .= "FROM sale_detail ";
		$Sql .= "INNER JOIN sale ON sale.DocNo = sale_detail.DocNo ";
		$Sql .= "INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code ";
		$Sql .= "INNER JOIN item ON sale_detail.Item_Code = item.Item_Code ";
		$Sql .= "WHERE ";
		$Sql .= "customer.AreaCode = '$Area' AND customer.Cus_Code = '$Cus_Code' ";
		$Sql .= "AND item.IsCancel = 0 AND item.IsSale = 1 ";
		$Sql .= "GROUP BY item.Item_Code ORDER BY item.Item_Code ASC,sale.DocDate DESC LIMIT 20";
	}else{
		$Sql .= "SELECT item.Item_Code,item.NameTH,item.SalePrice AS Price ";
		$Sql .= "FROM item ";
		$Sql .= "WHERE (item.Item_Code LIKE '%$Search%' OR item.NameTH LIKE '%$Search%') ";
		$Sql .= "AND item.IsCancel = 0 AND item.IsSale = 1 ";
		$Sql .= "ORDER BY item.Item_Code ASC LIMIT 20";
	}
	//echo $Sql."<br>";
	$Search = "";
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$Item_Code[$i]	=  $Result["Item_Code"];
		$DocDate[$i]	=  $Result["DocDate"];
		$NameTH[$i]	=  $Result["NameTH"];
		if($sel==1){
			$xPrice[$i] =  getPrice($conn, $Result["Item_Code"] ,$Cus_Code ,$Area );
		}else{
			$xPrice[$i] = $Result["Price"];
		}
		//echo $xPrice[$i]." : ".getPrice( $Result["Item_Code"] ,$Cus_Code ,$Area )."<br>";
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
    <link rel="stylesheet" href="css/all.css">
	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
</head>

<body>
<div class="topnav">
        <a href="Quotation_DocNo.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : <?= $xTitle ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>
	<div class="xTop1" align="center"><?php echo $xCusFullName ?></div>
	<form action="QtPriceSale.php" method="post">
		<div class="row xTop1">
			<div class="col">
				<label for="inputTxt1" class="visually-hidden">ค้นหา</label>
				<input type="Text" class="form-control" name="Search" id="Search" placeholder="ค้นหา">
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-primary mb-3">ค้นหา</button>
			</div>
		</div>
    </form>

	<table width="100%" border="0" cellspacing="5" cellpadding="5">
               
              <tr>
              
                <td>
         <div data-demo-html="true">

			<table class="table">
                <thead>
                  <tr class="ui-bar-d">
                    <th data-priority="2">ลำดับ</th>
                    <th>รายการ</th>
                    <th data-priority="1">ราคา</th>
                  </tr>
                </thead>
                <tbody>
                
 <?php 	for($j=0;$j<$i;$j++){ ?>               
                  <tr>
                    <th><?php echo $j+1 ?></th>
                    <td><a href="QtyQuotation.php?ItemCode=<?php echo $Item_Code[$j] ?>&amp;Price=<?php echo $xPrice[$j] ?>"><?php echo $NameTH[$j] ?></a></td>
                    <td><?php echo $xPrice[$j] ?></td>
                  </tr>
<?php } ?>
                </tbody>
              </table>

		</div>
                </td>
              </tr>
</table>


</body>

</html>
