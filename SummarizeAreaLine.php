<?php
session_start();
if($_SESSION["Area"] == "") header('location:index.html');
$chk = $_REQUEST["chk"];
$AC = $_REQUEST["AC"];
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
	$graph = new Graph(800, 600, 'auto', 10, true);   
	$graph->SetScale('textlin');   

	$mBC = array( 'blue','bluegreen','brown','cyan', 'darkgray','greengray','gray','green', 'greenblue','lightblue','lightred', 'purple','red','white','yellow','blue','bluegreen','brown','cyan', 'darkgray','greengray','gray','green', 'greenblue','lightblue','lightred', 'purple','red','white','yellow'); 
	
	$xGP = $_SESSION["xGP07S"];
	$xYear = $_SESSION["xYear07"];
	$xMonth = $_SESSION["xMonth07"];
	$EmCode = $_SESSION["Area"];
	$xGP07N = $_SESSION["xGP07N"];
	$xMGP07N = $_SESSION["xMGP07N"];
	
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
				
			$SqlX = "SELECT " .
						"report_summarize_area.M1,report_summarize_area.B1,".
						"report_summarize_area.M2,report_summarize_area.B2,".
						"report_summarize_area.M3,report_summarize_area.B3,".
						"report_summarize_area.M4,report_summarize_area.B4,".
						"report_summarize_area.M5,report_summarize_area.B5 ".
						"FROM report_summarize_area " . 
						"WHERE report_summarize_area.xYear = '$xYear' " . 
						"AND report_summarize_area.xMonth = '$xMonth' " .
						"AND report_summarize_area.Em_Code = '$EmCode' " .
						"AND report_summarize_area.Area_Code = '$AC'";
						
			//echo "<textarea  rows='10' cols='50' >$SqlX </textarea>";
			$ss = substr($today, 0,7);
			//echo "<textarea  rows='10' cols='50' > $ss ::: $xWk </textarea>";

			$meQuery = mysqli_query($conn,$SqlX);
			$n=0;
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				if( strlen(trim($dyaofweek[1])) != 0){
					$xM1[$n] = $Result["M1"];
					$xB1[$n] = substr($Result["B1"],0,strlen($Result["B1"])-3);
					$xSumM1 += $xM1[$n];
					$xSB1 = str_replace(',', '',$xB1[$n]);
					$xSumB1 += $xSB1;
				}
				if( strlen(trim($dyaofweek[2])) != 0){
					$xM2[$n] = $Result["M2"];
					$xB2[$n] = substr($Result["B2"],0,strlen($Result["B2"])-3);
					$xSumM2 += $xM2[$n];
					$xSB2 = str_replace(',', '',$xB2[$n]);
					$xSumB2 += $xSB2;
				}
				if( strlen(trim($dyaofweek[3])) != 0){
					$xM3[$n] = $Result["M3"];
					$xB3[$n] = substr($Result["B3"],0,strlen($Result["B3"])-3);
					$xSumM3 += $xM3[$n];
					$xSB3 = str_replace(',', '',$xB3[$n]);
					$xSumB3 += $xSB3;
				}
				if( strlen(trim($dyaofweek[4])) != 0){
					$xM4[$n] = $Result["M4"];
					$xB4[$n] = substr($Result["B4"],0,strlen($Result["B4"])-3);
					$xSumM4 += $xM4[$n];
					$xSB4 = str_replace(',', '',$xB4[$n]);
					$xSumB4 += $xSB4;
				}
				if( strlen(trim($dyaofweek[5])) != 0){
					$xM5[$n] = $Result["M5"];
					$xB5[$n] = substr($Result["B5"],0,strlen($Result["B5"])-3);
					$xSumM5 += $xM5[$n];
					$xSB5 = str_replace(',', '',$xB5[$n]);
					$xSumB5 += $xSB5;
				}
				$n++;
			}
			
						$xSumM = $xSumM1 + $xSumM2 + $xSumM3 + $xSumM4 + $xSumM5;
			$yy[0] = 1;
			$yy[1] = 2;
			$yy[2] = 3;
			$yy[3] = 4;
			if( strlen(trim($dyaofweek[5])) != 0)$yy[4] = 5;

			if($nWeek==4){
				$xdata = array( 0, 1, 2, 3); 
				$xSumB = $xSumB1 + $xSumB2 + $xSumB3 + $xSumB4;
				$ydata[$i] = array( $xSumB1, $xSumB2, $xSumB3, $xSumB4); 
			}elseif($nWeek==5){
				$xdata = array( 0, 1, 2, 3, 4); 
				$xSumB = $xSumB1 + $xSumB2 + $xSumB3 + $xSumB4 + $xSumB5;
				$ydata[$i] = array( $xSumB1, $xSumB2, $xSumB3, $xSumB4,$xSumB5); 
			}
			
			$lineplot[$i] = new LinePlot($ydata[$i], $xdata);   
			$lineplot[$i]->SetColor('forestgreen'); 
			$lineplot[$i]->SetLegend($pArea[$i]);
			$graph->Add($lineplot[$i]);  
			$lineplot[$i]->mark->SetType(MARK_IMG_MBALL,'red');
			$lineplot[$i]->value->Show(); 
			
			$graph->title->Set( $xMonth . "/" . $xYear);   
			
			$graph->title->SetFont(FF_ARIAL, FS_NORMAL);   
			$graph->xaxis->title->SetFont(FF_VERDANA, FS_ITALIC);   
			$graph->yaxis->title->SetFont(FF_TIMES, FS_BOLD);   
			
			$graph->xaxis->title->Set('Weeks');   
			$graph->yaxis->title->Set('');   
			  
			$graph->xaxis->SetColor('#0000FF');   
			$graph->yaxis->SetColor('#СС0000');   
			
			$graph->Stroke(); 
?>
