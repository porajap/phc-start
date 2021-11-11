<?php
require('fpdf.php');
require('../connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

    
$SelMonth = $_GET['SelMonth'];
$SelYear = $_GET['SelYear'];
$Area = $_GET['Area'];
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

// Date
// $eDate = "2018-06-06";
//$eDate = $_GET['eDate'];
//$eDate = explode("/",$eDate);
//$eDate = $eDate[2].'-'.$eDate[1].'-'.$eDate[0];

//$month_th = $_GET['month_th'];
//var_dump($month_th); die;
class PDF extends FPDF
{
  function Header()
  {
    $datetime = new DatetimeTH();

    // var_dump($SelMonth); 
    // var_dump($SelYear); 
    // var_dump($Area); die;

   // $eDate = $_GET['eDate'];
    //$eDate = explode("/",$eDate);
  //  $eDate = $eDate[2].'-'.$eDate[1].'-'.$eDate[0];
    $printdate = date('d')." ".$datetime->getTHmonth(date('F'))." พ.ศ. ".$datetime->getTHyear(date('Y'));
    $SelMonth = $_GET['SelMonth'];
    $SelYear = $_GET['SelYear'];
    $Area = $_GET['Area'];
    $sDate = $_GET['sDate'];
    $eDate = $_GET['eDate'];
    $SelMonth = $datetime->getTHmonthFromnum($SelMonth+1)." พ.ศ. ".$datetime->getTHyear($SelYear);
    // var_dump($month); die;

   

    if($this->page==1){
      $this->SetFont('THSarabun','',12);
      $this->Cell(280,10,iconv("UTF-8","TIS-620","วันที่พิมพ์รายงาน ".$printdate),0,0,'R');
      $this->Ln(10);
      // Title
      $this->SetFont('THSarabun','b',20);
      $this->Cell(80);
      $this->Cell(140,10,iconv("UTF-8","TIS-620","รายละเอียดเบิกสวัสดิการผู้แทนประจำเดือน ".$SelMonth),0,0,'C');
     
      // Line break
      $this->Ln(10);

      $this->SetFont('THSarabun','b',20);
      $this->Cell(80);
      $this->Cell(130,10,iconv("UTF-8","TIS-620","เขต ".$Area),0,0,'C');
      // Line break
      $this->Ln(10);

    }else{
      $this->Ln(15);  
      $this->SetFont('THSarabun','b',12);
      $this->Cell(20,7,iconv("UTF-8","TIS-620","เลขที่เอกสาร"),'B',0,'C');
      $this->Cell(20,7,iconv("UTF-8","TIS-620","เลขที่บัญชี"),'B',0,'C');
      $this->Cell(20,7,iconv("UTF-8","TIS-620","วันที่เอกสาร"),'B',0,'C');
      $this->Cell(80,7,iconv("UTF-8","TIS-620","ลูกค้า"),'B',0,'C');
      $this->Cell(25,7,iconv("UTF-8","TIS-620","รับชำระ"),'B',0,'C');
      $this->Cell(25,7,iconv("UTF-8","TIS-620","สถานะ"),'B',0,'C');
      $this->Cell(15,7,iconv("UTF-8","TIS-620","เบิกครั้งที่ 1"),'B',0,'C');
      $this->Cell(15,7,iconv("UTF-8","TIS-620","เบิกครั้งที่ 2"),'B',0,'C');
      $this->Cell(15,7,iconv("UTF-8","TIS-620","ตรวจสอบ"),'B',0,'C');
      $this->Cell(45,7,iconv("UTF-8","TIS-620","หมายเหตุ"),'B',0,'C');
      $this->Ln();
    }

    


  }


  function HeaderReport($printdate,$edate,$Month_TH)
  {
      // // Move to the right
      // $this->SetFont('THSarabun','',12);
      // $this->Cell(190,10,iconv("UTF-8","TIS-620",$printdate),0,0,'R');
      // $this->Ln(10);
      // // Title
      // $this->SetFont('THSarabun','b',21);
      // $this->Cell(80);
      // $this->Cell(30,10,iconv("UTF-8","TIS-620","รายชื่อ Set หน่วยจ่ายกลาง โรงพยาบาลมะเร็ง ลพบุรี"),0,0,'C');
      // // Line break
      // $this->Ln(10);
  }

  // Page footer
  function Footer()
  {
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('THSarabun','i',13);
    // Page number
    $this->Cell(0,10,iconv("UTF-8","TIS-620",'หน้า ').$this->PageNo().'/{nb}',0,0,'R');
  }

  function setTable($pdf,$header,$data,$width,$numfield,$field)
  {
    $field = explode(",",$field);
    // Column widths
    $w = $width;
    // Header
    $pdf->SetFont('THSarabun','b',12);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,iconv("UTF-8","TIS-620",$header[$i]),'B',0,'C');
    $this->Ln();

    // set Data Details
    $count = 0;
    $pdf->SetFont('THSarabun','',12);   //ใส่ข้อมูลฟิวล์
    if(is_array($data)){                        
      foreach($data as $data=>$inner_array){
        $this->Cell($w[0],6,iconv("UTF-8","TIS-620",$inner_array[$field[0]]),'B',0,'C');
        $this->Cell($w[1],6,iconv("UTF-8","TIS-620",$inner_array[$field[1]]),'B',0,'C');
        $this->Cell($w[2],6,iconv("UTF-8","TIS-620",$inner_array[$field[2]]),'B',0,'C');
        $this->Cell($w[3],6,iconv("UTF-8","TIS-620",$inner_array[$field[3]]),'B',0,'L');
        $this->Cell($w[4],6,iconv("UTF-8","TIS-620",$inner_array[$field[4]]),'B',0,'C');
        $this->Cell($w[5],6,iconv("UTF-8","TIS-620",$inner_array[$field[5]]),'B',0,'C');
        $this->Cell($w[6],6,iconv("UTF-8","TIS-620",$inner_array[$field[6]]),'B',0,'C');
        $this->Cell($w[7],6,iconv("UTF-8","TIS-620",$inner_array[$field[7]]),'B',0,'C');
        $this->Cell($w[8],6,iconv("UTF-8","TIS-620",$inner_array[$field[8]]),'B',0,'C');
        $this->Cell($w[9],6,iconv("UTF-8","TIS-620",$inner_array[$field[9]]),'B',0,'L');
        
        $this->Ln();
        $count++;
      }
  }
    // Closing line
    $pdf->Cell(array_sum($w),0,'','T');
  }

}

