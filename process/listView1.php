<?php
session_start();
require '../connect.php';
date_default_timezone_set("Asia/Bangkok");

if(isset($_POST['DATA']))
{
  $data = $_POST['DATA'];
  $DATA = json_decode(str_replace ('\"','"', $data), true);

  if ($DATA['STATUS'] == 'list1') {
    list1($conn, $DATA);
  }else if ($DATA['STATUS'] == 'list2') {
    list2($conn, $DATA);
  }else if ($DATA['STATUS'] == 'list3') {
    list3($conn, $DATA);
  }else{
    $return['status'] = "error";
    $return['form'] = "OnLoadPage";
    echo json_encode($return);
    die;
  }
}else{
    $return['status'] = "error";
    $return['form'] = "list1";
    $return['msg'] = $DATA['STATUS'];
    echo json_encode($return);
    mysqli_close($conn);
    die;
}

function list1($conn,$DATA)
{
    // mysqli_query($conn,"INSERT INTO (log) VALUES ('user :: password')");
  if (isset($DATA)) {
    $Sel = $DATA['Sel'];
    $AreaCode = $DATA['AreaCode'];

    $month  = date('m', time());
    $year  = date('Y', time());

    $imonth = (int)$month;
    $sDate = date('Y-m-d', time());
    $eDate = date('Y-m-d', time());

    $Sql = "SELECT perioddallycall.sDate,perioddallycall.eDate
    FROM perioddallycall
    WHERE perioddallycall.`Year` = '$year'
    AND perioddallycall.`Month` = '$month'";
    $meQuery = mysqli_query($conn,$Sql);
    while ($Result = mysqli_fetch_assoc($meQuery)){
        $sDate = $Result["sDate"];
        $eDate = $Result["eDate"];
    }

    $Sql = "SELECT
    sale.DocNo,
    `check`.Check_ModifyDate, 
    customer.Cus_Code,
    customer.FName,
    IFNULL(sale.DocNoAcc,'')AS DocNoAcc,
    sale.Total- sale.DeductCN_Price + sale.Add_Money AS Total,
    CASE WHEN sale.ExpressCode !='' then express.Express
    ELSE 'ผู้แทนจ่าย' end AS PayType ,
    CASE WHEN sale.IsCheckIn = '1' AND sale.ExpressCode IN(2,3,6) THEN 'จ่ายแล้ว'
         WHEN sale.IsCheckIn = '1' AND sale.ExpressCode = '1' THEN 'รับเช็ค ( เคลียร์แล้ว )'
         WHEN sale.IsCheckIn = '3' AND sale.ExpressCode = '1' THEN 'รับเช็ค ( รอเคลียร์ )'
         WHEN sale.IsCheckIn = '4' THEN 'ผู้แทนจ่าย' 
    ELSE '' end AS xStatus,
    CASE WHEN sale.ExpressCode !='' then express.Express
    ELSE 'ผู้แทนจ่าย' end AS PayType ,
    CASE WHEN sale.IsCheckIn = '1' AND sale.ExpressCode IN(2,3,6) THEN '#01937C'
         WHEN sale.IsCheckIn = '1' AND sale.ExpressCode = '1' THEN '#01937C'
         WHEN sale.IsCheckIn = '3' AND sale.ExpressCode = '1' THEN '#FFC074'
         WHEN sale.IsCheckIn = '4' THEN '#01937C'
    ELSE '' end AS xStatusColor,
    sale.AreaCode
    FROM
    sale
    LEFT JOIN `check` ON `check`.ID = sale.CheckNo
    LEFT JOIN customer ON sale.Cus_Code = customer.Cus_Code
    LEFT JOIN express ON sale.ExpressCode = express.id
    WHERE
    (date(`check`.Check_ModifyDate) between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() )
    AND sale.AreaCode ='$AreaCode'
    AND sale.IsCheckIn IN('1','3','4') 
    
    UNION
    SELECT 
    sale_x.DocNo,
    `check`.Check_ModifyDate,
    customer.Cus_Code,
    customer.FName,
    IFNULL(sale_x.DocNoAcc,'')AS DocNoAcc,
    sale_x.Total- sale_x.DeductCN_Price + sale_x.Add_Money AS Total,
    CASE WHEN sale_x.ExpressCode !='' then express.Express
    ELSE 'ผู้แทนจ่าย' end AS PayType ,
    CASE WHEN sale_x.IsCheckIn = '1' AND sale_x.ExpressCode IN(2,3,6) THEN 'จ่ายแล้ว'
         WHEN sale_x.IsCheckIn = '1' AND sale_x.ExpressCode = '1' THEN 'รับเช็ค ( เคลียร์แล้ว )'
         WHEN sale_x.IsCheckIn = '3' AND sale_x.ExpressCode = '1' THEN 'รับเช็ค ( รอเคลียร์ )'
         WHEN sale_x.IsCheckIn = '4' THEN 'ผู้แทนจ่าย' 
    ELSE '' end AS xStatus,
    CASE WHEN sale_x.ExpressCode !='' then express.Express
    ELSE 'ผู้แทนจ่าย' end AS PayType ,
    CASE WHEN sale_x.IsCheckIn = '1' AND sale_x.ExpressCode IN(2,3,6) THEN '#01937C'
         WHEN sale_x.IsCheckIn = '1' AND sale_x.ExpressCode = '1' THEN '#01937C'
         WHEN sale_x.IsCheckIn = '3' AND sale_x.ExpressCode = '1' THEN '#FFC074'
         WHEN sale_x.IsCheckIn = '4' THEN '#01937C'
    ELSE '' end AS xStatusColor,
    sale_x.AreaCode
    FROM
    sale_x
    LEFT JOIN `check` ON `check`.ID = sale_x.CheckNo
    LEFT JOIN customer ON sale_x.Cus_Code = customer.Cus_Code
    LEFT JOIN express ON sale_x.ExpressCode = express.id
    WHERE
    (date(`check`.Check_ModifyDate) between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() )
    AND sale_x.AreaCode ='$AreaCode'
    AND sale_x.IsCheckIn IN('1','3','4') 
    ORDER BY DocNoAcc";
    $meQuery = mysqli_query($conn,$Sql);
    $Money1=0;
    $count=0;
    while ($Result = mysqli_fetch_assoc($meQuery)){
      $return[$count]['DocNo']		= $Result['DocNo'];
      $return[$count]['Check_ModifyDate']		= $Result['Check_ModifyDate'];
			$return[$count]['FName']		= $Result['FName'];
			$return[$count]['PayType']		= $Result['PayType'];
			$return[$count]['xStatus']		= $Result['xStatus'];
      $return[$count]['xStatusColor']		= $Result['xStatusColor'];
			$return[$count]['DocNoAcc']		= $Result['DocNoAcc'];
			$return[$count]['Total']		= $Result['Total'];
      $count++;
    }
    $return['status'] = "success";
		$return['form'] = "list1";
		$return['rCnt'] = $count;
    $return['msg'] = $sel+" : "+$AreaCode;
		echo json_encode($return);
		mysqli_close($conn);
		die;
  }
}

