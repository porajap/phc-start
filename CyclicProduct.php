<?php
session_start();
if($_SESSION["Area"] == "") header('location:index.html');
$chk = $_REQUEST["chk"];
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
	$xGP = $_SESSION["xGP"];
	$sYear = $_SESSION["sYear"];
	$eYear = $_SESSION["eYear"];
	$EmCode = $_SESSION["Area"];
	$Area = $_SESSION["Area"];
	$gY = date("Y");
	$gM = date("m");
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
	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
	<script src="assets/dist/js/sweetalert2.min.js"></script>
    <style>
		.xBoxWh{
			width: 150px;
		}

        .xTop1{
            margin-top: 7px;
            margin-left: 3px;
            margin-right: 3px;
        }

        .xTop2{
            margin : 2px;
			padding: 5px;
        }

        .xTb{
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
            margin-bottom: 7px;
        }

        .label1{
            margin-left: 10px;
            margin-top: 7px;
        }

        .label2{
            margin-left: 10px;
            margin-top: 7px;
            margin-bottom: 7px;
        }

		table, th, td {
			border: 1px solid black;
		} 
    </style>
</head>

<body>

<?php


	function getRowCus($conn,$CC,$IC,$PV,$EM)
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
		function Rff($conn,$y,$IC,$EM){
			$SqlX = "SELECT Count(*) AS Cnt FROM report_circle " . 
						"WHERE xYear = '$y' " .
						"AND Em_Code = '$EM' " .
						"AND Item_Code = '$IC' ";	
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


if($chk != 1){	
	for($i=$sYear;$i<=$eYear;$i++){
		for($j=1;$j<=12;$j++){
			$Sql= "SELECT " .
					 "dallycall.xDate,dallycall.ItemCode AS Item_Code,item.NameTH," .
					 "dallycall.DocNo,SUM(dallycall.Qty) AS Qty,SUM(dallycall.Total3) AS Total " .
					 "FROM dallycall " .
					 "INNER JOIN item ON dallycall.ItemCode = item.Item_Code " .
					 "INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code " .
					 "WHERE dallycall.xDate LIKE '$i-" . createDigit2($j) . "%' " .
					 "AND item.CategorySub_Code LIKE '$xGP%' " .
					 "AND item.Grp_1 = 1 " .
					 "GROUP BY dallycall.ItemCode";
					 
			//echo "<textarea  rows='10' cols='50' >$Sql</textarea>";	 
			
			$meQuery = mysqli_query($conn,$Sql);
			$n=0;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{		
				$xCusCode[$n] = $Result["Cus_Code"];
				$xItemCode[$n] = $Result["Item_Code"];
				$xQty[$n] = $Result["Qty"];
				if($xQty[$n] == Null ) $xQty[$n] = "0";
				$xTotal[$n] = number_format($Result["Total"], 2, '.', ',');
				$n++;			
			}
			for($g=0;$g<$n;$g++){
				

							$tt = Rff($conn,$i,$xItemCode[$g],$EmCode);
							if($tt == 0)	{
								$SqlX = "INSERT INTO report_circle" .
												"(Cus_Code,Item_Code,xYear,M$j,B$j,Em_Code,Pv_Code)" .
												" VALUES " .
												"('" . $xCusCode[$g] . "'," .
												"'" . $xItemCode[$g] . "'," .
												"'" . $i . "'," .
												"'" . $xQty[$g] . "','". $xTotal[$g] .
												"','".$EmCode."','".$xPv."')";
							}else{
								$SqlX = "UPDATE report_circle SET M$j = '" . $xQty[$g] . "',B$j = '". $xTotal[$g] ."' " .
												"WHERE xYear = '" . $i . "' " .
												"AND Item_Code = '" . $xItemCode[$g] . "' " .
												"AND Em_Code = '" . $EmCode . "' ";
							}
							mysqli_query($conn,$SqlX);
							//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";	 		
			}
			for($g=0;$g<$n;$g++){
				$xCusCode[$g] = "";
				$xItemCode[$g] = "";
				$xQty[$g] = "";
				$xTotal[$g] = "";
			}
		}
	}
}	
			$SqlX = "SELECT " .
						"item.Item_Code,item.NameTH,report_circle.xYear,".
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
						"INNER JOIN item ON report_circle.Item_Code = item.Item_Code ".
						"WHERE report_circle.xYear BETWEEN '$sYear' AND '$eYear' " .
						"AND item.CategorySub_Code LIKE '$xGP%' " .
						"AND report_circle.Em_Code = '" . $EmCode . "' " .
						"GROUP BY report_circle.Item_Code,report_circle.xYear ";
			//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";
			$meQuery = mysqli_query($conn,$SqlX);
			$n=0;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$xItemCode[$n] = $Result["Item_Code"];
				$xItemName[$n] = $Result["NameTH"];
				$nYear[$n] = $Result["xYear"];
				$xM1[$n] = $Result["M1"];
				$xB1[$n] = substr($Result["B1"],0,strlen($Result["B1"])-3);
				$xM2[$n] = $Result["M2"];
				$xB2[$n] = substr($Result["B2"],0,strlen($Result["B2"])-3);
				$xM3[$n] = $Result["M3"];
				$xB3[$n] = substr($Result["B3"],0,strlen($Result["B3"])-3);
				$xM4[$n] = $Result["M4"];
				$xB4[$n] = substr($Result["B4"],0,strlen($Result["B4"])-3);
				$xM5[$n] = $Result["M5"];
				$xB5[$n] = substr($Result["B5"],0,strlen($Result["B5"])-3);
				$xM6[$n] = $Result["M6"];
				$xB6[$n] = substr($Result["B6"],0,strlen($Result["B6"])-3);
				$xM7[$n] = $Result["M7"];
				$xB7[$n] = substr($Result["B7"],0,strlen($Result["B7"])-3);
				$xM8[$n] = $Result["M8"];
				$xB8[$n] = substr($Result["B8"],0,strlen($Result["B8"])-3);
				$xM9[$n] = $Result["M9"];
				$xB9[$n] = substr($Result["B9"],0,strlen($Result["B9"])-3);
				$xM10[$n] = $Result["M10"];
				$xB10[$n] = substr($Result["B10"],0,strlen($Result["B10"])-3);
				$xM11[$n] = $Result["M11"];
				$xB11[$n] = substr($Result["B11"],0,strlen($Result["B11"])-3);
				$xM12[$n] = $Result["M12"];
				$xB12[$n] = substr($Result["B12"],0,strlen($Result["B12"])-3);

				$xSumM[$n] = $xM1[$n] + $xM2[$n]  + $xM3[$n] + $xM4[$n] + $xM5[$n] + $xM6[$n] + $xM7[$n] + $xM8[$n] + $xM9[$n] + $xM10[$n] + $xM11[$n] + $xM12[$n];
				$xSumB[$n] = str_replace(',', '',$xB1[$n]) +  str_replace(',', '',$xB2[$n])  +  str_replace(',', '',$xB3[$n]) +  str_replace(',', '',$xB4[$n]) +  str_replace(',', '',$xB5[$n]) +  str_replace(',', '',$xB6[$n]) + str_replace(',', '',$xB7[$n]) +  str_replace(',', '',$xB8[$n]) +  str_replace(',', '',$xB9[$n]) +  str_replace(',', '',$xB10[$n]) +  str_replace(',', '',$xB11[$n]) +  str_replace(',', '',$xB12[$n]);
				
				$xSumB[$n] = Cut100( $xSumB[$n] );
				$n++;
			}	