// *** Prepare Data Resource *** //
// Instanciation of inherited class

$pdf = new PDF();
$font = new Font($pdf);
$data = new Data();

// Using Coding
$pdf->AddPage('L');  // set ตั้งค่าหน้ากระดาษ
$pdf->SetMargins(10,0,0);
$pdf->Ln();


$query = "SELECT
sale.DocNo,
sale.DocNoAcc,
DATE_FORMAT(sale.DocDate ,'%d-%m-%Y') AS DocDate,
customer.FName AS FName,
CASE WHEN  sale.IsCheckIn = '0' THEN 'ยังไม่ชำระเงิน'
     WHEN  sale.IsCheckIn = '1' THEN 'ชำระเงินแล้ว'
     WHEN  sale.IsCheckIn = '3' THEN 'ชำระเงินแล้วแต่ยังไม่เคลียร์'
ELSE '' END   AS IsCheckIn,
CASE WHEN  sale.Status_Bring = '1' THEN 'เบิกบางส่วน'
     WHEN  sale.Status_Bring = '2' THEN 'เบิกล่วงหน้า'
     WHEN  sale.Status_Bring = '3' THEN 'เบิกเต็มบิล'
ELSE '' END   AS Status_Bring,
format(sale.Bring1, '2')AS Bring1,
CASE WHEN sale.Bring2_Datetime IS NULL THEN format(sale.Bring2, '2')
ELSE CONCAT(format(sale.Bring2, '2'),'  ','(',IFNULL(format(sale.Bring2, '2'),''),')')  END  AS  Bring2,
CASE WHEN  	sale.Status_Finish_Bring = '1' THEN 'อนุมัติ'
     WHEN  	sale.Status_Finish_Bring = '0' THEN 'ยังไม่ได้อนุมัติ'
ELSE '' END   AS StatusFinishBring,
IFNULL(sale.RemarkWelfare,'') AS Remar,
sale.Bring1 AS num_bring1,
sale.Bring2 AS num_bring2
FROM
	sale 
INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code
WHERE sale.Status_Finish_Bring_Datetime BETWEEN '$sDate' AND '$eDate'
AND sale.Status_Finish_Bring = 1 
AND customer.AreaCode = '$Area'


UNION 

