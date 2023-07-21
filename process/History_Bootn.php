<?php
session_start();
require '../connect.php';
date_default_timezone_set("Asia/Bangkok");

if (!empty($_POST['FUNC_NAME'])) {
  if ($_POST['FUNC_NAME'] == 'get_Select_Area') {
    get_Select_Area($conn);
  } else if ($_POST['FUNC_NAME'] == 'Show_Data') {
    Show_Data($conn);
  } else if ($_POST['FUNC_NAME'] == 'show_Model_DetailDoc') {
    show_Model_DetailDoc($conn);
  } 
}

function get_Select_Area($conn)
{

  $Sql = "SELECT
              area.ID, 
              area.`Code`, 
              area.`Name`
            FROM
              area
              WHERE IsBooth = 1
              ORDER BY area.`Name` ASC
          ";

  $meQuery = mysqli_query($conn, $Sql);
  while ($row = mysqli_fetch_assoc($meQuery)) {
    $return[] = $row;
  }

  
  echo json_encode($return);
  mysqli_close($conn);
  die;
}

function Show_Data($conn)
{

    $Select_Area	= $_POST["Select_Area"];
    $Text_Customer	= $_POST["Text_Customer"];

    if($Select_Area == '000'){
        $where = "";
    }else if($Select_Area == '01'){
      $where = "AND (booth.AreaCodeCus = '' OR  booth.AreaCodeCus = Null)";
    }else{
      $where = "AND  booth.AreaCodeCus = '$Select_Area'";
    }
    $Sql = "SELECT
              booth.ID,
              booth.AreaCode,
              booth.CreateDate,
              booth.FnameCus,
              booth.InformantName,
              booth.UserName,
              booth.UrgencyLevel,
              employee.FName,
              employee.LName,
              booth.AreaCodeCus   
            FROM
              booth
              INNER JOIN employee ON booth.AreaCode = employee.AreaCode 
              WHERE booth.FnameCus LIKE '%$Text_Customer%'
              $where
              ORDER BY booth.CreateDate DESC  LIMIT 300  ";

  $meQuery = mysqli_query($conn, $Sql);
  while ($row = mysqli_fetch_assoc($meQuery)) {
    $return[] = $row;
  }
  // $return['sa'] = $Sql;

  echo json_encode($return);
  mysqli_close($conn);
  die;
}

function show_Model_DetailDoc($conn)
{

    $ID	= $_POST["ID"];


  $Sql_booth = "SELECT
              booth.AreaCode,
              booth.CreateDate,
              booth.FnameCus,
              booth.InformantName,
              booth.UserName,
              booth.UrgencyLevel,
              booth.PhoneNumber,
              booth.Note,
              employee.FName,
              employee.LName,
              booth.AreaCodeCus     
            FROM
              booth
              INNER JOIN employee ON booth.AreaCode = employee.AreaCode 
              WHERE booth.ID = '$ID'
          ";

  $meQuery_booth = mysqli_query($conn, $Sql_booth);
  while ($row_booth = mysqli_fetch_assoc($meQuery_booth)) {
    $return['booth'][] = $row_booth;
  }

  $Sql_booth_Items = "SELECT
                        booth_Items_detail.ID,
                        booth_Items_detail.ItemName,
                        booth_Items_detail.Detail 
                      FROM
                        booth_Items_detail
                        WHERE booth_Items_detail.BoothID = '$ID'
                      ";

  $meQuery_booth_Items = mysqli_query($conn, $Sql_booth_Items);
  while ($row_booth_Items = mysqli_fetch_assoc($meQuery_booth_Items)) {
  $return['booth_Items'][] = $row_booth_Items;
  }


  $Sql_bootn_department = "SELECT
                            bootn_department_detail.ID, 
                            bootn_department_detail.DepartmentName
                          FROM
                            bootn_department_detail
                          WHERE
                            bootn_department_detail.BoothID = '$ID'
                          ";

  $meQuery_bootn_department = mysqli_query($conn, $Sql_bootn_department);
  while ($row_bootn_department = mysqli_fetch_assoc($meQuery_bootn_department)) {
  $return['bootn_department'][] = $row_bootn_department;
  }
  // $return['sa'] = $Sql;

  echo json_encode($return);
  mysqli_close($conn);
  die;
}


