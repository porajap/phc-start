<?php
session_start();
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
	$xPv = $_SESSION["xPv"];
	$sYear = $_SESSION["sYear"];
	$eYear = $_SESSION["eYear"];

	$EmCode = $_SESSION["Area"];
	$xCusCode = $_SESSION["CusCode"];
	$xArea = $_SESSION["Area"];
	$gY = date("Y");
	$gM = date("m");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Login</title>
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
</head>

<style >
	table, th, td {
	   border: 1px solid black;
	} 
</style>

<body>

<?php
	function getText($y,$CC,$IC,$PV,$EM)
	{
		$SqlX = "SELECT Count(*) AS Cnt FROM report_circle " . 
					"WHERE xYear = '$y' " .
					"AND Cus_Code = '$CC' " .
					"AND Item_Code = '$IC' " .
					"AND Pv_Code LIKE '$PV%' " .
					"AND Em_Code = '$EM' ";		
		//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";
		$meQuery1 = mysqli_query($conn,$SqlX);
		$Cnt=0;
		while ($Result1 = mysqli_fetch_assoc($meQuery1))
		{	
			$Cnt = $Result1["Cnt"];
		}
		//echo "<textarea  rows='10' cols='50' >$Cnt : $SqlX </textarea>";
		return $Cnt;
	}

	function getRowCus($CC,$IC,$PV,$EM)
	{
		$SqlX = "SELECT Count(*) AS Cnt FROM report_circle " . 
					"WHERE Cus_Code = '$CC' " .
					"AND Pv_Code LIKE '$PV%' ";
					"AND Em_Code = '$EM' ";
					
		//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";
		$meQuery1 = mysqli_query($conn,$SqlX);
		$Cnt1=0;
		while ($Result1 = mysqli_fetch_assoc($meQuery1))
		{	
			$Cnt1 = $Result1["Cnt"];
		}
		//echo "<textarea  rows='10' cols='50' >$Cnt : $SqlX </textarea>";
		return $Cnt1;
	}
	
	//echo "<textarea  rows='10' cols='50' >$sYear : $eYear </textarea>";	 
	//$xCus_Code = $xCusCode;
	for($i=$sYear;$i<=$eYear;$i++){
		for($j=1;$j<=12;$j++){
			$Sql= "SELECT " .
					 "customer.Cus_Code,customer.FName,dallycall.xDate,dallycall.ItemCode AS Item_Code,item.NameTH," .
					 "dallycall.DocNo,prefix.Prefix_Name,SUM(dallycall.Qty) AS Qty,SUM(dallycall.Total3) AS Total," .
					 "th_amphur.Pv_Code " .
					 "FROM customer " .
					 "INNER JOIN dallycall ON dallycall.Cus_Code = customer.Cus_Code " .
					 "INNER JOIN prefix ON customer.Prefix_Code = prefix.Prefix_Code " .
					 "INNER JOIN item ON dallycall.ItemCode = item.Item_Code " .
					 "INNER JOIN th_tambon ON customer.tbCode = th_tambon.Tb_Code " .
					 "INNER JOIN th_amphur ON th_tambon.Ap_Code = th_amphur.Ap_Code " .
					 "WHERE dallycall.xDate LIKE '$i-" . createDigit2($j) . "%' ";
			if( strlen($xPv) > 0 )		$Sql .= "AND th_amphur.Pv_Code = '$xPv' ";
			$Sql .= "AND customer.Cus_Code = '$xCusCode' " .
					 "AND item.Grp_1 = 1 " .
					 "AND customer.AreaCode = '$xArea' " .
					 "GROUP BY customer.FName,dallycall.ItemCode";
					 
			//echo "<textarea  rows='10' cols='50' >$Sql </textarea>";	 
			
			$meQuery = mysqli_query($conn,$Sql);
			$n=0;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{		
				//$xCusCode[$n] = $Result["Cus_Code"];
				$xItemCode[$n] = $Result["Item_Code"];
				$xQty[$n] = $Result["Qty"];
				
				$xTT =  number_format($Result["Total"], 2, '.', ',') ;
				$xTotal[$n] =  substr ($xTT,0,strlen($xTT)-3);
				$n++;			
			}
			for($g=0;$g<$n;$g++){
							//echo "<input type='text' value='$i:$xCusCode:$xItemCode[$g]' />";
							if(getText($i,$xCusCode,$xItemCode[$g],$xPv,$EmCode) == 0)	{
								$SqlX = "INSERT INTO report_circle" .
												"(Cus_Code,Item_Code,xYear,M$j,B$j,Em_Code,Pv_Code)" .
												" VALUES " .
												"('" . $xCusCode . "'," .
												"'" . $xItemCode[$g] . "'," .
												"'" . $i . "'," .
												"'" . $xQty[$g] . "','". $xTotal[$g] .
												"','".$EmCode."','".$xPv."')";
							}else{
								$SqlX = "UPDATE report_circle SET M$j = '" . $xQty[$g] . "',B$j = '". $xTotal[$g] ."' " .
												"WHERE xYear = '" . $i . "' " .
												"AND Cus_Code = '" . $xCusCode . "' " .
												"AND Item_Code = '" . $xItemCode[$g] . "' " .
												"AND Pv_Code LIKE '" . $xPv . "%' " .
												"AND Em_Code = '" . $EmCode . "' ";
							}
							mysqli_query($conn,$SqlX);
							//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";	 		
			}
			for($g=0;$g<$n;$g++){
				//$xCusCode[$g] = "";
				$xItemCode[$g] = "";
				$xQty[$g] = "";
				$xTotal[$g] = "";
			}
		}
	}
	
			$SqlX = "SELECT " .
						"customer.FName,item.NameTH,report_circle.xYear,".
						"report_circle.M1,report_circle.B1,".
						"report_circle.M2,report_circle.B2,".
						"report_circle.M3,report_circle.B3,".
						"report_circle.M4,report_circle.B4,".
						"report_circle.M5,report_circle.B5,".
						"report_circle.M6,report_circle.B6,".
						"report_circle.M7,report_circle.B7,".
						"report_circle.M8,report_circle.B8,".
						"report_circle.M9,report_circle.B9,".
						"report_circle.M10,report_circle.B10,".
						"report_circle.M11,report_circle.B11,".
						"report_circle.M12,report_circle.B12 ".
						"FROM report_circle " . 
						"INNER JOIN customer ON report_circle.Cus_Code = customer.Cus_Code " .
						"INNER JOIN item ON report_circle.Item_Code = item.Item_Code ".
						"WHERE report_circle.xYear BETWEEN '$sYear' AND '$eYear' " .
						"AND report_circle.Em_Code = '$EmCode'" .
						"AND report_circle.Pv_Code LIKE '$xPv%' " .
						"AND customer.Cus_Code = '$xCusCode' " .
						"GROUP BY report_circle.Cus_Code,report_circle.Item_Code,report_circle.xYear ";
			//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";
			$meQuery = mysqli_query($conn,$SqlX);
			$n=0;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$CusName[$n] = $Result["FName"];
				$xItemName[$n] = $Result["NameTH"];
				$nYear[$n] = $Result["xYear"];
				$xM1[$n] = $Result["M1"];
				$xB1[$n] = $Result["B1"];
				$xM2[$n] = $Result["M2"];
				$xB2[$n] = $Result["B2"];
				$xM3[$n] = $Result["M3"];
				$xB3[$n] = $Result["B3"];
				$xM4[$n] = $Result["M4"];
				$xB4[$n] = $Result["B4"];
				$xM5[$n] = $Result["M5"];
				$xB5[$n] = $Result["B5"];
				$xM6[$n] = $Result["M6"];
				$xB6[$n] = $Result["B6"];
				$xM7[$n] = $Result["M7"];
				$xB7[$n] = $Result["B7"];
				$xM8[$n] = $Result["M8"];
				$xB8[$n] = $Result["B8"];
				$xM9[$n] = $Result["M9"];
				$xB9[$n] = $Result["B9"];
				$xM10[$n] = $Result["M10"];
				$xB10[$n] = $Result["B10"];
				$xM11[$n] = $Result["M11"];
				$xB11[$n] = $Result["B11"];
				$xM12[$n] = $Result["M12"];
				$xB12[$n] = $Result["B12"];	
				$n++;
			}	
