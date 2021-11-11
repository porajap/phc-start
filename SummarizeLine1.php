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
	$graph = new Graph(800, 600, 'auto', 10, true);   
	$graph->SetScale('textlin');   
	$xdata = array( 0, 1, 2, 3, 4, 5, ); 
	
	$xGP = $_SESSION["xGP07S"];
	$xYear = $_SESSION["xYear07"];
	$xMonth = $_SESSION["xMonth07"];
	$EmCode = $_SESSION["Area"];
	$gY = date("Y");
	$gM = date("m");
	$now = time();
	$today = date('Y-m-d', mktime(0, 0, 0, date("m", $now), date("d", $now), date("Y", $now)));
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
			$xArea[$AreaCnt] = $Result1["Code"];
			$AreaCnt++;
		}			

	function getText($y,$m,$e)
	{
		$SqlX = "SELECT Count(*) AS Cnt FROM report_summarize " . 
					"WHERE xYear = '$y' " .
					"AND xMonth = '$m' " .
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
	
	function getOutlet($dw,$xYr,$xMh,$xGP)
	{
		$SqlX= "SELECT customer.Cus_Code " .
					"FROM dallycall  " .
					"INNER JOIN item ON dallycall.ItemCode = item.Item_Code  " .
					"INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code  " .
					"WHERE dallycall.xDate BETWEEN '" . $xYr.'-'.$xMh.'-'.getFirstDayOfWeek($dw) . "' ".
					"AND '" . $xYr.'-'.$xMh.'-'.getLastDayOfWeek($dw) . "' " .
					" AND item.CategorySub_Code LIKE '$xGP%' " .
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
						 "AND '" . $xYear.'-'.$xMonth.'-'.getLastDayOfWeek($dow) . "' " .
						 "AND item.CategorySub_Code LIKE '$xGP%' " .
						 "AND item.Grp_1 = 1 " .
						 "GROUP BY customer.AreaCode";

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
								if(getText($xYear,$xMonth,$EmCode) == 0)	{
									$SqlX = "INSERT INTO report_summarize " .
													"(Area_Code,xYear,xMonth,M$i,B$i,Em_Code,PG)" .
													" VALUES " .
													"(''," .
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
			$SqlX = "SELECT report_summarize.Area_Code," .
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
						"AND report_summarize.Em_Code = '$EmCode'";
			//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";
			$ss = substr($today, 0,7);
			//echo "<textarea  rows='10' cols='50' > $ss ::: $xWk </textarea>";

			$meQuery = mysqli_query($conn,$SqlX);
			$n=0;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				//$AreaCode[$n] = $Result["Area_Code"];
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
			$yy[0] = 1;
			$yy[1] = 2;
			$yy[2] = 3;
			$yy[3] = 4;
			$yy[4] = 5;
			$yy[5] = 6;
			
			$datay[0] = $xSumM1;
			$datay[1] = $xSumM2;
			$datay[2] = $xSumM3;
			$datay[3] = $xSumM4;
			$datay[4] = $xSumM5;
			$datay[5] = $xSumM6;

			$xSumB = $xSumB1 + $xSumB2 + $xSumB3 + $xSumB4 + $xSumB5 + $xSumB6;
			
			$xSumB1 = Cut100( $xSumB1 );
			$xSumB2 = Cut100( $xSumB2 );
			$xSumB3 = Cut100( $xSumB3 );
			$xSumB4 = Cut100( $xSumB4 );
			$xSumB5 = Cut100( $xSumB5 );
			$xSumB6 = Cut100( $xSumB6 );
			
			$xSumB = Cut100( $xSumB );
			
// Create the graph and setup the basic parameters 
$graph = new Graph(800,600,'auto'); 
$graph->img->SetMargin(40,30,40,50);
$graph->SetScale("textint");
$graph->SetFrame(true,'blue',1); 
$graph->SetColor('lightblue');
$graph->SetMarginColor('lightblue');

// Setup X-axis labels
//echo $yy[0] . "<br>" . $yy[1] . "<br>". $yy[2] . "<br>". $yy[3] . "<br>". $yy[4] . "<br>". $yy[5] . "<br>";
$a = $yy;
$graph->xaxis->SetTickLabels($a);
$graph->xaxis->SetFont(FF_FONT1);
$graph->xaxis->SetColor('darkblue','black');

// Setup "hidden" y-axis by given it the same color
// as the background (this could also be done by setting the weight
// to zero)
$graph->yaxis->SetColor('lightblue','darkblue');
$graph->ygrid->SetColor('white');

// Setup graph title ands fonts
$graph->title->Set('Using grace = 0');
$graph->title->SetFont(FF_FONT2,FS_BOLD);
$graph->xaxis->SetTitle('Year 2002','center');
$graph->xaxis->SetTitleMargin(15);
$graph->xaxis->title->SetFont(FF_FONT2,FS_BOLD);

// Add some grace to the top so that the scale doesn't
// end exactly at the max value. 
$graph->yaxis->scale->SetGrace(0);

// Create a bar pot
//$datay=array(7,19,11,4,20);
$bplot = new BarPlot($datay);
$bplot->SetFillColor('darkblue');
$bplot->SetColor('darkblue');
$bplot->SetWidth(0.5);
$bplot->SetShadow('darkgray');

// Setup the values that are displayed on top of each bar
// Must use TTF fonts if we want text at an arbitrary angle
$bplot->value->Show();
$bplot->value->SetFont(FF_ARIAL,FS_NORMAL,8);
$bplot->value->SetFormat('$%d');
$bplot->value->SetColor('darkred');
$bplot->value->SetAngle(45);

$graph->Add($bplot);

$graph->title->Set($rItemCode);   

$graph->title->SetFont(FF_ARIAL, FS_NORMAL);   
$graph->xaxis->title->SetFont(FF_VERDANA, FS_ITALIC);   
$graph->yaxis->title->SetFont(FF_TIMES, FS_BOLD);   

$graph->xaxis->title->Set('Weeks');   
$graph->yaxis->title->Set('Outlet');   
  
$graph->xaxis->SetColor('#0000FF');   
$graph->yaxis->SetColor('#СС0000');   

// Finally stroke the graph
$graph->Stroke();
?>
