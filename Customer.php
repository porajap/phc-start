<?php

session_start();
require 'connect.php';


	if($_SESSION["Area"] == "") header('location:index.html');

	$Area = $_SESSION["Area"];
	$xName = $_SESSION["xName"];
	$Search = $_POST["inputTxt1"];

	$Sql = "SELECT customer.Cus_Code,customer.FName,customer.LName
	FROM customer
	INNER JOIN prefix ON prefix.Prefix_Code = customer.Prefix_Code
	WHERE customer.AreaCode = '$Area' 
	AND (customer.Cus_Code LIKE '%$Search%' OR customer.FName LIKE '%$Search%')
	AND customer.IsActive = 1 
	AND prefix.Status = 1";
	// echo $Sql;
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$CusCode[$i] = $Result["Cus_Code"];
		$CusName[$i] = $Result["FName"];
		$Item[$i]	=  $CusCode[$i] . " : " .$Result["FName"] . "  " . $Result["LName"];
		$i++;
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
    <link rel="stylesheet" href="css/all.css">
    <script src="js/jquery/3.5.1/jquery.min.js "></script>
    <script src="assets/dist/js/bootstrap.js "></script>
    <script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
</head>

<body>
	<div class="topnav">
        <a href="p2.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $Area ?> : ราคาสินค้า ตามบิล/ลูกค้า</div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
	</div>

	<form action="Customer.php" method="post">
		<div class="row xTop1">
			<div class="col">
				<label for="inputTxt1" class="visually-hidden">Search</label>
				<input type="Text" class="form-control" id="inputTxt1" name="inputTxt1" placeholder="ค้นหา">
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-primary mb-3">ค้นหา</button>
			</div>
		</div>
	</form>

	<div class="row">
		<div class="col-12">
			<div class="list-group">
<?php 	for($j=0;$j<$i;$j++){ ?>
			<a class="list-group-item list-group-item-action" href="Date02.php?CusCode=<?= $CusCode[$j] ?>&CusName=<?= $CusName[$j] ?>"><?php echo $Item[$j] ?></a>
<?php } ?>
			</div>
		</div>
	</div>

</body>

</html>
