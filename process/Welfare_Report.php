<?php
  date_default_timezone_set("Asia/Bangkok");
  require '../connect.php';
  session_start();
  
  if (isset($_POST['DATA'])) {
    $data = $_POST['DATA'];
    $DATA = json_decode(str_replace('\"', '"', $data), true);
    if ($DATA['STATUS'] == 'SearchData') {
      SearchData($conn,$DATA);
    }
  }

  function SearchData($conn,$DATA){
    $Area   = $_SESSION["Area"];
    $SelMonth = $DATA["SelMonth"];
    $SelYear  = $DATA["SelYear"];


    $count = 0;
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

    $Sql = "SELECT
    sale.DocNo,
    sale.DocNoAcc,
    sale.Cus_Code,
    (
      SELECT
        SUM(dc.CmsB)
      FROM
        dallycall AS dc
      WHERE
        dc.DocNo = sale.DocNo
      AND dc.AreaCode = sale.AreaCode
      GROUP BY
        dc.DocNo
    ) AS BringTotal_Max,
    customer.FName,
    customer.BringWelfare,
    sale.IsCheckIn,
    sale.Bring1,
    sale.bFinish1,
    sale.Bring2,
    sale.bFinish2,
    sale.Bring3,
    sale.bFinish3,
    sale.Status_Finish_Bring,
    customer.AreaCode,
    sale.Status_Finish_Bring_Datetime
  FROM
    sale
  INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code
    WHERE sale.Status_Finish_Bring_Datetime BETWEEN '$sDate' AND '$eDate' ";

    $Sql .= "AND sale.Status_Finish_Bring = 1 ";
    $Sql .= "AND customer.AreaCode = '$Area' ";
  
  $Sql .= "UNION ";

  $Sql .= "SELECT
    sale_x.DocNo,
    sale_x.DocNoAcc,
    sale_x.Cus_Code,
    (
      SELECT
       SUM(dc.CmsB)
      FROM
       dallycall AS dc
      WHERE
       dc.DocNo = sale_x.DocNo
      AND dc.AreaCode = sale_x.AreaCode
      GROUP BY
       dc.DocNo
     ) AS BringTotal_Max,
    customer.FName,
    customer.BringWelfare,
    sale_x.IsCheckIn,
    sale_x.Bring1,
    sale_x.bFinish1,
    sale_x.Bring2,
    sale_x.bFinish2,
    sale_x.Bring3,
    sale_x.bFinish3,
    sale_x.Status_Finish_Bring,
    customer.AreaCode,
    sale_x.Status_Finish_Bring_Datetime
    FROM
     sale_x
    INNER JOIN customer ON sale_x.Cus_Code = customer.Cus_Code
    WHERE sale_x.Status_Finish_Bring_Datetime BETWEEN '$sDate' AND '$eDate' ";
    $Sql .= "AND sale_x.Status_Finish_Bring = 1 ";
    $Sql .= "AND customer.AreaCode = '$Area' ";

    $Sql .= "ORDER BY DocNo ASC";
    

    $meQuery = mysqli_query($conn, $Sql);
    while ($Result = mysqli_fetch_assoc($meQuery)) {
      $return[$count]['DocNo'] = $Result['DocNo'];
      $return[$count]['DocNo'] = $Result['DocNo'];
      $return[$count]['CusName'] = $Result['FName'];
      $return[$count]['DocNoAcc'] = $Result['DocNoAcc'];
      $return[$count]['Bring1'] = $Result['Bring1'];
      $return[$count]['Bring2'] = $Result['Bring2'];
      $count++;
    }


    $return['status'] = "success";
    $return['form'] = "SearchData";
    $return['rCnt'] = $count;
    
    $return['Sqlse'] = $Sqlse;
    $return['Sql'] = $Sql;
    echo json_encode($return);
    mysqli_close($conn);
    die;
  }
?>