?>
	<div class="topnav">
        <a href="SelSub.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?php echo $Area ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>

	<div class="overflow-auto">
		<table width="100%" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <td>

         <div class="overflow-auto">

			<table border="0" cellspacing="0" cellpadding="0">

                <thead>
                  <tr>
                  	<th style="background-image: url(img/Line02.png);" width="70px" rowspan="2">ลำดับ</th>
                    <th style="background-image: url(img/Line02.png);" width="250px" rowspan="2">รายการ</th>
                    <th style="background-image: url(img/Line02.png);" width="50px" rowspan="2">ปี</th>
                    <th style="background-image: url(img/Line02.png);" height="30px" align="center" colspan="13">เดือน</th>
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
                    <th style="background-image: url(img/Line04.png);" width="110px" align="center" data-priority="6">รวม</th>
                  </tr>                  
                </thead>
                <tbody>
               
 <?php 	
 			$rows=0;
			for($j=0;$j<$n;$j++){   
			
			             
               
						
					
					if($xItemName[($j)] == $xItemName[($j+1)]){ 
						echo "<th height='60px' width='70px' rowspan='2'>". ($j+1) ."</th>";
						echo "<td style='font-size: xx-small;color: #FF0000;' width='250px' rowspan='2'></td>";
						echo "<td width='50px' rowspan='2' align='center'><a href='CyclicProduct-Area.php?ItemCode=$xItemCode[$j]&Year=$nYear[$j]'> $nYear[$j] </a></td>";
					}else{
						echo "<th style='background-image: url(img/Line08.png);' height='60px' width='70px' rowspan='2'>". ($j+1) ."</th>";
						echo "<td style='background-image: url(img/Line08.png);font-size: xx-small;color: #FF0000;' width='250px' rowspan='2'> <a href='grapBar.php?ItemCode=$xItemCode[$j]&Year=$nYear[$j]' target='_blank'>B</a> <a href='graph.php?ItemCode=$xItemCode[$j]&Year=$nYear[$j]' target='_blank'>L</a>  $xItemName[$j] </td>";
						echo "<td style='background-image: url(img/Line08.png);' width='50px' rowspan='2' align='center'><a href='CyclicProduct-Area.php?ItemCode=$xItemCode[$j]&Year=$nYear[$j]'> $nYear[$j] </a> </td>";						
					}
					    //echo "<textarea  rows='10' cols='50' >($gY == $nYear[$j]) &&  (intval($gM) == 1)</textarea>";
				  		//===== M1 =====
				  		if( ($gY == $nYear[$j]) &&  (intval($gM) == 1) )
							echo "<td style='background-image: url(img/Line03.png);color:#FF0000;' height='30px' width='100px' align='center'>$xM1[$j]</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);' height='30px' width='100px' align='center'>$xM1[$j]</td>";
						//===== M2 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 2) )
							echo "<td style='background-image: url(img/Line03.png);color:#FF0000;' width='100px' align='center'>$xM2[$j]</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);' width='100px' align='center'>$xM2[$j]</td>";
						//===== M3 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 3) )
							echo "<td style='background-image: url(img/Line03.png);color:#FF0000;' width='100px' align='center'>$xM3[$j]</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);' width='100px' align='center'>$xM3[$j]</td>";
						//===== M4 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 4) )
							echo "<td style='background-image: url(img/Line03.png);color:#FF0000;' width='100px' align='center'>$xM4[$j]</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);' width='100px' align='center'>$xM4[$j]</td>";	
						//===== M5 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 5) )
							echo "<td style='background-image: url(img/Line03.png);color:#FF0000;' width='100px' align='center'>$xM5[$j]</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);' width='100px' align='center'>$xM5[$j]</td>";		
						//===== M6 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 6) )
							echo "<td style='background-image: url(img/Line03.png);color:#FF0000;' width='100px' align='center'>$xM6[$j]</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);' width='100px' align='center'>$xM6[$j]</td>";		
						//===== M7 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 7) )
							echo "<td style='background-image: url(img/Line03.png);color:#FF0000;' width='100px' align='center'>$xM7[$j]</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);' width='100px' align='center'>$xM7[$j]</td>";	
						//===== M8 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 8) )
							echo "<td style='background-image: url(img/Line03.png);color:#FF0000;' width='100px' align='center'>$xM8[$j]</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);' align='center'>$xM8[$j]</td>";		
						//===== M9 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 9) )
							echo "<td style='background-image: url(img/Line03.png);color:#FF0000;' width='100px' align='center'>$xM9[$j]</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);' width='100px' align='center'>$xM9[$j]</td>";	
						//===== M10 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 10) )
							echo "<td style='background-image: url(img/Line03.png);color:#FF0000;' width='100px' align='center'>$xM10[$j]</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);' width='100px' align='center'>$xM10[$j]</td>";		
						//===== M11 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 11) )
							echo "<td style='background-image: url(img/Line03.png);color:#FF0000;' width='100px' align='center'>$xM11[$j]</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);' width='100px' align='center'>$xM11[$j]</td>";	
						//===== M12 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 12) )
							echo "<td style='background-image: url(img/Line03.png);color:#FF0000;' width='100px' align='center'>$xM12[$j]</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);' width='100px' align='center'>$xM12[$j]</td>";
							
						echo "<td style='background-image: url(img/Line03.png);color:#FF0000;' width='100px' align='center'>$xSumM[$j]</td>";
					?>
                  </tr>
                  <tr>
                  <?php
				  		//===== B1 =====
				  		if( ($gY == $nYear[$j]) &&  (intval($gM) == 1) )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' height='30px' width='100px' align='center'>( $xB1[$j] )</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;background-color:#A9BCF5' height='30px' align='center'>( $xB1[$j] )</td>";
						//===== B2 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 2) )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB2[$j] )</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;background-color:#A9BCF5' align='center'>( $xB2[$j] )</td>";
						//===== B3 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 3) )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB3[$j] )</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;background-color:#A9BCF5' width='100px' align='center'>( $xB3[$j] )</td>";
						//===== B4 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 4) )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB4[$j] )</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;background-color:#A9BCF5' width='100px' align='center'>( $xB4[$j] )</td>";	
						//===== B5 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 5) )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB5[$j] )</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;background-color:#A9BCF5' width='100px' align='center'>( $xB5[$j] )</td>";		
						//===== B6 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 6) )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-smallcolor: #FF0000;;background-color:#A9BCF5' width='100px' align='center'>( $xB6[$j] )</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;;background-color:#A9BCF5' width='100px' align='center'>( $xB6[$j] )</td>";		
						//===== B7 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 7) )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB7[$j] )</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;background-color:#A9BCF5' align='center'>( $xB7[$j] )</td>";	
						//===== B8 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 8) )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB8[$j] )</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;background-color:#A9BCF5' align='center'>( $xB8[$j] )</td>";		
						//===== B9 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 9) )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB9[$j] )</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;background-color:#A9BCF5' align='center'>( $xB9[$j] )</td>";	
						//===== B10 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 10) )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB10[$j] )</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;background-color:#A9BCF5' width='100px' align='center'>( $xB10[$j] )</td>";		
						//===== B11 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 11) )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB11[$j] )</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;background-color:#A9BCF5' width='100px' align='center'>( $xB11[$j] )</td>";	
						//===== B12 =====	
						if( ($gY == $nYear[$j]) &&  (intval($gM) == 12) )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB12[$j] )</td>";
						else
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;background-color:#A9BCF5' width='100px' align='center'>( $xB12[$j] )</td>";
							
						echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xSumB[$j] )</td>"; //
                    ?>
                    	
              </tr>
<?php } ?>
                </tbody>
              </table> 
		</div>
                        
                </td>
              </tr>
</table>
</div>
</body>
</html>