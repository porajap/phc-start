<?php
session_start();
require 'connect.php';
require 'function.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");

	if($_SESSION["Area"] == "") header('location:index.html');
    $AreaCode = $_SESSION["Area"];
    $xTitle = "บันทึกขอซื้อ";

    $month  = date('m', time());
    $year  = date('Y', time());

    // $date = DateTime::createFromFormat('m-d-Y', date('m-d-Y', time()));
    // $date->modify('-1 month');
    // $month  = $date->format('m');
    // $year  = $date->format('Y');
   // echo $date->format('m-d-Y')."<br />";

    $imonth = (int)$month;
    $sDate = date('Y-m-d', time());
    $eDate = date('Y-m-d', time());

    $Sql = "SELECT perioddallycall.sDate,perioddallycall.eDate
    FROM perioddallycall
    WHERE perioddallycall.`Year` = '$year'
    AND perioddallycall.`Month` = '$month'";
    $meQuery = mysqli_query($conn,$Sql);
    while ($Result = mysqli_fetch_assoc($meQuery)){
        $sDate = $Result["sDate"];
        $eDate = $Result["eDate"];
    }

    $_SESSION["MY1"] = $sDate;
	$_SESSION["MY2"] = $eDate;
//    echo $month." :: ".$year." :: ".(int)$month." :: ".$sDate." :: ".$eDate." <br /> ";

    $data = array();
    # Grab the data from the database
    $Sql = "SELECT collection_target.Total
    FROM collection_target
    INNER JOIN employee ON employee.AreaCode = collection_target.xAreaCode
    WHERE collection_target.xMonth ='$imonth'
    AND collection_target.xYear = '$year'
    AND collection_target.xAreaCode = '$AreaCode'
    AND collection_target.xAreaCode !='PO00'";
    $meQuery = mysqli_query($conn,$Sql);
    $target=0;
    while ($Result = mysqli_fetch_assoc($meQuery)){
        $target = $Result["Total"];
    }

    $Sql = "SELECT
    `check`.Check_ModifyDate, 
    customer.Cus_Code,
    customer.FName,
    IFNULL(sale.DocNoAcc,'')AS DocNoAcc,
    sale.Total- sale.DeductCN_Price + sale.Add_Money AS Total,
    CASE WHEN sale.ExpressCode !='' then express.Express
    ELSE 'ผู้แทนจ่าย' end AS 'ประเภทการชำระเงิน' ,
    CASE WHEN sale.IsCheckIn = '1' AND sale.ExpressCode IN(2,3,6) THEN 'จ่ายแล้ว'
         WHEN sale.IsCheckIn = '1' AND sale.ExpressCode = '1' THEN 'รับเช็ค ( เคลียร์แล้ว )'
         WHEN sale.IsCheckIn = '3' AND sale.ExpressCode = '1' THEN 'รับเช็ค ( รอเคลียร์ )'
         WHEN sale.IsCheckIn = '4' THEN 'ผู้แทนจ่าย' 
    ELSE '' end AS 'สถานะ',
    sale.AreaCode
    FROM
    sale
    LEFT JOIN `check` ON `check`.ID = sale.CheckNo
    LEFT JOIN customer ON sale.Cus_Code = customer.Cus_Code
    LEFT JOIN express ON sale.ExpressCode = express.id
    WHERE
    (date(`check`.Check_ModifyDate) between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() )
    AND sale.AreaCode ='$AreaCode'
    AND sale.IsCheckIn IN('1','3','4') 
    
    UNION
    SELECT 
    `check`.Check_ModifyDate,
    customer.Cus_Code,
    customer.FName,
    IFNULL(sale_x.DocNoAcc,'')AS DocNoAcc,
    sale_x.Total- sale_x.DeductCN_Price + sale_x.Add_Money AS Total,
    CASE WHEN sale_x.ExpressCode !='' then express.Express
    ELSE 'ผู้แทนจ่าย' end AS 'ประเภทการชำระเงิน' ,
    CASE WHEN sale_x.IsCheckIn = '1' AND sale_x.ExpressCode IN(2,3,6) THEN 'จ่ายแล้ว'
         WHEN sale_x.IsCheckIn = '1' AND sale_x.ExpressCode = '1' THEN 'รับเช็ค ( เคลียร์แล้ว )'
         WHEN sale_x.IsCheckIn = '3' AND sale_x.ExpressCode = '1' THEN 'รับเช็ค ( รอเคลียร์ )'
         WHEN sale_x.IsCheckIn = '4' THEN 'ผู้แทนจ่าย' 
    ELSE '' end AS 'สถานะ',
    sale_x.AreaCode
    FROM
    sale_x
    LEFT JOIN `check` ON `check`.ID = sale_x.CheckNo
    LEFT JOIN customer ON sale_x.Cus_Code = customer.Cus_Code
    LEFT JOIN express ON sale_x.ExpressCode = express.id
    WHERE
    (date(`check`.Check_ModifyDate) between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() )
    AND sale_x.AreaCode ='$AreaCode'
    AND sale_x.IsCheckIn IN('1','3','4') 
    ORDER BY DocNoAcc";
    $meQuery = mysqli_query($conn,$Sql);
    $Money1=0;
    $cnt=0;
    while ($Result = mysqli_fetch_assoc($meQuery)){
        $Money1 += $Result["Total"];
        $cnt++;
    }
    // echo "Cnt : ".$cnt." <br />  <br />";
    // echo $Money1." <br />  <br />";
    // echo $Sql." <br />  <br />";
    $data1 = ($Money1/$target)*100;
    if(($Money1/$target) <= 1){
        $data2 = 100-$data1;
    }else{
        $data2 = 200-$data1;
    }
    // echo $Money1." / ".$target." :: ".$data1." :: ".$data2;
    $Money2=0;
    $Sql = "SELECT ";
	$Sql .= "dallycall.Id,dallycall.DocNo,dallycall.xDate AS DocDate,CONCAT(customer.FName,' ',customer.LName) AS xName,";
	$Sql .= "item.NameTH,dallycall.Qty,dallycall.Price,dallycall.Total,dallycall.DiscountP,dallycall.DiscountB,";
	$Sql .= "dallycall.VatB,dallycall.CmsP,dallycall.CmsB,dallycall.Total2,dallycall.WelfareP,dallycall.WelfareB,";
	$Sql .= "dallycall.Total3,dallycall.DallyP,dallycall.DallyB,contact.CT_Name,dallycall.BonusItemCode,";
	$Sql .= "dallycall.AreaCode,dallycall.AreaCode2,sale.isArea,sale.Sale_Status ";
	
	$Sql .= "FROM dallycall ";
	
	$Sql .= "INNER JOIN sale ON dallycall.DocNo = sale.DocNo ";
	$Sql .= "INNER JOIN customer ON dallycall.Cus_Code = customer.Cus_Code ";
	$Sql .= "INNER JOIN contact ON dallycall.CT_Code = contact.CT_Code ";
	$Sql .= "INNER JOIN item ON dallycall.ItemCode = item.Item_Code ";
	
	$Sql .= "WHERE dallycall.AreaCode = '$AreaCode' ";

	$Sql .= "AND sale.DocDate BETWEEN '$sDate' AND '$eDate' ";
	$Sql .= "AND dallycall.AreaCode2 = '-' ";
	$Sql .= "AND dallycall.IsCancel = 0 ";
	$Sql .= "AND sale.IsCancel = 0 ";

	$Sql .= "ORDER BY xDate ASC";
	// echo $Sql;
    $Sql123 = $Sql;
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
        $Money2 += $Result["WelfareB"];
    }

    $Sql = "SELECT ";
    $Sql .= "Refund ";
    $Sql .= "FROM refund ";
    $Sql .= "WHERE Area = '$AreaCode' ";
    $Sql .= "AND  xYear = '".substr($eDate,0,4)."' ";
    $Sql .= "AND xMounth = '".substr($eDate,5,2)."' ";
    $Refund = "0";
    $meQuery = mysqli_query($conn,$Sql);
    while ($Result = mysqli_fetch_assoc($meQuery))
    {
        $Refund = $Result["Refund"];
    }

    $Sql = "SELECT
    sale.DocNoAcc,
    customer.FName,
    IF (sale.AreaCode <> '',sale.AreaCode,customer.AreaCode) AS AreaCode,
    DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30 AS Day,
    CASE WHEN sale.DocDateAcc != '' AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30 >= 241 AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30 <= 360 THEN (sale.Total - sale.DeductCN_Price + sale.Add_Money)*0.25/100
           WHEN sale.DocDateAcc = ''  AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30 >= 241 AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30 <= 360   THEN (sale.Total - sale.DeductCN_Price + sale.Add_Money)*0.25/100
    ELSE '' END AS 'Total'
    FROM
        sale
    INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code
    LEFT JOIN checkinsub ON checkinsub.DocNoAcc = sale.DocNoAcc
    LEFT JOIN checkin ON checkin.NoDoc = checkinsub.NoDoc
    WHERE
        sale.AreaCode = '$AreaCode'
    AND sale.DocNoAcc != ''
    AND sale.IsCheckIn = 0
    AND (
        checkin.IsClear = 0
        OR checkin.IsClear IS NULL
    )
    AND sale.IsCancel = 0
    AND sale.IsCopy = 0
    AND sale.Cn = '0'
    AND sale.DocDateAcc BETWEEN ('2015-01-01') AND DATE(NOW())
    AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc)+ 30 >= 241 AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30 <= 360
    UNION
    
    SELECT
    sale_x.DocNoAcc,
    customer.FName,
    IF (sale_x.AreaCode <> '',sale_x.AreaCode,customer.AreaCode) AS AreaCode,
    DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc)+ 30 AS Day,
    CASE WHEN sale_x.DocDateAcc != '' AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc) + 30 >= 241 AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc) + 30 <= 360 THEN (sale_x.Total - sale_x.DeductCN_Price + sale_x.Add_Money)*0.25/100
           WHEN sale_x.DocDateAcc = ''  AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc) + 30 >= 241 AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc) + 30 <= 360   THEN (sale_x.Total - sale_x.DeductCN_Price + sale_x.Add_Money)*0.25/100
    ELSE '' END AS 'Total'
    FROM
        sale_x
    INNER JOIN customer ON sale_x.Cus_Code = customer.Cus_Code
    LEFT JOIN checkinsub ON checkinsub.DocNoAcc = sale_x.DocNoAcc
    LEFT JOIN checkin ON checkin.NoDoc = checkinsub.NoDoc
    WHERE
        sale_x.AreaCode = '$AreaCode'
    AND sale_x.DocNoAcc != ''
    AND sale_x.IsCheckIn = 0
    AND (
        checkin.IsClear = 0
        OR checkin.IsClear IS NULL
    )
    AND sale_x.Sale_Status = 1
    AND sale_x.DocDateAcc BETWEEN ('2015-01-01') AND DATE(NOW())
    AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc)+ 30 >= 241 AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc) + 30 <= 360
    ORDER BY 	DocNoAcc ASC";
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
    $Money3=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
        $Money3 += $Result["Total"];
    }


    $Sql = "SELECT
    sale.DocNoAcc,
    customer.FName,
    IF (sale.AreaCode <> '',sale.AreaCode,customer.AreaCode) AS AreaCode,
    DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30 AS Day,
    CASE WHEN sale.DocDateAcc != '' AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30 >= 361  THEN (sale.Total - sale.DeductCN_Price + sale.Add_Money)*0.50/100
           WHEN sale.DocDateAcc = ''  AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc) + 30 >= 361    THEN (sale.Total - sale.DeductCN_Price + sale.Add_Money)*0.50/100
    ELSE '' END AS 'Total'
    FROM sale
    INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code
    LEFT JOIN checkinsub ON checkinsub.DocNoAcc = sale.DocNoAcc
    LEFT JOIN checkin ON checkin.NoDoc = checkinsub.NoDoc
    WHERE sale.AreaCode = '$AreaCode'
    AND sale.DocNoAcc != ''
    AND sale.IsCheckIn = 0
    AND (
        checkin.IsClear = 0
        OR checkin.IsClear IS NULL
    )
    AND sale.IsCancel = 0
    AND sale.IsCopy = 0
    AND sale.Cn = '0'
    AND sale.DocDateAcc BETWEEN ('2015-01-01') AND DATE(NOW())
    AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale.DocDateAcc)+ 30 >= 361 
    
    UNION
    
    SELECT
    sale_x.DocNoAcc,
    customer.FName,
    IF (sale_x.AreaCode <> '',sale_x.AreaCode,customer.AreaCode) AS AreaCode,
    DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc)+ 30 AS Day,
    CASE WHEN sale_x.DocDateAcc != '' AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc) + 30 >= 361  THEN (sale_x.Total - sale_x.DeductCN_Price + sale_x.Add_Money)*0.50/100
           WHEN sale_x.DocDateAcc = ''  AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc) + 30 >= 361    THEN (sale_x.Total - sale_x.DeductCN_Price + sale_x.Add_Money)*0.50/100
    ELSE '' END AS 'Total'
    FROM sale_x
    INNER JOIN customer ON sale_x.Cus_Code = customer.Cus_Code
    LEFT JOIN checkinsub ON checkinsub.DocNoAcc = sale_x.DocNoAcc
    LEFT JOIN checkin ON checkin.NoDoc = checkinsub.NoDoc
    WHERE sale_x.AreaCode = '$AreaCode'
    AND sale_x.DocNoAcc != ''
    AND sale_x.IsCheckIn = 0
    AND (
        checkin.IsClear = 0
        OR checkin.IsClear IS NULL
    )
    AND sale_x.Sale_Status = 1
    AND sale_x.DocDateAcc BETWEEN ('2015-01-01') AND DATE(NOW())
    AND DATEDIFF(DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'),INTERVAL 1 MONTH),sale_x.DocDateAcc)+ 30 >= 361 
    ORDER BY	DocNoAcc ASC";
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
    $Money4=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
        $Money4 += $Result["Total"];
    }


