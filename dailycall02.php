<?php
session_start();
require 'connect.php';

    
	$Area = $_SESSION["Area"];
	if( ($Area == "padmin") || ($Area == "psbkk") ){
		$xArea = $_SESSION["xArea"];
	}else{
		$xArea = $Area;
	}
	
	$xItem_Search = $_SESSION["Item_Search"];
	$Dispenser = $_SESSION["Dispenser"];
	$PvCode = $_SESSION["PvCode"];
	$sDate = $_SESSION["MY1"];
	$eDate = $_SESSION["MY2"];
	
	$xPr = $_SESSION["xPr"] ;
	$xCusName = $_SESSION["xCusName"] ;
	$xName = $_SESSION["xName"];
	$getCus = "";
	
	$Sql = "SELECT Cus_Code,FName FROM customer INNER JOIN area ON customer.AreaCode = area.`Code` WHERE customer.AreaCode = '$xArea' AND area.Pv_Code LIKE '$PvCode%'";
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$getCus .= "dallycall.Cus_Code = '" .$Result["Cus_Code"] . "' OR ";
	}
	$getCus = substr($getCus,0,strlen($getCus)-3);
	
	//========================================== 
	//  
	//==========================================
	$Sql = "SELECT ";
	$Sql .= "dallycall.Id,dallycall.DocNo,dallycall.xDate AS DocDate,CONCAT(customer.FName,' ',customer.LName) AS xName,";
	$Sql .= "item.NameTH,dallycall.Qty,dallycall.Price,dallycall.Total,dallycall.DiscountP,dallycall.DiscountB,";
	$Sql .= "dallycall.VatB,dallycall.CmsP,dallycall.CmsB,dallycall.Total2,dallycall.WelfareP,dallycall.WelfareB,";
	$Sql .= "dallycall.Total3,dallycall.DallyP,dallycall.DallyB,contact.CT_Name,dallycall.BonusItemCode,";
	$Sql .= "dallycall.AreaCode,dallycall.AreaCode2,sale.isArea,sale.Sale_Status ";
	
	$Sql .= "FROM dallycall ";
	
	$Sql .= "INNER JOIN sale ON dallycall.DocNo = sale.DocNo ";
	$Sql .= "INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code ";
	$Sql .= "INNER JOIN contact ON dallycall.CT_Code = contact.CT_Code ";
	$Sql .= "INNER JOIN item ON dallycall.ItemCode = item.Item_Code ";
	
	$Sql .= "WHERE dallycall.AreaCode = '$xArea' ";

	$Sql .= "AND sale.DocDate BETWEEN '$sDate' AND '$eDate' ";
	$Sql .= "AND dallycall.AreaCode2 = '-' ";
	$Sql .= "AND dallycall.IsCancel = 0 ";
	$Sql .= "AND sale.IsCancel = 0 ";

	if($Dispenser == 1) $Sql .= "AND item.row_count BETWEEN 1 AND 15 ";

	$Sql .= "AND ( item.Item_Code LIKE '%". $xPr ."%' OR item.NameTH LIKE '%". $xPr ."%' ) ";
	$Sql .= "AND ( customer.Cus_Code LIKE '%". $xCusName ."%' OR customer.FName LIKE '%". $xCusName ."%' ) ";

	$Sql .= "ORDER BY xDate ASC";
	// echo $Sql;
    $Sql123 = $Sql;
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		
		$xDocNo[$i] =  $Result["DocNo"];
		$xDocDate[$i] =  $Result["DocDate"];
		$xRefDocNo[$i] =  $Result["RefDocNo"];
		$xFullName[$i] =  $Result["xName"];
		$NameTH[$i] =  $Result["NameTH"];
		$Qty[$i] =  $Result["Qty"];
		$Price[$i] =  number_format($Result["Price"], 2, '.', ',');
		$Total[$i] =  number_format($Result["Total"], 2, '.', ',');
		$xTotal += $Result["Total"];
		$VatB[$i] =  number_format($Result["VatB"], 2, '.', ',');
		$xVatB += $Result["VatB"];
		$CmsP[$i] =  $Result["CmsP"]."%";
		$CmsB[$i] =  number_format($Result["CmsB"], 2, '.', ',');
		$xCmsB += $Result["CmsB"];
		$Total2[$i] =  number_format($Result["Total2"], 2, '.', ',');
		$xTotal2 += $Result["Total2"];
		$WelfareP[$i] =  $Result["WelfareP"]."%";
		$xWelfareP += $Result["WelfareP"];
		$Total3[$i] =  number_format($Result["WelfareB"], 2, '.', ',');
		$xTotal3 += $Result["WelfareB"];
		
		$i++;
	}
	
	$xTotalPP = $xTotal3;
	$xTotal =  number_format($xTotal, 2, '.', ',');
	$xVatB =  number_format($xVatB, 2, '.', ',');
	$xCmsB =  number_format($xCmsB, 2, '.', ',');
	$xTotal2 =  number_format($xTotal2, 2, '.', ',');
	$xWelfareP =  number_format($xWelfareP, 2, '.', ',');
	$xTotal3 =  number_format($xTotal3, 2, '.', ',');

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
	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
</head>

