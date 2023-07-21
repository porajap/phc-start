<?php
session_start();
require '../connect.php';
date_default_timezone_set("Asia/Bangkok");

if(isset($_POST['DATA']))
{
  $data = $_POST['DATA'];
  $DATA = json_decode(str_replace ('\"','"', $data), true);

  if ($DATA['STATUS'] == 'checklogin') {
    checklogin($conn, $DATA);
  }else if ($DATA['STATUS'] == 'chgPassword') {
    chgPassword($conn, $DATA);
  }else{
    $return['status'] = "error";
    $return['form'] = "OnLoadPage";
    echo json_encode($return);
    die;
  }
}else{
    $return['status'] = "error";
    $return['form'] = "checklogin";
	$return['msg'] = $DATA['STATUS'];
	echo json_encode($return);
	mysqli_close($conn);
  die;
}

function checklogin($conn,$DATA)
{
    // mysqli_query($conn,"INSERT INTO (log) VALUES ('user :: password')");
  if (isset($DATA)) {
    $user = $DATA['USERNAME'];
    $password = $DATA['PASSWORD'];
    

    // $password = md5($DATA['PASSWORD']);
    $boolean = false;
    $Count=0;
    $Sql = "SELECT Employee_Code,xUname,IsShowBoothDetail,CONCAT(FName,' ',LName) AS xName,AreaCode,isChart
    FROM employee WHERE xUname = '$user' AND xPword = '$password'";
    $meQuery = mysqli_query($conn,$Sql);
    while ($Result = mysqli_fetch_assoc($meQuery)) {
      $ID                   = $Result['ID'];
      $_SESSION['Em_Code']  = $Result['Employee_Code'];
      $_SESSION['xName']    = $Result['xName'];
      $_SESSION['xUname']    = $Result['xUname'];
      $_SESSION['Area']     = $Result['AreaCode'];
      $_SESSION['IsShowBoothDetail']     = $Result['IsShowBoothDetail'];
      $isChart              = $Result['isChart'];
      $Count++;
      $boolean = true;
    }
    $return['Sql'] = $Sql;
    if($boolean == true){
      $return['Count'] = $Count;
      $return['status'] = "success";
      $return['form'] = "chk_login";
      $return['msg'] = "เข้าสู่ระบบสำเร็จ";
      $return['isChart'] = $isChart;
      echo json_encode($return);
      mysqli_close($conn);
      die;
    }else{
      $return['status'] = "failed";
      $return['form'] = "chklogin";
      $return['msg'] = "$user or $password is Wrong!";
      echo json_encode($return);
      mysqli_close($conn);
      die;
    }
  }
}

function chgPassword($conn,$DATA)
{
    // mysqli_query($conn,"INSERT INTO (log) VALUES ('user :: password')");
  if (isset($DATA)) {
    $user = $DATA['USERNAME'];
    $password = $DATA['PASSWORD'];
    $newpassword = $DATA['NEWPASSWORD'];

    // $password = md5($DATA['PASSWORD']);
    $boolean = false;
    $Count=0;

    $Sql = "UPDATE employee SET xPword = '$newpassword' WHERE xUname = '$user' AND xPword = '$password'";
    mysqli_query($conn,$Sql);
    if(mysqli_affected_rows($conn) == 1){ 
      $boolean = true;
    }else{
      $boolean = false;
    }

    $return['Sql'] = "Affected rows: " . mysqli_affected_rows($conn) . " // " . $Sql;

    if($boolean == true){
      $return['Count'] = $Count;
      $return['status'] = "success";
      $return['form'] = "chgPassword";
      $return['msg'] = "บันทึกสำเร็จ...";
      echo json_encode($return);
      mysqli_close($conn);
      die;
    }else{
      $return['status'] = "failed";
      $return['form'] = "chgPassword";
      $return['msg'] = "$user or $password is Wrong!";
      echo json_encode($return);
      mysqli_close($conn);
      die;
    }
  }
}

function rand_string( $length ) {
  $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz@#$&*";
  $size = strlen( $chars );
  $str = '';
  for( $i = 0; $i < $length; $i++ ) {
    $str .= $chars[ rand( 0, $size - 1 ) ];
  }
  return $str;
}


?>