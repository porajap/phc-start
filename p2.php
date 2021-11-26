<?php
session_start();
	if($_SESSION["Area"] == "") header('location:index.html');
	$Area = $_SESSION["Area"];
	$xName = $_SESSION["xName"];
	$_SESSION["xID"] = "";
	$Bk= substr($Area,0,2);
	
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
	<Style>
		.xColorRed{
			color: red;
		}
	</Style>
</head>

<body>
	<div class="topnav">
        <div class="xlabel"><?php echo $Area ?> : คุณ<?php echo $xName ?></div>
        <div class="topnav-right">            
            <a href="logoff.php">
				<img src="img/logout-icon.png" width="30px" height="30px" /> 
			</a>
        </div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="list-group">
				<?php 
					if($Area == "padmin" || $Area == "psbkk"){ ?>
						<a class="list-group-item list-group-item-action active" href="Date03.php" >Daily call</a>
						<a class="list-group-item list-group-item-action" href="Area01.php">Cyclic purchasing ( ALL )</a>
						<a class="list-group-item list-group-item-action" href="AreaDispenser.php">Cyclic purchasing ( Dispenser )</a>
						<a class="list-group-item list-group-item-action" href="SaleBB.php">Sale For Month</a>
				<?php
                    }elseif($Area == "BB"){ ?>
						<a class="list-group-item list-group-item-action" href="ListHospital.php?AF=0">บันทึกการเข้าพื้นที่</a>
						<a class="list-group-item list-group-item-action" href="ListHospital.php?AF=1">บันทึกการเข้าพื้นที่ ( ย้อนหลัง )</a>
						<a class="list-group-item list-group-item-action" href="ListHospital2.php">รายการ เข้าพื้นที่</a>
				<?php
					}else{ ?>
						<a class="list-group-item list-group-item-action" href="Welfare.php"><img src='img/money01.png' width='40' height='40' /> บันทึกเบิกสวัสดิการ</a>
						<a class="list-group-item list-group-item-action" href="PieChart.php"><img src='img/rsz_pie-chart.png' width='40' height='40' /> Chart</a>
						<a class="list-group-item list-group-item-action" href="order.php" id="menuHide">บันทึกขอซื้อ</a>
						<a class="list-group-item list-group-item-action" href="CustomerSel.php?Menu=2"><img src='img/rsz_paybill.png' width='40' height='40' /> อับโหลดเช็ค</a> 
						<a class="list-group-item list-group-item-action" href="Quotation.php">เสนอราคา</a>
						<a class="list-group-item list-group-item-action" href="Bring.php">ใบเบิกสินค้า</a>
						<a class="list-group-item list-group-item-action" href="Dispenser.php"><img src='img/logo_0.png' width='40' height='40' /> ใบเบิกสินค้า ( Dispenser )</a>
						<a class="list-group-item list-group-item-action" href="Borrow.php">ใบยืมสินค้า</a>
						<a class="list-group-item list-group-item-action" href="SaleBB.php">Sales/Month</a>
						<a class="list-group-item list-group-item-action" href="Date03.php">Daily call</a>
						<a class="list-group-item list-group-item-action" href="Area01.php">Cyclic purchasing ( ALL )</a>
						<a class="list-group-item list-group-item-action" href="AreaDispenser.php">Cyclic purchasing ( Dispenser )</a>
						<a class="list-group-item list-group-item-action" href="Customer.php">ราคาสินค้า ตามบิล/ลูกค้า</a>
						<a class="list-group-item list-group-item-action" href="Date01.php">ราคาสินค้า</a>
						<a class="list-group-item list-group-item-action" href="SelCustomer.php">รายการสินค้า ตาม รายลูกค้า</a>

						<a class="list-group-item list-group-item-action" href="ProductNew.php">บันทึกสินค้าเข้าใหม่ ( เดือนปัจจุบัน )</a>
						<a class="list-group-item list-group-item-action" href="ProductNewNext.php">บันทึกสินค้าคาดว่าจะเข้า( เดือนถัดไป )</a>
						<a class="list-group-item list-group-item-action" href="p2_1.php">กิจกรรมประจำเดือน</a>

						<a class="list-group-item list-group-item-action" href="cPassword.php">เปลี่ยนรหัสผ่าน</a>
						<a class="list-group-item list-group-item-action" href="Date06.php">รายงานสรุปยอดขาย</a>
						<a class="list-group-item list-group-item-action" href="Date07.php">รายงานสรุปยอดขายประจำเดือน</a>
						<a class="list-group-item list-group-item-action" href="activity_show.php">รายงานกิจกรรมที่ทำภายในเดือน</a>
						<a class="list-group-item list-group-item-action" href="idea_show.php">รายงานปัญหาที่พบ/ข้อเสนอแนะ/ข้อมูลคู่แข่ง</a>
						<a class="list-group-item list-group-item-action" href="ProductNew_Show.php">รายงานสินค้าเข้าใหม่ ( เดือนปัจจุบัน )</a>
						<a class="list-group-item list-group-item-action" href="ProductNew_Show.php?IsStatus=1">รายงานสินค้าคาดว่าจะเข้า( เดือนถัดไป )</a>
						<a class="list-group-item list-group-item-action" href="CustomerSel.php?Menu=1">ยกเลิกรายการ ที่เคยสั่งซื้อ</a>
				<?php } ?>		
			</div>
		</div>
	</div>

	<script>
		checkEndDate();
		const currentDateTime = new Date();
		//current date time from client
		const currentYear = currentDateTime.getFullYear();
		const currentMonth = currentDateTime.getMonth() + 1;
		const currentDate = currentDateTime.getDate();
		const currentHour = currentDateTime.getHours()

		//await data from database
		let getEndYear;
		let getEndMonth;
		let getEndDate;
		const hourForHide = 12 //12.00
		const limitHour = 3 // 3 hours

	
		function checkEndDate(){

			const _url = "process/p2.php";
			const _data = {};
			const _other_params = {
				headers : { "content-type" : "application/json; charset=UTF-8"},
				body : _data,
				method : "POST",
				mode : "cors"
			};

			fetch(_url, _other_params).then(function(response) {
				if (response.ok) {
					return response.json();
				} else {
					throw new Error("Could not reach the API: " + response.statusText);
				}
			}).then(function(data) {

				getEndMonth = data.Month;
				getEndYear = data.Year;

				var _eDate = data.eDate;
				if(_eDate != ""){
					getEndDate = _eDate.split("-")[2].trim();
				}

				checkHideOrShowMenu();
			}).catch(function(error) {
				toggleMenu("block");
			});
		}


		function checkHideOrShowMenu(){

			if(
				getEndYear == currentYear && 
				getEndMonth == currentMonth && 
				getEndDate == currentDate && 
				currentHour >= hourForHide &&
				(currentHour - hourForHide) <= limitHour &&
				(currentHour - hourForHide) != limitHour
			){
				toggleMenu("none");
			}else{
				toggleMenu("block");
			}
		}

		function toggleMenu(style){
			var _menu = document.getElementById('menuHide');
				_menu.style.display  = style
		}
	</script>
</body>

</html>
