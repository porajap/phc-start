<?php
require 'connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $xDocNo 	= $_POST['xDocNo'];
    $xSel   	= $_POST['xSel'];
	$xAmount   	= $_POST['xAmount'];
	
	$Sql = "SELECT
	customer.BringWelfare,
	( sale.Bring1 + sale.Bring2 + sale.Bring3 ) AS SumBring,
	(
	 SELECT SUM( dc.CmsB )
	 FROM dallycall AS dc
	 WHERE dc.DocNo = sale.DocNo
	 AND dc.AreaCode = sale.AreaCode
	 GROUP BY dc.DocNo
	) AS BringTotal_Max,
	sale.bFinish1,
	sale.bFinish2,
	sale.bFinish3

	FROM sale
	INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code
	WHERE sale.DocNo = '$xDocNo'";
    $meQuery = mysqli_query($conn, $Sql);
    while ($Result = mysqli_fetch_assoc($meQuery)) {
	  $SumBring = $Result['SumBring'];
	  $bMax = $Result['BringTotal_Max'];
	  $Welfare = $Result['BringWelfare'];
	  $bFinish1 = $Result['bFinish1'];
	  $bFinish2 = $Result['bFinish2'];
	  $bFinish3 = $Result['bFinish3'];
	}
	
    if ($bFinish1 == 0) {
        $sAmount = $xAmount;
	}elseif ($bFinish1 == 1 && $bFinish2 == 0 ) {
        $sAmount = ($xAmount + $SumBring);
	}elseif ($bFinish1 == 1 && $bFinish2 == 1 && $bFinish3 == 0 ) {
        $sAmount = ($xAmount + $SumBring);
	}
	
	if($Welfare > 0){
		$aMax = $bMax * ($Welfare/100);
	}else{
		$aMax = $bMax;
	}

	if( $sAmount < $aMax ){
		if($xSel == 1){
			$Sql = "UPDATE sale SET Bring1 = '$xAmount',Bring1_Datetime = NOW() WHERE DocNo = '$xDocNo'";
		}elseif($xSel == 2){
			$Sql = "UPDATE sale SET Bring2 = '$xAmount',Bring1_Datetime = NOW() WHERE DocNo = '$xDocNo'";
		}elseif($xSel == 3){
			$Sql = "UPDATE sale SET Bring3 = '$xAmount',Bring1_Datetime = NOW() WHERE DocNo = '$xDocNo'";
		}
		mysqli_query($conn, $Sql);
		$img="img/success-1.png";
		$msg="บันทึกสำเร็จ...";
	}else{
		$img="img/unsuccess-2.png";
		$msg="ท่านได้เบิกเกินวงเงิน...";
	}


}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Customer</title>
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<script src="js/jquery.js"></script>
    <script src="js/jquery.mobile-1.4.5.min.js"></script>
	<style>
		.center {
			margin: auto;
			width: 50%;
			border: 3px solid #73AD21;
			padding: 10px;
		}
	</style>
</head>

<body>
<div style="margin: 35px;">
	<div class="container">
		<div class="card img-fluid" style="text-align:center;width:300px">
			<img class="card-img-top" src="<?=$img?>" alt="Card image" style="width:50%">
			<div class="card-img-overlay">
			<h4 class="card-title"><?=$msg?></h4>
			</div>
		</div>
	</div>
</div>
<script>
    window.setTimeout(function() {
		window.location.href = 'Welfare.php';
    }, 4000);
</script>
</body>
