<?php
  require '../connect.php';
  session_start();
  if (isset($_POST['DATA'])) {
    $data = $_POST['DATA'];
    $DATA = json_decode(str_replace('\"', '"', $data), true);
    if ($DATA['STATUS'] == 'SearchData') {
      SearchData($conn,$DATA);
    }else if ($DATA['STATUS'] == 'SaveWelfare') {
      SaveWelfare($conn,$DATA);
    }
  }

  function SearchData($conn,$DATA){

    $Area = $_SESSION['Area'];
    $xSel  = $DATA["xSel"];
    $Search  = $DATA["Search"];
    $lenSearch = strlen($Search);
    $count = 0;
    $Sql = "SELECT
    sale.DocNo,
    IFNULL(sale.DocNoAcc,'') AS DocNoAcc,
    sale.Cus_Code,
    customer.FName,
    (
    SELECT SUM( dc.CmsB )
    FROM dallycall AS dc
    WHERE dc.DocNo = sale.DocNo
    GROUP BY dc.DocNo
    ) AS BringTotal_Max,
    sale.IsCheckIn,
    sale.Bring1,
    sale.bFinish1,
    sale.Bring2,
    sale.bFinish2,
    sale.Bring3,
    sale.bFinish3,
    sale.Status_Finish_Bring 
    FROM sale
    INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code
    WHERE customer.AreaCode = '$Area' 
    AND ( sale.DocNo LIKE '%$Search%' OR sale.DocNoAcc LIKE '%$Search%' )
    AND 	(
        SELECT
            SUM(dc.CmsB)
        FROM
            dallycall AS dc
        WHERE
            dc.DocNo = sale.DocNo
        GROUP BY
            dc.DocNo
    ) > 0 ";
    if($xSel==0)
        $Sql .= "AND sale.bFinish1 = 0 AND sale.bFinish2 = 0 AND sale.bFinish3 = 0 
                 AND sale.Status_Finish_Bring = 0 ";
    else if($xSel==1)
        $Sql .= "AND (( sale.Bring1 > 0 ) OR ( sale.Bring2 > 0 ) OR ( sale.Bring3 > 0 )) 
                 AND sale.Status_Finish_Bring = 0 ";
    else if($xSel==2)
        $Sql .= "AND sale.Status_Finish_Bring = 1 ";

    if($lenSearch>0)    
      $Sql .= "ORDER BY sale.DocNo DESC";
    else
      $Sql .= "ORDER BY sale.DocNo DESC LIMIT 50";
    // $xSql = str_replace("'","",$Sql);
    // mysqli_query($conn, "INSERT INTO log (log) VALUES ('$xSql')");
    $meQuery = mysqli_query($conn, $Sql);
    while ($Result = mysqli_fetch_assoc($meQuery)) {
      $return[$count]['DocNo']         = $Result['DocNo'];
      $return[$count]['DocNoAcc']      = $Result['DocNoAcc'];
      $return[$count]['CusCode']       = $Result['Cus_Code'];
      $return[$count]['CusName']       = $Result['FName'];
      $return[$count]['bFinish1']      = $Result['bFinish1'];
      $return[$count]['bFinish2']      = $Result['bFinish2'];
      $return[$count]['bFinish3']      = $Result['bFinish3'];
      $return[$count]['Bring1']        = $Result['Bring1'];
      $return[$count]['Bring2']        = $Result['Bring2'];
      $return[$count]['Bring3']        = $Result['Bring3'];
      $return[$count]['Status_Finish_Bring'] = $Result['Status_Finish_Bring'];
      
      $return[$count]['BringMax'] = $Result['BringTotal_Max'];
      $return[$count]['IsCheckIn']      = $Result['IsCheckIn'];
      $count++;
    }
    $return['status'] = "success";
    $return['form'] = "SearchData";
    $return['rCnt'] = $count;
    echo json_encode($return);
    mysqli_close($conn);
    die;
  }

  function SaveWelfare($conn,$DATA){
    $id      = $DATA["id"];

    $count = 0;
    $Sql = "SELECT id,ssName,ssLocation,ssAddress1,ssAddress2 FROM br_dispenser_address WHERE id = $id";
    // mysqli_query($conn, "INSERT INTO log (log) VALUES ('$Sql')");
    $meQuery = mysqli_query($conn, $Sql);
    while ($Result = mysqli_fetch_assoc($meQuery)) {
      $return[$count]['id'] = $Result['id'];
      $return[$count]['ssName'] = $Result['ssName'];
      $return[$count]['FName'] = $Result['FName'];
      $return[$count]['BringTotal_Max'] = $Result['BringTotal_Max'];
      $return[$count]['ssAddress2'] = $Result['ssAddress2'];
      $count++;
    }
    $return['status'] = "success";
    $return['form'] = "getAddress";
    $return['rCnt'] = $count;
    echo json_encode($return);
    mysqli_close($conn);
    die;
  }
?>