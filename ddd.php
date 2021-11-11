<?php
    session_start();
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
	$xName = $_SESSION["xName"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title></title>
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    
	<script src="js/jquery.js"></script>
	<script src="js/jquery.mobile-1.4.5.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(e){
			alert("dddd");
		})

        function OnLoadPage(AreaCode){
            var data = {
            'STATUS'      : 'OnLoadPage',
            'AreaCode'    : AreaCode,
            'Search'      : '',
            };
            senddata(JSON.stringify(data));
        }

        function senddata(data){
            var form_data = new FormData();
            form_data.append("DATA",data);
            var URL = 'process/Welfare.php';
            $.ajax({
                url: URL,
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (result) {
                    try {
                        var temp = $.parseJSON(result);
                    } catch (e) {
                        console.log('Error#542-decode error');
                    }
                    if (temp["status"]=='success') {
                        if (temp["form"]=='OnLoadPage') {

                        }
                    }
                }
            });
        }
    </script>
</head>

<body>
<div data-demo-html="true">
        <div data-role="header">
            <a href="p2.php" class="ui-btn ui-corner-all ui-btn-inline ui-mini footer-button-left ui-btn-icon-left ui-icon-carat-l">กลับ</a>            
            <h1> <?php echo $Area ?> : บันทึกเบิกสวัสดิการ</h1>
            <a href="logoff.php" class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-power">ออก</a>
        </div>
    </div>
		

          <div data-demo-html="true">

			<table data-role="table" id="table-custom-2" data-mode="columntoggle" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columns to display..." data-column-popup-theme="a">

                <thead>
                  <tr class="ui-bar-d">
                    <th data-priority="2">ลำดับ</th>
                    <th >รายการ</th>
                    <th data-priority="1">จำนวน</th>
                    <th data-priority="3">ราคา</th>
                    <th data-priority="5">เป็นเงิน</th>
                  </tr>
                </thead>
                <tbody>
                
                </tbody>
                <tfoot>
                  <tr class="ui-bar-a">
                    <th>&nbsp;</th>
                    <th>&nbsp;เป็นเงิน</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th><?php echo number_format($xPT, 2, '.', ','); ?></th>
                    </tr>
                </tfoot>
              </table>

		</div>                       
</body>

</html>