<body>
	<div class="topnav">
        <a href="dailycall01.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : Daily call</div>
        <div class="topnav-right">        
			<a href="PieChart.php"><img src='img/rsz_pie-chart.png' width='30px' height='30px' /></a>    
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>

	<div class="overflow-auto">
		<table class="table">
              <tr>
                <td>
					<table class="table">
							<thead>
							<tr class="ui-bar-d">
								<th style="width: 50px;">ลำดับ</th>
								<th style="width: 170px;">วันที่</th>
								<th style="width: 250px;">เลขที่เอกสาร</th>
								<th style="width: 350px;">ลูกค้า</th>
								<th style="width: 150px;">รายการ</th>
								<th style="width: 150px;">จำนวน</th>
								<th style="width: 150px;">ราคา</th>
								<th style="width: 150px;">รวมเป็นเงิน</th>
								<th style="width: 150px;">ถอด Vat</th>
								<th style="width: 150px;">ส.ก.(%)</th>
								<th style="width: 150px;">ส.ก.(B)</th>
								<th style="width: 150px;">คงเหลือ</th>
								<th style="width: 150px;">เข้ายอด</th>
								<th style="width: 150px;">Daily Sales</th>
							</tr>
							</thead>
							<tbody>
								<?php 	for($j=0;$j<$i;$j++){ ?>               
									<tr>
										<th><?php echo $j+1 ?></th>
										<td><?php echo $xDocDate[$j] ?></td>
										<td><?php echo $xDocNo[$j] ?></td>
										<td><?php echo $xFullName[$j] ?></td>
										<td><?php echo $NameTH[$j] ?></td>
										<td><?php echo $Qty[$j] ?></td>
										<td><?php echo $Price[$j] ?></td>
										<td><?php echo $Total[$j] ?></td>
										<td><?php echo $VatB[$j] ?></td>
										<td><?php echo $CmsP[$j] ?></td>
										<td><?php echo $CmsB[$j] ?></td>
										<td><?php echo $Total2[$j] ?></td>
										<td><?php echo $WelfareP[$j] ?></td>
										<td><?php echo $Total3[$j] ?></td>
									</tr>
								<?php } ?>
							</tbody>
							<tfoot>
							<tr class="ui-bar-a">
								<th>&nbsp;</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
								<th>เป็นเงิน</th>
								<th>&nbsp;</th>
								<th>&nbsp;</th>
								<th><?php echo $xTotal ?></th>
								<th><?php echo $xVatB ?></th>
								<th>&nbsp;</th>
								<th><?php echo $xCmsB ?></th>
								<th><?php echo $xTotal2 ?></th>
								<th>&nbsp;</th>
								<th><?php echo $xTotal3 ?></th>
							</tr>
							</tfoot>
					</table>

		<?php
			$Sql = "SELECT ";
			$Sql .= "COUNT(*) AS Cnt ";
			$Sql .= "FROM dallycall ";
			
			$Sql .= "INNER JOIN sale ON dallycall.DocNo = sale.DocNo ";
			$Sql .= "INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code ";
			$Sql .= "INNER JOIN contact ON dallycall.CT_Code = contact.CT_Code ";
			$Sql .= "INNER JOIN item ON dallycall.ItemCode = item.Item_Code ";
			
			$Sql .= "WHERE dallycall.AreaCode = '$xArea' ";
			$Sql .= "AND sale.DocDate BETWEEN '$sDate' AND '$eDate' ";
			$Sql .= "AND dallycall.AreaCode2 = '-' ";
			$Sql .= "AND dallycall.IsCancel = 0 ";
			$Sql .= "AND sale.IsCancel = 0 ";

			if($Dispenser == 1) $Sql .= "AND item.row_count BETWEEN 1 AND 15 ";
			
			$Sql .= "AND ( item.Item_Code LIKE '%". $xPr ."%' OR item.NameTH LIKE '%". $xPr ."%' ) ";
			$Sql .= "AND ( customer.Cus_Code LIKE '%". $xCusName ."%' OR customer.FName LIKE '%". $xCusName ."%' ) ";
			
			$Sql .= "GROUP BY dallycall.Cus_Code ";
			$Cnt=0;
			//echo $Sql."<br>";
			$meQuery = mysqli_query($conn,$Sql);
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$Cnt++;
			}
			
			$Sql = "SELECT ";
			$Sql .= "Refund ";
			$Sql .= "FROM refund ";
			$Sql .= "WHERE Area = '$xArea' ";
			$Sql .= "AND  xYear = '".substr($eDate,0,4)."' ";
			$Sql .= "AND xMounth = '".substr($eDate,5,2)."' ";
			$Refund = "0";
			$meQuery = mysqli_query($conn,$Sql);
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$Refund = $Result["Refund"];
			}
			
			//echo $Refund . "  " . $Sql123."<br>";
		?>
					<div align="left">
						<table class="table">
							<tr>
								<td width="42%">Outlet</td>
								<td width="58%" align="right"><?php echo $Cnt ?></td>
								<td width="58%" align="left">lot</td>
							</tr>
							<tr>
								<td>ยอดรวม</td>
								<td align="right"><?php echo $xTotal3 ?></td>
								<td align="left">บาท</td>
							</tr>
							<tr>  
								<td>หักยอด</td>
								<td align="right"><?php echo  number_format( $Refund , 2, '.', ',')  ?></td>
								<td align="left">บาท</td>
							</tr>
							<tr>  
								<td>รวมเป็นเงิน</td>
								<td align="right"><?php echo number_format( ($xTotalPP - $Refund) , 2, '.', ',') ?></td>
								<td align="left">บาท</td>
								
							</tr>
						</table>
					</div>
				</td>
			  </tr>
		</table>	  		
	</div>


</body>

</html>
