<?php
  require '../connect.php';
  session_start();
  date_default_timezone_set("Asia/Bangkok");

	if (isset($_POST['DATA'])) {
		$data = $_POST['DATA'];
		$DATA = json_decode(str_replace('\"', '"', $data), true);
		if ($DATA['STATUS'] == 'SearchData') {
		SearchData($conn,$DATA);
		}
	}

	function SearchData($conn,$DATA){
		$Area	= $_SESSION['Area'];
		$Search	= $DATA["Search"];
		$xMenu	= $DATA["xMenu"];
		$xAdd	= $DATA["xAdd"];
		$lenSearch = strlen($Search);
		$count = 0;

		$Sql = "SELECT Cus_Code,CONCAT(customer.FName,' ',customer.LName) AS CusName 
		FROM customer 
		WHERE AreaCode = '$Area' 
		AND IsActive = 1
		AND (Cus_Code LIKE '%$Search%' OR FName  LIKE '%$Search%')";
		// $xSql = str_replace("'","",$Sql);
		// mysqli_query($conn, "INSERT INTO log (log) VALUES ('$xSql')");
		$meQuery = mysqli_query($conn, $Sql);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$return[$count]['Cus_Code']		= $Result['Cus_Code'];
			$return[$count]['CusName']		= $Result['CusName'];
			$count++;
		}
		$return['status']	= "success";
		$return['form']		= "SearchData";
		$return['rCnt']		= $count;
		$return['xMenu']	= $xMenu;
		$return['xAdd']		= $xAdd;
		$return['Sql']		= $Sql;
		echo json_encode($return);
		mysqli_close($conn);
		die;
	}
?>