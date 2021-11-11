<?php
require('tcpdf/tcpdf.php');
require('../../connect.php');
require('Class.php');
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
//--------------------------------------------------------------------------


$bid = $_GET['bid'];
$eDate = $_GET['eDate'];
$docno = $_GET['docno'];

  $docno = str_replace("[","",$docno);
  $docno = str_replace(" ","",$docno);
  $docno = str_replace("]","",$docno);

$docno_arr = explode(",", $docno);

// foreach ($docno_arr as $key => $value)
// {
//   echo $value;
// }

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
    // require('../../connect.php');
    // $datetime = new DatetimeTH();
    // // date th
    // $printdate = date('d') . " " . $datetime->getTHmonth(date('F')) . " พ.ศ. " . $datetime->getTHyear(date('Y'));

    //   $B_ID = $_GET['bid'];

    //   $B = "SELECT
    //           BdName
    //         FROM
    //           buildg
    //         WHERE ID = '$B_ID' ";
    //     $BQ = mysqli_query($conn, $B);
    //     while ($RB = mysqli_fetch_assoc($BQ))
    //     {
    //       $BdName = $RB['BdName'];
    //     }




    // if ($this->page == 1) {
    //     // Set font
    //     $this->SetFont('thsarabun', '', 9);
    //     // Title
    //     $this->Cell(0, 10,  'วันที่พิมพ์รายงาน' . $printdate, 0, 1, 'R');

    //     $this->SetFont('thsarabun', 'b', 22);
    //     $this->Cell(0, 10,  "รายงานเรียกคืนอุปกรณ์ ", 0, 1, 'C');
        
    //     $this->SetFont('thsarabun', 'b', 18);
    //     $this->Cell(0, 10,"ประจำตึก : $BdName ", 0, 1, 'C');
    //     $this->Ln(10);
    // }
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

