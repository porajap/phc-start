<?php
  require '../connect.php';

  if (isset($_POST['DATA'])) {
    $data = $_POST['DATA'];
    $DATA = json_decode(str_replace('\"', '"', $data), true);
    if ($DATA['STATUS'] == 'LoadAddress') {
      LoadAddress($conn,$DATA);
    }else if ($DATA['STATUS'] == 'getAddress') {
      getAddress($conn,$DATA);
    }
  }

  
  function LoadAddress($conn,$DATA){
    $AreaCode = $DATA["AreaCode"];
    $CusCode  = $DATA["CusCode"];

    $count = 0;
    $Sql = "SELECT id,ssName,ssLocation,ssAddress1,ssAddress2 FROM br_dispenser_address WHERE AreaCode = '$AreaCode' AND CusCode = '$CusCode' ORDER BY id DESC";
    // $xSql = str_replace("'","",$Sql);
    // mysqli_query($conn, "INSERT INTO log (log) VALUES ('$xSql')");
  
    $meQuery = mysqli_query($conn, $Sql);
    while ($Result = mysqli_fetch_assoc($meQuery)) {
      $return[$count]['id'] = $Result['id'];
      $return[$count]['ssName'] = $Result['ssName'];
      $return[$count]['ssLocation'] = $Result['ssLocation'];
      $return[$count]['ssAddress1'] = $Result['ssAddress1'];
      $return[$count]['ssAddress2'] = $Result['ssAddress2'];
      $count++;
    }
    $return['status'] = "success";
    $return['form'] = "LoadAddress";
    $return['rCnt'] = $count;
    echo json_encode($return);
    mysqli_close($conn);
    die;
  }

  function getAddress($conn,$DATA){
    $id      = $DATA["id"];

    $count = 0;
    $Sql = "SELECT id,ssName,ssLocation,ssAddress1,ssAddress2 FROM br_dispenser_address WHERE id = $id";
    // mysqli_query($conn, "INSERT INTO log (log) VALUES ('$Sql')");

    $meQuery = mysqli_query($conn, $Sql);
    while ($Result = mysqli_fetch_assoc($meQuery)) {
      $return[$count]['id'] = $Result['id'];
      $return[$count]['ssName'] = $Result['ssName'];
      $return[$count]['ssLocation'] = $Result['ssLocation'];
      $return[$count]['ssAddress1'] = $Result['ssAddress1'];
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