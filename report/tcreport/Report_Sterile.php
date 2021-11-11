<?php
require('tcpdf/tcpdf.php');
require('../../connect/connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
//--------------------------------------------------------------------------


$B_ID = $_GET['bid'];
$eDate = $_GET['eDate'];
//  BETWEEN , MONTH , YEAR
$type_report = $_GET['type'];
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

      $B_ID = $_GET['p_pid'];
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


      $edate = explode("/", $edate);
      $edate = $edate[2] . '-' . $edate[1] . '-' . $edate[0];

      $edate = explode("-", $edate);
      $edatex = $edate[2] . " " . $datetime->getTHmonthFromnum($edate[1]) . " พ.ศ. " . $datetime->getTHyear($edate[0]);

      
   
    if ($this->page == 1) {
        // Set font
        $this->SetFont('thsarabun', '', 9);
        // Title
        $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . $printdate, 0, 1, 'R');

        $this->SetFont('thsarabun', 'b', 22);
        $this->Cell(0, 10,  "สรุปยอดฆ่าเชื้อประจำวันที่ $edatex", 0, 1, 'C');
        
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



    // Loop วัน
    $end_date = $_GET['eDate'];
    $B_ID = $_GET['p_pid'];
  //--------------------------------------------------------------------------------------
    $end_date = explode("/", $end_date);
    $end_date = $end_date[2] . '-' . $end_date[1] . '-' . $end_date[0];
  //-------------------------------------------------------------------------------------

  // SELECT เครื่องฆ่าเชื้อ 
  $Sumsummary = 0;
  $Sql = "SELECT
          sterile.SterileMachineID,
          sterilemachine.MachineName,
          sterilemachine.MachineName2
          FROM
          sterile
          INNER JOIN sterilemachine ON sterile.SterileMachineID = sterilemachine.ID
          WHERE DATE(sterile.ModifyDate) = DATE('$end_date')
          AND sterile.B_ID = '$B_ID'
          -- AND CAST(TIME(sterile.ModifyDate) AS time) >= CAST('08:00:00' AS time)
          -- AND CAST(TIME(sterile.ModifyDate) AS time) <= CAST('16:00:00' AS time)
          GROUP BY sterile.SterileMachineID ";
          
  $meQuery1 = mysqli_query($conn, $Sql);
  while ($Result1 = mysqli_fetch_assoc($meQuery1))
  {
    $Sumtotal = 0;
    $SterileMachineID = $Result1['SterileMachineID'];
    $MachineName = $Result1['MachineName'];
    $MachineName2 = $Result1['MachineName2'];

    // ชื่อเเครื่องฆ่าเชื้อ
    $pdf->SetFont('thsarabun', 'b', 15);
    $pdf->Cell(77, 7,  "เครื่องฆ่าเชื้อ : " . $MachineName, 0, 1, 'L');


    // SELECT program ตามเครื่องฆ่าเชื้อ
    $Sql = "SELECT
              sterile.SterileMachineID,
              sterile.SterileProgramID,
              sterileprogram.SterileName,
              sterile.SterileRoundNumber 
            FROM
              sterile
              INNER JOIN sterileprogram ON sterile.SterileProgramID = sterileprogram.ID
              INNER JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo 
            WHERE
              DATE( sterile.ModifyDate ) = DATE( '$end_date' )
              AND sterile.B_ID = '$B_ID'
              -- AND CAST(TIME(sterile.ModifyDate) AS time) >= CAST('08:00:00' AS time)
              -- AND CAST(TIME(sterile.ModifyDate) AS time) <= CAST('16:00:00' AS time)
              AND sterile.SterileMachineID = '" . $SterileMachineID . "' 
            GROUP BY
              steriledetail.DocNo 
            ORDER BY
              sterile.SterileRoundNumber ASC ";


    $meQuery2 = mysqli_query($conn, $Sql);
    while ($Result2 = mysqli_fetch_assoc($meQuery2))
    {
      $SumMachine = 0;
      $SterileProgramID = $Result2['SterileProgramID'];
      $SterileName = $Result2['SterileName'];
      $SterileRoundNumber = $Result2['SterileRoundNumber'];

      $pdf->SetFont('thsarabun', 'b', 13);
      $pdf->Cell(77, 7,  "=>โปรแกรม : " . $SterileName . ' ' . " รอบที่ " . ' ' . $SterileRoundNumber, 0, 1, 'L');


      if ($SterileProgramID != "6")
      {

        // ขึ้นหัวตาราง
        $html = '<table cellspacing="0" cellpadding="2" border="1" >
                <thead><tr style="font-size:18px;font-weight: bold;">
                <th  width="10 mm" align="center">ลำดับ</th>
                <th  width="50 mm" align="center">ชื่ออุปกรณ์</th>
                <th  width="20 mm" align="center">หมดอายุ(วัน)</th>
                <th  width="20 mm" align="center">จำนวน</th>
                <th  width="20 mm" align="center">StartTime</th>
                <th  width="20 mm" align="center">FinishTime</th>
                <th  width="20 mm" align="center">Before</th>
                <th  width="20 mm" align="center">After</th></tr></thead>';
        $query = "SELECT
                    item.itemname,
                    packingmat.Shelflife,
                    SUM( steriledetail.Qty ) AS Qty,
                    TIME( sterile.StartTime ) AS StartTime,
                    TIME( sterile.FinishTime ) AS FinishTime,
                    e1.FirstName AS BeforeApprove,
                    e2.FirstName AS AfterApprove 
                  FROM
                    sterile
                    LEFT JOIN employee AS e2 ON sterile.AfterApprove = e2.EmpCode
                    LEFT JOIN employee AS e1 ON sterile.BeforeApprove = e1.EmpCode
                    INNER JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo
                    INNER JOIN itemstock ON steriledetail.ItemStockID = itemstock.RowID
                    INNER JOIN item ON itemstock.ItemCode = item.itemcode
                    INNER JOIN packingmat ON item.PackingMatID = packingmat.ID 
                  WHERE
                    DATE( sterile.ModifyDate ) = DATE( '$end_date' )
                    AND sterile.B_ID = '$B_ID'
                    -- AND CAST(TIME(sterile.ModifyDate) AS time) >= CAST('08:00:00' AS time)
                    -- AND CAST(TIME(sterile.ModifyDate) AS time) <= CAST('16:00:00' AS time)                        
                    AND sterile.SterileMachineID = '$SterileMachineID' 
                    AND sterile.SterileProgramID = '$SterileProgramID' 
                    AND sterile.SterileRoundNumber = '$SterileRoundNumber'
                  GROUP BY
                    item.itemcode,
                    item.PackingMatID 
                  ORDER BY
                    item.itemname ASC ";
           $meQuery3 = mysqli_query($conn, $query);
           while ($Result3 = mysqli_fetch_assoc($meQuery3))
           {
              $html .= '<tr nobr="true">';
              $html .=   '<td width="10mm" align="center">' . $count . '</td>';
              $html .=   '<td width="50mm" align="left"> ' . $Result3['itemname'] . '</td>';
              $html .=   '<td width="20mm" align="center">' . $Result3['Shelflife'] . '</td>';
              $html .=   '<td width="20mm" align="center">' . $Result3['Qty'] . '</td>';
              $html .=   '<td width="20mm" align="center">' . $Result3['StartTime'] . '</td>';
              $html .=   '<td width="20mm" align="center">' . $Result3['FinishTime'] . '</td>';
              $html .=   '<td width="20mm" align="center">' . $Result3['BeforeApprove'] . '</td>';
              $html .=   '<td width="20mm" align="center">' . $Result3['AfterApprove'] . '</td>';
              $html .=  '</tr>';
              $count++;
              $sumqty += $Result3['Qty'];
           }
              $html .= '<tr nobr="true">';
              $html .=   '<td width="10mm" align="center"></td>';
              $html .=   '<td width="50mm" align="center" style="font-weight: bold;">รวมรอบที่ '. $SterileRoundNumber .'</td>';
              $html .=   '<td width="20mm" align="center" style="font-weight: bold;"></td>';
              $html .=   '<td width="20mm" align="center" style="font-weight: bold;">' . $sumqty . '</td>';
              $html .=   '<td width="20mm" align="center" style="font-weight: bold;"></td>';
              $html .=   '<td width="20mm" align="center" style="font-weight: bold;"></td>';
              $html .=   '<td width="20mm" align="center" style="font-weight: bold;"></td>';
              $html .=   '<td width="20mm" align="center" style="font-weight: bold;"></td>';
              $html .=  '</tr>';
              $html .= '</table>';
              $sumqty_sum += $sumqty;
              $sumqty = 0;
              $count = 1;
              $pdf->writeHTML($html, true, false, false, false, '');
      }
    }
    
              // รวมต่อวัน 
              $pdf->SetFont('thsarabun', 'b', 15);
              $pdf->Cell(35, 7,  "รวมเครื่องฆ่าเชื้อ  : " . $MachineName . ' ' . 'จำนวน :' . ' ' . $sumqty_sum . ' ' . 'รายการ', 0, 1, 'L');
              $pdf->Cell(35, 7,  " ", 0, 1, 'L');
              $sumqty_sum_end += $sumqty_sum;
              $sumqty_sum = 0;
  }
              // รวมทั้งหมด 
              $pdf->SetFont('thsarabun', 'b', 15);
              $pdf->Cell(35, 7,  "รวมทั้งหมดเป็น  : " . $sumqty_sum_end . ' ' . 'รายการ', 0, 1, 'L');
              $sumqty_sum_end += $sumqty_sum;
              $sumqty_sum = 0;









  // $day = "SELECT
  // DATE( sterile.ModifyDate ) AS ModifyDate
  // FROM
  // sterile
  // LEFT JOIN sterilemachine ON sterile.SterileMachineID = sterilemachine.ID 
  // WHERE
  // DATE( sterile.ModifyDate ) BETWEEN '$start_date' AND '$end_date' 
  // AND CAST( TIME( sterile.ModifyDate ) AS time ) >= CAST( '08:00:00' AS time ) 
  // AND CAST( TIME( sterile.ModifyDate ) AS time ) <= CAST( '16:00:00' AS time )
  // AND sterile.B_ID = '$B_ID' 
  // -- AND sterile.IsStatus = '1'
  // GROUP BY
  // DATE( sterile.ModifyDate ) ";
  // $meQuery_day = mysqli_query($conn, $day);
  // while ($Result0 = mysqli_fetch_assoc($meQuery_day))
  // {
  //   $ModifyDatex = $Result0['ModifyDate'];
  //   // นำไปแสดง รวมต่อวัน 
  //   $datetime_loop = new DatetimeTH();
  //   $ModifyDate_show = $Result0['ModifyDate'];
  //   $ModifyDate_show_ex = explode("-", $ModifyDate_show);
  //   $show_full_date = $ModifyDate_show_ex[2] . " " . $datetime_loop->getTHmonthFromnum($ModifyDate_show_ex[1]) . " พ.ศ. " . $datetime_loop->getTHyear($ModifyDate_show_ex[0]);
  //   // ===============================================

  //   // หัวตาราง 
  //   $head = "SELECT
  //       sterile.SterileMachineID,
  //       sterilemachine.MachineName2 ,
  //       DATE( sterile.ModifyDate ) AS ModifyDate,
  //       sterileprogram.SterileName ,
  //       sterile.SterileRoundNumber,
  //       sterile.SterileProgramID
  //     FROM
  //       sterile
  //     LEFT JOIN sterilemachine ON sterile.SterileMachineID = sterilemachine.ID 
  //     INNER JOIN sterileprogram ON sterileprogram.ID = sterile.SterileProgramID 
  //     WHERE
  //     DATE( sterile.ModifyDate ) = '$ModifyDatex' 
  //     AND CAST( TIME( sterile.ModifyDate ) AS time ) >= CAST( '08:00:00' AS time ) 
  //     AND CAST( TIME( sterile.ModifyDate ) AS time ) <= CAST( '16:00:00' AS time ) 
  //     AND sterile.B_ID = '$B_ID'
  //     -- AND sterile.IsStatus = '1'
  //     ORDER BY 
  //     DATE( sterile.ModifyDate ) , sterile.SterileMachineID";
  //   $pdf->Ln(20);
  //   $meQuery = mysqli_query($conn, $head);
  //   while ($Result1 = mysqli_fetch_assoc($meQuery)) {
  //     $SterileMachineID = $Result1['SterileMachineID'];
  //     $MachineName2 = $Result1['MachineName2'];

  //     $datetimex = new DatetimeTH();
  //     $ModifyDate = $Result1['ModifyDate'];
  //     $sDate = explode("-", $ModifyDate);
  //     $edate = $sDate[2] . " " . $datetimex->getTHmonthFromnum($sDate[1]) . " พ.ศ. " . $datetimex->getTHyear($sDate[0]);

  //     $SterileName = $Result1['SterileName'];
  //     $SterileRoundNumber = $Result1['SterileRoundNumber'];
  //     $SterileProgramID = $Result1['SterileProgramID'];


  //     $pdf->SetFont('thsarabun', 'b', 14);
  //     $pdf->Cell(35, 7,  "รายการฆ่าเชื้อในวันที่  : " . $edate, 0, 1, 'L');
  //     $pdf->Cell(77, 7,  "เครื่องฆ่าเชื้อ : " . $MachineName2, 0, 1, 'L');
  //     $pdf->Cell(77, 7,  "โปรแกรม : " . $SterileName . ' ' . 'รอบที่' . ' ' . $SterileRoundNumber, 0, 0, 'L');

  //     $pdf->Ln(10);
  //     $html = '<table cellspacing="0" cellpadding="2" border="1" >
  //     <thead><tr style="font-size:18px;font-weight: bold;">
  //     <th  width="10 %" align="center">ลำดับ</th>
  //     <th  width="50 %" align="center">ชื่ออุปกรณ์</th>
  //     <th  width="40 %" align="center">จำนวน</th></tr> </thead>';

  //     // รายละเอียด 
  //     $Detail = " SELECT
  //               item.itemname,
  //               SUM( steriledetail.Qty ) AS Qty 
  //             FROM
  //               sterile
  //               LEFT JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo
  //               LEFT JOIN itemstock ON steriledetail.ItemStockID = itemstock.RowID
  //               LEFT JOIN item ON itemstock.ItemCode = item.itemcode
  //               LEFT JOIN packingmat ON item.PackingMatID = packingmat.ID 
  //             WHERE
  //               DATE( sterile.ModifyDate ) = DATE( '$ModifyDate' ) 
  //               AND CAST( TIME( sterile.ModifyDate ) AS time ) >= CAST( '08:00:00' AS time ) 
  //               AND CAST( TIME( sterile.ModifyDate ) AS time ) <= CAST( '16:00:00' AS time ) 
  //               AND sterile.SterileMachineID = '$SterileMachineID' 
  //               AND sterile.SterileProgramID = '$SterileProgramID' 
  //               AND sterile.SterileRoundNumber = '$SterileRoundNumber' -- AND steriledetail.IsStatus = '1'
  //               AND sterile.B_ID = '$B_ID' 
  //             GROUP BY
  //               item.itemcode,
  //               item.PackingMatID 
  //             ORDER BY
  //               item.itemname ASC ";
  //     $count = 1;
  //     $meQuery2 = mysqli_query($conn, $Detail);
  //     while ($Result2 = mysqli_fetch_assoc($meQuery2)) {
  //       $html .= '<tr nobr="true">';
  //       $html .=   '<td width="10%" align="center">' . $count . '</td>';
  //       $html .=   '<td width="50%" align="left"> ' . $Result2['itemname'] . '</td>';
  //       $html .=   '<td width="40%" align="center">' . $Result2['Qty'] . '</td>';
  //       $html .=  '</tr>';
  //       $count++;
  //       $sumqty += $Result2['Qty'];
  //     }
  //     $html .= '<tr nobr="true">';
  //     $html .=   '<td width="10%" align="center"></td>';
  //     $html .=   '<td width="50%" align="center" style="font-weight: bold;">รวม</td>';
  //     $html .=   '<td width="40%" align="center" style="font-weight: bold;">' . $sumqty . '</td>';
  //     $html .=  '</tr>';
  //     $html .= '</table>';



  //     $pdf->writeHTML($html, true, false, false, false, '');
  //     $sumqty_sum += $sumqty;
  //     $sumqty = 0;
  //   }

  //   // รวมต่อวัน 
  //   $pdf->SetFont('thsarabun', 'b', 18);
  //   $pdf->Cell(35, 7,  "รวมรายการฆ่าเชื้อช่วงวันที่  : " . $show_full_date . ' ' . 'จำนวน :' . ' ' . $sumqty_sum . ' ' . 'รายการ', 0, 1, 'L');
  //   $pdf->Cell(35, 7,  "________________________________________________________________________________  ", 0, 1, 'L');

  //   $sumqty_sum_end += $sumqty_sum;
  //   $sumqty_sum = 0;
  // }

  // // รวมทั้งหมด
  // $pdf->Ln(10);
  // $datetime_end = new DatetimeTH();
  // $start_date = explode("-", $start_date);
  // $end_date = explode("-", $end_date);
  // $edate = $start_date[2] . " " . $datetime_end->getTHmonthFromnum($start_date[1]) . " พ.ศ. " . $datetime_end->getTHyear($start_date[0]);
  // $sdate = $end_date[2] . " " . $datetime_end->getTHmonthFromnum($end_date[1]) . " พ.ศ. " . $datetime_end->getTHyear($end_date[0]);
  // $pdf->SetFont('thsarabun', 'b', 18);

  // if ($edate == $sdate) {
  //   $pdf->Cell(35, 7,  "* รวมรายการฆ่าเชื้อช่วงวันที่  : " . $edate . ' ' . 'จำนวน' . ' ' . $sumqty_sum_end . ' ' . 'รายการ', 0, 1, 'L');
  // } else {
  //   $pdf->Cell(35, 7,  "* รวมรายการฆ่าเชื้อช่วงวันที่  : " . $edate . ' ' . 'ถึง' . ' ' . $sdate . ' ' . 'จำนวน' . ' ' . $sumqty_sum_end . ' ' . 'รายการ', 0, 1, 'L');
  // }
  // $pdf->Cell(35, 7,  "________________________________________________________________________________  ", 0, 1, 'L');

$pdf->SetFont('thsarabun', 'b', 14);
$pdf->SetLineWidth(0.3);
$pdf->sety($pdf->Gety() - 8.0);
// ---------------------------------------------------------

//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Sterile_' . $ddate . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
