<?php
session_start();
require 'connect.php';
	$ItemCode = $_REQUEST["ItemCode"];
	$NameTH = $_REQUEST["NameTH"];
	
		$Sql = "SELECT customer.FName ";
		$Sql .= "FROM sale ";
		$Sql .= "INNER JOIN sale_detail ON sale.DocNo = sale_detail.DocNo ";
		$Sql .= "INNER JOIN item ON sale_detail.Item_Code = item.Item_Code ";
		$Sql .= "INNER JOIN customer ON sale.Cus_Code = customer.Cus_Code ";
		$Sql .= "WHERE sale_detail.Item_Code = '$ItemCode' ";
		$Sql .= "GROUP BY sale.Cus_Code ORDER BY customer.FName ASC";

	//echo $Sql."<br>";
	$meQuery = mysqli_query($conn,$Sql);
	$i=0;
	while ($Result = mysqli_fetch_assoc($meQuery))
	{
		$FName[$i]	=  $Result["FName"];
		$i++;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Login</title>
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
	<script language="javascript" >
		$('#uName').keydown(function (event) {
			alert(event.keyCode);
			var keypressed = event.keyCode || event.which;
			if (keypressed == 13) {
				alert("xxxx");
				//$("#pWord").focus();
			}
		});
		
		$('#submit-button-1').click(function() {
			$.mobile.changePage($('#page2'), 'pop'); 
		});

	</script>
    <style id="custom-icon">
        .ui-icon-custom:after {
			background-image: url("../_assets/img/glyphish-icons/21-skull.png");
			background-position: 3px 3px;
			background-size: 70%;
		}
    </style>
</head>

<body>

		<div data-demo-html="true">
			<div data-role="header">
            	<a href="SelProduct.php" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-carat-l">กลับ</a>
            	<h1> <?php echo $Area ?> : คุณ<?php echo $xName ?></h1>
				<a href="logoff.php" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power">ออก</a>
			</div>
		</div>
	<table width="100%" border="0" cellspacing="5" cellpadding="5">
                <tr>
                    <td>
                        <div align="center"><img src="img/logo.png" width="220" height="45" /></div>
                    </td>
                </tr>
              <tr>
              <tr>
                    <td>
                        <div align="center"><?php echo $xCusFullName ?></div>
                    </td>
              </tr>
                
              <tr>
              
                <td>
         <div data-demo-html="true">

			<table data-role="table" id="table-custom-2" data-mode="columntoggle" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columns to display..." data-column-popup-theme="a">

                <thead>
                  <tr class="ui-bar-d">
                    <th data-priority="1"></th>
                    <th data-priority="2"><?php echo $NameTH ?></th>
                  </tr>
                  <tr class="ui-bar-d">
                    <th data-priority="2" width="100px">ลำดับ</th>
                    <th>ชื่อลูกค้า</th>
                  </tr>                 
                </thead>
                <tbody>
                
 <?php 	for($j=0;$j<$i;$j++){ ?>               
                  <tr>
                    <th><?php echo $j+1 ?></th>
                    <td><?php echo $FName[$j] ?></td>
                  </tr>
<?php } ?>
                </tbody>
              </table>

		</div>
                </td>
              </tr>
</table>


</body>

</html>
