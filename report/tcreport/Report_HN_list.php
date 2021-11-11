<?php
require('tcpdf/tcpdf.php');
require('../../connect/connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
//--------------------------------------------------------------------------


$B_ID = $_GET['bid'];
$sDate = $_GET['sDate'];
$eDate = $_GET['eDate'];
$input_hn = $_GET['input_hn'];
$check_all = $_GET['check_all'];
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

      $B_ID = $_GET['bid'];
      $sdate = $_GET['sDate'];
      $edate = $_GET['eDate'];

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

        $this->SetFont('thsarabun', 'b', 22);
        $this->Cell(0, 10,  "รายงานการใช้อุปกรณ์ ", 0, 1, 'C');
        
        $this->SetFont('thsarabun', 'b', 22);
        $this->Cell(0, 10,  "ช่วงวันที่   $sdatex ถึง  $edatex   ", 0, 1, 'C');

        $this->SetFont('thsarabun', 'b', 18);
        $this->Cell(0, 10,"ประจำตึก : $BdName ", 0, 1, 'C');
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

$sdate = explode("/", $sDate);
$sdate = $sdate[2] . '-' . $sdate[1] . '-' . $sdate[0];


$edate = explode("/", $eDate);
$edate = $edate[2] . '-' . $edate[1] . '-' . $edate[0];
  // แสดงชื่อทั้งหมด
$count_hn = 0;

if($check_all ==0)
{
  $check_date = "AND DocDate BETWEEN '$sdate' AND '$edate'";
}
else
{
  $check_date = " " ;
}
  $showname = "SELECT
                FName ,
                HnAge ,
                hncode.HnCode ,
                hncode.Remark
              FROM
                hotpitalnumber
                INNER JOIN hncode ON hncode.HnCode = hotpitalnumber.HnCode
                INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
              WHERE CONCAT(hotpitalnumber.FName,' : ',hotpitalnumber.HnCode) LIKE '%$input_hn%'
              $check_date
              GROUP BY FName DESC ";

 $meQuery_showname = mysqli_query($conn, $showname);
  while ($Result1 = mysqli_fetch_assoc($meQuery_showname))
  {
    $FName = $Result1['FName'];
    $HnAge = $Result1['HnAge'];
    $HnCode = $Result1['HnCode'];
    $Remark = $Result1['Remark'];

        // ชื่อคนไข้
    $pdf->Ln(10);
    $pdf->SetFont('thsarabun', 'b', 15);
    $pdf->Cell(77, 7, "1. " .  $HnCode . " : " . $FName  . " อายุ " . $HnAge . " ปี ", 0, 1, 'L');
    $pdf->Cell(77, 7, "2. " .  "Operation :" . " " . $Remark , 0, 1, 'L');

        // ขึ้นหัวตาราง
    $pdf->Ln(5);
        $html = '<table cellspacing="0" cellpadding="2" border="1" >
                <thead><tr style="font-size:18px;font-weight: bold;">
                <th  width="10 mm" align="center">ลำดับ</th>
                <th  width="60 mm" align="center">รายการ</th>
                <th  width="55 mm" align="center">รหัสอุปกรณ์</th>
                <th  width="55 mm" align="center">วันที่ใช้</th></tr></thead>';

      $showdetail = "SELECT
                    itemstock.UsageCode,
                    item.itemname,
                    DATE_FORMAT(hncode.DocDate, '%d/%m/%Y') AS DocDate
                    FROM
                    hncode
                    INNER JOIN hncode_detail ON hncode.DocNo = hncode_detail.DocNo
                    INNER JOIN itemstock ON hncode_detail.ItemStockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode
                    INNER JOIN hotpitalnumber ON hncode.HnCode = hotpitalnumber.HnCode
                    WHERE 	hotpitalnumber.HnCode =  '$HnCode' 
                    AND hncode.IsCancel = 0
                    $check_date
                    ORDER BY hncode.DocDate DESC ";
         $meQuery_showdetail = mysqli_query($conn, $showdetail);
         while ($Result2 = mysqli_fetch_assoc($meQuery_showdetail))
         {
              $html .= '<tr nobr="true"  style="font-weight: normal	;">';
              $html .=   '<td width="10mm" align="center">' . $count . '</td>';
              $html .=   '<td width="60mm" align="left"> ' . $Result2['itemname'] . '</td>';
              $html .=   '<td width="55mm" align="center">' . $Result2['UsageCode'] . '</td>';
              $html .=   '<td width="55mm" align="center">' . $Result2['DocDate'] . '</td>';
              $html .=  '</tr>';
              $count++;
         }

         $html .= '</table>';
         $pdf->writeHTML($html, true, false, false, false, '');

        $count = $count - 1;
        // $pdf->Cell(35, 7,   "รวมจำนวน :" . " " . $count . " " ."รายการ", 0, 1, 'L');
        // $pdf->Cell(35, 7,   "__________________________________________________________________________________________", 0, 1, 'L');
        $count_hn++ ;
  }
        $datetime = new DatetimeTH();
        $sdate = explode("-", $sdate);
        $sdatex = $sdate[2] . " " . $datetime->getTHmonthFromnum($sdate[1]) . " พ.ศ. " . $datetime->getTHyear($sdate[0]);

        $edate = explode("-", $edate);
        $edatex = $edate[2] . " " . $datetime->getTHmonthFromnum($edate[1]) . " พ.ศ. " . $datetime->getTHyear($edate[0]);

        // $pdf->Cell(0, 10,  "ช่วงวันที่   $sdatex ถึง  $edatex   ", 0, 1, 'C');


        if($count_hn > 0)
        {
          // $pdf->Ln(5);
          $pdf->Cell(35, 7,   "รวมจำนวนการใช้อุปกรณ์ช่วงวันที่ " . $sdatex . " ถึง " . $edatex . " " . "จำนวน " . $count . " รายการ", 0, 1, 'L');
          // $pdf->Cell(35, 7,   "HN จำนวน : " . $count_hn . " ราย " . " / " . " รายการอุปกรณ์จำนวน  : " . $sumcount . " รายการ " , 0, 1, 'L');
        }
        




$pdf->SetFont('thsarabun', 'b', 14);
$pdf->SetLineWidth(0.3);
$pdf->sety($pdf->Gety() - 8.0);
// ---------------------------------------------------------

//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_HN_' . $ddate . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