SELECT
sale_x.DocNo,
sale_x.DocNoAcc,
DATE_FORMAT(sale_x.DocDate ,'%d-%m-%Y') AS DocDate,
customer.FName AS FName,
CASE WHEN  sale_x.IsCheckIn = '0' THEN 'ยังไม่ชำระเงิน'
     WHEN  sale_x.IsCheckIn = '1' THEN 'ชำระเงินแล้ว'
     WHEN  sale_x.IsCheckIn = '3' THEN 'ชำระเงินแล้วแต่ยังไม่เคลียร์'
ELSE '' END   AS IsCheckIn,
CASE WHEN  sale_x.Status_Bring = '1' THEN 'เบิกบางส่วน'
     WHEN  sale_x.Status_Bring = '2' THEN 'เบิกล่วงหน้า'
     WHEN  sale_x.Status_Bring = '3' THEN 'เบิกเต็มบิล'
ELSE '' END   AS Status_Bring,
format(sale_x.Bring1, '2')AS Bring1,
CASE WHEN sale_x.Bring2_Datetime IS NULL THEN format(sale_x.Bring2, '2')
ELSE CONCAT(format(sale_x.Bring2, '2'),'  ','(',IFNULL(format(sale_x.Bring2, '2'),''),')')  END  AS  Bring2,
CASE WHEN  	sale_x.Status_Finish_Bring = '1' THEN 'อนุมัติ'
     WHEN  	sale_x.Status_Finish_Bring = '0' THEN 'ยังไม่ได้อนุมัติ'
ELSE '' END   AS StatusFinishBring,
IFNULL(sale_x.RemarkWelfare,'') AS Remar,
sale_x.Bring1 AS num_bring1,
sale_x.Bring2 AS num_bring2
FROM
     sale_x
INNER JOIN customer ON sale_x.Cus_Code = customer.Cus_Code
WHERE sale_x.Status_Finish_Bring_Datetime BETWEEN '$sDate' AND '$eDate'
AND sale_x.Status_Finish_Bring = 1 
AND customer.AreaCode = '$Area'

ORDER BY DocNoAcc ASC
  ";
 //var_dump($query); die;
// Number of column
$numfield = 12;
// Field data (Must match with Query)
$field ="DocNo,DocNoAcc,DocDate,FName,IsCheckIn,Status_Bring,Bring1,Bring2,StatusFinishBring,Remar,num_bring1,num_bring2";
// Table header
$header = array('เลขที่เอกสาร','เลขที่บัญชี','วันที่เอกสาร','ลูกค้า','รับชำระ','สถานะ','เบิกครั้งที่ 1','เบิกครั้งที่ 2','ตรวจสอบ','หมายเหตุ');
// width of column table
$width = array(20,20,20,80,25,25,15,15,15,45);
// Get Data and store in Result
$result = $data->getdata($conn,$query,$numfield,$field);
// Set Table
$pdf->SetFont('THSarabun','b',12);
$pdf->setTable($pdf,$header,$result,$width,$numfield,$field);
$pdf->Ln();
// Get $totalsum


$totalsum1 = 0;
$totalsum2 = 0;
if(is_array($result)){
foreach($result as $result=>$inner_array){
  $totalsum1 += $inner_array['num_bring1'];
  $totalsum2 += $inner_array['num_bring2'];
  }
}

//$Sumsummary1 += $totalsum1;
//$Sumsummary2 += $totalsum2;
//var_dump($totalsum1);
//var_dump($Sumsummary2);
//die;
// Footer Table
$pdf->SetFont('THSarabun','b',12);
$footer = array('รวม','','','','','',''.number_format($totalsum1,2),number_format($totalsum2,2));
for($i=0;$i<count($footer);$i++){
  if($footer[$i]!=''){
    $pdf->Cell($width[$i],7,iconv("UTF-8","TIS-620",$footer[$i]),'',0,'C');
  }else{
    if($i==0){
      $pdf->Cell($width[$i],7,iconv("UTF-8","TIS-620",$footer[$i]),'',0,'C');
    }else{
      $pdf->Cell($width[$i],7,iconv("UTF-8","TIS-620",$footer[$i]),'',0,'C');
    }
  }
}
$pdf->SetFont('THSarabun','b',12);
$pdf->Ln(3);
$pdf->Cell(190,6,iconv("UTF-8","TIS-620","---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------"),0,0,'L');



// Footer Table



$ddate = date('d_m_Y');
$pdf->Output('I','Welfare_Report'.$ddate.'.pdf');
mysqli_close($conn);
?>
