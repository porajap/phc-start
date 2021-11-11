<?php
session_start();
require 'connect.php';
require 'xFunction.php';
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
$xName = $_SESSION["xName"];
$Area = $_SESSION["Area"];
$mm = date('m');
$yy = date('Y');
$IsStatus = $_REQUEST["IsStatus"];
$xSt = 0;
$n = 0;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<title>PHC</title>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="icon/icon.ico">
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/sweetalert2.min.css">
	<link rel="stylesheet" href="css/topnav.css">
	<script src="js/jquery/3.5.1/jquery.min.js "></script>
	<script src="assets/dist/js/bootstrap.js "></script>
	<script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
    <style>
        .xTop1{
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
        }

        .xTb{
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
            margin-bottom: 7px;
        }

        .label1{
            margin-left: 10px;
            margin-top: 7px;
        }

        .label2{
            margin-left: 10px;
            margin-top: 7px;
            margin-bottom: 7px;
        }
    </style>
</head>

<body>
	<div class="topnav">
        <a href="p2.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel"><?php echo $Area ?></div>
        <div class="topnav-right">            
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>

	<table class="tables">
                <tr>
                    <td>
                        <div align="center">ปัญหาที่พบ/ข้อเสนอแนะ/ข้อมูลคู่แข่ง</div>
                    </td>
                </tr>
              <tr>
                <td>
                    <form method="post" action="Save_idea.php" enctype="multipart/form-data" data-ajax="false">
                            <table class="tables">
                            <tr>
                            	<td></td>
                            	<td>
                                    <table class="tables">
            
                            <thead>
                              <tr class="ui-bar-d">
                                <th data-priority="2">เขต</th>
                                <th >กิจกรรม</th>
                                <th >รูป 1</th>
                              </tr>
                            </thead>
                            <tbody>
                            
             <?php 				$Sql = "SELECT ID,Area,YY,MM,Activity,Pic1,Pic2 ";
			$Sql .= "FROM idea_by_month ";
			$Sql .= "WHERE YY = '$yy' AND MM = '$mm'";
			$meQuery = mysqli_query($conn,$Sql);
			while ($Result = mysqli_fetch_assoc($meQuery))
			{
			  ?>               
                              <tr>
                                <th><?php echo $Result["Area"] ?></th>
                                <td><?php echo $Result["Activity"] ?></td>
                                <td><img src="<?php echo "img/" . $Result["Pic1"] ?>" width="100px"></td>
                              </tr>
            <?php $j++; } ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                              </tr>
                            </tfoot>
                          </table>
                                </td>
                            </td>

                            </table>
                    </form>
                </td>
              </tr>
</table>


</body>
<script>
    $('#page').on('pageinit', function(){
		$("#chooseFile").click(function(e){
			e.preventDefault();
			$("input[type=file]").trigger("click");
		});
		$("input[type=file]").change(function(){
			var file = $("input[type=file]")[0].files[0];            
			$("#preview").empty();
			displayAsImage3(file, "preview");
			
			$info = $("#info");
			$info.empty();
			if (file && file.name) {
				$info.append("<li>name:<span>" + file.name + "</span></li>");
			}
			if (file && file.type) {
				$info.append("<li>size:<span>" + file.type + " bytes</span></li>");
			}
			if (file && file.size) {
				$info.append("<li>size:<span>" + file.size + " bytes</span></li>");
			}
			if (file && file.lastModifiedDate) {
				$info.append("<li>lastModifiedDate:<span>" + file.lastModifiedDate + " bytes</span></li>");
			}
			$info.listview("refresh");
		});
    });

    function displayAsImage3(file, containerid) {
		if (typeof FileReader !== "undefined") {
			var container = document.getElementById(containerid),
			    img = document.createElement("img"),
			    reader;
			container.appendChild(img);
			reader = new FileReader();
			reader.onload = (function (theImg) {
				return function (evt) {
					theImg.src = evt.target.result;
				};
			}(img));
			reader.readAsDataURL(file);
		}
	}
</script>
</html>
