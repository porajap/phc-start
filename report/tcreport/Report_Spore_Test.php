<?php
require('tcpdf/tcpdf.php');
require('../../connect/connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
//--------------------------------------------------------------------------



//  BETWEEN , MONTH , YEAR
//--------------------------------------------------------------------------
//print_r($data);
//--------------------------------------------------------------------------
class MYPDF extends TCPDF
{
  protected $last_page_flag = false;

  public function Close()
  {
    $this->last_page_flag = true;
    parent::Close();
  }
  //Page header
  public function Header()
  {
    require('../../connect/connect.php');
    $datetime = new DatetimeTH();
    // date th
    $printdate = date('d') . " " . $datetime->getTHmonth(date('F')) . " พ.ศ. " . $datetime->getTHyear(date('Y'));
      $Type = $_GET['Type'];
      $B_ID = $_GET['bid'];
      $sdate = $_GET['sDate'];
      $edate = $_GET['eDate'];
      if($Type == '2')
      {
        $Type = '6';
      }
      else if($Type == '3')
      {
        $Type = '7';
      }
      $B = "SELECT
              BdName
            FROM
              buildg
            WHERE ID = '$B_ID' ";
        $BQ = mysqli_query($conn, $B);
        while ($RB = mysqli_fetch_assoc($BQ))
        {
          $BdName = $RB['BdName'];
        }

        $Sql = "SELECT
        testprogram.ID,
        testprogram.TestProgramName
        FROM
        testprogram 
        WHERE testprogram.ID = $Type ";
        
        $meQuery = mysqli_query($conn, $Sql);
        while ($Result = mysqli_fetch_assoc($meQuery))
        {
          $testprogramid = $Result['ID'];
          $testprogramname = $Result['TestProgramName'];
        }
        if($testprogramid == 1)
        {
          $spore = "ประเภทการทดสอบ : Spore test (4 ชั่วโมง Rapid ReadOut) Steam Autoclave";
        }
        else if($testprogramid == 6)
        {
          $spore = "ประเภทการทดสอบ : Spore test (4 ชั่วโมง Rapid ReadOut) EO";
        }
        else if($testprogramid == 7)
        {
          $spore = "ประเภทการทดสอบ : Spore test (24 นาที Super ReadOut) Steam Autoclave";
        }
        else
        {
          $spore = "ไม่พบประเภทการทดสอบ";
        }
          // ช่วงวันที่
      //  =============================================================================================================================
      $sdate = explode("/", $sdate);
      $sdate = $sdate[2] . '-' . $sdate[1] . '-' . $sdate[0];

      $sdate = explode("-", $sdate);
      $sdatex = $sdate[2] . " " . $datetime->getTHmonthFromnum($sdate[1]) . " พ.ศ. " . $datetime->getTHyear($sdate[0]);


      $edate = explode("/", $edate);
      $edate = $edate[2] . '-' . $edate[1] . '-' . $edate[0];

      $edate = explode("-", $edate);
      $edatex = $edate[2] . " " . $datetime->getTHmonthFromnum($edate[1]) . " พ.ศ. " . $datetime->getTHyear($edate[0]);
    //  =============================================================================================================================
    if ($this->page == 1) {
        // Set font
        $this->SetFont('thsarabun', '', 9);
        // Title
        $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . $printdate, 0, 1, 'R');

        $this->SetFont('thsarabun', 'b', 18);
        $this->Cell(0, 10,  "รายงานผลตรวจสอบประสิทธิภาพการทำให้ปราศจากเชื้อ ", 0, 1, 'C');
        
        // $this->SetFont('thsarabun', 'b', 22);
        // $this->Cell(0, 10,  "ช่วงวันที่   $sdatex ถึง  $edatex   ", 0, 1, 'C');

        $this->SetFont('thsarabun', 'b', 16);
        $this->Cell(0, 10,"ประจำตึก : $BdName ", 0, 1, 'C');

        $this->SetFont('thsarabun', 'b', 16);
        $this->Cell(0, 10," $spore ", 0, 1, 'C');
      $this->Ln(10);
    }
  }
  // Page footer
  public function Footer()
  {
    $this->SetY(-25);
    // Arial italic 8
    $this->SetFont('thsarabun', 'i', 12);
    // Page number

    $this->Cell(190, 10,  "หน้า" . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
  }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Report Sterile');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 27);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// ------------------------------------------------------------------------------
$count = 1;
// ------------------------------------------------------------------------------

// set font
// add a page
  $pdf->AddPage('P', 'A4');
  $pdf->Ln(10);

  // ===========================================================
  $B_ID = $_GET['bid'];
  $sDate = $_GET['sDate'];
  $eDate = $_GET['eDate'];
  $Type = $_GET['Type'];

  $sdate = explode("/", $sDate);
  $sdate = $sdate[2] . '-' . $sdate[1] . '-' . $sdate[0];


  $edate = explode("/", $eDate);
  $edate = $edate[2] . '-' . $edate[1] . '-' . $edate[0];
  // ===========================================================

  if($Type == '2')
  {
    $Type = '6';
  }
  else if($Type == '3')
  {
    $Type = '7';
  }
  $Sql = "SELECT
  testprogram.ID,
  testprogram.TestProgramName
  FROM
  testprogram 
  WHERE testprogram.ID = $Type ";

  $meQuery = mysqli_query($conn, $Sql);
  while ($Result = mysqli_fetch_assoc($meQuery))
  {
    $testprogramid = $Result['ID'];
    $testprogramname = $Result['TestProgramName'];
  }


      $pdf->Ln(10);
      if($testprogramid == 6)
      {
        $html = '<table cellspacing="0" cellpadding="2" border="1" >
                <thead><tr style="font-size:18px;font-weight: bold;">
                <th  width="20 mm" align="center">วัน/เดือน/ปี</th>
                <th  width="20 mm" align="center">เครื่อง/รอบ</th>
                <th  width="55 mm" align="center">แผนกต่าง ๆ</th>
                <th  width="25 mm" align="center">ผลการทดสอบ</th>
                <th  width="30 mm" align="center">ผู้ทดสอบ</th>
                <th  width="30 mm" align="center">ผู้อ่านผล</th></tr></thead>';
      }
      else
      {
                $html = '<table cellspacing="0" cellpadding="2" border="1" >
                <thead><tr style="font-size:18px;font-weight: bold;">
                <th  width="20 mm" align="center">วัน/เดือน/ปี</th>
                <th  width="20 mm" align="center">เครื่อง/รอบ</th>
                <th  width="55 mm" align="center">รายการเครื่องมือ</th>
                <th  width="25 mm" align="center">ผลการทดสอบ</th>
                <th  width="30 mm" align="center">ผู้ทดสอบ</th>
                <th  width="30 mm" align="center">ผู้อ่านผล</th></tr></thead>';
      }

      $query = "SELECT
      DATE_FORMAT(sterile.DocDate,'%d/%m/%Y') AS DocDate,
      CONCAT(sterilemachine.MachineName2,'/',sterile.SterileRoundNumber) AS MachineName2,
      CASE testresult.IsResultTest
          WHEN 1 THEN 'ผ่าน'
          WHEN 0 THEN 'ไม่ผ่าน'
      END AS IsResultTest, 
      testresult.Remark,
      COALESCE(CONCAT(emp1.FirstName,' ',emp1.LastName),'-') AS BeforeApprove,
      COALESCE(CONCAT(emp2.FirstName,' ',emp2.LastName),'-') AS UserApprove
      FROM
      testresult
      INNER JOIN sterile ON testresult.DocNo = sterile.DocNo
      INNER JOIN sterilemachine ON sterile.SterileMachineID = sterilemachine.ID
      INNER JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo
      INNER JOIN itemstock ON steriledetail.ItemStockID = itemstock.RowID
      INNER JOIN item ON itemstock.ItemCode = item.itemcode
      LEFT JOIN employee AS emp1 ON sterile.BeforeApprove = emp1.EmpCode
      LEFT JOIN employee AS emp2 ON testresult.UserApprove = emp2.EmpCode
      INNER JOIN testprogram ON testresult.ProgramTest = testprogram.ID
      WHERE DATE(sterile.DocDate) BETWEEN DATE('$sdate') AND DATE('$edate') 
      AND testprogram.ID = '$testprogramid'
      AND testresult.IsATP = 0
      AND testresult.B_ID = '$B_ID'
      GROUP BY testresult.DocNo";
      
        $meQuery = mysqli_query($conn, $query);
        while ($Result = mysqli_fetch_assoc($meQuery))
        {
          $html .= '<tr nobr="true" style="font-weight: normal	;">';
          $html .=   '<td width="20mm" align="center">' . $Result['DocDate'] . '</td>';
          $html .=   '<td width="20mm" align="center"> ' . $Result['MachineName2'] . '</td>';
          $html .=   '<td width="55mm" align="left">' .   $Result['Remark'] . '</td>';
          $html .=   '<td width="25mm" align="center">' . $Result['IsResultTest'] . '</td>';
          $html .=   '<td width="30mm" align="center">' . $Result['BeforeApprove'] . '</td>';
          $html .=   '<td width="30mm" align="center">' . $Result['UserApprove'] . '</td>';
          $html .=  '</tr>';
          $count++;
        }











         $html .= '</table>';
         $pdf->writeHTML($html, true, false, false, false, '');
//   // แสดงชื่อทั้งหมด
// $count_hn = 0;
//   $showname = "SELECT
//                 FName ,
//                 HnAge ,
//                 hncode.HnCode ,
//                 hncode.Remark
//               FROM
//                 hotpitalnumber
//                 INNER JOIN hncode ON hncode.HnCode = hotpitalnumber.HnCode
//                 INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
//               WHERE DocDate BETWEEN '$sdate' AND '$edate'
//               GROUP BY FName DESC ";

//  $meQuery_showname = mysqli_query($conn, $showname);
//   while ($Result1 = mysqli_fetch_assoc($meQuery_showname))
//   {
//     $FName = $Result1['FName'];
//     $HnAge = $Result1['HnAge'];
//     $HnCode = $Result1['HnCode'];
//     $Remark = $Result1['Remark'];

//         // ชื่อคนไข้
//     $pdf->Ln(10);
//     $pdf->SetFont('thsarabun', 'b', 15);
//     $pdf->Cell(77, 7,"1. " .   $HnCode . " : " . $FName  . " อายุ " . $HnAge . " ปี ", 0, 1, 'L');
//     $pdf->Cell(77, 7,"2. " .   "Operation :" . " " . $Remark , 0, 1, 'L');

//         // ขึ้นหัวตาราง
//     $pdf->Ln(5);
//         $html = '<table cellspacing="0" cellpadding="2" border="1" >
//                 <thead><tr style="font-size:18px;font-weight: bold;">
//                 <th  width="10 mm" align="center">ลำดับ</th>
//                 <th  width="60 mm" align="center">รายการ</th>
//                 <th  width="55 mm" align="center">รหัสอุปกรณ์</th>
//                 <th  width="55 mm" align="center">วันที่ใช้</th></tr></thead>';

//       $showdetail = "SELECT
//                     itemstock.UsageCode,
//                     item.itemname,
//                     DATE_FORMAT(hncode.DocDate, '%d/%m/%Y') AS DocDate
//                     FROM
//                     hncode
//                     INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
//                     INNER JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
//                     INNER JOIN item ON itemstock.ItemCode = item.itemcode
//                     INNER JOIN hotpitalnumber ON hncode.HnCode = hotpitalnumber.HnCode
//                     WHERE 	hotpitalnumber.HnCode =  '$HnCode' 
//                     AND hncode.IsCancel = 0
//                     AND DocDate BETWEEN '$sdate' AND '$edate'
//                     ORDER BY hncode.DocDate DESC ";
//          $meQuery_showdetail = mysqli_query($conn, $showdetail);
//          while ($Result2 = mysqli_fetch_assoc($meQuery_showdetail))
//          {
//               $html .= '<tr nobr="true" style="font-weight: normal	;">';
//               $html .=   '<td width="10mm" align="center">' . $count . '</td>';
//               $html .=   '<td width="60mm" align="left"> ' . $Result2['itemname'] . '</td>';
//               $html .=   '<td width="55mm" align="center">' . $Result2['UsageCode'] . '</td>';
//               $html .=   '<td width="55mm" align="center">' . $Result2['DocDate'] . '</td>';
//               $html .=  '</tr>';
//               $count++;
//          }

//          $html .= '</table>';
//          $pdf->writeHTML($html, true, false, false, false, '');

//         $count = $count - 1;
//         $pdf->Cell(35, 7,   "รวมจำนวน :" . " " . $count . " " ."รายการ", 0, 1, 'L');
//         $pdf->Cell(35, 7,   "__________________________________________________________________________________________", 0, 1, 'L');
//         $sumcount += $count;
//         $count_hn++ ;
//         $count = 1;
//   }
//         $datetime = new DatetimeTH();
//         $sdate = explode("-", $sdate);
//         $sdatex = $sdate[2] . " " . $datetime->getTHmonthFromnum($sdate[1]) . " พ.ศ. " . $datetime->getTHyear($sdate[0]);

//         $edate = explode("-", $edate);
//         $edatex = $edate[2] . " " . $datetime->getTHmonthFromnum($edate[1]) . " พ.ศ. " . $datetime->getTHyear($edate[0]);

//         // $pdf->Cell(0, 10,  "ช่วงวันที่   $sdatex ถึง  $edatex   ", 0, 1, 'C');

//         if($count_hn > 0)
//         {
//           $pdf->Ln(5);
//           $pdf->Cell(35, 7,   "รวมจำนวนการใช้อุปกรณ์ช่วงวันที่ " . $sdatex . " ถึง " . $edatex , 0, 1, 'L');
//           $pdf->Cell(35, 7,   "HN จำนวน : " . $count_hn . " ราย " . " / " . " รายการอุปกรณ์จำนวน  : " . $sumcount . " รายการ " , 0, 1, 'L');
//         }



// $pdf->SetFont('thsarabun', 'b', 14);
// $pdf->SetLineWidth(0.3);
// $pdf->sety($pdf->Gety() - 8.0);
// // ---------------------------------------------------------

//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_HN_' . $ddate . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
