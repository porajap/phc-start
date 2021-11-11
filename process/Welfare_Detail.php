<?php
  require '../connect.php';

  if (isset($_POST['DATA'])) {
    $data = $_POST['DATA'];
    $DATA = json_decode(str_replace('\"', '"', $data), true);
    if ($DATA['STATUS'] == 'SaveData') {
      SaveData($conn,$DATA);
    }
  }

  function SaveData($conn,$DATA){
    $xDocNo 	= $DATA['xDocNo'];
    $xSel  = $DATA['xSel'];
    $xAmount  = round($DATA['xAmount'] == "" ? 0 : $DATA['xAmount']);
    $xIsCopy  = $DATA['xIsCopy'];
    $xCheckT  = $DATA['xCheckT'];
    if ($xCheckT == 's') {
        $Sql = "SELECT
        customer.BringWelfare,
        ( sale.Bring1 + sale.Bring2 + sale.Bring3 ) AS SumBring,
        (
        SELECT SUM( dc.CmsB )
        FROM dallycall AS dc
        WHERE dc.DocNo = sale.DocNo
        AND dc.AreaCode = sale.AreaCode 
        AND dc.AreaCode2 = '-' 
        AND sale.IsCopy = '0'
        GROUP BY dc.DocNo
        ) AS BringTotal_Max,
        (
        SELECT SUM( calcms2.CmsB )
        FROM calcms2 
        WHERE calcms2.DocNo = sale.DocNo
        AND calcms2.AreaCode = calcms2.AreaCode 
        GROUP BY calcms2.DocNo
        ) AS BringTotal_Max2,
        sale.bFinish1,
        sale.bFinish2,
        sale.bFinish3
        FROM sale
        INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code
        WHERE sale.DocNo = '$xDocNo'";
        $meQuery = mysqli_query($conn, $Sql);
        while ($Result = mysqli_fetch_assoc($meQuery)) {
            $SumBring = $Result['SumBring'];
            $bMax = $Result['BringTotal_Max2'] != "" ? $Result['BringTotal_Max2']: $Result['BringTotal_Max'];
            $Welfare = $Result['BringWelfare'];
            $bFinish1 = $Result['bFinish1'];
            $bFinish2 = $Result['bFinish2'];
            $bFinish3 = $Result['bFinish3'];
        }
    
        if ($bFinish1 == 0) {
            $sAmount = $xAmount;
        } elseif ($bFinish1 == 1 && $bFinish2 == 0) {
            $sAmount = ($xAmount + $SumBring);
        } elseif ($bFinish1 == 1 && $bFinish2 == 1 && $bFinish3 == 0) {
            $sAmount = ($xAmount + $SumBring);
        }
    
        if ($Welfare > 0) {
            $aMax = $bMax * ($Welfare/100);
        } else {
            $aMax = $bMax;
        }
        // echo "bMax: " . $bMax . ", ";
        //  echo "sAmount: " . $sAmount . ", ";
        //  echo "aMax: " . $aMax . ", ";
         
        if ($sAmount <= round($aMax)) {
            
            if ($xSel == 1) {
                $Sql = "UPDATE sale SET Bring1 = '$xAmount',Bring1_Datetime = NOW() WHERE DocNo = '$xDocNo'";
            } elseif ($xSel == 2) {
                $Sql = "UPDATE sale SET Bring2 = '$xAmount',Bring1_Datetime = NOW() WHERE DocNo = '$xDocNo'";
            } elseif ($xSel == 3) {
                $Sql = "UPDATE sale SET Bring3 = '$xAmount',Bring1_Datetime = NOW() WHERE DocNo = '$xDocNo'";
            }
            mysqli_query($conn, $Sql);
            $msg="บันทึกสำเร็จ...";
            $return['status'] = "success";
            $return['form'] = "SaveData";
            $return['msg'] = $msg;
        } else {
            $msg="ท่านได้เบิกเกินวงเงิน...";
            $return['status'] = "unsuccess";
            $return['form'] = "SaveData";
            $return['msg'] = $msg;
        }
    }else{
      $Sql = "SELECT
      customer.BringWelfare,
      ( sale_x.Bring1 + sale_x.Bring2 + sale_x.Bring3 ) AS SumBring,
      (
      SELECT SUM( dc.CmsB )
      FROM calcms2_x AS dc
      WHERE dc.DocNo = sale_x.DocNo
      AND dc.AreaCode = sale_x.AreaCode
      GROUP BY dc.DocNo
      ) AS BringTotal_Max,
      sale_x.bFinish1,
      sale_x.bFinish2,
      sale_x.bFinish3
      FROM sale_x
      INNER JOIN customer ON sale_x.Cus_Code = customer.Cus_Code
      WHERE sale_x.DocNo = '$xDocNo'";
      $meQuery = mysqli_query($conn, $Sql);
      while ($Result = mysqli_fetch_assoc($meQuery)) {
          $SumBring = $Result['SumBring'];
          $bMax = $Result['BringTotal_Max'];
          $Welfare = $Result['BringWelfare'];
          $bFinish1 = $Result['bFinish1'];
          $bFinish2 = $Result['bFinish2'];
          $bFinish3 = $Result['bFinish3'];
      }
  
      if ($bFinish1 == 0) {
          $sAmount = $xAmount;
      } elseif ($bFinish1 == 1 && $bFinish2 == 0) {
          $sAmount = ($xAmount + $SumBring);
      } elseif ($bFinish1 == 1 && $bFinish2 == 1 && $bFinish3 == 0) {
          $sAmount = ($xAmount + $SumBring);
      }
  
      if ($Welfare > 0) {
          $aMax = $bMax * ($Welfare/100);
      } else {
          $aMax = $bMax;
      }

      if ($sAmount < $aMax) {
          if ($xSel == 1) {
              $Sql = "UPDATE sale_x SET Bring1 = '$xAmount',Bring1_Datetime = NOW() WHERE DocNo = '$xDocNo'";
          } elseif ($xSel == 2) {
              $Sql = "UPDATE sale_x SET Bring2 = '$xAmount',Bring1_Datetime = NOW() WHERE DocNo = '$xDocNo'";
          } elseif ($xSel == 3) {
              $Sql = "UPDATE sale_x SET Bring3 = '$xAmount',Bring1_Datetime = NOW() WHERE DocNo = '$xDocNo'";
          }
          mysqli_query($conn, $Sql);
          $msg="บันทึกสำเร็จ...";
          $return['status'] = "success";
          $return['form'] = "SaveData";
          $return['msg'] = $msg;
      } else {
          $msg="ท่านได้เบิกเกินวงเงิน...";
          $return['status'] = "unsuccess";
          $return['form'] = "SaveData";
          $return['msg'] = $msg;
      }
    }
    echo json_encode($return);
    mysqli_close($conn);
    die;
  }
?>