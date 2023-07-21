<?php
session_start();
require '../connect.php';
date_default_timezone_set("Asia/Bangkok");

if (!empty($_POST['FUNC_NAME'])) {
  if ($_POST['FUNC_NAME'] == 'SaveEdit') {
    SaveEdit($conn);
  } else if ($_POST['FUNC_NAME'] == 'SaveDoc') {
    SaveDoc($conn);
  } else if ($_POST['FUNC_NAME'] == 'deleteData') {
    deleteData($conn);
  } else if ($_POST['FUNC_NAME'] == 'addDetail') {
    addDetail($conn);
  }else if ($_POST['FUNC_NAME'] == 'showDateDetail') {
    showDateDetail($conn);
  }else if ($_POST['FUNC_NAME'] == 'SaveAdd_Docdetail') {
    SaveAdd_Docdetail($conn);
  }
  
}

function showDateDetail($conn)
{

  $DocNoP	= $_POST["DocNoPs"];
 
  $Sql = "SELECT
            acc_delegate.RowId, 
            acc_delegate.DocNo, 
            acc_delegate.Ispay, 
            acc_delegate.Sumtotal, 
            acc_delegate.img_slip, 
            acc_delegate.img_slip2,
            acc_delegate.Bank, 
            acc_delegate.branch_Bank, 
            DATE_FORMAT(acc_delegate.dateBank,'%d-%m-%Y') AS dateBank,
            acc_delegate.img_tax, 
            acc_delegate.TaxPay, 
            acc_delegate.Sumtotal_Tax, 
            acc_delegate.TaxType,
            acc_delegate.IsStatusTax,
            acc_delegate.IsStatus,
            acc_delegate.check_number,
            acc_delegate.SlipPay,
            acc_delegate.Type_sum
            FROM
            acc_delegate
            WHERE acc_delegate.DocNo='$DocNoP'
          ";

  $meQuery = mysqli_query($conn, $Sql);
  while ($row = mysqli_fetch_assoc($meQuery)) {
    $return[] = $row;
  }

  
  echo json_encode($return);
  mysqli_close($conn);
  die;
}


