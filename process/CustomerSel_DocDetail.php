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
		$xAdd	= $DATA["xAdd"];
		$Cus_Code	= $DATA['Cus_Code'];
		$lenSearch = strlen($Search);
		$count = 0;

		$Sql = "SELECT
					acc_delegate.RowId,
					acc_delegate.DocNo,
					DATE_FORMAT(acc_delegate.DocDate,'%d-%m-%Y') AS DocDate,
					acc_delegate.IsStatus,
					acc_delegate.Cus_Code,
					customer.FName,
					acc_delegate.AreaCode,
					acc_delegate.QtyDoc,
					acc_delegate.IsStatusTax 
				FROM
					acc_delegate
					INNER JOIN customer ON acc_delegate.Cus_Code = customer.Cus_Code
					WHERE acc_delegate.AreaCode = '$Area'
					AND acc_delegate.Cus_Code = '$Cus_Code' 
					ORDER BY DocNo DESC ";

		$meQuery = mysqli_query($conn, $Sql);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$return[$count]['RowId']		= $Result['RowId'];
			$return[$count]['DocNo']		= $Result['DocNo'];
			$return[$count]['DocDate']		= $Result['DocDate'];
			$return[$count]['IsStatus']		= $Result['IsStatus'];
			$return[$count]['Cus_Code']		= $Result['Cus_Code'];
			$return[$count]['CusName']		= $Result['FName'];
			$return[$count]['AreaCode']		= $Result['AreaCode'];
			$return[$count]['QtyDoc']		= $Result['QtyDoc'];
			$return[$count]['IsStatusTax']		= $Result['IsStatusTax'];
			$count++;
		}
		$return['status']	= "success";
		$return['form']		= "SearchData";
		$return['rCnt']		= $count;
		$return['xAdd']		= $xAdd;
		$return['Sql']		= $Sql;
		echo json_encode($return);
		mysqli_close($conn);
		die;
	}
?>