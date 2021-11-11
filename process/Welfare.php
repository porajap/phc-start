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
    $Area   = $_SESSION["Area"];
    $xSel  = $DATA["xSel"];
    $Search  = $DATA["Search"];
    $lenSearch = strlen($Search);
    $return = array();
    $count = 0;
    $Sql = "SELECT
    sale.DocNo,
    IFNULL(sale.DocNoAcc,'') AS DocNoAcc,
    sale.Cus_Code AS CusCode,
    customer.FName AS CusName,
    (
    SELECT SUM( dc.CmsB )
    FROM dallycall AS dc
    WHERE dc.DocNo = sale.DocNo
    GROUP BY dc.DocNo
    ) AS BringMax,
    sale.IsCheckIn,
    sale.Bring1,
    sale.bFinish1,
    sale.Bring2,
    sale.bFinish2,
    sale.Bring3,
    sale.IsCopy,
    sale.bFinish3,
    sale.Status_Finish_Bring ,
    's' AS CheckT,
    CASE 
    WHEN sale.bFinish1 = 0 AND sale.bFinish2 = 0 AND sale.bFinish3 = 0 AND sale.Status_Finish_Bring = 0 AND sale.Bring1 = 0 AND sale.Bring2 = 0 AND sale.Bring3 = 0 THEN 'รอเบิก'
    WHEN (sale.Bring1 > 0 OR sale.Bring2 > 0 OR sale.Bring3 > 0) AND sale.Status_Finish_Bring = 0 THEN 'เบิกแต่ยังไม่ได้อนุมัติ'
    ELSE 'อนุมัติเรียบร้อย'
    END sel
    FROM sale
    INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code
    WHERE customer.AreaCode = '$Area' 
    AND  sale.IsCopy = 0
    AND ( sale.DocNo LIKE '%$Search%' OR sale.DocNoAcc LIKE '%$Search%' )
    AND 	(
        SELECT
            SUM(dc.CmsB)
        FROM
            dallycall AS dc
        WHERE
            dc.DocNo = sale.DocNo
        AND    
            dc.AreaCode = sale.AreaCode 
        AND
            dc.AreaCode2 = '-'    
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
      $return[] = $Result;
      $count++;
      
    }

    $Sql1 = "SELECT
    sale_x.DocNo,
    IFNULL(sale_x.DocNoAcc,'') AS DocNoAcc,
    sale_x.Cus_Code AS CusCode,
    customer.FName AS CusName,
    (
    SELECT SUM( dc.CmsB )
    FROM calcms2_x AS dc
    WHERE dc.DocNo = sale_x.DocNo
    GROUP BY dc.DocNo
    ) AS BringMax,
    sale_x.IsCheckIn,
    sale_x.Bring1,
    sale_x.bFinish1,
    sale_x.Bring2,
    sale_x.bFinish2,
    sale_x.Bring3,
    sale_x.bFinish3,
    sale_x.IsCopy,
    sale_x.Status_Finish_Bring ,
    'x' AS CheckT,
    CASE 
    WHEN sale_x.bFinish1 = 0 AND sale_x.bFinish2 = 0 AND sale_x.bFinish3 = 0 AND sale_x.Status_Finish_Bring = 0 AND sale_x.Bring1 = 0 AND sale_x.Bring2 = 0 AND sale_x.Bring3 = 0 THEN 'รอเบิก'
    WHEN (sale_x.Bring1 > 0 OR sale_x.Bring2 > 0 OR sale_x.Bring3 > 0) AND sale_x.Status_Finish_Bring = 0 THEN 'เบิกแต่ยังไม่ได้อนุมัติ'
    ELSE 'อนุมัติเรียบร้อย'
    END sel
    FROM sale_x
    INNER JOIN customer ON sale_x.Cus_Code = customer.Cus_Code
    WHERE customer.AreaCode = '$Area' 
    AND ( sale_x.DocNo LIKE '%$Search%' OR sale_x.DocNoAcc LIKE '%$Search%' )
    AND 	(
        SELECT
            SUM(dc.CmsB)
        FROM
            calcms2_x AS dc
        WHERE
            dc.DocNo = sale_x.DocNo
        AND    
            dc.AreaCode = sale_x.AreaCode  
        GROUP BY
            dc.DocNo
    ) > 0 ";
    if($xSel==0)
        $Sql1 .= "AND sale_x.bFinish1 = 0 AND sale_x.bFinish2 = 0 AND sale_x.bFinish3 = 0 
                 AND sale_x.Status_Finish_Bring = 0 ";
    else if($xSel==1)
        $Sql1 .= "AND (( sale_x.Bring1 > 0 ) OR ( sale_x.Bring2 > 0 ) OR ( sale_x.Bring3 > 0 )) 
                 AND sale_x.Status_Finish_Bring = 0 ";
    else if($xSel==2)
        $Sql1 .= "AND sale_x.Status_Finish_Bring = 1 ";

    if($lenSearch>0)    
      $Sql1 .= "ORDER BY sale_x.DocNo DESC";
    else
      $Sql1 .= "ORDER BY sale_x.DocNo DESC LIMIT 50";
    // $xSql = str_replace("'","",$Sql);
    // mysqli_query($conn, "INSERT INTO log (log) VALUES ('$xSql')");
    $meQuery = mysqli_query($conn, $Sql1);
    while ($Result = mysqli_fetch_assoc($meQuery)) {
      $return[] = $Result;
      $count++;
    }

    ksort($return);
    // for($x = 0; $x < $count; $x++) {
    //   $myArray = explode(',',$ar[$x]);
    //   $return[$x]['DocNo']         = $myArray[0];
    //   $return[$x]['DocNoAcc']      = $myArray[1];
    //   $return[$x]['CusCode']       = $myArray[2];
    //   $return[$x]['CusName']       = $myArray[3];
    //   $return[$x]['bFinish1']      = $myArray[4];
    //   $return[$x]['bFinish2']      = $myArray[5];
    //   $return[$x]['bFinish3']      = $myArray[6];
    //   $return[$x]['Bring1']        = $myArray[7];
    //   $return[$x]['Bring2']        = $myArray[8];
    //   $return[$x]['Bring3']        = $myArray[9];
    //   $return[$x]['Status_Finish_Bring'] = $myArray[10];
      
    //   $return[$x]['BringMax']      = $myArray[11];
    //   $return[$x]['IsCheckIn']     = $myArray[12];
    //   $return[$x]['CheckT']        = $myArray[13];
    // }

    $return['status'] = "success";
    $return['form'] = "SearchData";
    $return['rCnt'] = $count;
    $return['Sql'] = $Sql;
    $return['Sql1'] = $Sql1;
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