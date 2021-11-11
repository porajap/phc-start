<html>
<head>
<title>TEST PHP : PDF</title>
</head>
<body>
<?php
 require('fpdf.php');
 require('../connect.php');
 require('Class.php');
  class PDF extends FPDF{
  function BasicTable($header){
//ส่วน colums
   foreach($header as $col)
       $this->Cell(30,7,$col,1); //กำหนดความกว้างของ colums
   $this->Ln();
   }
}
$pdf=new PDF();
$header=array('Colum 1','Colum 2','Column 3','Column 4','Column 5'); // เพิ่ม colums
$pdf->SetFont('Arial','',10);
$pdf->AddPage();
$pdf->BasicTable($header);
$pdf->Output("MyPDF/MyPDF.pdf","F");
?>
</body>
</html>