function SaveEdit($conn)
{
    $DocNoP	= $_POST["DocNoP"];
    $Radiopay	= $_POST["Radiopay"];
		$imageSlip	= $_POST["imageSlip"];
		$data_imageSlip	= $_POST["data_imageSlip"];
    $imageSlip2	= $_POST["imageSlip2"];
		$data_imageSlip2	= $_POST["data_imageSlip2"];

		$Select_Bank	= $_POST["Select_Bank"];
		$Text_branch	= $_POST["Text_branch"];
		$txt_dateBank	= $_POST["txt_dateBank"];
		$Text_total	= $_POST["Text_total"];
    $Text_total	= str_replace(",","",$Text_total);

		$imageTax	= $_POST["imageTax"];
		$data_imageTax	= $_POST["data_imageTax"];
		$Text_taxpay	= $_POST["Text_taxpay"];
    $Text_taxpay	= str_replace(",","",$Text_taxpay);

		$Text_totaltax	= $_POST["Text_totaltax"];
		$Radiotax	= $_POST["Radiotax"];
    $Cus_Code	= $_POST["Cus_Code"];
		$Area	= $_POST["Area"];

    $text_imageSlip	= $_POST["text_imageSlip"];
    $text_imageSlip2	= $_POST["text_imageSlip2"];
    $text_imageTax	= $_POST["text_imageTax"];
    $Text_number	= $_POST["Text_number"];
    $Text_total_check	= $_POST["Text_total_check"];

    $text_sum_tax	= $_POST["text_sum_tax"];
    $text_sum_tax	= str_replace(",","",$text_sum_tax);

    $Radio_Sum	= $_POST["Radio_Sum"];

    if($text_imageSlip == ""){

      $random = rand(00000, 99999);
      $imageSlip_now = "PHC_".$random. ".png";

      include("gen_thumbnail.php");

    //---------------------------------------------------------------------------------------------
    if ($_FILES['imageSlip'] != "") {
      // if($imageSlip != ""){
      //   unlink('../imageSlip/' . $imageSlip);
      // }
      // copy($_FILES['imageSlip']['tmp_name'], '../imageSlip/' . $imageSlip_now);
  
      // $imageSlip_name = $imageSlip_now;


      if($imageSlip != ""){
        unlink('../imageSlip/' . $imageSlip);
      }
      copy($_FILES['imageSlip']['tmp_name'], '../imageSlip/' . $imageSlip_now);
 
  
     
  
      $cfg_thumb =  (object) array(
        "source" => "../imageSlip/" . $imageSlip_now,                // ตำแหน่งและชื่อไฟล์ต้นฉบับ
        "destination" => "../imageSlip/" . $imageSlip_now,   // ตำแแหน่งและชื่อไฟล์ที่สร้างใหม่ ถ้าเลือกสร้างเป็นไฟล์ใหม่
        "width" => 500,         //  กำหนดความกว้างรูปใหม่
        "height" => 500,       //  กำหนดความสูงรูปใหม่
        "background" => "#fff",    // กำหนดสีพื้นหลังรูปใหม่ (#FF0000) ถ้าไม่กำหนดและ เป็น gif หรือ png จะแสดงเป็นโปร่งใส
        "output" => "",        //  กำหนดนามสกุลไฟล์ใหม่ jpg | gif หรือ png ถ้าไม่กำหนด จะใช้ค่าเริ่มต้นจากต้นฉบับ
        "show" => 0,           //  แสดงเป็นรูปภาพ หรือสร้างเป็นไฟล์ 0=สร้างเป็นไฟล์ | 1=แสดงเป็นรูปภาพ
        "crop" => 1                //  กำหนด crop หรือ ไม่ 0=crop | 1=crop
      );
      createthumb(
        $cfg_thumb->source,
        $cfg_thumb->destination,
        $cfg_thumb->width,
        $cfg_thumb->height,
        $cfg_thumb->background,
        $cfg_thumb->output,
        $cfg_thumb->show,
        $cfg_thumb->crop
      );
      } else {
        if ($data_imageSlip == "default") {

          if($imageSlip != ""){
          unlink('../imageSlip/' . $imageSlip);
          }

        $imageSlip_name = "";
        }
      }
  }else {
    $imageSlip_name = $text_imageSlip;
  }

  //--------------------------------------------------------------------------------------------------------------
  if($text_imageSlip2 == ""){
    $random2 = rand(00000, 99999);
    $imageSlip_now2 = "PHC_".$random2. ".png";
     if ($_FILES['imageSlip2'] != "") {
       if($imageSlip2 != ""){
         unlink('../imageSlip/' . $imageSlip2);
       }
       copy($_FILES['imageSlip2']['tmp_name'], '../imageSlip/' . $imageSlip_now2);
    
        $imageSlip_name2 = $imageSlip_now2;
    
       // $cfg_thumb =  (object) array(
       //   "source" => "../imageSlip/" . $imageSlip_now2,                // ตำแหน่งและชื่อไฟล์ต้นฉบับ
       //   "destination" => "../imageSlip/" . $imageSlip_now2,   // ตำแแหน่งและชื่อไฟล์ที่สร้างใหม่ ถ้าเลือกสร้างเป็นไฟล์ใหม่
       //   "width" => 500,         //  กำหนดความกว้างรูปใหม่
       //   "height" => 500,       //  กำหนดความสูงรูปใหม่
       //   "background" => "#fff",    // กำหนดสีพื้นหลังรูปใหม่ (#FF0000) ถ้าไม่กำหนดและ เป็น gif หรือ png จะแสดงเป็นโปร่งใส
       //   "output" => "",        //  กำหนดนามสกุลไฟล์ใหม่ jpg | gif หรือ png ถ้าไม่กำหนด จะใช้ค่าเริ่มต้นจากต้นฉบับ
       //   "show" => 0,           //  แสดงเป็นรูปภาพ หรือสร้างเป็นไฟล์ 0=สร้างเป็นไฟล์ | 1=แสดงเป็นรูปภาพ
       //   "crop" => 1                //  กำหนด crop หรือ ไม่ 0=crop | 1=crop
       // );
       // createthumb(
       //   $cfg_thumb->source,
       //   $cfg_thumb->destination,
       //   $cfg_thumb->width,
       //   $cfg_thumb->height,
       //   $cfg_thumb->background,
       //   $cfg_thumb->output,
       //   $cfg_thumb->show,
       //   $cfg_thumb->crop
       // );
       } else {
         if ($data_imageSlip2 == "default") {
   
           if($imageSlip2 != ""){
           unlink('../imageSlip/' . $imageSlip2);
           }
   
         $imageSlip_name2 = "";
         }
       }
  }else {
    $imageSlip_name2 = $text_imageSlip2;
  }
 //---------------------------------------------------------------------------------------------
 if($text_imageTax == ""){

    $random2 = rand(00000, 99999);
    $imageTax_now = "PHCTAX_".$random2. ".png";

    if ($_FILES['imageTax'] != "") {
      if($imageTax != ""){
        unlink('../imageSlip/' . $imageTax);
      }
      copy($_FILES['imageTax']['tmp_name'], '../imageSlip/' . $imageTax_now);
   
       $imageTax_name = $imageTax_now;
   
      // $cfg_thumb =  (object) array(
      //   "source" => "../imageSlip/" . $imageTax_now,                // ตำแหน่งและชื่อไฟล์ต้นฉบับ
      //   "destination" => "../imageSlip/" . $imageTax_now,   // ตำแแหน่งและชื่อไฟล์ที่สร้างใหม่ ถ้าเลือกสร้างเป็นไฟล์ใหม่
      //   "width" => 500,         //  กำหนดความกว้างรูปใหม่
      //   "height" => 500,       //  กำหนดความสูงรูปใหม่
      //   "background" => "#fff",    // กำหนดสีพื้นหลังรูปใหม่ (#FF0000) ถ้าไม่กำหนดและ เป็น gif หรือ png จะแสดงเป็นโปร่งใส
      //   "output" => "",        //  กำหนดนามสกุลไฟล์ใหม่ jpg | gif หรือ png ถ้าไม่กำหนด จะใช้ค่าเริ่มต้นจากต้นฉบับ
      //   "show" => 0,           //  แสดงเป็นรูปภาพ หรือสร้างเป็นไฟล์ 0=สร้างเป็นไฟล์ | 1=แสดงเป็นรูปภาพ
      //   "crop" => 1                //  กำหนด crop หรือ ไม่ 0=crop | 1=crop
      // );
      // createthumb(
      //   $cfg_thumb->source,
      //   $cfg_thumb->destination,
      //   $cfg_thumb->width,
      //   $cfg_thumb->height,
      //   $cfg_thumb->background,
      //   $cfg_thumb->output,
      //   $cfg_thumb->show,
      //   $cfg_thumb->crop
      // );
      } else {
        if ($data_imageTax == "default") {
          if($imageTax != ""){
          unlink('../imageSlip/' . $imageTax);
          }
  
        $imageTax_name = "";
        }
      }
    }else {
      $imageTax_name = $text_imageTax;
    }
    $txt_dateBank = explode("-", $txt_dateBank);
    $txt_dateBank = $txt_dateBank[2].'-'.$txt_dateBank[1].'-'.$txt_dateBank[0];

        $query = "  UPDATE acc_delegate 
                    SET DocDate = DATE(NOW()),
                        Ispay = '$Radiopay',
                        Sumtotal = '$Text_total',
                        img_slip = '$imageSlip_name',
                        img_slip2 = '$imageSlip_name2',
                        Bank = '$Select_Bank',
                        branch_Bank = '$Text_branch',
                        dateBank = '$txt_dateBank',
                        img_tax = '$imageTax_name',
                        TaxPay = '$text_sum_tax',
                        Sumtotal_Tax = '$Text_totaltax',
                        TaxType = '$Radiotax',
                        QtyDoc = '0',
                        Cus_Code = '$Cus_Code',
                        AreaCode = '$Area',
                        check_number = '$Text_number',
                        SlipPay = '$Text_total_check',
                        Type_sum = '$Radio_Sum' 
                        WHERE DocNo = '$DocNoP'
                  ";

      if(mysqli_query($conn, $query)){
        $return = $DocNoP;
      }else{
        $return = "0";
      }
    

  echo $return;
  mysqli_close($conn);
  die;
}

