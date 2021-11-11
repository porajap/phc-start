<?php
session_start();
if($_SESSION["Area"] == "") header('location:index.html');
$chk = $_REQUEST["chk"];
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

	$xYear = $_SESSION["xYear07"];
	$xMonth = $_SESSION["xMonth07"];
	$EmCode = $_SESSION["Area"];
	$Area = $_SESSION["Area"];

	$gY = date("Y");
	$gM = date("m");
	$now = time();
	$today = date('Y-m-d', mktime(0, 0, 0, date("m", $now), date("d", $now), date("Y", $now)));
			$xWk = getWeeks($today,'sunday' );
			$dyaofweek[] = array();
			$YM = $xYear."-".$xMonth;
			$LDM = getLastDayOfMonth( $YM );
			for($i = 1;$i<=$LDM;$i++ ){
				$Week = getWeeks($xYear.'-'.$xMonth.'-'.$i ,'sunday');
				switch($Week){
					case 1:	$dyaofweek[$Week] .= $i . ",";
								break;
					case 2:	$dyaofweek[$Week] .= $i . ",";
								break;
					case 3:	$dyaofweek[$Week] .= $i . ",";
								break;
					case 4:	$dyaofweek[$Week] .= $i . ",";
								break;
					case 5:	$dyaofweek[$Week] .= $i . ",";
								break;
					case 6:	$dyaofweek[$Week] .= $i . ",";
								break;
				}
			}
		if($dyaofweek[1]==0){
			$dyaofweek[1]=$dyaofweek[2];
			$dyaofweek[2]=$dyaofweek[3];
			$dyaofweek[3]=$dyaofweek[4];
			$dyaofweek[4]=$dyaofweek[5];
			$dyaofweek[5]=$dyaofweek[6];
		}
		$nWeek=0;
		for($i=1;$i<=5;$i++)
			if( strlen(trim($dyaofweek[$i])) != 0) $nWeek++;
			
			
		$SqlX = "SELECT Code FROM area ORDER BY Code ASC";	
		$meQuery1 = mysqli_query($conn,$SqlX);
		$AreaCnt=0;
		while ($Result1 = mysqli_fetch_assoc($meQuery1))
		{	
			$xArea[$AreaCnt] = $Result1["Code"];
			$AreaCnt++;
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
	

	function getOutlet($conn,$dw,$xYr,$xMh,$xAr)
	{
		$SqlX= "SELECT customer.Cus_Code " .
					"FROM dallycall  " .
					"INNER JOIN item ON dallycall.ItemCode = item.Item_Code  " .
					"INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code  " .
					"WHERE dallycall.xDate BETWEEN '" . $xYr.'-'.$xMh.'-'.getFirstDayOfWeek($dw) . "' ".
					"AND '" . $xYr.'-'.$xMh.'-'.getLastDayOfWeek($dw) . "' " .
					"AND customer.AreaCode = '$xAr' " .
					"AND item.Grp_1 = 1 " .
					"GROUP BY customer.Cus_Code";
		$meQuery1 = mysqli_query($conn,$SqlX);
		$Cnt=0;
		while ($Result1 = mysqli_fetch_assoc($meQuery1))
		{	
			$Cnt ++;
		}
		//echo "<textarea  rows='10' cols='50' >$Cnt :::: $SqlX </textarea>";
		return $Cnt;
	}	
	function gtt($conn,$y,$m,$a,$e)
	{
		$SqlX = "SELECT Count(*) AS Cnt FROM report_summarize_area " . 
					"WHERE xYear = '$y' " .
					"AND xMonth = '$m' " .
					"AND Area_Code = '$a' " .
					"AND Em_Code = '$e'";	
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
	for($j=0;$j<$AreaCnt;$j++){
		for($i=1;$i<=6;$i++){
			
			if($dyaofweek[ $i ] != ""){
				$dow = explode(",", substr($dyaofweek[ $i ],0,strlen($dyaofweek[ $i ])-1));
				$Sql= "SELECT " .
						 "SUM(dallycall.Total3) AS Total " .
						 "FROM dallycall " .
						 "INNER JOIN item ON dallycall.ItemCode = item.Item_Code " .
						 "INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code " .
						 "WHERE dallycall.xDate BETWEEN '" . $xYear.'-'.$xMonth.'-'.getFirstDayOfWeek($dow) . "' " .
						 "AND '" . $xYear.'-'.$xMonth.'-'.getLastDayOfWeek($dow) . "' " .
						 "AND customer.AreaCode = '" . $xArea[$j] . "' " .
						 "AND item.Grp_1 = 1 " .
						 "GROUP BY customer.AreaCode";
	 
				//echo "<textarea  rows='10' cols='50' >" . $dyaofweek[ $i ] . " === $Sql</textarea>";	 

				$meQuery = mysqli_query($conn,$Sql);
				$n=0;
				while ($Result = mysqli_fetch_assoc($meQuery))
				{		
					$xTotal = number_format($Result["Total"], 2, '.', ',');
					$xOutlet = getOutlet($conn,$dow,$xYear,$xMonth,$xArea[$j]);
					$n++;	
					//echo "<textarea  rows='10' cols='50' >$xOutlet  %  $xTotal </textarea>";	 
				}
								//echo "<input type='text' value='getText($i,$xItemCode[$g],$EmCode)' />";
								if(gtt($conn,$xYear,$xMonth,$xArea[$j],$EmCode) == 0)	{
									$SqlX = "INSERT INTO report_summarize_area " .
													"(Area_Code,xYear,xMonth,M$i,B$i,Em_Code)" .
													" VALUES " .
													"('" . $xArea[$j] . "'," .
													"'" . $xYear . "'," .
													"'" .$xMonth . "'," .
													"'" . $xOutlet . "','". $xTotal .
													"','".$EmCode."')";
								}else{
									$SqlX = "UPDATE report_summarize_area SET M$i = '" . $xOutlet . "',B$i = '". $xTotal ."' " .
													"WHERE xYear = '" . $xYear . "' " .
													"AND xMonth = '" . $xMonth . "' " .
													"AND Area_Code = '" . $xArea[$j] . "' " .
													"AND Em_Code = '" . $EmCode . "'";
								}
								mysqli_query($conn,$SqlX);
								//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";	 
			}
			$xOutlet = "0";
			$xTotal = "0";
		}
	}
}	
			$SqlX = "SELECT report_summarize_area.Area_Code," .
						"report_summarize_area.M1,report_summarize_area.B1,".
						"report_summarize_area.M2,report_summarize_area.B2,".
						"report_summarize_area.M3,report_summarize_area.B3,".
						"report_summarize_area.M4,report_summarize_area.B4,".
						"report_summarize_area.M5,report_summarize_area.B5 ".
						"FROM report_summarize_area " . 
						"WHERE report_summarize_area.xYear = '$xYear' " . 
						"AND report_summarize_area.xMonth = '$xMonth' " .
						"AND report_summarize_area.Em_Code = '$EmCode'";
						
			//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";
			$ss = substr($today, 0,7);
			//echo "<textarea  rows='10' cols='50' > $ss ::: $xWk </textarea>";

			$meQuery = mysqli_query($conn,$SqlX);
			$n=0;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$AreaCode[$n] = $Result["Area_Code"];
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

				$xSumM[$n] = $xM1[$n] + $xM2[$n]  + $xM3[$n] + $xM4[$n] + $xM5[$n] ;
				$xSumB[$n] = str_replace(',', '',$xB1[$n]) +  str_replace(',', '',$xB2[$n])  +  str_replace(',', '',$xB3[$n]) +  str_replace(',', '',$xB4[$n]) +  str_replace(',', '',$xB5[$n]);
				
				$xSumB[$n] = Cut100( $xSumB[$n] );
				$n++;
			}	

