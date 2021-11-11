<?php
session_start();
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
	$sel = $_REQUEST["sel"];
	$xPv = $_SESSION["xPv"];
	$sYear = $_SESSION["sYear"];
	$eYear = $_SESSION["eYear"];
	$mm = date('m');
	$bb = "chkDate04.php?CusCode=1";
	$xTitle ="Cyclic purchasing ( All )";
	if($sel == 1){
		$bb = "chkDateDispenser.php?CusCode=1";
		$xTitle ="Cyclic purchasing ( Dispenser )";
	}

	$Sql = "SELECT sDate FROM perioddallycall WHERE `Month` = '01' AND `Year` = '$sYear' ";

	$meQuery = mysqli_query($conn,$Sql);
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$sDate	=  $Result["sDate"];
	}
	
	$Sql = "SELECT eDate FROM perioddallycall WHERE `Month` = '" . createDigit2($mm) . "' AND `Year` = '$eYear' ";

	$meQuery = mysqli_query($conn,$Sql);
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$eDate	=  $Result["eDate"];
	}


	$xCusCode = $_SESSION["CusCode"];
	$xArea = $_SESSION["xArea"];
	$Area = $_SESSION["Area"];
	$xName = $_SESSION["xName"];
	$gY = date("Y");
	$gM = date("m");
	
	function getPrice($conn,$y,$m,$AA,$IT,$PV,$CS)
	{
		
		$Sql = "SELECT sDate,eDate FROM perioddallycall WHERE `Month` = '" . createDigit2($m) . "' AND `Year` = '$y' ";
		//echo "<textarea  rows='10' cols='50' >$Sql </textarea>";
			$meQuery = mysqli_query($conn,$Sql);
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$sDate1	=  $Result["sDate"];
				$eDate1	=  $Result["eDate"];
			}
		
			$Sql = "SELECT SUM(dallycall.Total2) AS xQty FROM dallycall ";
			
			$Sql .= "INNER JOIN sale ON dallycall.DocNo = sale.DocNo ";
			$Sql .= "INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code ";
			$Sql .= "INNER JOIN th_tambon ON customer.tbCode = th_tambon.Tb_Code ";
			$Sql .= "INNER JOIN th_amphur ON th_tambon.Ap_Code = th_amphur.Ap_Code ";
			$Sql .= "INNER JOIN item ON dallycall.ItemCode = item.Item_Code ";
			$Sql .= "WHERE sale.DocDate BETWEEN '$sDate1' AND '$eDate1' ";
			$Sql .= "AND dallycall.AreaCode2 = '-' ";
			$Sql .= "AND dallycall.IsCancel = 0 ";
			$Sql .= "AND sale.IsCancel = 0 ";
			$Sql .= "AND item.Item_Code = '$IT' ";
			$Sql .= "AND customer.Cus_Code = '". $CS ."' ";
			$Sql .= "GROUP BY dallycall.ItemCode ";
			$Sql .= "ORDER BY xDate ASC";
			
			// echo "<textarea  rows='10' cols='50' >$Sql </textarea>";
		$meQuery1 = mysqli_query($conn,$Sql);
		$Cnt=0;
		while ($Result1 = mysqli_fetch_assoc($meQuery1))
		{	
			$Cnt = $Result1["xQty"];
		}
		//echo "<textarea  rows='10' cols='50' >$Cnt : $SqlX </textarea>";
		return $Cnt;
	}	
	
	function getQty($conn,$y,$m,$AA,$IT,$PV,$CS)
	{
		
		$Sql = "SELECT sDate,eDate FROM perioddallycall WHERE `Month` = '" . createDigit2($m) . "' AND `Year` = '$y' ";
		//echo "<textarea  rows='10' cols='50' >$Sql </textarea>";
			$meQuery = mysqli_query($conn,$Sql);
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$sDate1	=  $Result["sDate"];
				$eDate1	=  $Result["eDate"];
			}
		
			$Sql = "SELECT SUM(dallycall.Qty) AS xQty FROM dallycall ";
			
			$Sql .= "INNER JOIN sale ON dallycall.DocNo = sale.DocNo ";
			$Sql .= "INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code ";
			$Sql .= "INNER JOIN th_tambon ON customer.tbCode = th_tambon.Tb_Code ";
			$Sql .= "INNER JOIN th_amphur ON th_tambon.Ap_Code = th_amphur.Ap_Code ";
			$Sql .= "INNER JOIN item ON dallycall.ItemCode = item.Item_Code ";
			
			$Sql .= "WHERE sale.DocDate BETWEEN '$sDate1' AND '$eDate1' ";
			$Sql .= "AND dallycall.AreaCode2 = '-' ";
			$Sql .= "AND dallycall.IsCancel = 0 ";
			$Sql .= "AND sale.IsCancel = 0 ";
			$Sql .= "AND item.Item_Code = '$IT' ";
			$Sql .= "AND sale.isArea = 0 ";
			
			$Sql .= "AND customer.Cus_Code = '". $CS ."' ";
			$Sql .= "GROUP BY dallycall.ItemCode ";
			$Sql .= "ORDER BY xDate ASC";
			
			//echo "<textarea  rows='10' cols='50' >$Sql </textarea>";
		$meQuery1 = mysqli_query($conn,$Sql);
		$Cnt=0;
		while ($Result1 = mysqli_fetch_assoc($meQuery1))
		{	
			$Cnt = $Result1["xQty"];
		}
		//echo "<textarea  rows='10' cols='50' >$Cnt : $SqlX </textarea>";
		return $Cnt;
	}

	function getCusName($conn,$CC)
	{
		$SqlX = "SELECT customer.Cus_Code,customer.FName " . 
					"FROM customer WHERE customer.Cus_Code = '$CC'";
					
		//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";
		$meQuery1 = mysqli_query($conn,$SqlX);
		$Cnt1=0;
		while ($Result1 = mysqli_fetch_assoc($meQuery1))
		{	
			$Cnt1 = $Result1["FName"];
		}
		//echo "<textarea  rows='10' cols='50' >$Cnt : $SqlX </textarea>";
		return $Cnt1;
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
          <a href="<?php echo $bb ?>"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
          <div class="xlabel"><?= $xArea ?> : <?= $xTitle ?></div>
          <div class="topnav-right">            
              <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
          </div>
    </div>

    <div>
        <h1><?php echo getCusName($conn,$xCusCode)  ?></h1>
	</div>
    <div class="overflow-auto">
	<table width="860px" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>

		<div class="overflow-auto">

			<table border="0" cellspacing="0" cellpadding="0"  style='border:1px;border-style:solid solid solid solid;'>

                <thead>
                  <tr>
                  	<th style='border:1px;border-style:hidden solid solid hidden;background:#e6e600' width="50px" rowspan="2">ลำดับ</th>
                    <th style='border:1px;border-style:hidden solid solid hidden;background:#e6e600' width="140px" rowspan="2">รายการ</th>
                    <th style='border:1px;border-style:hidden solid solid hidden;background:#e6e600' align="center" width="50px" rowspan="2">ปี</th>
                    <th style='border:1px;border-style:hidden solid solid hidden;background:#e6e600' align="center" colspan="12">เดือน</th>
                  </tr>
                  <tr>
                    <th style="border:1px;border-style:hidden solid solid hidden;background:#e6e600;color:#000000" width="50px" height="29px"align="center"><div style="color:#F3D">1</div></th>
                    <th style="border:1px;border-style:hidden solid solid hidden;background:#e6e600;color:#000000" width="50px" align="center"><div style="color:#F3D">2</div></th>
                    <th style="border:1px;border-style:hidden solid solid hidden;background:#e6e600;color:#000000" width="50px" align="center"><div style="color:#F3D">3</div></th>
                    <th style="border:1px;border-style:hidden solid solid hidden;background:#e6e600;color:#000000" width="50px" align="center"><div style="color:#F3D">4</div></th>
                    <th style="border:1px;border-style:hidden solid solid hidden;background:#e6e600;color:#000000" width="50px" align="center"><div style="color:#F3D">5</div></th>
					<th style="border:1px;border-style:hidden solid solid hidden;background:#e6e600;color:#000000" width="50px" align="center"><div style="color:#F3D">6</div></th>
                    <th style="border:1px;border-style:hidden solid solid hidden;background:#e6e600;color:#000000" width="50px" align="center"><div style="color:#F3D">7</div></th>
                    <th style="border:1px;border-style:hidden solid solid hidden;background:#e6e600;color:#000000" width="50px" align="center"><div style="color:#F3D">8</div></th>
                    <th style="border:1px;border-style:hidden solid solid hidden;background:#e6e600;color:#000000" width="50px" align="center"><div style="color:#F3D">9</div></th>
                    <th style="border:1px;border-style:hidden solid solid hidden;background:#e6e600;color:#000000" width="50px" align="center"><div style="color:#F3D">10</div></th>
                    <th style="border:1px;border-style:hidden solid solid hidden;background:#e6e600;color:#000000" width="50px" align="center"><div style="color:#F3D">11</div></th>
                    <th style="border:1px;border-style:hidden solid solid hidden;background:#e6e600;color:#000000" width="50px" align="center"><div style="color:#F3D">12</div></th>
                  </tr>                  
                </thead>
                <tbody>
               
 <?php 	
 			/*
 			$Cus_Search = "";
 			$Sql = "SELECT Cus_Code FROM customer WHERE AreaCode = 'BB1'";
 			$meQuery = mysqli_query($conn,$Sql);
			$n=1;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
 				$Cus_Search = "Cus_Code = '" . $Result["Cus_Code"] . "' OR ";
			}
			
			$Cus_Search = substr($Cus_Search,0,strlen($Cus_Search)-3);
			
			*/
			
			$Sql = "SELECT item.Item_Code,item.NameTH,item.ForeColor ";
			$Sql .= "FROM dallycall ";
			
			$Sql .= "INNER JOIN sale ON dallycall.DocNo = sale.DocNo ";
			$Sql .= "INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code ";
			$Sql .= "INNER JOIN th_tambon ON customer.tbCode = th_tambon.Tb_Code ";
			$Sql .= "INNER JOIN th_amphur ON th_tambon.Ap_Code = th_amphur.Ap_Code ";
			$Sql .= "INNER JOIN item ON dallycall.ItemCode = item.Item_Code ";
			$Sql .= "WHERE ";
			$Sql .= "sale.DocDate BETWEEN '$sDate' AND '$eDate' ";
			$Sql .= "AND dallycall.AreaCode2 = '-' ";
			$Sql .= "AND dallycall.IsCancel = 0 ";
			$Sql .= "AND sale.IsCancel = 0 ";
			if($sel == 1){
				$Sql .= "AND item.row_count between 1 and 12 ";
			}
			if( $PvCode>0 ) $Sql .= "AND th_tambon.Tb_Code LIKE '$PvCode%' ";
			$Sql .= "AND customer.Cus_Code = '". $xCusCode ."' ";
			/*
			if( $PvCode<>0 ) $Sql .= "AND th_amphur.Pv_Code LIKE '$PvCode%' ";
			if( strlen($xPr)>0 ) $Sql .= "AND item.NameTH LIKE '%". $xPr ."%' ";
			if(  strlen($xCusName)>0 )  $Sql .= "AND customer.FName LIKE '%". $xCusName ."%' ";
			*/
			$Sql .= "GROUP BY dallycall.ItemCode ";
			$Sql .= "ORDER BY item.`No` ASC";
			// echo "<textarea  rows='10' cols='50' > $bb :: $Sql </textarea>";
			$meQuery = mysqli_query($conn,$Sql);
			$n=1;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				if(($n%2)==0)
					echo "<tr  bgcolor='#ffff99'>";
				else
					echo "<tr  bgcolor='#ffffe6'>";
				
				echo "	<td colspan='15'>";
				echo "	<table border='0' cellspacing='0' cellpadding='0'>";
				echo "		<tr>";
                echo "  			<td style='color:#". $Result["ForeColor"] .";border:1px;border-style:hidden solid solid hidden;' width='50px' align='center'>$n</td>";
                echo "    		<td style='color:#". $Result["ForeColor"] .";border:1px;border-style:hidden solid solid hidden;' width='140px';> ".$Result["NameTH"] . "</td>";
				echo "    		<td style='color:#". $Result["ForeColor"] .";border:1px;border-style:hidden solid solid hidden;' colspan='13'>";
				echo "				<table border='0' cellspacing='0' cellpadding='0'>";
									for($i=$sYear;$i<=$eYear;$i++){
										if(($i%2)==0)
											echo "		<tr bgcolor='#ffff99'>";
										else
											echo "		<tr bgcolor='#ffffe6'>";
											
										echo "    		<td width='50px' align='center' style='border-right: 1px  solid black;' >$i</td>";
										echo "    		<td>";
										echo "				<table border='0' cellspacing='0' cellpadding='0'>";
										echo "				<tr height='30px' >";
											for($j=1;$j<=12;$j++){
													if($gM == $j && $gY == $i ){
														if( getQty( $conn,$i,$j,$xArea,$Result["Item_Code"],$xPv,$xCusCode) > 0 )
																echo "  <td width='50px' align='center' style='color:#FF0000;border-right: 1px  solid black;'><strong>" . getQty( $conn,$i,$j,$xArea,$Result["Item_Code"],$xPv,$xCusCode) . "</strong></td>";
														else
																echo "  <td width='50px' align='center' style='border-right: 1px  solid black;'>&nbsp;</td>";
														
													}else{
														if( getQty( $conn,$i,$j,$xArea,$Result["Item_Code"],$xPv,$xCusCode) > 0 )
																echo "  <td width='50px' align='center' style='border-right: 1px  solid black;'><strong>". getQty( $conn,$i,$j,$xArea,$Result["Item_Code"],$xPv,$xCusCode) ."</strong></td>";
														else
																echo "  <td width='50px' align='center' style='border-right: 1px  solid black;'>&nbsp;</td>";
													}
											}
										echo "				</tr>";	
										echo "				<tr height='40px'>";
											for($j=1;$j<=12;$j++){
													if($gM == $j && $gY == $i ){
														if( getPrice( $conn,$i,$j,$xArea,$Result["Item_Code"],$xPv,$xCusCode) > 0 )
																echo "  <td width='50px' align='center' style='font-size:10px;color:#FF0000;border-right: 1px  solid black;'> ( ". number_format(getPrice( $conn,$i,$j,$xArea,$Result["Item_Code"],$xPv,$xCusCode),0,".",",") . " )</td>";
														else
																echo "  <td width='50px' align='center' style='border-right: 1px  solid black;'>&nbsp;</td>";
													}else{
														if( getPrice( $conn,$i,$j,$xArea,$Result["Item_Code"],$xPv,$xCusCode) > 0 )
																echo "  <td  width='50px' align='center' style='font-size:10px;border-right: 1px  solid black;'> (". 
																	number_format(getPrice( $conn,$i,$j,$xArea,$Result["Item_Code"],$xPv,$xCusCode),0,".",",") 
																." )</td>";
														else
																echo "  <td  width='50px' align='center' style='border-right: 1px  solid black;'>&nbsp;</td>";
													}

											}
										echo "				</tr>";
										echo "				</table>";	
										echo "    		</td>";
										echo "		</tr>";
									}
				echo "				</table>";		
				echo "</td>";
				echo "  		</tr>";
				echo "	</table>";
				echo "	</td>";
                echo "</tr>";
				$n++;
			}
?>
                </tbody>
              </table>

		</div>
                        
                </td>
              </tr>
</table>

	</div>
</body>
</html>