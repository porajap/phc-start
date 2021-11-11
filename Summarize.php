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

	function gtt($conn,$y,$m,$e)
	{
		$SqlX = "SELECT Count(*) AS Cnt FROM report_summarize " . 
					"WHERE xYear = '$y' " .
					"AND xMonth = '$m' " .
					"AND Em_Code = '$e'";	
		$meQuery1 = mysqli_query($conn,$SqlX);
		$Cnt=0;
		while ($Result1 = mysqli_fetch_assoc($meQuery1))
		{	
			$Cnt = $Result1["Cnt"];
		}
		//echo "<textarea  rows='10' cols='50' >$Cnt : $SqlX </textarea>";
		return $Cnt;
	}

	function getOutlet($conn,$dw,$xYr,$xMh)
	{
		$SqlX= "SELECT customer.Cus_Code " .
					"FROM dallycall  " .
					"INNER JOIN item ON dallycall.ItemCode = item.Item_Code  " .
					"INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code  " .
					"WHERE dallycall.xDate BETWEEN '" . $xYr.'-'.$xMh.'-'.getFirstDayOfWeek($dw) . "' ".
					"AND '" . $xYr.'-'.$xMh.'-'.getLastDayOfWeek($dw) . "' " .
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
	
if($chk != 1){	

		for($i=1;$i<=6;$i++){
			if($dyaofweek[ $i ] != ""){
				$dow = explode(",", substr($dyaofweek[ $i ],0,strlen($dyaofweek[ $i ])-1));
				$Sql= "SELECT " .
						 "SUM(dallycall.Total3) AS Total " .
						 "FROM dallycall " .
						 "INNER JOIN item ON dallycall.ItemCode = item.Item_Code " .
						 "INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code " .
						 "WHERE dallycall.xDate BETWEEN '" . $xYear.'-'.$xMonth.'-'.getFirstDayOfWeek($dow) . "' " .
						 "AND '" . $xYear.'-'.$xMonth.'-'.getLastDayOfWeek($dow) . "'" .
						 "AND item.Grp_1 = 1 ";
				//echo "<textarea  rows='10' cols='50' > $Sql </textarea>";
				$meQuery = mysqli_query($conn,$Sql);
				$n=0;
				while ($Result = mysqli_fetch_assoc($meQuery))
				{		
					$xTotal = number_format($Result["Total"], 2, '.', ',');
					$xOutlet = getOutlet($conn,$dow,$xYear,$xMonth);
					$n++;	
					//echo "<textarea  rows='10' cols='50' >$xOutlet  %  $xTotal </textarea>";	 
				}
								//echo "<input type='text' value='getText($i,$xItemCode[$g],$EmCode)' />";
								if(gtt($conn,$xYear,$xMonth,$EmCode) == 0)	{
									$SqlX = "INSERT INTO report_summarize " .
													"(xYear,xMonth,M$i,B$i,Em_Code)" .
													" VALUES " .
													"('" . $xYear . "'," .
													"'" .$xMonth . "'," .
													"'" . $xOutlet . "','". $xTotal .
													"','".$EmCode."')";
								}else{
									$SqlX = "UPDATE report_summarize SET M$i = '" . $xOutlet . "',B$i = '". $xTotal ."' " .
													"WHERE xYear = '" . $xYear . "' " .
													"AND xMonth = '" . $xMonth . "' " .
													"AND Em_Code = '" . $EmCode . "'";
								}
								mysqli_query($conn,$SqlX);
								//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";	 
			}
			$xOutlet = "0";
			$xTotal = "0";
		}

}	
			$SqlX = "SELECT " .
						"report_summarize.M1,report_summarize.B1,".
						"report_summarize.M2,report_summarize.B2,".
						"report_summarize.M3,report_summarize.B3,".
						"report_summarize.M4,report_summarize.B4,".
						"report_summarize.M5,report_summarize.B5 ".
						"FROM report_summarize " . 
						"WHERE report_summarize.xYear = '$xYear' " . 
						"AND report_summarize.xMonth = '$xMonth' " .
						"AND report_summarize.Em_Code = '$EmCode'";
			//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";
			$ss = substr($today, 0,7);
			//echo "<textarea  rows='10' cols='50' > :::: $xGP07N ::: </textarea>";

			$meQuery = mysqli_query($conn,$SqlX);
			$n=0;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{

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

				$xSumM1 += $xM1[$n];
				$xSumM2 += $xM2[$n];
				$xSumM3 += $xM3[$n];
				$xSumM4 += $xM4[$n];
				$xSumM5 += $xM5[$n];
				$xSumM6 += $xM6[$n];
				
				$xSB1 = str_replace(',', '',$xB1[$n]);
				$xSumB1 += $xSB1;
				$xSB2 = str_replace(',', '',$xB2[$n]);
				$xSumB2 += $xSB2;
				$xSB3 = str_replace(',', '',$xB3[$n]);
				$xSumB3 += $xSB3;
				$xSB4 = str_replace(',', '',$xB4[$n]);
				$xSumB4 += $xSB4;
				$xSB5 = str_replace(',', '',$xB5[$n]);
				$xSumB5 += $xSB5;
				$xSB6 = str_replace(',', '',$xB6[$n]);
				$xSumB6 += $xSB6;

				$n++;
			}	
			
			$xSumM = $xSumM1 + $xSumM2 + $xSumM3 + $xSumM4 + $xSumM5 + $xSumM6;
			
			$xSumB = $xSumB1 + $xSumB2 + $xSumB3 + $xSumB4 + $xSumB5 + $xSumB6;
			
			$xSumB1 = Cut100( $xSumB1 );
			$xSumB2 = Cut100( $xSumB2 );
			$xSumB3 = Cut100( $xSumB3 );
			$xSumB4 = Cut100( $xSumB4 );
			$xSumB5 = Cut100( $xSumB5 );
			$xSumB6 = Cut100( $xSumB6 );
			
			$xSumB = Cut100( $xSumB );
?>
	<div class="topnav">
        <a href="Date07.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : Daily call</div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>

<div align="center" >      
	<table width="100%" border="0" cellspacing="5" cellpadding="5">
                <tr>
                    <td>
                        <div align="center"><?php echo $xMGP07N ?> : <?php echo $xGP07N ?> ประจำ <?php echo $xMonth ?>/<?php echo $xYear ?></div>
                    </td>
                </tr>
              <tr>
                <td>
			<table border="0" cellspacing="0" cellpadding="0">

                <thead>
                  <tr>
                  	<th style="background-image: url(img/Line02.png);" width="70px" rowspan="2">ลำดับ</th>
                    <th style="background-image: url(img/Line02.png);" width="250px" rowspan="2">รายการ</th>
                    <th style="background-image: url(img/Line02.png);" width="50px" rowspan="2"></th>
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
			//for($j=0;$j<$n;$j++){   
						echo "<th style='background-image: url(img/Line08.png);' height='60px' width='70px' rowspan='2'>". ($j+1) ."</th>";
						echo "<td style='background-image: url(img/Line08.png);font-size: small;color: #FF0000;' width='250px' rowspan='2'> <a href='SummarizeBar.php' target='_blank'>B</a> <a href='SummarizeLine.php' target='_blank'>L</a>   <a href='SummarizeArea.php?ItemCode=$xItemCode[$j]&Year=$nYear[$j]'> รายละเอียดเขต </a> </td>";
						echo "<td style='background-image: url(img/Line08.png);' width='50px' rowspan='2' align='center'> </td>";						

					    //echo "<textarea  rows='10' cols='50' >($gY == $nYear[$j]) &&  (intval($gM) == 1)</textarea>";
				  		//===== M1 =====
				  		if( strlen(trim($dyaofweek[1])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);color:#000000;' height='30px' width='100px' align='center'>$xSumM1</td>";

						//===== M2 =====	
						if( strlen(trim($dyaofweek[2])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);color:#000000;' width='100px' align='center'>$xSumM2</td>";
						//===== M3 =====	
						if( strlen(trim($dyaofweek[3])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);color:#000000;' width='100px' align='center'>$xSumM3</td>";
						//===== M4 =====	
						if( strlen(trim($dyaofweek[4])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);color:#000000;' width='100px' align='center'>$xSumM4</td>";
						//===== M5 =====	
						if( strlen(trim($dyaofweek[5])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);color:#000000;' width='100px' align='center'>$xSumM5</td>";	
							
						echo "<td style='background-image: url(img/Line03.png);color:#000000;' width='100px' align='center'>$xSumM</td>";
					?>
                  </tr>
                  <tr>
                  <?php
				  		//===== B1 =====
				  		if( strlen(trim($dyaofweek[1])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' height='30px' width='100px' align='center'>( $xSumB1 )</td>";
						//===== B2 =====	
						if( strlen(trim($dyaofweek[2])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xSumB2 )</td>";
						//===== B3 =====	
						if( strlen(trim($dyaofweek[3])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xSumB3 )</td>";
						//===== B4 =====	
						if( strlen(trim($dyaofweek[4])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xSumB4 )</td>";	
						//===== B5 =====	
						if( strlen(trim($dyaofweek[5])) != 0 )
							echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xSumB5 )</td>";

						echo "<td style='background-image: url(img/Line03.png);font-size: xx-small;color: #FF0000;background-color:#A9BCF5' width='100px' align='center'>( $xSumB )</td>"; 
                    ?>
                    	
              </tr>
<?php //}*/ ?>
                </tbody>
              </table> 

                        
                </td>
              </tr>
</table>
</div>

</body>
</html>