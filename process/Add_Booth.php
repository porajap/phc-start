<?php
session_start();
require '../connect.php';
date_default_timezone_set("Asia/Bangkok");

if (!empty($_POST['FUNC_NAME'])) {
  if ($_POST['FUNC_NAME'] == 'get_Select_Customer') {
    get_Select_Customer($conn);
  } else if ($_POST['FUNC_NAME'] == 'SaveAdd_Booth') {
    SaveAdd_Booth($conn);
  } 
}

function get_Select_Customer($conn)
{

  $Sql = "SELECT
            customer.Cus_Code, 
            customer.FName
            FROM
            customer
            WHERE customer.FName != '-'
            ORDER BY customer.FName ASC ";

  $meQuery = mysqli_query($conn, $Sql);
  while ($row = mysqli_fetch_assoc($meQuery)) {
    $return[] = $row;
  }

  
  echo json_encode($return);
  mysqli_close($conn);
  die;
}

function SaveAdd_Booth($conn)
{

    $xUname	= $_POST["xUname"];
    $Area	= $_POST["Area"];
    $Select_Customer	= $_POST["Select_Customer"];
    $Text_NameUser	= $_POST["Text_NameUser"];
    $Text_PhoneNumber	= $_POST["Text_PhoneNumber"];
    $RadioStu	= $_POST["RadioStu"];
    $Text_Note	= $_POST["Text_Note"];
    $NameCustomer	= $_POST["NameCustomer"];
    $NameProduct	= $_POST["NameProduct"];
    $DetailProduct	= $_POST["DetailProduct"];
    
    $Cus_Code	= $_POST["Cus_Code"];
    
    if($Cus_Code=="0"){
        $FnameCus = $Select_Customer;
        $AreaCodeCus = "";
    }else{
        $Sql_Customer = "SELECT
                            customer.FName,
                            customer.AreaCode AS AreaCodeCus
                            FROM
                            customer
                            WHERE  customer.Cus_Code ='$Select_Customer' 
                            ORDER BY customer.FName ASC
                            LIMIT 1
                        ";

        $meQuery_Customer = mysqli_query($conn, $Sql_Customer);
        $row_Customer = mysqli_fetch_assoc($meQuery_Customer);
        $FnameCus = $row_Customer['FName'];
        $AreaCodeCus = $row_Customer['AreaCodeCus'];
    }

 

  if($RadioStu=='very_urgent'){
    $num = 1;
  }

  if($RadioStu=='urgent'){
    $num = 2;
  }

  if($RadioStu=='normal'){
    $num = 3;
  }

  $Sql = " INSERT INTO booth 
            SET AreaCode = '$Area',
            CreateDate = NOW(),
            FnameCus = '$FnameCus',
            InformantName = '$Text_NameUser',
            PhoneNumber = '$Text_PhoneNumber',
            UrgencyLevel = '$RadioStu',
            UrgencyNum = '$num',
            Note = '$Text_Note',
            UserName = '$xUname',
            AreaCodeCus= '$AreaCodeCus',
            IsCancel = '0'
        ";

  $meQuery = mysqli_query($conn, $Sql);

    $SqlSELECT_ID = "SELECT
            booth.ID
            FROM
            booth
            WHERE booth.AreaCode = '$Area'
            AND booth.UserName = '$xUname'
            ORDER BY booth.CreateDate DESC
            LIMIT 1
          ";

  $meQuery_ID = mysqli_query($conn, $SqlSELECT_ID);
  $row_ID = mysqli_fetch_assoc($meQuery_ID);
  $booth_ID = $row_ID['ID'];


  // foreach($NameCustomer as $key => $value){

  //   $query_department_detail = "  INSERT INTO bootn_department_detail
  //                       SET 
  //                       BoothID = '$booth_ID',
  //                       DepartmentName = '$value'
  //                     ";

  //     mysqli_query($conn, $query_department_detail);

  // }

  // foreach($NameProduct as $key => $value){

  //   $query_detailCustomer = "  INSERT INTO booth_Items_detail
  //                       SET 
  //                       BoothID = '$booth_ID',
  //                       ItemName = '$value',
  //                       Detail = '$DetailProduct[$key]'
  //                     ";

  //     mysqli_query($conn, $query_detailCustomer);

  // }
  // $return['1'] =  $query_detailCustomer;
  // $return['2'] =  $query_department_detail;

  Add_Boothdetail($conn,$NameCustomer,$NameProduct,$DetailProduct,$booth_ID);

  // $return['3'] =  $SqlSELECT_ID;
  // echo json_encode($return);
  // mysqli_close($conn);
  // die;
}

function Add_Boothdetail($conn,$NameCustomer,$NameProduct,$DetailProduct,$booth_ID)
{



  foreach($NameCustomer as $key => $value){

    $query_department_detail = "  INSERT INTO bootn_department_detail
                        SET 
                        BoothID = '$booth_ID',
                        DepartmentName = '$value'
                      ";

      mysqli_query($conn, $query_department_detail);

  }

  foreach($NameProduct as $key => $value){

    $query_detailCustomer = "  INSERT INTO booth_Items_detail
                        SET 
                        BoothID = '$booth_ID',
                        ItemName = '$value',
                        Detail = '$DetailProduct[$key]'
                      ";

      mysqli_query($conn, $query_detailCustomer);

  }
  $return['1'] =  $query_detailCustomer;
  $return['2'] =  $query_department_detail;

  echo json_encode($return);
  mysqli_close($conn);
  die;
}


