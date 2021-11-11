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
    $iCode 	= $DATA['iCode'];
    $val   	= $DATA['val'];
    $CusCode   	= $DATA['CusCode'];
        $Sql = "UPDATE itemorder SET isHidden = $val WHERE ItemCode = '$iCode' AND CusCode = '$CusCode'";
        mysqli_query($conn, $Sql);
     
        $return['status'] = "success";
        $return['form'] = "SaveData";
        $return['msg'] = "บันทึกสำเร็จ...";

        echo json_encode($return);
        mysqli_close($conn);
        die;

  }
?>