function list2($conn,$DATA)
{
    // mysqli_query($conn,"INSERT INTO (log) VALUES ('user :: password')");
  if (isset($DATA)) {
    $Sel = $DATA['Sel'];
    $AreaCode = $DATA['AreaCode'];

    switch($Sel){
      case "0": $Sel1 = "";break;
      case "1": $Sel1 = "AND (DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30) BETWEEN 1 AND 120";break;
      case "2": $Sel1 = "AND (DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30) BETWEEN 121 AND 180";break;
      case "3": $Sel1 = "AND (DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30) BETWEEN 181 AND 240";break;
      case "4": $Sel1 = "AND (DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30) BETWEEN 241 AND 360";break;
      case "5": $Sel1 = "AND (DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30) > 360";break;
    }

    switch($Sel){
      case "0": $Sel2 = "";break;
      case "1": $Sel2 = "AND (DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc)+ 30) BETWEEN 1 AND 120";break;
      case "2": $Sel2 = "AND (DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc)+ 30) BETWEEN 121 AND 180";break;
      case "3": $Sel2 = "AND (DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc)+ 30) BETWEEN 181 AND 240";break;
      case "4": $Sel2 = "AND (DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc)+ 30) BETWEEN 241 AND 360";break;
      case "5": $Sel2 = "AND (DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc)+ 30) > 360";break;
    }

    $Sql = "SELECT
    sale.DocNo,
    sale.DocNoAcc,
    customer.FName,
    IF (sale.AreaCode <> '',sale.AreaCode,customer.AreaCode) AS AreaCode,
    DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30 AS Day,
    sale.Total - sale.DeductCN_Price + sale.Add_Money AS Total
    FROM
      sale
    INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code
    LEFT JOIN checkinsub ON checkinsub.DocNoAcc = sale.DocNoAcc
    LEFT JOIN checkin ON checkin.NoDoc = checkinsub.NoDoc
    WHERE
      sale.AreaCode = '$AreaCode'
    AND sale.DocNoAcc != ''
    AND sale.IsCheckIn = 0
    AND (
      checkin.IsClear = 0
      OR checkin.IsClear IS NULL
    )
    AND sale.IsCancel = 0
    AND sale.IsCopy = 0
    AND sale.Cn = '0'
    AND sale.DocDateAcc BETWEEN ('2015-01-01') AND DATE(NOW())
    $Sel1

    UNION
    
    SELECT
    sale_x.DocNo,
    sale_x.DocNoAcc,
    customer.FName,
    IF (sale_x.AreaCode <> '',sale_x.AreaCode,customer.AreaCode) AS AreaCode,
    DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc)+ 30 AS Day,
    sale_x.Total - sale_x.DeductCN_Price + sale_x.Add_Money AS Total
    FROM
      sale_x
    INNER JOIN customer ON sale_x.Cus_Code = customer.Cus_Code
    LEFT JOIN checkinsub ON checkinsub.DocNoAcc = sale_x.DocNoAcc
    LEFT JOIN checkin ON checkin.NoDoc = checkinsub.NoDoc
    WHERE
      sale_x.AreaCode = '$AreaCode'
    AND sale_x.DocNoAcc != ''
    AND sale_x.IsCheckIn = 0
    AND (
      checkin.IsClear = 0
      OR checkin.IsClear IS NULL
    )
    AND sale_x.Sale_Status = 1
    AND sale_x.DocDateAcc BETWEEN ('2015-01-01') AND DATE(NOW())
    $Sel2

    ORDER BY Day DESC";
    $meQuery = mysqli_query($conn,$Sql);
    $Money1=0;
    $count=0;
    while ($Result = mysqli_fetch_assoc($meQuery)){
      $return[$count]['DocNo']		= $Result['DocNo'];
      $return[$count]['DocNoAcc']		= $Result['DocNoAcc'];
			$return[$count]['FName']		= $Result['FName'];
			$return[$count]['Day']		= $Result['Day'];
			$return[$count]['Total']		= $Result['Total'];
      $count++;
    }
    $return['status'] = "success";
		$return['form'] = "list2";
		$return['rCnt'] = $count;
    $return['msg'] = $Sql;
		echo json_encode($return);
		mysqli_close($conn);
		die;
  }
}