function SaveDoc($conn)
{

    $Radiopay	= $_POST["Radiopay"];
		$imageSlip	= $_POST["imageSlip"];
		$data_imageSlip	= $_POST["data_imageSlip"];
    $imageSlip2	= $_POST["imageSlip2"];
		$data_imageSlip2	= $_POST["data_imageSlip2"];

		$Select_Bank	= $_POST["Select_Bank"];
		$Text_branch	= $_POST["Text_branch"];
		$txt_dateBank	= $_POST["txt_dateBank"];
		$Text_total	= $_POST["Text_total"];
    $Text_total	= str_replace(",","",$Text_total);

		$imageTax	= $_POST["imageTax"];
		$data_imageTax	= $_POST["data_imageTax"];
		$Text_taxpay	= $_POST["Text_taxpay"];
    $Text_taxpay	= str_replace(",","",$Text_taxpay);

		$Text_totaltax	= $_POST["Text_totaltax"];
		$Radiotax	= $_POST["Radiotax"];
    $Cus_Code	= $_POST["Cus_Code"];
		$Area	= $_POST["Area"];
    $Text_number	= $_POST["Text_number"];
    $Text_total_check	= $_POST["Text_total_check"];

    
    $Radio_Sum	= $_POST["Radio_Sum"];
    $text_sum_tax	= $_POST["text_sum_tax"];
    $text_sum_tax	= str_replace(",","",$text_sum_tax);

    $random = rand(00000, 99999);
		$imageSlip_now = "PHC_".$random. ".png";

		include("gen_thumbnail.php");

   //---------------------------------------------------------------------------------------------
   if ($_FILES['imageSlip'] != "") {
    if($imageSlip != ""){
      unlink('../imageSlip/' . $imageSlip);
    }
    copy($_FILES['imageSlip']['tmp_name'], '../imageSlip/' . $imageSlip_now);
 
     $imageSlip_name = $imageSlip_now;
 
    // $cfg_thumb =  (object) array(
    //   "source" => "../imageSlip/" . $imageSlip_now,                // ตำแหน่งและชื่อไฟล์ต้นฉบับ
    //   "destination" => "../imageSlip/" . $imageSlip_now,   // ตำแแหน่งและชื่อไฟล์ที่สร้างใหม่ ถ้าเลือกสร้างเป็นไฟล์ใหม่
    //   "width" => 500,         //  กำหนดความกว้างรูปใหม่
    //   "height" => 500,       //  กำหนดความสูงรูปใหม่
    //   "background" => "#fff",    // กำหนดสีพื้นหลังรูปใหม่ (#FF0000) ถ้าไม่กำหนดและ เป็น gif หรือ png จะแสดงเป็นโปร่งใส
    //   "output" => "",        //  กำหนดนามสกุลไฟล์ใหม่ jpg | gif หรือ png ถ้าไม่กำหนด จะใช้ค่าเริ่มต้นจากต้นฉบับ
    //   "show" => 0,           //  แสดงเป็นรูปภาพ หรือสร้างเป็นไฟล์ 0=สร้างเป็นไฟล์ | 1=แสดงเป็นรูปภาพ
    //   "crop" => 1                //  กำหนด crop หรือ ไม่ 0=crop | 1=crop
    // );
    // createthumb(
    //   $cfg_thumb->source,
    //   $cfg_thumb->destination,
    //   $cfg_thumb->width,
    //   $cfg_thumb->height,
    //   $cfg_thumb->background,
    //   $cfg_thumb->output,
    //   $cfg_thumb->show,
    //   $cfg_thumb->crop
    // );
    } else {
      if ($data_imageSlip == "default") {

        if($imageSlip != ""){
        unlink('../imageSlip/' . $imageSlip);
        }

      $imageSlip_name = "";
      }
    }
 //---------------------------------------------------------------------------------------------
 $random2 = rand(00000, 99999);
 $imageSlip_now2 = "PHC_".$random2. ".png";
    if ($_FILES['imageSlip2'] != "") {
      if($imageSlip2 != ""){
        unlink('../imageSlip/' . $imageSlip2);
      }
      copy($_FILES['imageSlip2']['tmp_name'], '../imageSlip/' . $imageSlip_now2);
   
       $imageSlip_name2 = $imageSlip_now2;
   
      // $cfg_thumb =  (object) array(
      //   "source" => "../imageSlip/" . $imageSlip_now2,                // ตำแหน่งและชื่อไฟล์ต้นฉบับ
      //   "destination" => "../imageSlip/" . $imageSlip_now2,   // ตำแแหน่งและชื่อไฟล์ที่สร้างใหม่ ถ้าเลือกสร้างเป็นไฟล์ใหม่
      //   "width" => 500,         //  กำหนดความกว้างรูปใหม่
      //   "height" => 500,       //  กำหนดความสูงรูปใหม่
      //   "background" => "#fff",    // กำหนดสีพื้นหลังรูปใหม่ (#FF0000) ถ้าไม่กำหนดและ เป็น gif หรือ png จะแสดงเป็นโปร่งใส
      //   "output" => "",        //  กำหนดนามสกุลไฟล์ใหม่ jpg | gif หรือ png ถ้าไม่กำหนด จะใช้ค่าเริ่มต้นจากต้นฉบับ
      //   "show" => 0,           //  แสดงเป็นรูปภาพ หรือสร้างเป็นไฟล์ 0=สร้างเป็นไฟล์ | 1=แสดงเป็นรูปภาพ
      //   "crop" => 1                //  กำหนด crop หรือ ไม่ 0=crop | 1=crop
      // );
      // createthumb(
      //   $cfg_thumb->source,
      //   $cfg_thumb->destination,
      //   $cfg_thumb->width,
      //   $cfg_thumb->height,
      //   $cfg_thumb->background,
      //   $cfg_thumb->output,
      //   $cfg_thumb->show,
      //   $cfg_thumb->crop
      // );
      } else {
        if ($data_imageSlip2 == "default") {
  
          if($imageSlip2 != ""){
          unlink('../imageSlip/' . $imageSlip2);
          }
  
        $imageSlip_name2 = "";
        }
      }
   //---------------------------------------------------------------------------------------------

    $random2 = rand(00000, 99999);
    $imageTax_now = "PHCTAX_".$random2. ".png";

    if ($_FILES['imageTax'] != "") {
      if($imageTax != ""){
        unlink('../imageSlip/' . $imageTax);
      }
      copy($_FILES['imageTax']['tmp_name'], '../imageSlip/' . $imageTax_now);
   
       $imageTax_name = $imageTax_now;
   
      // $cfg_thumb =  (object) array(
      //   "source" => "../imageSlip/" . $imageTax_now,                // ตำแหน่งและชื่อไฟล์ต้นฉบับ
      //   "destination" => "../imageSlip/" . $imageTax_now,   // ตำแแหน่งและชื่อไฟล์ที่สร้างใหม่ ถ้าเลือกสร้างเป็นไฟล์ใหม่
      //   "width" => 500,         //  กำหนดความกว้างรูปใหม่
      //   "height" => 500,       //  กำหนดความสูงรูปใหม่
      //   "background" => "#fff",    // กำหนดสีพื้นหลังรูปใหม่ (#FF0000) ถ้าไม่กำหนดและ เป็น gif หรือ png จะแสดงเป็นโปร่งใส
      //   "output" => "",        //  กำหนดนามสกุลไฟล์ใหม่ jpg | gif หรือ png ถ้าไม่กำหนด จะใช้ค่าเริ่มต้นจากต้นฉบับ
      //   "show" => 0,           //  แสดงเป็นรูปภาพ หรือสร้างเป็นไฟล์ 0=สร้างเป็นไฟล์ | 1=แสดงเป็นรูปภาพ
      //   "crop" => 1                //  กำหนด crop หรือ ไม่ 0=crop | 1=crop
      // );
      // createthumb(
      //   $cfg_thumb->source,
      //   $cfg_thumb->destination,
      //   $cfg_thumb->width,
      //   $cfg_thumb->height,
      //   $cfg_thumb->background,
      //   $cfg_thumb->output,
      //   $cfg_thumb->show,
      //   $cfg_thumb->crop
      // );
      } else {
        if ($data_imageTax == "default") {
          if($imageTax != ""){
          unlink('../imageSlip/' . $imageTax);
          }
  
        $imageTax_name = "";
        }
      }
   //---------------------------------------------------------------------------------------------

   $Sql = "SELECT
              CONCAT(
                'PHC',
                SUBSTRING( YEAR ( DATE( NOW())), 3, 4 ),
                LPAD( MONTH ( DATE( NOW())), 2, 0 ),
                '-',
              LPAD( ( COALESCE ( MAX( CONVERT ( SUBSTRING( DocNo, 11, 5 ), UNSIGNED INTEGER )), 0 )+ 1 ), 6, 0 )) AS DocNo 
            FROM
              acc_delegate 
            WHERE
              DocNo LIKE CONCAT(
                'PHC',
                SUBSTRING( YEAR ( DATE( NOW())), 3, 4 ),
                LPAD( MONTH ( DATE( NOW())), 2, 0 ),
                '%' 
              ) 
            ORDER BY
              DocNo DESC 
              LIMIT 1";

		$meQuery = mysqli_query($conn, $Sql);
		$Result = mysqli_fetch_assoc($meQuery);
    $DocNo = $Result['DocNo'];


    $txt_dateBank = explode("-", $txt_dateBank);
    $txt_dateBank = $txt_dateBank[2].'-'.$txt_dateBank[1].'-'.$txt_dateBank[0];

        $query = "  INSERT INTO acc_delegate 
                    SET DocNo = '$DocNo',
                        DocDate = DATE(NOW()),
                        IsStatus = '1',
                        IsCancel = '0',
                        Ispay = '$Radiopay',
                        Sumtotal = '$Text_total',
                        img_slip = '$imageSlip_name',
                        img_slip2 = '$imageSlip_name2',
                        Bank = '$Select_Bank',
                        branch_Bank = '$Text_branch',
                        dateBank = '$txt_dateBank',
                        img_tax = '$imageTax_name',
                        TaxPay = '$text_sum_tax',
                        Sumtotal_Tax = '$Text_totaltax',
                        TaxType = '$Radiotax',
                        QtyDoc = '0',
                        Cus_Code = '$Cus_Code',
                        AreaCode = '$Area',
                        IsStatusTax = '1',
                        check_number = '$Text_number',
                        SlipPay = '$Text_total_check',
                        Type_sum = '$Radio_Sum'
                        
                  ";

      if(mysqli_query($conn, $query)){
        $return = $DocNo;
      }else{
        $return = "0";
      }
    

  echo $return;
  mysqli_close($conn);
  die;
}