$datetime = new DatetimeTH();
// date th
$printdate = date('d') . " " . $datetime->getTHmonth(date('F')) . " พ.ศ. " . $datetime->getTHyear(date('Y'));

  $B_ID = $_GET['bid'];

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


    //=============================================================== show header 
      $x = 0;
      $y = 0;
      $Sql_head = "SELECT
      department.DepName2
      FROM
      recall
      INNER JOIN department ON recall.DeptID = department.ID
      INNER JOIN recall_type ON recall.DocTypeNo = recall_type.ID
      WHERE
      recall.DocNo  IN ( ";
                      foreach ($docno_arr as $key => $value)
                      {
                        $Sql_head .= " '$value' ,";
                      }
                      $Sql_head = rtrim($Sql_head, ' ,'); 
        $Sql_head .= " ) AND recall.B_ID = '$bid'
                    GROUP BY  department.DepName2 ";
      $meQuery_head = mysqli_query($conn,$Sql_head);
      while ($Result_head = mysqli_fetch_assoc($meQuery_head))
      {
        $DepName2_head[$x] = $Result_head['DepName2'];
        $x++;
      }
  // ====================================================================


    //=============================================================== show header 
    $x_show = 0;
    $y_show = 0;
    $Sql_head = "SELECT
    department.DepName2,
	  recall.DocNo
    FROM
    recall
    INNER JOIN department ON recall.DeptID = department.ID
    INNER JOIN recall_type ON recall.DocTypeNo = recall_type.ID
    WHERE
    recall.DocNo  IN ( ";
                    foreach ($docno_arr as $key => $value)
                    {
                      $Sql_head .= " '$value' ,";
                    }
                    $Sql_head = rtrim($Sql_head, ' ,'); 
      $Sql_head .= " ) AND recall.B_ID = '$bid'
                      ORDER BY DepName2	";
    $meQuery_head = mysqli_query($conn,$Sql_head);
    while ($Result_head = mysqli_fetch_assoc($meQuery_head))
    {
      $DepName2_show[$x] = $Result_head['DepName2'];
      $DocNo_show[$x] = $Result_head['DocNo'];
      $x++;
    }
// ====================================================================




foreach ($DocNo_show as $key => $value)
{
  $pdf->AddPage('P', 'A4');
  $pdf->Ln(10);
  // หัวข้อ 
  $Sql = "SELECT
  department.DepName2,
  recall.DocNo,
  DATE_FORMAT(recall.DocDate, '%d-%m-%Y') AS DocDate,
  recall_type.TyeName AS DocTypeNo,
  COALESCE ((recall.Remark), '-') AS Remark
  FROM
  recall
  INNER JOIN department ON recall.DeptID = department.ID
  INNER JOIN recall_type ON recall.DocTypeNo = recall_type.ID
  WHERE
  recall.DocNo = '$value'
  AND recall.B_ID = '$bid' ";
  $meQuery = mysqli_query($conn,$Sql);
  while ($Result = mysqli_fetch_assoc($meQuery))
  {
    $DepName2 = $Result['DepName2'];
    $DocNo = $Result['DocNo'];
    $DocDate = $Result['DocDate'];
    $DocTypeNo = $Result['DocTypeNo'];
    $Remark = $Result['Remark'];


  //=============================================================== show header 
   if($DepName2 == $DepName2_head[$y] )
   {
    $pdf->SetY(10);
    $pdf->SetFont('thsarabun', '', 9);
    // Title
    $pdf->Cell(0, 10,  'วันที่พิมพ์รายงาน' . $printdate, 0, 1, 'R');

    $pdf->SetFont('thsarabun', 'b', 22);
    $pdf->Cell(0, 10,  "รายงานเรียกคืนอุปกรณ์ ", 0, 1, 'C');
    
    $pdf->SetFont('thsarabun', 'b', 18);
    $pdf->Cell(0, 10,"ประจำตึก : $BdName ", 0, 1, 'C');
    $pdf->Ln(10);

    $y++;
   }
    //===============================================================







    $pdf->SetFont('thsarabun', 'b', 15);
    $pdf->Cell(35, 7,  "แผนก  : " . $DepName2  , 0, 0, 'L');
    $pdf->Cell(130, 7, "วันที่เรียกคืน  :  " . $DocDate , 0, 1, 'R');
    $pdf->Cell(35, 7,  "ประเภทการเรียกคืน : " . $DocTypeNo , 0, 1, 'L');
    $pdf->Cell(35, 7,  "เลขที่เครื่อง : " . $DocNo , 0, 1, 'L');
    $pdf->Cell(35, 7,  "หมายเหตุ : " . $Remark , 0, 1, 'L');
    $pdf->Ln(5);



    //  ขึ้นหัวตาราง
        $html = '<table cellspacing="0" cellpadding="2" border="1" >
                <thead><tr style="font-size:18px;font-weight: bold;">
                <th  width="20 mm" align="center">ลำดับ</th>
                <th  width="70 mm" align="center">รายการ</th>
                <th  width="45 mm" align="center">รหัสอุปกกรณ์</th>
                <th  width="45 mm" align="center">วันหมดอายุ</th></tr></thead>';
    $Sql2 = "SELECT
    item.itemname,
    itemstock.UsageCode,
    DATE_FORMAT(recalldetail.ExpireDate,'%d-%m-%Y') AS ExpireDate
    FROM
    recalldetail
    INNER JOIN itemstock ON recalldetail.ItemStockID = itemstock.RowID
    INNER JOIN item ON itemstock.ItemCode = item.itemcode
    WHERE recalldetail.DocNo = '$DocNo'
    ORDER BY  itemstock.UsageCode ASC  ";
      $meQuery2 = mysqli_query($conn,$Sql2);
      while ($Result2 = mysqli_fetch_assoc($meQuery2))
      {
          $html .= '<tr nobr="true">';
          $html .=   '<td width="20mm" align="center">' . $count . '</td>';
          $html .=   '<td width="70mm" align="left"> ' . $Result2['itemname'] . '</td>';
          $html .=   '<td width="45mm" align="center">' . $Result2['UsageCode'] . '</td>';
          $html .=   '<td width="45mm" align="center">' . $Result2['ExpireDate'] . '</td>';
          $html .=  '</tr>';
          $count++;
      }

   $count = 1;
   $html .= '</table>';
   $pdf->writeHTML($html, true, false, false, false, '');

  }

}

$pdf->SetFont('thsarabun', 'b', 14);
$pdf->SetLineWidth(0.3);
$pdf->sety($pdf->Gety() - 8.0);
// ---------------------------------------------------------

//Close and output PDF document
$ddate = date('d_m_Y');
$pdf->Output('Report_Recall_' . $ddate . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
