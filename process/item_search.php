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
		$Search  = $DATA["Search"];
		$lenSearch = strlen($Search);
		$count = 0;

		$Sql = "SELECT Item_Code,NameTH FROM item WHERE item.IsSale = 1
		AND (Item_Code LIKE '%$Search%' OR NameTH LIKE '%$Search%')";
		$meQuery = mysqli_query($conn, $Sql);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$return[$count]['Item_Code'] = $Result["Item_Code"];
			$return[$count]['NameTH'] = $Result["NameTH"];
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