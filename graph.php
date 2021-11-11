<?php // content="text/plain; charset=utf-8"
session_start();
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');

	$rItemCode = $_REQUEST["ItemCode"];
	$rYear = $_REQUEST["Year"];
	$xGP = $_SESSION["xGP"];
	$sYear = $_SESSION["sYear"];
	$eYear = $_SESSION["eYear"];
	$EmCode = $_SESSION["Area"];
	$gY = date("Y");
	$gM = date("m");

	$graph = new Graph(800, 600, 'auto', 10, true);   
	$graph->SetScale('textlin');   
	$xdata = array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10,11); 
	$m = 0;
	for($i=$sYear;$i<=$eYear;$i++){
			$SqlX = "SELECT " .
						"item.NameTH,report_circle.xYear,".
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
						"WHERE item.CategorySub_Code LIKE '$xGP%' " .
						"AND item.Item_Code = '$rItemCode' " .
						"AND report_circle.Em_Code = '" . $EmCode . "' " .
						"AND report_circle.xYear = '" . $i . "'";
			//echo "$SqlX <br>";
			$meQuery = mysqli_query($conn,$SqlX);
			$n=0;
			
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
				$xM1 = $Result["M1"]+0;
				$xB1 = $Result["B1"]+0;
				$xM2 = $Result["M2"]+0;
				$xB2 = $Result["B2"]+0;
				$xM3 = $Result["M3"]+0;
				$xB3 = $Result["B3"]+0;
				$xM4 = $Result["M4"]+0;
				$xB4 = $Result["B4"]+0;
				$xM5 = $Result["M5"]+0;
				$xB5 = $Result["B5"]+0;
				$xM6 = $Result["M6"]+0;
				$xB6 = $Result["B6"]+0;
				$xM7= $Result["M7"]+0;
				$xB7= $Result["B7"]+0;
				$xM8 = $Result["M8"]+0;
				$xB8 = $Result["B8"]+0;
				$xM9 = $Result["M9"]+0;
				$xB9 = $Result["B9"]+0;
				$xM10 = $Result["M10"]+0;
				$xB10 = $Result["B10"]+0;
				$xM11 = $Result["M11"]+0;
				$xB11 = $Result["B11"]+0;
				$xM12 = $Result["M12"]+0;
				$xB12 = $Result["B12"]+0;	
				$n++;				
			}

			$ydata[$m] = array( $xM1, $xM2, $xM3, $xM4,$xM5,$xM6,$xM7,$xM8,$xM9, $xM10, $xM11,$xM12);  

			$lineplot[$m] = new LinePlot($ydata[$m], $xdata);   
			$lineplot[$m]->SetColor('forestgreen'); 
			$lineplot[$m]->SetLegend($i);
			$graph->Add($lineplot[$m]);  

			switch($m){
				case 0: $lineplot[$m]->mark->SetType(MARK_IMG_MBALL,'red'); break;
			  	case 1: $lineplot[$m]->mark->SetType(MARK_IMG_MBALL,'purple'); break;
				case 2: $lineplot[$m]->mark->SetType(MARK_IMG_MBALL,'blue'); break;
				case 3: $lineplot[$m]->mark->SetType(MARK_IMG_MBALL,'yellow'); break;
				case 4: $lineplot[$m]->mark->SetType(MARK_IMG_MBALL,'brown'); break;
				case 5: $lineplot[$m]->mark->SetType(MARK_IMG_MBALL,'gray'); break;
			}
			$lineplot[$m]->value->Show(); 

			$m++;
	}

$graph->title->Set($rItemCode);   

$graph->title->SetFont(FF_ARIAL, FS_NORMAL);   
$graph->xaxis->title->SetFont(FF_VERDANA, FS_ITALIC);   
$graph->yaxis->title->SetFont(FF_TIMES, FS_BOLD);   

$graph->xaxis->title->Set('Month');   
$graph->yaxis->title->Set('Quantity');   
  
$graph->xaxis->SetColor('#0000FF');   
$graph->yaxis->SetColor('#СС0000');   

$graph->Stroke(); 
?>
