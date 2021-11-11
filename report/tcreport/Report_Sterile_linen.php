<?php
require('tcpdf/tcpdf.php');
require('../../connect/connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
//--------------------------------------------------------------------------


$B_ID = $_GET['bid'];

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
    $datetime = new DatetimeTH();


    // date th
    $printdate = date('d') . " " . $datetime->getTHmonth(date('F')) . " พ.ศ. " . $datetime->getTHyear(date('Y'));
    $type_report = $_GET['type'];


    if ($type_report == 'BETWEEN') {
      $start_date_show = $_GET['sDate'];
      $start_end_show = $_GET['eDate'];

 
      $start_date_show = explode("/", $start_date_show);
      $start_date_show = $start_date_show[2] . '-' . $start_date_show[1] . '-' . $start_date_show[0];
      $start_end_show = explode("/", $start_end_show);
      $start_end_show = $start_end_show[2] . '-' . $start_end_show[1] . '-' . $start_end_show[0];

      $start_date_show = explode("-", $start_date_show);
      $start_end_show = explode("-", $start_end_show);
      $edate = $start_date_show[2] . " " . $datetime->getTHmonthFromnum($start_date_show[1]) . " พ.ศ. " . $datetime->getTHyear($start_date_show[0]);
      $sdate = $start_end_show[2] . " " . $datetime->getTHmonthFromnum($start_end_show[1]) . " พ.ศ. " . $datetime->getTHyear($start_end_show[0]);

      
      $text_Date = 'ช่วงวันที่';
    } else if ($type_report == 'MONTH') {
      $sM = $_GET['sDate'];
      $eM = $_GET['eDate'];
      $Y = $_GET['Year'];
      $start_date_show="99/".$sM."/".$Y;
      $start_end_show="99/".$eM."/".$Y;

      $start_date_show = explode("/", $start_date_show);
      $start_date_show = $start_date_show[2] . '-' . $start_date_show[1] . '-' . $start_date_show[0];
      $start_end_show = explode("/", $start_end_show);
      $start_end_show = $start_end_show[2] . '-' . $start_end_show[1] . '-' . $start_end_show[0];

      $start_date_show = explode("-", $start_date_show);
      $start_end_show = explode("-", $start_end_show);
      $edate = $datetime->getTHmonthFromnum($start_date_show[1]);
      $sdate = $datetime->getTHmonthFromnum($start_end_show[1]);
      $year = " พ.ศ. " . $datetime->getTHyear($start_end_show[0]);

      $text_Date = 'ประจำเดือน';
    } else if ($type_report == 'YEAR') {

      $sY = $_GET['Year1'];
      $eY = $_GET['Year2'];

      $start_date_show="09/09/".$sY;
      $start_end_show="09/09/".$eY;

      $start_date_show = explode("/", $start_date_show);
      $start_date_show = $start_date_show[2] . '-' . $start_date_show[1] . '-' . $start_date_show[0];
      $start_end_show = explode("/", $start_end_show);
      $start_end_show = $start_end_show[2] . '-' . $start_end_show[1] . '-' . $start_end_show[0];

      $start_date_show = explode("-", $start_date_show);
      $start_end_show = explode("-", $start_end_show);
      $edate = $datetime->getTHyear($start_date_show[0]);
      $sdate = $datetime->getTHyear($start_end_show[0]);

      $text_Date = 'ประจำปี';
    }

    if ($this->page == 1) {
      if ($type_report == 'BETWEEN') {
        // Set font
        $this->SetFont('thsarabun', '', 9);
        // Title
        $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . $printdate, 0, 1, 'R');

        $this->SetFont('thsarabun', 'b', 22);
        $this->Cell(0, 10,  "รายงานการผลิตเครื่องผ้าทำให้ปราศจากเชื้อแล้ว", 0, 1, 'C');
        $this->SetFont('thsarabun', 'b', 20);
        if ($edate == $sdate) {
          $this->Cell(0, 10,  $text_Date . ' ' . $edate, 0, 0, 'C');
        } else {
          $this->Cell(0, 10,  $text_Date . ' ' . $edate . " ถึง " . $sdate, 0, 0, 'C');
        }
      } else if ($type_report == 'MONTH') {
        // Set font
        $this->SetFont('thsarabun', '', 9);
        // Title
        $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . $printdate, 0, 1, 'R');
        $this->SetFont('thsarabun', 'b', 22);
        $this->Cell(0, 10,  "รายงานการผลิตเครื่องผ้าทำให้ปราศจากเชื้อแล้ว(รายเดือน)", 0, 1, 'C');
        $this->SetFont('thsarabun', 'b', 20);

        if ($start_date_show[1] == $start_end_show[1]) {
          $this->Cell(0, 10,  $text_Date . ' ' . $edate . ' ' . $year, 0, 0, 'C');
        } else {
          $this->Cell(0, 10,  $text_Date . ' ' . $edate . " - " . $sdate . ' ' . $year, 0, 0, 'C');
        }
      } else if ($type_report == 'YEAR') {
        // Set font
        $this->SetFont('thsarabun', '', 9);
        // Title
        $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . $printdate, 0, 1, 'R');
        $this->SetFont('thsarabun', 'b', 22);
        $this->Cell(0, 10,  "รายงานการผลิตเครื่องผ้าทำให้ปราศจากเชื้อแล้ว(รายปี)", 0, 1, 'C');
        $this->SetFont('thsarabun', 'b', 20);

        if ($edate == $sdate) {
          $this->Cell(0, 10,  $text_Date . ' ' . ' พ.ศ. ' . $edate, 0, 0, 'C');
        } else {
          $this->Cell(0, 10,  $text_Date . ' ' . ' พ.ศ. ' . $edate . " - " . $sdate, 0, 0, 'C');
        }
      }
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
// $pdf->AddPage('P', 'A4');