function addDetail($conn)
{

    $DocNo_delegate	= $_POST["DocNo"];
		$DocNO_sale	= $_POST["DocNO_sale"];
		$amount	= $_POST["amount"];
    $Cus_Code	= $_POST["Cus_Code"];
    $Area	= $_POST["Area"];

    $count = 0;
    $count_bill = 0;
    foreach($DocNO_sale as $key => $value){
      $Sql = "SELECT
                sale.DocNo,
                sale.DocNoAcc,
                sale.Cus_Code,
                customer.FName,
                sale.IsCheckIn,
                  sale.Total - sale.DeductCN_Price + sale.Add_Money  AS Total,
                customer.AreaCode,
                  sale.IsCopy,
                  DATE(sale.DocDate) AS DocDate
              FROM
                sale
              INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code
                WHERE sale.IsCopy = 0
              AND customer.AreaCode = '$Area'
                AND customer.Cus_Code='$Cus_Code'
                AND sale.IsCheckIn=0
                AND sale.DocNoAcc IS NOT NULL
                AND sale.Sale_Status=1
                AND sale.DocNoAcc = '$value'
              UNION
              SELECT
                sale_x.DocNo,
                sale_x.DocNoAcc,
                sale_x.Cus_Code,
                customer.FName,
                sale_x.IsCheckIn,
                  sale_x.Total - sale_x.DeductCN_Price + sale_x.Add_Money  AS Total,
                customer.AreaCode,
                  sale_x.IsCopy,
                  DATE(sale_x.DocDate) AS DocDate
                FROM
                sale_x
                INNER JOIN customer ON sale_x.Cus_Code = customer.Cus_Code
                WHERE sale_x.IsCopy <> 0
                AND customer.AreaCode = '$Area'
                AND customer.Cus_Code='$Cus_Code'
                AND sale_x.IsCheckIn=0
                AND sale_x.DocNoAcc IS NOT NULL
                AND sale_x.Sale_Status=1
                AND sale_x.DocNoAcc = '$value' ";
		$meQuery = mysqli_query($conn, $Sql);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
          $DocNo		= $Result['DocNo'];
          $DocNoAcc		= $Result['DocNoAcc'];
          $FName		= $Result['FName'];
          $IsCheckIn		= $Result['IsCheckIn'];
          $Total		= number_format($Result['Total'],2);
          $Total_int		= $Result['Total'];
          $IsCopy		= $Result['IsCopy'];
          $DocDate		= $Result['DocDate'];



             $query = "  INSERT INTO acc_delegate_detail
                          SET DocNo_acc_delegate = '$DocNo_delegate',
                              DocDate = DATE(NOW()),
                              IsCancel = '0',
                              RefDocNoAcc = '$DocNoAcc',
                              RefDocNosale = '$DocNo',
                              IsCopy = '$IsCopy',
                              Sumtotal = '$Total_int',
                              DateDocSale = '$DocDate'
                      ";

              mysqli_query($conn, $query);

          if($IsCopy>'0'){
            $Sql_updatebill = "UPDATE sale_x 
                                SET sale_x.IsPayAcc_delegate = '1'
                                WHERE sale_x.DocNoAcc = '$DocNoAcc' ";
            $conn->query( $Sql_updatebill );
          }else{
            $Sql_updatebill = "UPDATE sale 
                                SET sale.IsPayAcc_delegate = '1'
                                WHERE sale.DocNoAcc = '$DocNoAcc' ";
            $conn->query( $Sql_updatebill );
          }
             

          $count++;
        }
        $count_bill++;
    }
     
    $Sql2 = "UPDATE acc_delegate 
              SET acc_delegate.QtyDoc = $count_bill
              WHERE acc_delegate.DocNo = '$DocNo_delegate' ";
    $conn->query( $Sql2 );
    
  echo $count_bill;
  mysqli_close($conn);
  die;
}