function list3($conn,$DATA)
{
    // mysqli_query($conn,"INSERT INTO (log) VALUES ('user :: password')");
  if (isset($DATA)) {
    $Sel = $DATA['Sel'];
    $AreaCode = $DATA['AreaCode'];

    $month  = date('m', time());
    $year  = date('Y', time());
    $m = (int)$month;

    $Sql = "SELECT
    collection_target_detail.DocNo,
    customer.Cus_Code,
    customer.FName,
    collection_target_detail.DocNoAcc,
    collection_target_detail.Total
    FROM
    collection_target_detail
    INNER JOIN customer ON customer.Cus_Code = collection_target_detail.Cus_Code
    WHERE
    collection_target_detail.xMonth ='$m'
    AND collection_target_detail.xYear = '$year'
    AND collection_target_detail.AreaCode = '$AreaCode'
    AND collection_target_detail.AreaCode !='PO00'";
    $meQuery = mysqli_query($conn,$Sql);
    $Money1=0;
    $count=0;
    while ($Result = mysqli_fetch_assoc($meQuery)){
      $return[$count]['DocNo']		= $Result['DocNo'];
      $return[$count]['DocNoAcc']		= $Result['DocNoAcc'];
			$return[$count]['FName']		= $Result['FName'];
			$return[$count]['Total']		= $Result['Total'];
      $count++;
    }
    $return['status'] = "success";
		$return['form'] = "list3";
		$return['rCnt'] = $count;
    $return['msg'] = $Sql;
		echo json_encode($return);
		mysqli_close($conn);
		die;
  }
}
?>