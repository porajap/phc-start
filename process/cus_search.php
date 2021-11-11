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
		$Area = $_SESSION['Area'];
		$Search  = $DATA["Search"];
		$lenSearch = strlen($Search);
		$count = 0;

		$Sql = "SELECT customer.Cus_Code,customer.FName 
		FROM customer 
		WHERE customer.AreaCode = '$Area'
		AND (Cus_Code LIKE '%$Search%' OR FName LIKE '%$Search%')";
		$meQuery = mysqli_query($conn, $Sql);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$return[$count]['Cus_Code'] = $Result["Cus_Code"];
			$return[$count]['FName'] = $Result["FName"];
			$count++;
		}

		$return['status'] = "success";
		$return['form'] = "SearchData";
		$return['rCnt'] = $count;
		$return['Sql'] = $Sql;
		echo json_encode($return);
		mysqli_close($conn);
		die;
	}
?>