function SaveAdd_Docdetail($conn)
{

    $DocNo_delegate	= $_POST["DocNoP"];
		$DocNO_sale	= $_POST["DocNO_sale"];
    $Cus_Code	= $_POST["Cus_Code"];
    $Area	= $_POST["Area"];

    $count = 0;
    $count_bill = 0;

      $Sql = "SELECT
                sale.DocNo,
                sale.DocNoAcc,
                sale.Cus_Code,
                customer.FName,
                sale.IsCheckIn,
                  sale.Total - sale.DeductCN_Price + sale.Add_Money  AS Total,
                customer.AreaCode,
                  sale.IsCopy,
                  DATE(sale.DocDate) AS DocDate
              FROM
                sale
              INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code
                WHERE sale.IsCopy = 0
              AND customer.AreaCode = '$Area'
                AND customer.Cus_Code='$Cus_Code'
                AND sale.IsCheckIn=0
                AND sale.DocNoAcc IS NOT NULL
                AND sale.Sale_Status=1
                AND sale.DocNoAcc = '$DocNO_sale'
              UNION
              SELECT
                sale_x.DocNo,
                sale_x.DocNoAcc,
                sale_x.Cus_Code,
                customer.FName,
                sale_x.IsCheckIn,
                  sale_x.Total - sale_x.DeductCN_Price + sale_x.Add_Money  AS Total,
                customer.AreaCode,
                  sale_x.IsCopy,
                  DATE(sale_x.DocDate) AS DocDate
                FROM
                sale_x
                INNER JOIN customer ON sale_x.Cus_Code = customer.Cus_Code
                WHERE sale_x.IsCopy <> 0
                AND customer.AreaCode = '$Area'
                AND customer.Cus_Code='$Cus_Code'
                AND sale_x.IsCheckIn=0
                AND sale_x.DocNoAcc IS NOT NULL
                AND sale_x.Sale_Status=1
                AND sale_x.DocNoAcc = '$DocNO_sale' ";
                
		$meQuery = mysqli_query($conn, $Sql);
		while ($Result = mysqli_fetch_assoc($meQuery)) {
          $DocNo		= $Result['DocNo'];
          $DocNoAcc		= $Result['DocNoAcc'];
          $FName		= $Result['FName'];
          $IsCheckIn		= $Result['IsCheckIn'];
          $Total		= number_format($Result['Total'],2);
          $Total_int		= $Result['Total'];
          $IsCopy		= $Result['IsCopy'];
          $DocDate		= $Result['DocDate'];



             $query = "  INSERT INTO acc_delegate_detail
                          SET DocNo_acc_delegate = '$DocNo_delegate',
                              DocDate = DATE(NOW()),
                              IsCancel = '0',
                              RefDocNoAcc = '$DocNoAcc',
                              RefDocNosale = '$DocNo',
                              IsCopy = '$IsCopy',
                              Sumtotal = '$Total_int',
                              DateDocSale = '$DocDate'
                      ";

              mysqli_query($conn, $query);

          if($IsCopy>'0'){
            $Sql_updatebill = "UPDATE sale_x 
                                SET sale_x.IsPayAcc_delegate = '1'
                                WHERE sale_x.DocNoAcc = '$DocNoAcc' ";
            $conn->query( $Sql_updatebill );
          }else{
            $Sql_updatebill = "UPDATE sale 
                                SET sale.IsPayAcc_delegate = '1'
                                WHERE sale.DocNoAcc = '$DocNoAcc' ";
            $conn->query( $Sql_updatebill );
          }          
          $count++;
        }
 
    
  echo $count_bill;
  mysqli_close($conn);
  die;
}


function deleteData($conn)
{
  $ID_txt = $_POST['ID_txt'];

  $query = "UPDATE item SET IsCancel = 1 WHERE itemcode = $ID_txt";
  mysqli_query($conn, $query);
  echo "ลบข้อมูลสำเร็จ";
  unset($conn);
  die;
}