?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="icon/icon.ico">
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/sweetalert2.min.css">
	<link rel="stylesheet" href="css/topnav.css">
	<link rel="stylesheet" href="css/all.css">
	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
    <script type="text/javascript" src="js/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable( [
            ['', ''],
            ['', <?= $data1 ?>],
            ['', <?= $data2 ?>]
        ] );

        var options = {
            title: '',
            is3D: true,
            // width: 450,
            // height: 450,
            pointSize: 5,                           
            legend: {position: 'none'},
            chartArea: {
                left: 50,
                top: 10,
                width: 300,
                height: 230
            },
            // hAxis: {
            //     textStyle: {color: '#FF0000',fontName: 'Arial',fontSize: '28'}
            // },
            vAxis: {
                baselineColor: '#fff',
                gridlines: {color: '#fff'},
                // textStyle: {color: '#FF0000',fontName: 'Arial',fontSize: '28'},
                minValue: 64,
                maxValue: 71
            },
            fontSize: '14',
            tooltip: {trigger: 'none'},
            enableInteractivity: false,
            annotation: {
                1: {
                    style: 'default'
                }
            },
            series: {0: {color: '#4D7AD3'}, 1: {color: '#4D7AD3'}}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        function selectHandler(){
        var selectedItem = chart.getSelection()[0];
            if (selectedItem) 
            {
                var topping = data.getValue(selectedItem.row, 0);
            }
        } 

        google.visualization.events.addListener(chart, 'select', selectHandler);   
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div class="topnav">
        <a href="index.html"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?= $AreaCode ?> : <?= $xTitle ?></div>
        <div class="topnav-right">            
            <a href="p2.php"><img src="img/right-blue-arrow.png" width="30px" height="30px" /> </a>
        </div>
	</div>

    <div class="container">
        <div class="row" style="margin-top: 20px;">
            <div class="col-6">
                <div style="margin-left: 20px;">ยอดเก็บเดือน<?= $thaimonth[$imonth-1] ?></div>
            </div>
            <div class="col-3" style="text-align: right;">    
                <div style="margin-right: -10px;color:blue;font-weight: bold;"><?= number_format(intval($Money1), 0, '', ',') ?></div>
            </div>    
            <div class="col-1" style="text-align: left;">
                <div style="margin-left: -12px;">.<?= substr(number_format($Money1, 2, '.', ','),-2)  ?></div>
            </div> 
            <div class="col-2" style="text-align: left;">
                
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div style="margin-left: 20px;">Target เก็บเดือน<?= $thaimonth[$imonth-1] ?></div>
            </div>
            <div class="col-3" style="text-align: right;">    
                <div style="margin-right: -10px;color:blue;font-weight: bold;"><?= number_format(intval($target), 0, '', ',') ?></div>
            </div>    
            <div class="col-1" style="text-align: left;">
                <div style="margin-left: -12px;">.<?= substr(number_format($target, 2, '.', ','),-2)  ?></div>
            </div> 
            <div class="col-2" style="text-align: left;">
                <a href="listView1.php?sel=4&link=listView1"><img src="img/add.png" width="30px" height="30px" /></a>
            </div> 
        </div>

        <div class="row">  
            <div class="col-6">
                <div style="margin-left: 20px;">% ยอดเก็บ<?= $thaimonth[$imonth-1] ?></div>
            </div>
            <div class="col-3" style="text-align: right;">    
                <div style="margin-right: -10px;color:blue;font-weight: bold;"><?= number_format(intval($data1), 0, '', ',') ?></div>
            </div>    
            <div class="col-1" style="text-align: left;">
                <div style="margin-left: -12px;">.<?= substr(number_format($data1, 2, '.', ','),-2)  ?>%</div>
            </div>     
            <div class="col-2" style="text-align: left;">
                <a href="listView1.php?sel=1&link=listView1"><img src="img/add.png" width="30px" height="30px" /></a>
            </div> 
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?php if($data1>100){ ?>
                <div style="width: 550px; height: 250px;color:blue;text-align: center;line-height: 400px;font-size: 250%;font-family: 'Lucida Console', 'Courier New';">Perfect</div>
            <?php }else{ ?>
                <div id="piechart_3d" style="width: 550px; height: 250px;"></div>
            <?php } ?>    
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-6">
            <div style="margin-left: 20px;">ยอดถูกหักเกิน 240 ถึง 360 วัน</div>
        </div>
        <div class="col-4" style="text-align: right;">    
            <div style="margin-right: -10px;color:blue;font-weight: bold;"><?= number_format($Money3, 2, '.', ',') ?> บาท</div>
        </div>  
        <div class="col-1">
            <a href="listView1.php?sel=2&link=listView1"><img src="img/add.png" width="30px" height="30px" /></a>
        </div>
    </div>

    <div class="row" style="margin-top: 5px;">
        <div class="col-6">
            <div style="margin-left: 20px;">ยอดถูกหักเกิน 360วัน</div>
        </div>
        <div class="col-4" style="text-align: right;">    
            <div style="margin-right: -10px;color:blue;font-weight: bold;"><?= number_format($Money4, 2, '.', ',') ?> บาท</div>
        </div>  
        <div class="col-1">
            <a href="listView1.php?sel=3&link=listView1"><img src="img/add.png" width="30px" height="30px" /></a>
        </div>
    </div>

    <div class="row" style="margin-top: 5px;">
        <div class="col-6">
            <div style="margin-left: 20px;">รวมเป็นเงิน</div>
        </div>
        <div class="col-4" style="text-align: right;">    
            <div style="margin-right: -10px;color:blue;font-weight: bold;"><?= number_format($Money3+$Money4, 2, '.', ',') ?> บาท</div>
        </div>  
        <div class="col-1">
            
        </div>
    </div>

    <hr />
    <!-- <div class="row" style="margin-top: 20px;">
        <div class="col-7">
            <div style="margin-left: 20px;">ยอดเก็บ : </div>
        </div>
        <div class="col-3" style="text-align: right;">    
            <div style="margin-right: -10px;color:blue;font-weight: bold;"><?= number_format($data1, 2, '.', ',') ?>%</div>
        </div>  
        <div class="col-1">
            <a href="listView1.php?sel=1&link=listView1"><img src="img/add.png" width="30px" height="30px" /></a>
        </div>
    </div> -->

    <!-- <div class="row" style="margin-top: 20px;">
        <div class="col-7">
            <div style="margin-left: 20px;">ยอดค้าง : </div>
        </div>
        <div class="col-3" style="text-align: right;">    
            <div style="margin-right: -10px;color:blue;font-weight: bold;"><?= number_format($data2, 2, '.', ',') ?>%</div>
        </div>
        <div class="col-1">
            <a href="listView1.php?sel=2&link=listView1"><img src="img/add.png" width="30px" height="30px" /></a>
        </div>  
    </div> -->
    
    <div class="row" style="margin-top: 5px;">
        <div class="col-6">
            <div style="margin-left: 20px;">ยอดขาย</div>
        </div>
        <div class="col-4" style="text-align: right;">    
            <div style="margin-right: -10px;color:blue;font-weight: bold;"><?= number_format($Money2-$Refund, 2, '.', ',') ?> บาท</div>
        </div>
        <div class="col-1">
            <a href="dailycall02.php"><img src="img/add.png" width="30px" height="30px" /></a>
        </div>  
    </div>

  </body>
</html>