?>

	<div class="topnav">
        <a href="Summarize.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : Daily call</div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>

	<table width="100%" border="0" cellspacing="5" cellpadding="5">
              <tr>
                <tr>
                    <td>
                        <div align="center"><?php echo $xMGP07N ?> : <?php echo $xGP07N ?> ประจำ <?php echo $xMonth ?>/<?php echo $xYear ?></div>
                    </td>
                </tr>              
                <td>

         <div>

			<table border="0" cellspacing="0" cellpadding="0">

                <thead>
                  <tr>
                  	<th style="background-image: url(img/Line02.png);" width="70px" rowspan="2">ลำดับ</th>
                    <th style="background-image: url(img/Line02.png);" width="250px" rowspan="2">รายการ</th>
                    <th style="background-image: url(img/Line02.png);" width="50px" rowspan="2">ปี</th>
                    <th style="background-image: url(img/Line02.png);" height="30px" align="center" colspan="13">สัปดาห์</th>
                  </tr>
                  <tr>
					<?php
				  		for($i=1;$i<=$nWeek;$i++){
                    		echo "<th style='background-image: url(img/Line04.png);' height='29px' width='100px' align='center' data-priority='$i'>$i</th>";
				  }
                    ?>
                    <th style="background-image: url(img/Line04.png);" width="110px" align="center" data-priority="<?php echo $i ?>">รวม</th>
                  </tr>                  
                </thead>
                <tbody>
               
 <?php 	
 			$rows=0;
			for($j=0;$j<$n;$j++){   
						echo "<th style='background-image: url(img/Line08.png);' height='60px' width='70px' rowspan='2'>". ($j+1) ."</th>";
						echo "<td style='background-image: url(img/Line08.png);font-size: small;color: #FF0000;' width='250px' rowspan='2'> <a href='SummarizeAreaBar.php?AC=$AreaCode[$j]' target='_blank'>B</a> <a href='SummarizeAreaLine.php?AC=$AreaCode[$j]' target='_blank'>L</a>  $AreaCode[$j] </td>";
						echo "<td style='background-image: url(img/Line08.png);' width='50px' rowspan='2' align='center'><a href='CyclicProduct-Area.php?ItemCode=$xItemCode[$j]&Year=$nYear[$j]'> $nYear[$j] </a> </td>";						

					    //echo "<textarea  rows='10' cols='50' >($gY == $nYear[$j]) &&  (intval($gM) == 1)</textarea>";
				  		//===== M1 =====
				  		if( strlen(trim($dyaofweek[1])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);color:#000000;' height='30px' width='100px' align='center'>$xM1[$j]</td>";
						//===== M2 =====	
						if( strlen(trim($dyaofweek[2])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);color:#000000;' width='100px' align='center'>$xM2[$j]</td>";
						//===== M3 =====	
						if( strlen(trim($dyaofweek[3])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);color:#000000;' width='100px' align='center'>$xM3[$j]</td>";
						//===== M4 =====	
						if( strlen(trim($dyaofweek[4])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);color:#000000;' width='100px' align='center'>$xM4[$j]</td>";	
						//===== M5 =====	
						if( strlen(trim($dyaofweek[5])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);color:#000000;' width='100px' align='center'>$xM5[$j]</td>";	
							
						echo "<td style='background-image: url(img/Line03.png);color:#000000;' width='100px' align='center'>$xSumM[$j]</td>";
					?>
                  </tr>
                  <tr>
                  <?php
				  		//===== B1 =====
				  		if( strlen(trim($dyaofweek[1])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' height='30px' width='100px' align='center'>( $xB1[$j] )</td>";
						//===== B2 =====	
						if( strlen(trim($dyaofweek[2])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB2[$j] )</td>";
						//===== B3 =====	
						if( strlen(trim($dyaofweek[3])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB3[$j] )</td>";
						//===== B4 =====	
						if( strlen(trim($dyaofweek[4])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB4[$j] )</td>";
						//===== B5 =====	
						if( strlen(trim($dyaofweek[5])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xB5[$j] )</td>";

						echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xSumB[$j] )</td>"; 
                    ?>
                    	
              </tr>
<?php } ?>
                </tbody>
              </table> 
		</div>
                        
                </td>
              </tr>
</table>

	<p>&nbsp;</p>

</body>
</html>