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
			if($IsStatus == 1){
				$xID = $_REQUEST["xID"];
				$Sql = "DELETE FROM idea_by_month ";
				$Sql .= "WHERE ID = '$xID'";
				$meQuery = mysqli_query($conn,$Sql);
			}
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
        .ui-icon-custom:after {
          background-image: url("../_assets/img/glyphish-icons/21-skull.png");
          background-position: 3px 3px;
          background-size: 70%;
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

  <div align="center" class="xTb">ปัญหาที่พบ/ข้อเสนอแนะ/ข้อมูลคู่แข่ง</div>

  <form method="post" action="Save_idea.php" enctype="multipart/form-data" data-ajax="false">
      <input type="hidden" name="xYear" id="xYear" value="<?= $yy ?>">
      <input type="hidden" name="xMonth" id="xMonth" value="<?= $mm ?>">
      <input type="hidden" name="cMonth" id="cMonth" value="<?= $mm ?>">
      <input type="hidden" name="xSt" id="xSt" value="<?= $xSt ?>">
      <input type="hidden" name="Area" id="Area" value="<?= $Area ?>">

          
                      <div class="input-group mb-3">
                        <span class="input-group-text xBoxWh">กิจกรรม</span>
                        <input type="text" name="Activity" id="Activity" value="" class="form-control" placeholder="กิจกรรม" aria-describedby="basic-addon1">
                      </div>
                      <div class="input-group mb-3">
                        <span class="input-group-text xBoxWh">รูป 1</span>
                        <input class="form-control form-control-lg" type="file" name="Pic1" id="Pic1">
                      </div>
                      <div class="input-group mb-3">
                        <span class="input-group-text xBoxWh">รูป 2</span>
                        <input class="form-control form-control-lg" type="file" name="Pic2" id="Pic2">
                      </div>
                      <div class="input-group mb-3">
                        <span class="input-group-text xBoxWh">รูป 3</span>
                        <input class="form-control form-control-lg" type="file" name="Pic3" id="Pic3">
                      </div>
                      <div class="input-group mb-3">
                        <span class="input-group-text xBoxWh">รูป 4</span>
                        <input class="form-control form-control-lg" type="file" name="Pic4" id="Pic4">
                      </div>
                      <div class="input-group mb-3">
                        <span class="input-group-text xBoxWh">รูป 5</span>
                        <input class="form-control form-control-lg" type="file" name="Pic5" id="Pic5">
                      </div>

    <div class="d-grid xTb">
			<button class="btn btn-primary" name="submit-button-1" id="submit-button-1" >บันทึก</button>
    </div>       
  
    <table data-role="table" id="table-custom-2" data-mode="columntoggle" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columns to display..." data-column-popup-theme="a">
      <thead>
          <tr class="ui-bar-d">
            <th data-priority="2">ลำดับ</th>
            <th >กิจกรรม</th>
            <th >รูป1</th>
            <th >รูป2</th>
            <th >รูป3</th>
            <th >รูป4</th>
            <th >รูป5</th>
          </tr>
        </thead>
        <tbody>
        <?php 				
            $Sql = "SELECT ID,YY,MM,Activity,Pic1,Pic2,Pic3,Pic4,Pic5 ";
            $Sql .= "FROM idea_by_month ";
            $Sql .= "WHERE Area = '$Area' AND YY = '$yy' AND MM = '$mm'";
            $meQuery = mysqli_query($conn,$Sql);
            while ($Result = mysqli_fetch_assoc($meQuery))
            {
			  ?>               
              <tr>
                <th>
                  <a href="idea.php?IsStatus=1&xID=<?php echo $Result["ID"] ?>" ><img src="img/del.png" width="16" height="16" /></a>
                </th>
                <td><?php echo $Result["Activity"] ?></td>
                <td><img src="<?php echo "img_i/" . $Result["Pic1"] ?>" width="100px"></td>
                <td><img src="<?php echo "img_i/" . $Result["Pic2"] ?>" width="100px"></td>
                <td><img src="<?php echo "img_i/" . $Result["Pic3"] ?>" width="100px"></td>
                <td><img src="<?php echo "img_i/" . $Result["Pic4"] ?>" width="100px"></td>
                <td><img src="<?php echo "img_i/" . $Result["Pic5"] ?>" width="100px"></td>
              </tr>
          <?php $j++; } ?>
          </tbody>
          <tfoot>
            <tr class="ui-bar-a">
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              </tr>
          </tfoot>
        </table>
  </form>

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
