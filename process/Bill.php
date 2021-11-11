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

		$SelMonth1	= $DATA["sMonth1"];
		$SelYear1	= $DATA["sYear1"];
		$SelMonth2	= $DATA["sMonth2"];
		$SelYear2	= $DATA["sYear2"];
		$Cus_Code 	= $DATA["Cus_Code"];
		
		if(strlen($SelMonth1)==1) $SelMonth1="0".$SelMonth1;

		$Sqlse1 = "SELECT perioddallycall.sDate FROM perioddallycall
		WHERE perioddallycall.`Year` = '$SelYear1' AND perioddallycall.`Month` = '$SelMonth1'";
		$meQuery = mysqli_query($conn, $Sqlse1);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$sDate = $Result["sDate"];
		}

		if(strlen($SelMonth2)==1) $SelMonth2="0".$SelMonth2;
		$Sqlse2 = "SELECT perioddallycall.eDate FROM perioddallycall
		WHERE perioddallycall.`Year` = '$SelYear2' AND perioddallycall.`Month` = '$SelMonth2'";
		$meQuery = mysqli_query($conn, $Sqlse2);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$eDate = $Result["eDate"];
		}

		$Sql = "SELECT DocDate,DocNo,IsCheckIn,customer.FName ";
		$Sql .= "FROM sale ";
		$Sql .= "INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code ";
		$Sql .= "WHERE customer.AreaCode = '$Area' AND customer.Cus_Code = '$Cus_Code' ";
		$Sql .= "AND  sale.DocDate BETWEEN '$sDate' AND '$eDate' ";
		$Sql .= "AND  sale.DocNo LIKE '%$Search%' ";
		if($lenSearch > 0)
			$Sql .= "ORDER BY DocNo DESC";
		else	
			$Sql .= "ORDER BY DocNo DESC LIMIT 50";
		// $xSql = str_replace("'","",$Sql);
		// mysqli_query($conn, "INSERT INTO log (log) VALUES ('$xSql')");
		$meQuery = mysqli_query($conn, $Sql);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$return[$count]['DocNo']		= $Result['DocNo'];
			$return[$count]['DocDate']		= $Result['DocDate'];
			$return[$count]['FName']		= $Result['FName'];
			$return[$count]['IsCheckIn']	= $Result['IsCheckIn'];
			$count++;
		}
		$return['status'] = "success";
		$return['form'] = "SearchData";
		$return['rCnt'] = $count;
		$return['Sql'] = "";
		echo json_encode($return);
		mysqli_close($conn);
		die;
	}

	function getCus($conn,$Cus_ID){
		$xSql = "SELECT CONCAT(customer.FName,' ',customer.LName) AS CusName ";
		$xSql .= "FROM customer WHERE Cus_Code = '$Cus_ID'";
		$meQuery = mysqli_query($conn,$xSql);
		while ($Result = mysqli_fetch_assoc($meQuery))
		{
			$CusName =  $Result["CusName"];
			$_SESSION["CusFullName"]	= $Result["CusName"];
		}
		return $CusName;
	}
	
?>