?>

		<div data-demo-html="true">
			<div data-role="header">
                <a href="Date04.php" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-carat-l">กลับ</a>
            	<h1> <?php echo $Area ?> : คุณ<?php echo $xName ?></h1>
				<a href="logoff.php" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power">ออก</a>
			</div>
		</div>
	<table width="100%" border="0" cellspacing="5" cellpadding="5">
              <tr>
              			<td align="center"> <h2><?php echo $CusName[0]  ?></h2></td>
              </tr>
              
              <tr>
                <td>

         <div data-demo-html="true">

			<table border="0" cellspacing="0" cellpadding="0">

                <thead>
                  <tr>
                  	<th style="background-image: url(img/Line02.png);" width="70px" rowspan="2">ลำดับ</th>
                    <!-- th style="background-image: url(img/Line02.png);" width="130px" rowspan="2">ลูกค้า</th -->
                    <th style="background-image: url(img/Line02.png);" width="250px" rowspan="2">รายการ</th>
                    <th style="background-image: url(img/Line02.png);" width="50px" rowspan="2">ปี</th>
                    <th style="background-image: url(img/Line02.png);" height="30px" align="center" colspan="12">เดือน</th>
                  </tr>
                  <tr>
                    <th style="background-image: url(img/Line04.png);" height="29px" width="100px" align="center" data-priority="1">1</th>
                    <th style="background-image: url(img/Line04.png);" width="110px" align="center" data-priority="2">2</th>
                    <th style="background-image: url(img/Line04.png);" width="110px" align="center" data-priority="3">3</th>
                    <th style="background-image: url(img/Line04.png);" width="110px" align="center" data-priority="6">4</th>
                    <th style="background-image: url(img/Line04.png);" width="110px" align="center" data-priority="6">5</th>
					<th style="background-image: url(img/Line04.png);" width="110px" align="center" data-priority="6"> 6</th>
                    <th style="background-image: url(img/Line04.png);" width="110px" align="center" data-priority="6">7</th>
                    <th style="background-image: url(img/Line04.png);" width="110px" align="center" data-priority="6">8</th>
                    <th style="background-image: url(img/Line04.png);" width="110px" align="center" data-priority="6">9</th>
                    <th style="background-image: url(img/Line04.png);" width="110px" align="center" data-priority="6">10</th>
                    <th style="background-image: url(img/Line04.png);" width="110px" align="center" data-priority="6">11</th>
                    <th style="background-image: url(img/Line04.png);" width="110px" align="center" data-priority="6">12</th>
                  </tr>                  
                </thead>
                <tbody>
               
 <?php 	
 			$rows=0;
			for($j=0;$j<$n;$j++){   
			$k = $j % 2;
			 
				  	if($CusName[($j)] == $CusName[($j+1)]){ 
				 		echo "<tr style='background-image: url(img/Line06.png);'>";
						$rows++;
					}else{
						echo "<tr  style='background-image: url(img/Line02.png);'>";
						$rows=0;
					}
					
                    echo "<th height='60px' width='70px' rowspan='2'>". ($j+1) ."</th>";
					//if($rows==0) echo "<td  width='130px' rowspan='10'>$CusName[$j]</td>";
					//echo "<td  width='130px' rowspan='2'>$CusName[$j]</td>";
					if($xItemName[($j)] == $xItemName[($j+1)]){ 
						echo "<td width='250px' rowspan='2'  bgcolor='#99CCCC'>$xItemName[$j]</td>";
						echo "<td width='50px' rowspan='2' bgcolor='#99CCCC' align='center'>$nYear[$j]</td>";
					}else{
						echo "<td style='background-image: url(img/Line02.png);bgcolor=#99CCCC' width='250px' rowspan='2'>$xItemName[$j]</td>";
						echo "<td style='background-image: url(img/Line02.png);bgcolor=#99CCCC' width='50px' rowspan='2' align='center'>$nYear[$j]</td>";						
					}
				  		//===== M1 =====
				  		if( ($gY == $nYear[$j]) &&  (intval($gM) == 1) )
							echo "<td style='background-image: url(img/Line09.png);' height='30px' width='100px' align='center'>$xM1[$j]</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);' height='30px' width='100px' align='center'>$xM1[$j]</td>";
						//===== M2 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 2) )
							echo "<td style='background-image: url(img/Line09.png);' width='100px' align='center'>$xM2[$j]</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);' width='100px' align='center'>$xM2[$j]</td>";
						//===== M3 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 3) )
							echo "<td style='background-image: url(img/Line09.png);' width='100px' align='center'>$xM3[$j]</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);' width='100px' align='center'>$xM3[$j]</td>";
						//===== M4 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 4) )
							echo "<td style='background-image: url(img/Line09.png);' width='100px' align='center'>$xM4[$j]</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);' width='100px' align='center'>$xM4[$j]</td>";	
						//===== M5 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 5) )
							echo "<td style='background-image: url(img/Line09.png);' width='100px' align='center'>$xM5[$j]</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);' width='100px' align='center'>$xM5[$j]</td>";		
						//===== M6 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 6) )
							echo "<td style='background-image: url(img/Line09.png);' width='100px' align='center'>$xM6[$j]</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);' width='100px' align='center'>$xM6[$j]</td>";		
						//===== M7 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 7) )
							echo "<td style='background-image: url(img/Line09.png);' width='100px' align='center'>$xM7[$j]</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);' width='100px' align='center'>$xM7[$j]</td>";	
						//===== M8 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 8) )
							echo "<td style='background-image: url(img/Line09.png);' width='100px' align='center'>$xM8[$j]</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);' align='center'>$xM8[$j]</td>";		
						//===== M9 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 9) )
							echo "<td style='background-image: url(img/Line09.png);' width='100px' align='center'>$xM9[$j]</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);' width='100px' align='center'>$xM9[$j]</td>";	
						//===== M10 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 10) )
							echo "<td style='background-image: url(img/Line09.png);' width='100px' align='center'>$xM10[$j]</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);' width='100px' align='center'>$xM10[$j]</td>";		
						//===== M11 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 11) )
							echo "<td style='background-image: url(img/Line09.png);' width='100px' align='center'>$xM11[$j]</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);' width='100px' align='center'>$xM11[$j]</td>";	
						//===== M12 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 12) )
							echo "<td style='background-image: url(img/Line09.png);' width='100px' align='center'>$xM12[$j]</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);' width='100px' align='center'>$xM12[$j]</td>";
					?>
                  </tr>
                  <tr>
                  <?php
				  		//===== M1 =====
				  		if( ($gY == $nYear[$j]) &&  (intval($gM) == 1) )
							echo "<td style='background-image: url(img/Line09.png);font-size: small;' height='30px' width='100px' align='center'>( $xB1[$j] )</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);font-size: small;' height='30px' align='center'>( $xB1[$j] )</td>";
						//===== M2 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 2) )
							echo "<td style='background-image: url(img/Line09.png);font-size: small;' width='100px' align='center'>( $xB2[$j] )</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);font-size: small;' align='center'>( $xB2[$j] )</td>";
						//===== M3 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 3) )
							echo "<td style='background-image: url(img/Line09.png);font-size: small;' width='100px' align='center'>( $xB3[$j] )</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);font-size: small;' width='100px' align='center'>( $xB3[$j] )</td>";
						//===== M4 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 4) )
							echo "<td style='background-image: url(img/Line09.png);font-size: small;' width='100px' align='center'>( $xB4[$j] )</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);font-size: small;' width='100px' align='center'>( $xB4[$j] )</td>";	
						//===== M5 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 5) )
							echo "<td style='background-image: url(img/Line09.png);font-size: small;' width='100px' align='center'>( $xB5[$j] )</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);font-size: small;' width='100px' align='center'>( $xB5[$j] )</td>";		
						//===== M6 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 6) )
							echo "<td style='background-image: url(img/Line09.png);font-size: small;' width='100px' align='center'>( $xB6[$j] )</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);font-size: small;' width='100px' align='center'>( $xB6[$j] )</td>";		
						//===== M7 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 7) )
							echo "<td style='background-image: url(img/Line09.png);font-size: small;' width='100px' align='center'>( $xB7[$j] )</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);font-size: small;' align='center'>( $xB7[$j] )</td>";	
						//===== M8 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 8) )
							echo "<td style='background-image: url(img/Line09.png);font-size: small;' width='100px' align='center'>( $xB8[$j] )</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);font-size: small;' align='center'>( $xB8[$j] )</td>";		
						//===== M9 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 9) )
							echo "<td style='background-image: url(img/Line09.png);font-size: small;' width='100px' align='center'>( $xB9[$j] )</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);font-size: small;' align='center'>( $xB9[$j] )</td>";	
						//===== M10 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 10) )
							echo "<td style='background-image: url(img/Line09.png);font-size: small;' width='100px' align='center'>( $xB10[$j] )</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);font-size: small;' width='100px' align='center'>( $xB10[$j] )</td>";		
						//===== M11 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 11) )
							echo "<td style='background-image: url(img/Line09.png);font-size: small;' width='100px' align='center'>( $xB11[$j] )</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);font-size: small;' width='100px' align='center'>( $xB11[$j] )</td>";	
						//===== M12 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 12) )
							echo "<td style='background-image: url(img/Line09.png);font-size: small;' width='100px' align='center'>( $xB12[$j] )</td>";
						else
							echo "<td style='background-image: url(img/LineX$k.png);font-size: small;' width='100px' align='center'>( $xB12[$j] )</td>";
                    ?>
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