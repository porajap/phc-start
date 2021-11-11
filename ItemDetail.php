<?php

session_start();
require 'connect.php';
	if($_SESSION["DocNo"] == "" && $_SESSION["ItemCode"] == "") header('location:index.html');

	$Area = $_SESSION["Area"];
	$xName = $_SESSION["xName"];
	$DocNo = $_SESSION["DocNo"];
	$ItemCode = $_SESSION["ItemCode"];

	$Sql = "SELECT ";
	$Sql .= "sale.RefDocNo,dallycall.xDate,CONCAT(customer.FName,' ',customer.LName) AS xName,";
	$Sql .= "item.NameTH,dallycall.Qty,dallycall.Price,dallycall.Total,dallycall.DiscountP,";
	$Sql .= "dallycall.DiscountB,dallycall.VatB,dallycall.CmsP,dallycall.CmsB,dallycall.Total2,";
	$Sql .= "dallycall.WelfareP,dallycall.WelfareB,dallycall.Total3,dallycall.DallyP,dallycall.DallyB,sale_detail.xDetail ";
	$Sql .= "FROM dallycall ";
	$Sql .= "INNER JOIN item ON dallycall.ItemCode = item.Item_Code ";
	$Sql .= "INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code ";
	$Sql .= "INNER JOIN sale ON dallycall.DocNo = sale.DocNo ";
	$Sql .= "INNER JOIN sale_detail ON sale.DocNo = sale_detail.DocNo ";
		
	$Sql .= "WHERE dallycall.DocNo = '$DocNo' ";
	$Sql .= "AND dallycall.ItemCode = '$ItemCode' ";
	$Sql .= "AND dallycall.IsCancel = 0 ";
	$Sql .= "AND sale.IsCancel = 0 ";
	$Sql .= "AND item.IsSale = 1 ";
	$Sql .= "AND item.Grp_1 = 1 ";

	//echo $Sql."<br>";
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery)) {
		$RefDocNo = $Result["RefDocNo"];
		$NameTH =  $Result["NameTH"];
		$Qty =  $Result["Qty"];
		$Price =  number_format($Result["Price"], 2, '.', ',');
		$Total =  number_format($Result["Total"], 2, '.', ',');
		$VatB =  number_format($Result["VatB"], 2, '.', ',');
		$CmsP =  number_format($Result["CmsP"], 2, '.', ',');
		$CmsB =  number_format($Result["CmsB"], 2, '.', ',');
		$Total2 =  number_format($Result["Total2"], 2, '.', ',');
		$WelfareP =  number_format($Result["WelfareP"], 2, '.', ',');
		$Total3 =  number_format($Result["Total3"], 2, '.', ',');
		$xDetail =  $Result["xDetail"];
		
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
        <a href="Date01.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : ราคาสินค้า</div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>

		<div class="input-group">
          <span class="input-group-text xBoxWh">เลขที่เอกสาร</span>
          <input type="text"  value="<?= $RefDocNo ?>" class="form-control" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
          <span class="input-group-text xBoxWh">รายการ</span>
          <input type="text"  value="<?= $NameTH ?>" class="form-control" aria-describedby="basic-addon1">
		</div>
		<div class="input-group">
          <span class="input-group-text xBoxWh">จำนวนซื้อ</span>
          <input type="text"  value="<?= $Qty ?>" class="form-control" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
          <span class="input-group-text xBoxWh">ราคา</span>
          <input type="text"  value="<?= $Price ?>" class="form-control" aria-describedby="basic-addon1">
		</div>
		<div class="input-group">
          <span class="input-group-text xBoxWh">รวมเป็นเงิน</span>
          <input type="text"  value="<?= $Total ?>" class="form-control" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
          <span class="input-group-text xBoxWh">ถอด Vat</span>
          <input type="text"  value="<?= $VatB ?>" class="form-control" aria-describedby="basic-addon1">
		</div>
		<div class="input-group">
          <span class="input-group-text xBoxWh">ส.ก.(%)</span>
          <input type="text"  value="<?= $CmsP ?>" class="form-control" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
          <span class="input-group-text xBoxWh">หัก ส.ก.</span>
          <input type="text"  value="<?= $CmsB ?>" class="form-control" aria-describedby="basic-addon1">
		</div>
		<div class="input-group">
          <span class="input-group-text xBoxWh">คงเหลือ</span>
          <input type="text"  value="<?= $Total2 ?>" class="form-control" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
          <span class="input-group-text xBoxWh">เข้ายอด</span>
          <input type="text"  value="<?= $WelfareP ?>" class="form-control" aria-describedby="basic-addon1">
		</div>
		<div class="input-group">
          <span class="input-group-text xBoxWh">Dally Sale</span>
          <input type="text"  value="<?= $Total3 ?>" class="form-control" aria-describedby="basic-addon1">
        </div>
        <div class="input-group">
          <span class="input-group-text xBoxWh">รายละเอียด</span>
          <input type="text"  value="<?= $xDetail ?>" class="form-control" aria-describedby="basic-addon1">
		</div>
</body>

</html>
