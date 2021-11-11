<?php
session_start();
if($_SESSION["Area"] == "") header('location:index.html');
$chk = $_REQUEST["chk"];
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

	$xGP = $_SESSION["xGP07S"];
	$xYear = $_SESSION["xYear07"];
	$xMonth = $_SESSION["xMonth07"];
	$EmCode = $_SESSION["Area"];
	$xGP07N = $_SESSION["xGP07N"];
	$xMGP07N = $_SESSION["xMGP07N"];
	
	$graph = new Graph(800, 600, 'auto', 10, true);   
	$graph->SetScale('textlin');   
	$xdata = array( 0, 1, 2, 3, 4, 5); 
	$mBC = array( 'blue','bluegreen','brown','cyan', 'darkgray','greengray','gray','green', 'greenblue','lightblue','lightred', 'purple','red','white','yellow','blue','bluegreen','brown','cyan', 'darkgray','greengray','gray','green', 'greenblue','lightblue','lightred', 'purple','red','white','yellow'); 
	
	$gY = date("Y");
	$gM = date("m");
	$now = time();
	$today = date('Y-m-d', mktime(0, 0, 0, date("m", $now), date("d", $now), date("Y", $now)));
	
		$SqlX = "SELECT Code FROM area ORDER BY Code ASC";	
		$meQuery1 = mysqli_query($conn,$SqlX);
		$AreaCnt=0;
		while ($Result1 = mysqli_fetch_assoc($meQuery1))
		{	
			$xArea[$AreaCnt] = $Result1["Code"];
			$AreaCnt++;
		}
		
			$xWk = getWeeks($today,'sunday' );
			$dyaofweek[] = array();
			for($i = 1;$i<=getLastDayOfMonth( '$xYear-$xMonth' );$i++ ){
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
			
		$SqlX = "SELECT Code FROM area ORDER BY Code ASC";	
		$meQuery1 = mysqli_query($conn,$SqlX);
		$AreaCnt=0;
		while ($Result1 = mysqli_fetch_assoc($meQuery1))
		{	
			$pArea[$AreaCnt] = $Result1["Code"];
			$AreaCnt++;
		}			

	function getText($y,$m,$a,$e)
	{
		$SqlX = "SELECT Count(*) AS Cnt FROM report_summarize " . 
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

	function getRowCus($CC,$IC,$PV,$EM)
	{
		$SqlX = "SELECT Count(*) AS Cnt FROM report_summarize " . 
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
	
	function getOutlet($dw,$xYr,$xMh,$xGP,$xAr)
	{
		$SqlX= "SELECT customer.Cus_Code " .
					"FROM dallycall  " .
					"INNER JOIN item ON dallycall.ItemCode = item.Item_Code  " .
					"INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code  " .
					"WHERE dallycall.xDate BETWEEN '" . $xYr.'-'.$xMh.'-'.getFirstDayOfWeek($dw) . "' ".
					"AND '" . $xYr.'-'.$xMh.'-'.getLastDayOfWeek($dw) . "' " .
					" AND item.CategorySub_Code LIKE '$xGP%' " .
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
						 "AND item.CategorySub_Code LIKE '$xGP%' " . 
						 "AND customer.AreaCode = '" . $xArea[$j] . "' " .
						 "AND item.Grp_1 = 1 " .
						 "GROUP BY customer.AreaCode";
	 
				//echo "<textarea  rows='10' cols='50' >" . $dyaofweek[ $i ] . " === $Sql</textarea>";	 

				$meQuery = mysqli_query($conn,$Sql);
				$n=0;
				while ($Result = mysqli_fetch_assoc($meQuery))
				{		
					$xTotal = number_format($Result["Total"], 2, '.', ',');
					$xOutlet = getOutlet($dow,$xYear,$xMonth,$xGP,$xArea[$j]);
					$n++;	
					//echo "<textarea  rows='10' cols='50' >$xOutlet  %  $xTotal </textarea>";	 
				}
								//echo "<input type='text' value='getText($i,$xItemCode[$g],$EmCode)' />";
								if(getText($xYear,$xMonth,$xArea[$j],$EmCode) == 0)	{
									$SqlX = "INSERT INTO report_summarize " .
													"(Area_Code,xYear,xMonth,M$i,B$i,Em_Code,PG)" .
													" VALUES " .
													"('" . $xArea[$j] . "'," .
													"'" . $xYear . "'," .
													"'" .$xMonth . "'," .
													"'" . $xOutlet . "','". $xTotal .
													"','".$EmCode."','".$xGP."')";
								}else{
									$SqlX = "UPDATE report_summarize SET M$i = '" . $xOutlet . "',B$i = '". $xTotal ."' " .
													"WHERE xYear = '" . $xYear . "' " .
													"AND xMonth = '" . $xMonth . "' " .
													"AND Area_Code = '" . $xArea[$j] . "' " .
													"AND Em_Code = '" . $EmCode . "' " .
													"AND PG = '".$xGP."'";
								}
								mysqli_query($conn,$SqlX);
								//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";	 
			}
			$xOutlet = "0";
			$xTotal = "0";
		}
	}
}	
//echo "$AreaCnt <BR>";
for($i=0;$i<$AreaCnt;$i++){
			$SqlX = "SELECT " .
						"report_summarize.M1,report_summarize.B1,".
						"report_summarize.M2,report_summarize.B2,".
						"report_summarize.M3,report_summarize.B3,".
						"report_summarize.M4,report_summarize.B4,".
						"report_summarize.M5,report_summarize.B5,".
						"report_summarize.M6,report_summarize.B6 ".
						"FROM report_summarize " . 
						"WHERE report_summarize.xYear = '$xYear' " . 
						"AND report_summarize.xMonth = '$xMonth' " .
						"AND report_summarize.PG = '$xGP' " .
						"AND report_summarize.Em_Code = '$EmCode' ".
						"AND report_summarize.Area_Code = '$pArea[$i]'";
			$ss = substr($today, 0,7);
			$meQuery = mysqli_query($conn,$SqlX);
			$n=0;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$xM1 = $Result["M1"]+0;
				$xB1 = substr($Result["B1"],0,strlen($Result["B1"])-3);
				$xM2 = $Result["M2"]+0;
				$xB2 = substr($Result["B2"],0,strlen($Result["B2"])-3);
				$xM3 = $Result["M3"]+0;
				$xB3 = substr($Result["B3"],0,strlen($Result["B3"])-3);
				$xM4 = $Result["M4"]+0;
				$xB4 = substr($Result["B4"],0,strlen($Result["B4"])-3);
				$xM5 = $Result["M5"]+0;
				$xB5 = substr($Result["B5"],0,strlen($Result["B5"])-3);
				$xM6 = $Result["M6"]+0;
				$xB6 = substr($Result["B6"],0,strlen($Result["B6"])-3);

				//$xSumM = $xM1 + $xM2[$n]  + $xM3[$n] + $xM4[$n] + $xM5[$n] + $xM6[$n];
				//$xSumB = str_replace(',', '',$xB1[$n]) +  str_replace(',', '',$xB2[$n])  +  str_replace(',', '',$xB3[$n]) +  str_replace(',', '',$xB4[$n]) +  str_replace(',', '',$xB5[$n]) +  str_replace(',', '',$xB6[$n]);
				
				//$xSumB[$n] = Cut100( $xSumB[$n] );

				
				$n++;
			}	
			
			$ydata[$i] = array( $xM1, $xM2, $xM3, $xM4,$xM5,$xM6);  
			//echo $i . " || " .$ydata[$i][0] . " : " .  $ydata[$i][1] . " : " .  $ydata[$i][2] . " : " .  $ydata[$i][3] . " : " .  $ydata[$i][4] . " : " .  $ydata[$i][5] . "<br>";
			//$ydata[0] = array( 100, 102, 203, 75,86,46); 
			//$ydata[1] = array( 63, 75, 159, 20,44,46);
			//$ydata[2] = array( 36, 92, 47, 63,72,105); 
			
			$lineplot[$i] = new LinePlot($ydata[$i], $xdata);   
			$lineplot[$i]->SetColor('forestgreen'); 
			$lineplot[$i]->SetLegend($pArea[$i]);
			$graph->Add($lineplot[$i]);  
			$lineplot[$i]->mark->SetType(MARK_IMG_MBALL,$mBC[$i]);
			$lineplot[$i]->value->Show(); 
}
//$xMGP07N . " : " . $xGP07N . 

$graph->title->Set( "ประจำ " . $xMonth . "/" . $xYear);   

$graph->title->SetFont(FF_ARIAL, FS_NORMAL);   
$graph->xaxis->title->SetFont(FF_VERDANA, FS_ITALIC);   
$graph->yaxis->title->SetFont(FF_TIMES, FS_BOLD);   

$graph->xaxis->title->Set('Weeks');   
$graph->yaxis->title->Set('Outlet');   
  
$graph->xaxis->SetColor('#0000FF');   
$graph->yaxis->SetColor('#СС0000');   

$graph->Stroke(); 

?>