if ($type_report == 'BETWEEN') {

    // Loop วัน
    $start_date = $_GET['sDate'];
    $end_date = $_GET['eDate'];
    $end_date = $_GET['eDate'];
    $Machine = $_GET['Machine'];
    $Round = $_GET['Round'];
  //--------------------------------------------------------------------------------------
    $start_date = explode("/", $start_date);
    $start_date = $start_date[2] . '-' . $start_date[1] . '-' . $start_date[0];
    $end_date = explode("/", $end_date);
    $end_date = $end_date[2] . '-' . $end_date[1] . '-' . $end_date[0];
  //-------------------------------------------------------------------------------------
  $ID_machine = "";
  if($Machine != '-' && $Round != '-')
  {
    $Sql_machine = "SELECT
                      sterilemachine.ID
                    FROM
                      sterilemachine
                    WHERE sterilemachine.MachineName2 = '$Machine' ";
    $meQuery_machine = mysqli_query($conn, $Sql_machine);
    $Result_machine = mysqli_fetch_assoc($meQuery_machine);
    $ID_machine = $Result_machine['ID'];

    $Round_Machine = "	AND sterile.SterileMachineID = '$ID_machine' AND Sterile.SterileRoundNumber = '$Round'";
  }
  else
  {
    $Round_Machine = "";
  }


  $day = "SELECT
  DATE( sterile.ModifyDate ) AS ModifyDate
  FROM
  sterile
  LEFT JOIN sterilemachine ON sterile.SterileMachineID = sterilemachine.ID
  LEFT JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo
	LEFT JOIN itemstock ON steriledetail.ItemStockID = itemstock.RowID
  LEFT JOIN item ON itemstock.ItemCode = item.itemcode
  WHERE
  DATE( sterile.ModifyDate ) BETWEEN '$start_date' AND '$end_date' 
  AND CAST( TIME( sterile.ModifyDate ) AS time ) >= CAST( '08:00:00' AS time ) 
  AND CAST( TIME( sterile.ModifyDate ) AS time ) <= CAST( '16:00:00' AS time )
  AND sterile.B_ID = '$B_ID'
  AND item.NoWash = '1'
  $Round_Machine
  GROUP BY
  DATE( sterile.ModifyDate ) ";

  $meQuery_day = mysqli_query($conn, $day);
  while ($Result0 = mysqli_fetch_assoc($meQuery_day)) {
    $ModifyDatex = $Result0['ModifyDate'];
    // นำไปแสดง รวมต่อวัน 
    $datetime_loop = new DatetimeTH();
    $ModifyDate_show = $Result0['ModifyDate'];
    $ModifyDate_show_ex = explode("-", $ModifyDate_show);
    $show_full_date = $ModifyDate_show_ex[2] . " " . $datetime_loop->getTHmonthFromnum($ModifyDate_show_ex[1]) . " พ.ศ. " . $datetime_loop->getTHyear($ModifyDate_show_ex[0]);
    // ===============================================

    // หัวตาราง 
    $head = "SELECT
        sterile.SterileMachineID,
        sterilemachine.MachineName ,
        DATE( sterile.ModifyDate ) AS ModifyDate,
        sterileprogram.SterileName ,
        sterile.SterileRoundNumber,
        sterile.SterileProgramID,
        TIME(sterile.StartTime) AS StartTime,
        TIME(sterile.FinishTime) AS FinishTime,
        sterile.DocNo ,
        employee.FirstName
      FROM
        sterile
      LEFT JOIN sterilemachine ON sterile.SterileMachineID = sterilemachine.ID 
      INNER JOIN sterileprogram ON sterileprogram.ID = sterile.SterileProgramID
      INNER JOIN employee ON sterile.ApproveCode = employee.ID
      INNER JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo
      INNER JOIN itemstock ON steriledetail.ItemStockID = itemstock.RowID
      INNER JOIN item ON itemstock.ItemCode = item.itemcode
      WHERE
      DATE( sterile.ModifyDate ) = '$ModifyDatex' 
      AND CAST( TIME( sterile.ModifyDate ) AS time ) >= CAST( '08:00:00' AS time ) 
      AND CAST( TIME( sterile.ModifyDate ) AS time ) <= CAST( '16:00:00' AS time ) 
      AND sterile.B_ID = '$B_ID'
      AND item.NoWash = '1' 
      $Round_Machine
      GROUP BY
	    sterile.DocNo   
      ORDER BY 
      DATE( sterile.ModifyDate ) , sterile.SterileMachineID";

    // echo '<pre>';
    // echo $head;
    // echo '</pre>';
    $meQuery = mysqli_query($conn, $head);
    while ($Result1 = mysqli_fetch_assoc($meQuery)) {
      $pdf->AddPage('P', 'A4');
      $pdf->Ln(20);

      $SterileMachineID = $Result1['SterileMachineID'];
      $MachineName = $Result1['MachineName'];

      $datetimex = new DatetimeTH();
      $ModifyDate = $Result1['ModifyDate'];
      $sDate = explode("-", $ModifyDate);
      $edate = $sDate[2] . " " . $datetimex->getTHmonthFromnum($sDate[1]) . " พ.ศ. " . $datetimex->getTHyear($sDate[0]);

      $SterileName = $Result1['SterileName'];
      $SterileRoundNumber = $Result1['SterileRoundNumber'];
      $SterileProgramID = $Result1['SterileProgramID'];
      $DocNo = $Result1['DocNo'];
      $StartTime = $Result1['StartTime'];
      $FinishTime = $Result1['FinishTime'];
      $FirstName = $Result1['FirstName'];


      $pdf->SetFont('thsarabun', 'b', 14);
      $pdf->Cell(90, 7,  "เลขที่เอกสาร  : " . $DocNo, 0, 0, 'L');
      $pdf->Cell(90, 7,  "วันที่  : " . $edate, 0, 1, 'L');
      $pdf->Cell(90, 7,  "เครื่อง  : " . $MachineName, 0, 0, 'L');
      $pdf->Cell(90, 7,  "รอบ : " . $SterileRoundNumber, 0, 1, 'L');
      $pdf->Cell(90, 7,  "เวลาเรึ่ม  : " . $StartTime, 0, 0, 'L');
      $pdf->Cell(90, 7,  "เวลาสิ้นสุด : " . $FinishTime, 0, 1, 'L');
      $pdf->Cell(90, 7,  "การทดสอบ  : " . '-', 0, 0, 'L');
      $pdf->Cell(90, 7,  "ตรวจ : " . $FirstName, 0, 1, 'L');
      $pdf->Ln(10);

      // $html = '<style>
      //         .font {
      //             font-size: 20px;

      //         }
        
      //     </style>' ;

      $html = '<table cellspacing="0" cellpadding="2" border="1" >
      <thead><tr style="font-size:18px;font-weight: bold; ">
      <th  width="10 %" align="center">ลำดับ</th>
      <th  width="50 %" align="center">รายการเครื่องผ้า</th>
      <th  width="40 %" align="center">จำนวน</th></tr> </thead>';

      // รายละเอียด 
      $Detail = " SELECT
                item.itemname,
                item.itemcode,
                SUM( steriledetail.Qty ) AS Qty 
              FROM
                sterile
                LEFT JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo
                LEFT JOIN itemstock ON steriledetail.ItemStockID = itemstock.RowID
                LEFT JOIN item ON itemstock.ItemCode = item.itemcode
                LEFT JOIN packingmat ON item.PackingMatID = packingmat.ID 
              WHERE
                DATE( sterile.ModifyDate ) = DATE( '$ModifyDate' ) 
                AND CAST( TIME( sterile.ModifyDate ) AS time ) >= CAST( '08:00:00' AS time ) 
                AND CAST( TIME( sterile.ModifyDate ) AS time ) <= CAST( '16:00:00' AS time ) 
                AND sterile.SterileMachineID = '$SterileMachineID' 
                AND sterile.SterileProgramID = '$SterileProgramID' 
                AND sterile.SterileRoundNumber = '$SterileRoundNumber' 
                AND sterile.B_ID = '$B_ID' 
                AND sterile.DocNo = '$DocNo' 
                AND item.NoWash = '1'
              GROUP BY
                item.itemcode,
                item.PackingMatID 
              ORDER BY
                item.itemname ASC ";
    //    echo '<pre>';
    // echo $Detail;
    // echo '</pre>';
      $count = 1;
      $meQuery2 = mysqli_query($conn, $Detail);
      while ($Result2 = mysqli_fetch_assoc($meQuery2)) {
        $itemcode = $Result2['itemcode'];

        $html .= '<tr nobr="true">';
        $html .=   '<td width="10%" align="center">' . $count . '</td>';
        $html .=   '<td width="50%" align="left"  > ' . $Result2['itemname'] . '</td>';
        $html .=   '<td width="40%" align="center">' . $Result2['Qty'] . '</td>';
        $html .=  '</tr>';

        $count++;
        $sumqty += $Result2['Qty'];
        $Detail_sub = "SELECT
                        itemstock.UsageCode
                      FROM
                        sterile
                        LEFT JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo
                        LEFT JOIN itemstock ON steriledetail.ItemStockID = itemstock.RowID
                      WHERE itemstock.ItemCode = '$itemcode' AND sterile.DocNo = '$DocNo' ";
          // echo '<pre>';
          // echo $Detail_sub;
          // echo '</pre>';
          $meQuery3 = mysqli_query($conn, $Detail_sub);
          while ($Result3 = mysqli_fetch_assoc($meQuery3))
          {
            $html .= '<tr nobr="true" >';
            $html .=   '<td width="10%" align="center"></td>';
            $html .=   '<td width="50%" align="left" > ' . $Result3['UsageCode'] . '</td>';
            $html .=   '<td width="40%" align="center"></td>';
            $html .=  '</tr>';
          }

  
      }

      $html .= '<tr nobr="true">';
      $html .=   '<td width="10%" align="center"></td>';
      $html .=   '<td width="50%" align="center" style="font-weight: bold;">รวม</td>';
      $html .=   '<td width="40%" align="center" style="font-weight: bold;">' . $sumqty . '</td>';
      $html .=  '</tr>';
      $html .= '</table>';
      $sumqty = 0;

      $pdf->writeHTML($html, true, false, false, false, '');
    }

  }

} else if ($type_report == 'MONTH') {

  $pdf->AddPage('P', 'A4');
  $sM = $_GET['sDate'];
  $eM = $_GET['eDate'];
  $Y = $_GET['Year'];
  $start_date="09-".$sM."-".$Y;
  $end_date="09-".$eM."-".$Y;


  $Machine = $_GET['Machine'];
  $Round = $_GET['Round'];
  $ID_machine = "";
  if($Machine != '-' && $Round != '-')
  {
    $Sql_machine = "SELECT
                      sterilemachine.ID
                    FROM
                      sterilemachine
                    WHERE sterilemachine.MachineName2 = '$Machine' ";
    $meQuery_machine = mysqli_query($conn, $Sql_machine);
    $Result_machine = mysqli_fetch_assoc($meQuery_machine);
    $ID_machine = $Result_machine['ID'];

    $Round_Machine = "	AND sterile.SterileMachineID = '$ID_machine' AND Sterile.SterileRoundNumber = '$Round'";
  }
  else
  {
    $Round_Machine = "";
  }

  $begin = new DateTime($start_date);
  $end = new DateTime($end_date);
  $end = $end->modify('1 day');

  $interval = new DateInterval('P1M');
  $period = new DatePeriod($begin, $interval, $end);
  $datetime = new DatetimeTH();
  $allmonth = array();
  foreach ($period as $key => $value) {
    array_push($allmonth, $value->format('m'));
  }

  $allmonth = array_unique($allmonth);
  $count = sizeof($allmonth);
  $width_date = 130 / ($count + 1);

  $pdf->Ln(10);
  $pdf->SetFont('thsarabun', 'b', 14);
  $html = '<table cellspacing="0" cellpadding="2" border="1" >
    <thead><tr style="font-size:18px;font-weight: bold;">
    <th  width="10 mm" align="center">ลำดับ</th>
    <th  width="40 mm" align="center">รายการ</th>';
  $pdf->SetFont('thsarabun', '', 14);
  foreach ($allmonth as $key => $value) {
    $html .= '<th  width=" ' . $width_date . ' mm " align="center">' .  $datetime->getShortlyTHmonth($value) . '</th>';
  }
  $html .= '<th  width=" ' . $width_date . ' mm " align="center">รวม</th> </tr> </thead> ';
  // ===================================================================================================


  $start_date = explode("-", $start_date);
  $start_date = $start_date[2] . '-' . $start_date[1] . '-' . $start_date[0];
  $end_date = explode("-", $end_date);
  $end_date = $end_date[2] . '-' . $end_date[1] . '-' . $end_date[0];

  // รายละเอียด 
  $Detail = "SELECT
              item.itemcode,
              item.itemname
            FROM
              sterile
              LEFT JOIN sterilemachine ON sterile.SterileMachineID = sterilemachine.ID
              LEFT JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo
              LEFT JOIN itemstock ON steriledetail.ItemStockID = itemstock.RowID
              LEFT JOIN item ON itemstock.ItemCode = item.itemcode
              LEFT JOIN packingmat ON item.PackingMatID = packingmat.ID 
            WHERE
              MONTH( sterile.ModifyDate ) BETWEEN MONTH( '$start_date' ) AND MONTH( '$end_date' )
              AND YEAR( sterile.ModifyDate ) BETWEEN YEAR( '$start_date' ) AND YEAR( '$end_date' )  
              AND CAST( TIME( sterile.ModifyDate ) AS time ) >= CAST( '08:00:00' AS time ) 
              AND CAST( TIME( sterile.ModifyDate ) AS time ) <= CAST( '16:00:00' AS time ) 
              AND sterile.B_ID = '$B_ID'
              AND item.NoWash = '1'
              $Round_Machine
            GROUP BY
              item.itemcode,
              item.PackingMatID
            ORDER BY
              item.itemname ASC ";
  $count = 1;
  $meQuery2 = mysqli_query($conn, $Detail);
  while ($Result2 = mysqli_fetch_assoc($meQuery2)) {
    $itemcode = $Result2['itemcode'];

    $html .= '<tr nobr="true">';
    $html .=   '<td width="10 mm" align="center">' . $count . '</td>';
    $html .=   '<td width="40 mm" align="left">' . $Result2['itemname'] . '</td>';


    // Qty รายเดือน
    $sum_qty_month = 0;
    foreach ($allmonth as $key => $value) {

      $showqty = "SELECT
                    SUM( steriledetail.Qty ) AS Qty 
                  FROM
                    sterile
                    LEFT JOIN sterilemachine ON sterile.SterileMachineID = sterilemachine.ID
                    LEFT JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo
                    LEFT JOIN itemstock ON steriledetail.ItemStockID = itemstock.RowID
                    LEFT JOIN item ON itemstock.ItemCode = item.itemcode
                    LEFT JOIN packingmat ON item.PackingMatID = packingmat.ID 
                  WHERE
                    MONTH( sterile.ModifyDate ) = '$value'
                    AND YEAR( sterile.ModifyDate ) = YEAR( '$start_date' )
                    AND CAST( TIME( sterile.ModifyDate ) AS time ) >= CAST( '08:00:00' AS time ) 
                    AND CAST( TIME( sterile.ModifyDate ) AS time ) <= CAST( '16:00:00' AS time ) 
                    AND item.itemcode = '$itemcode'
                    AND sterile.B_ID = '$B_ID'
                    AND item.NoWash = '1'
                    $Round_Machine
                  GROUP BY
                    item.itemcode,
                    item.PackingMatID ";

      $chk_month = 0;
      $meQuery3 = mysqli_query($conn, $showqty);
      while ($Result3 = mysqli_fetch_assoc($meQuery3)) {
        $qty_month = $Result3['Qty'];
        $html .=   '<td  width=" ' . $width_date . ' mm " align="center">' . $qty_month . '</td>';
        $chk_month = 1;
        $sum_qty_month += $qty_month;
      }
      // check ค่าว่าง ให้เติม - 
      if ($chk_month == 0) {
        $html .=   '<td  width=" ' . $width_date . ' mm " align="center">-</td>';
      }
    }

    // ผลรวมแถบบน
    $html .=   '<td  width=" ' . $width_date . ' mm " align="center">' . $sum_qty_month . '</td>';
    $html .=  '</tr>';
    $count++;
  }

  // แถบรวมล่าง
  $html .= '<tr nobr="true">';
  $html .=   '<td width="50 mm" align="center">รวม</td>';
  foreach ($allmonth as $key => $value) {
    $showsum = "SELECT
                  SUM( steriledetail.Qty ) AS Qty 
                FROM
                  sterile
                  LEFT JOIN sterilemachine ON sterile.SterileMachineID = sterilemachine.ID
                  LEFT JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo
                  LEFT JOIN itemstock ON steriledetail.ItemStockID = itemstock.RowID
                  LEFT JOIN item ON itemstock.ItemCode = item.itemcode
                  LEFT JOIN packingmat ON item.PackingMatID = packingmat.ID 
                WHERE
                  MONTH( sterile.ModifyDate ) = '$value'
                  AND YEAR( sterile.ModifyDate ) = YEAR( '2020-01-03' )
                  AND CAST( TIME( sterile.ModifyDate ) AS time ) >= CAST( '08:00:00' AS time ) 
                  AND CAST( TIME( sterile.ModifyDate ) AS time ) <= CAST( '16:00:00' AS time )
                  AND sterile.B_ID = '$B_ID'
                  AND item.NoWash = '1'
                    $Round_Machine ";

    $meQuery4 = mysqli_query($conn, $showsum);
    while ($Result4 = mysqli_fetch_assoc($meQuery4)) {
      $qty_month_total = $Result4['Qty'] == NULL ? '-' : $Result4['Qty'];
      $html .=   '<td  width=" ' . $width_date . ' mm " align="center">' . $qty_month_total . '</td>';
      $chk_month_end = 1;
      $sum_qty_month_end += $qty_month_total;
    }
  }


  // ผลรวมแถบล่าง
  $html .=   '<td  width=" ' . $width_date . ' mm " align="center">' . $sum_qty_month_end . '</td>';

  $html .=  '</tr>';
  $html .= '</table>';

  $pdf->writeHTML($html, true, false, false, false, '');
} else if ($type_report == 'YEAR') {

  $pdf->AddPage('P', 'A4');
  $sY = $_GET['Year1'];
  $eY = $_GET['Year2'];

  $start_date="09-09-".$sY;
  $end_date="09-09-".$eY;

  
  $Machine = $_GET['Machine'];
  $Round = $_GET['Round'];
  $ID_machine = "";
  if($Machine != '-' && $Round != '-')
  {
    $Sql_machine = "SELECT
                      sterilemachine.ID
                    FROM
                      sterilemachine
                    WHERE sterilemachine.MachineName2 = '$Machine' ";
    $meQuery_machine = mysqli_query($conn, $Sql_machine);
    $Result_machine = mysqli_fetch_assoc($meQuery_machine);
    $ID_machine = $Result_machine['ID'];

    $Round_Machine = "	AND sterile.SterileMachineID = '$ID_machine' AND Sterile.SterileRoundNumber = '$Round'";
  }
  else
  {
    $Round_Machine = "";
  }

  $begin = new DateTime($start_date);
  $end = new DateTime($end_date);
  $end = $end->modify('1 day');

  $interval = new DateInterval('P1M');
  $period = new DatePeriod($begin, $interval, $end);
  $datetime = new DatetimeTH();
  $allyear = array();
  foreach ($period as $key => $value) {
    array_push($allyear, $value->format('Y'));
  }
  $allyear = array_unique($allyear);
  $count = sizeof($allyear);
  $width_date = 130 / ($count + 1);

  $pdf->Ln(10);
  $pdf->SetFont('thsarabun', 'b', 14);
  $html = '<table cellspacing="0" cellpadding="2" border="1" >
  <thead><tr style="font-size:18px;font-weight: bold;">
  <th  width="10 mm" align="center">ลำดับ</th>
  <th  width="40 mm" align="center">รายการ</th>';
  $pdf->SetFont('thsarabun', '', 14);
  foreach ($allyear as $key => $value) {
    $html .= '<th  width=" ' . $width_date . ' mm " align="center">' .  $datetime->getTHyear($value) . '</th>';
  }
  $html .= '<th  width=" ' . $width_date . ' mm " align="center">รวม</th> </tr> </thead> ';
  // ===================================================================================================
  $start_date = explode("-", $start_date);
  $start_date = $start_date[2] . '-' . $start_date[1] . '-' . $start_date[0];
  $end_date = explode("-", $end_date);
  $end_date = $end_date[2] . '-' . $end_date[1] . '-' . $end_date[0];
  // รายละเอียด 
  $Detail = "SELECT
            item.itemcode,
            item.itemname
          FROM
            sterile
            LEFT JOIN sterilemachine ON sterile.SterileMachineID = sterilemachine.ID
            LEFT JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo
            LEFT JOIN itemstock ON steriledetail.ItemStockID = itemstock.RowID
            LEFT JOIN item ON itemstock.ItemCode = item.itemcode
            LEFT JOIN packingmat ON item.PackingMatID = packingmat.ID 
          WHERE
            YEAR( sterile.ModifyDate ) BETWEEN YEAR( '$start_date' ) AND YEAR( '$end_date' )  
            AND CAST( TIME( sterile.ModifyDate ) AS time ) >= CAST( '08:00:00' AS time ) 
            AND CAST( TIME( sterile.ModifyDate ) AS time ) <= CAST( '16:00:00' AS time ) 
            AND sterile.B_ID = '$B_ID'
            AND item.NoWash = '1'
              $Round_Machine
          GROUP BY
            item.itemcode,
            item.PackingMatID 
          ORDER BY
            item.itemname ASC ";
  $count = 1;
  $meQuery2 = mysqli_query($conn, $Detail);
  while ($Result2 = mysqli_fetch_assoc($meQuery2)) {
    $itemcode = $Result2['itemcode'];

    $html .= '<tr nobr="true">';
    $html .=   '<td width="10 mm" align="center">' . $count . '</td>';
    $html .=   '<td width="40 mm" align="left">' . $Result2['itemname'] . '</td>';


    // Qty รายเดือน
    $sum_qty_year = 0;
    foreach ($allyear as $key => $value) {

      $showqty = "SELECT
                  SUM( steriledetail.Qty ) AS Qty 
                FROM
                  sterile
                  LEFT JOIN sterilemachine ON sterile.SterileMachineID = sterilemachine.ID
                  LEFT JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo
                  LEFT JOIN itemstock ON steriledetail.ItemStockID = itemstock.RowID
                  LEFT JOIN item ON itemstock.ItemCode = item.itemcode
                  LEFT JOIN packingmat ON item.PackingMatID = packingmat.ID 
                WHERE
                  YEAR( sterile.ModifyDate ) = '$value'
                  AND CAST( TIME( sterile.ModifyDate ) AS time ) >= CAST( '08:00:00' AS time ) 
                  AND CAST( TIME( sterile.ModifyDate ) AS time ) <= CAST( '16:00:00' AS time ) 
                  AND item.itemcode = '$itemcode'
                  AND sterile.B_ID = '$B_ID'
                  AND item.NoWash = '1'
                      $Round_Machine
                GROUP BY
                  item.itemcode,
                  item.PackingMatID ";

      $chk_year = 0;
      $meQuery3 = mysqli_query($conn, $showqty);
      while ($Result3 = mysqli_fetch_assoc($meQuery3)) {
        $qty_year = $Result3['Qty'];
        $html .=   '<td  width=" ' . $width_date . ' mm " align="center">' . $qty_year . '</td>';
        $chk_year = 1;
        $sum_qty_year += $qty_year;
      }
      // check ค่าว่าง ให้เติม - 
      if ($chk_year == 0) {
        $html .=   '<td  width=" ' . $width_date . ' mm " align="center">-</td>';
      }
    }

    // ผลรวมแถบบน
    $html .=   '<td  width=" ' . $width_date . ' mm " align="center">' . $sum_qty_year . '</td>';
    $html .=  '</tr>';
    $count++;
  }

  // แถบรวมล่าง
  $html .= '<tr nobr="true">';
  $html .=   '<td width="50 mm" align="center">รวม</td>';
  foreach ($allyear as $key => $value) {
    $showsum = "SELECT
                SUM( steriledetail.Qty ) AS Qty 
              FROM
                sterile
                LEFT JOIN sterilemachine ON sterile.SterileMachineID = sterilemachine.ID
                LEFT JOIN steriledetail ON sterile.DocNo = steriledetail.DocNo
                LEFT JOIN itemstock ON steriledetail.ItemStockID = itemstock.RowID
                LEFT JOIN item ON itemstock.ItemCode = item.itemcode
                LEFT JOIN packingmat ON item.PackingMatID = packingmat.ID 
              WHERE
                YEAR( sterile.ModifyDate ) = '$value'
                AND CAST( TIME( sterile.ModifyDate ) AS time ) >= CAST( '08:00:00' AS time ) 
                AND CAST( TIME( sterile.ModifyDate ) AS time ) <= CAST( '16:00:00' AS time )
                AND sterile.B_ID = '$B_ID'
                AND item.NoWash = '1'
                      $Round_Machine ";

    $meQuery4 = mysqli_query($conn, $showsum);
    while ($Result4 = mysqli_fetch_assoc($meQuery4)) {
      $qty_year_total = $Result4['Qty'] == NULL ? '-' : $Result4['Qty'];
      $html .=   '<td  width=" ' . $width_date . ' mm " align="center">' . $qty_year_total . '</td>';
      $chk_year_end = 1;
      $sum_qty_year_end += $qty_year_total;
    }
  }


  // ผลรวมแถบล่าง
  $html .=   '<td  width=" ' . $width_date . ' mm " align="center">' . $sum_qty_year_end . '</td>';

  $html .=  '</tr>';
  $html .= '</table>';

  $pdf->writeHTML($html, true, false, false, false, '');
}
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
