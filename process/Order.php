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

		$SelMonth = $DATA["SelMonth"];
		$SelYear  = $DATA["SelYear"];
		if($SelMonth<10) 
			$xSelM = "0".($SelMonth+1);
		else
			$xSelM = ($SelMonth+1);    

		$Sqlse = "SELECT perioddallycall.sDate,perioddallycall.eDate
				FROM perioddallycall
				WHERE perioddallycall.`Year` = '$SelYear' AND perioddallycall.`Month` = '$xSelM'";
		$meQuery = mysqli_query($conn, $Sqlse);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$sDate = $Result["sDate"];
			$eDate = $Result["eDate"];
		}

		$sDate = $_SESSION["sDate"];
		$eDate = $_SESSION["eDate"];

		$chk1 = substr( ($sDate ),0,4);
		$chk2 = substr( ($eDate ),0,4);
		
		if($chk1>2000 && $chk2>2000){
			$sDate = $chk1.substr($sDate,4,8);
			$eDate = $chk2.substr($eDate,4,8);
		}

		$mm = (int)date("m");
		if(($mm-1) == 0 ) 
			$mm = 1;
		else
			$mm = ($mm-1);

		$Sql = "SELECT DocDate,DocNo,DueDate,IsSave,IsFinish,IsCancel,IsSend,customer.Cus_Code,Modify_Date ";
		$Sql .= "FROM saleorder ";
		$Sql .= "INNER JOIN customer ON saleorder.Cus_Code = customer.Cus_Code ";
		$Sql .= "WHERE Area_Code = '$Area' AND IsCancel = 0 ";
		$Sql .= "AND ( saleorder.DocNo LIKE '%$Search%' OR saleorder.Cus_Code LIKE '%$Search%' OR customer.FName  LIKE '%$Search%' )";
		if($lenSearch > 0)
			$Sql .= "ORDER BY DocNo DESC";
		else	
			$Sql .= "ORDER BY DocNo DESC LIMIT 100";
	
		// $xSql = str_replace("'","",$Sql);
		// mysqli_query($conn, "INSERT INTO log (log) VALUES ('$xSql')");
		$meQuery = mysqli_query($conn, $Sql);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
			$return[$count]['DocNo']		= $Result['DocNo'];
			$return[$count]['IsFinish']		= $Result['IsFinish'];
			$return[$count]['IsSave']		= $Result['IsSave'];
			$return[$count]['IsSend']		= $Result['IsSend'];
			$return[$count]['IsCancel']		= $Result['IsCancel'];
			$return[$count]['DueDate']		= $Result['DueDate'];
			$return[$count]['Modify_Date']	= $Result['Modify_Date'];
			$return[$count]['Status']		= ($Result["IsSave"]==1?'<div style="color:blue;">สถานะ : บันทึกเรียบร้อย</div>':'<div style="color:red;">สถานะ : รอการบันทึก</div>');
			$return[$count]['Item']			=  getCus($conn,$Result["Cus_Code"] );
			if ($Result['DueDate'] != "") {
				$newDate = date("d-m-Y", strtotime($Result['DueDate']));
				$return[$count]['SendDate']	= " [ วันที่ส่ง : " . $newDate . " ]";
			}
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