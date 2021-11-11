<?php
session_start();
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
$xName = $_SESSION["xName"];
$Area = $_SESSION["Area"];

	$Sql = "SELECT ID,xArea,xYear,Q01Sale,Q02Sale,Q03Sale,Q04Sale,Q05Sale,Q06Sale,Q07Sale,Q08Sale,Q09Sale,Q10Sale,Q11Sale,Q12Sale ";
	$Sql .= "FROM quarter_price_by_month ";
	if($Area == "padmin" || $Area == "psbkk")
		$Sql .= "WHERE ( xArea = 'BB1' OR xArea = 'BB2' OR xArea = 'BB3' OR xArea = 'BB4' OR xArea = 'BB5' )";
	else	
		$Sql .= "WHERE xArea = '$Area'";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>PHC</title>
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
        .xTop1{
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
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
    </style>
</head>

<body>
	<div class="topnav">
        <a href="p2.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : Sales/Month</div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>
	
<div class="overflow-auto">
	<table class="table">
              <tr>
                <td>


<?php
echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                              echo "<tr>";
                              	echo "<td align='center' style='border:1px;border-style:solid solid solid solid;background:#CCFFFF'>เขต</td>";
                                echo "<td align='center' style='border:1px;border-style:solid solid solid hidden;background:#CCFFFF'>ปี</td>";
                                echo "<td align='center' style='border:1px;border-style:solid solid solid hidden;background:#CCFFFF'>เดือน 01</td>";
								echo "<td align='center' style='border:1px;border-style:solid solid solid hidden;background:#CCFFFF'>เดือน 02</td>";
								echo "<td align='center' style='border:1px;border-style:solid solid solid hidden;background:#CCFFFF'>เดือน 03</td>";
								echo "<td align='center' style='border:1px;border-style:solid solid solid hidden;background:#CCFFFF'>เดือน 04</td>";
								echo "<td align='center' style='border:1px;border-style:solid solid solid hidden;background:#CCFFFF'>เดือน 05</td>";
								echo "<td align='center' style='border:1px;border-style:solid solid solid hidden;background:#CCFFFF'>เดือน 06</td>";
								echo "<td align='center' style='border:1px;border-style:solid solid solid hidden;background:#CCFFFF'>เดือน 07</td>";
								echo "<td align='center' style='border:1px;border-style:solid solid solid hidden;background:#CCFFFF'>เดือน 08</td>";
								echo "<td align='center' style='border:1px;border-style:solid solid solid hidden;background:#CCFFFF'>เดือน 09</td>";
								echo "<td align='center' style='border:1px;border-style:solid solid solid hidden;background:#CCFFFF'>เดือน 10</td>";
								echo "<td align='center' style='border:1px;border-style:solid solid solid hidden;background:#CCFFFF'>เดือน 11</td>";
								echo "<td align='center' style='border:1px;border-style:solid solid solid hidden;background:#CCFFFF'>เดือน 12</td>";
                              echo "</tr>";
                              							   
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		if( ($i%2) == 0 ){
		
								echo "<tr>";
								
							    echo "<td align='center' style='color:#0000FF;border-left: 1px  solid black;border-right: 1px  solid black;'>" . $Result["xArea"] . "</td>";
                                echo "<td align='center' style='color:#0000FF;border-right: 1px  solid black;'>" . $Result["xYear"] . "</td>";
                                echo "<td align='right' style='color:#0000F0;border-right: 1px  solid black;'>" . number_format($Result["Q01Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#0000FF;border-right: 1px  solid black;'>" . number_format($Result["Q02Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#0000FF;border-right: 1px  solid black;'>" . number_format($Result["Q03Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#0000FF;border-right: 1px  solid black;'>" . number_format($Result["Q04Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#0000FF;border-right: 1px  solid black;'>" . number_format($Result["Q05Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#0000FF;border-right: 1px  solid black;'>" . number_format($Result["Q06Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#0000FF;border-right: 1px  solid black;'>" . number_format($Result["Q07Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#0000FF;border-right: 1px  solid black;'>" . number_format($Result["Q08Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#0000FF;border-right: 1px  solid black;'>" . number_format($Result["Q09Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#0000FF;border-right: 1px  solid black;'>" . number_format($Result["Q10Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#0000FF;border-right: 1px  solid black;'>" . number_format($Result["Q11Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#0000FF;border-right: 1px  solid black;'>" . number_format($Result["Q12Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								
								
								echo "</tr>";
								
	}else{
								echo "<tr>";
								
							    echo "<td align='center' style='color:#ff66cc;border-left: 1px  solid black;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . $Result["xArea"] . "</td>";
                                echo "<td align='center' style='color:#ff66cc;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . $Result["xYear"] . "</td>";
                                echo "<td align='right' style='color:#ff66cc;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . number_format($Result["Q01Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#ff66cc;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . number_format($Result["Q02Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#ff66cc;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . number_format($Result["Q03Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#ff66cc;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . number_format($Result["Q04Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#ff66cc;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . number_format($Result["Q05Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#ff66cc;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . number_format($Result["Q06Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#ff66cc;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . number_format($Result["Q07Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#ff66cc;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . number_format($Result["Q08Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#ff66cc;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . number_format($Result["Q09Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#ff66cc;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . number_format($Result["Q10Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#ff66cc;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . number_format($Result["Q11Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								echo "<td align='right' style='color:#ff66cc;border-bottom: 1px  solid black;border-right: 1px  solid black;background:#e6ffe6'>" . number_format($Result["Q12Sale"], 0, '.', ',') . "&nbsp;&nbsp;&nbsp;</td>";
								
								
								echo "</tr>";			
			
	}
								
								
$i++;								
	}	
echo "</table>";						   
?>                                                                          
                </td>
                <td>&nbsp; </td>
              </tr>
              
	</table>
</div>

</body>

</html>
