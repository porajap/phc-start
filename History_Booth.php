<?php
session_start();
require 'connect.php';
if ($_SESSION["Area"] == "") header('location:index.html');
$Area     = $_SESSION["Area"];
$xTitle = $_SESSION["xName"];
$xUname = $_SESSION["xUname"];
$IsShowBoothDetail = $_SESSION["IsShowBoothDetail"];
// $CusName = $_REQUEST["CusName"];
// $IsStatus = $_REQUEST["IsStatus"];
// $DocNoP = $_REQUEST["DocNoP"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>PHC</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="icon/icon.ico">
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/topnav.css">
    <link rel="stylesheet" href="assets/plugins/dropify/dist/css/dropify.min.css">
    <link rel="stylesheet" href="assets/datepicker/dist/css/datepicker.min.css">
    <link rel="stylesheet" href="css/select2222.css">

    <script src="js/jquery/3.5.1/jquery.min.js "></script>
    <script src="assets/dist/js/bootstrap.js "></script>
    <script src="assets/dist/js/bootstrap.bundle.min.js "></script>
    <script src="assets/dist/js/sweetalert2.min.js"></script>
    <script src="assets/plugins/dropify/dist/js/dropify.min.js"></script>
    <script src="assets/datepicker/dist/js/datepicker.min.js"></script>
    <script src="assets/datepicker/dist/js/i18n/datepicker.en.js"></script>
    <script src="js/select2.min.js"></script>

    <style>
        .xTop1 {
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
        }

        .xTb {
            margin-top: 7px;
            margin-left: 1px;
            margin-right: 1px;
            margin-bottom: 7px;
        }

        .label1 {
            margin-left: 10px;
            margin-top: 7px;
        }

        .label2 {
            margin-left: 10px;
            margin-top: 7px;
            margin-bottom: 7px;
        }

        .caption div {
            box-shadow: 0 0 5px #C8C8C8;
            transition: all 0.3s ease 0s;
        }

        .img-circle {
            border-radius: 50%;
        }

        .img-circle {
            border-radius: 0;
        }

        .ratio {
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;

            height: 0;
            padding-bottom: 15%;
            position: relative;
            width: 15%;
        }

        .img-circle {
            border-radius: 50%;
        }

        .img-responsive {
            display: block;
            height: auto;
            max-width: 15%;
        }

        .dropify-wrapper .dropify-message span.file-icon {
            font-size: 18px;
            color: #CCC;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 4px;
            height: 37px;
            margin-left: 1%;
        }

        .datepicker {
            z-index: 9999 !important
        }
    </style>
</head>

<body>
    <div class="topnav">
        <a href="Add_Booth.php"><img src="img/left-blue-arrow.png" width="30px" height="30px" /></a>
        <div class="xlabel ">เขตที่ : <?= $Area ?></div>
        <div class="topnav-right">
            <a href="logoff.php"><img src="img/logout-icon.png" width="30px" height="30px" /> </a>
        </div>
    </div>

    <div class="row xTop1">
        <!-- <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3" onclick="createDoc();">สร้างเอกสารจ่าย</button>
        </div> -->
    </div>
    <center>
        <h2>History Booth</h2>
    </center>
    <div class="col-12 d-flex justify-content-end px-2">

        <button type="button" class="btn btn-warning" onclick="open_modalreport();">รายงาน</button>

    </div>
    <div class=" mt-3 px-2 " >
        <div class="card" style="border: solid;border-color: darkgray;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6  " id="div_Select_Area">
                        <label for="exampleFormControlTextarea1" style="font-size: 16px;font-weight: bold;" class="form-label ">เขต</label>
                        <select class="form-select js-example-basic-single" aria-label="Default select example" data-live-search="true" id="Select_Area" onchange="Show_Data();">
                        </select>
                    </div>

                    <div class="col-md-6 " id="div_Text_Customer">
                        <label style="font-size: 16px;font-weight: bold;" for="exampleFormControlTextarea1" class="form-label">ชื่อลูกค้า</label>
                        <input type="text" class="form-control" id="Text_Customer" placeholder="กรอกชื่อลูกค้า" onkeyup="Show_Data()">
                    </div>

                </div>

                <div class=" mt-3" id="Div_list_Data" style="max-height: 700px; overflow-y: scroll;">
                    <!-- <div class="card">
                        <div class="card-header">
                            <h3>เขต P091</h3>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <h4 for="">ชื่อลูกค้า : </h4>
                                    <span> Lorem ipsum dolor sit, amet consectetur adipisic</span>
                                </div>
                                <div class="form-group">
                                    <h4 for="">ผู้สนใจ : </h4>
                                    <span> Lorem ipsum dolor sit, amet consectetur adipisic</span>
                                </div>
                                <div class="form-group">
                                    <h4 for="">ผู้แทน : </h4>
                                    <span> Lorem ipsum dolor sit, amet consectetur adipisic</span>
                                </div>
                                <div class="form-group">
                                    <h4 for="">สถานะ : </h4>
                                    <span> Lorem ipsum dolor sit, amet consectetur adipisic</span>
                                </div>
                            </form>
                        </div>
                    </div> -->
                </div>

            </div>




        </div>
    </div>





    <div id="Sql"></div>
    <div id="Grid1"></div>


    <!-- Modal -->
    <div class="modal fade" id="DocDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">แสดงรายละเอียดเอกสาร</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <h4 class="modal-title" id="Text_Area">เขต P051</h4>
                        <div class="col-md-12">
                            <label for="" style="font-size: 20px;font-weight: bold;" class="form-label">เลือกชื่อลูกค้า </label>
                            <div style="margin-left: 5%;">
                                <p style="font-size: 18px;" class="form-label" id="FName"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" style="font-size: 20px;font-weight: bold;" class="form-label">แผนก </label>
                            <div style="margin-left: 5%;">
                                <p style="font-size: 18px;" class="form-label" id="DepartmentName"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" style="font-size: 20px;font-weight: bold;" class="form-label">ชื่อผู้สนใจ </label>
                            <div style="margin-left: 5%;">
                                <p style="font-size: 18px;" class="form-label" id="InformantName"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" style="font-size: 20px;font-weight: bold;" class="form-label">เบอร์โทร </label>
                            <div style="margin-left: 5%;">
                                <p style="font-size: 18px;" class="form-label" id="PhoneNumber"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" style="font-size: 20px;font-weight: bold;" class="form-label">สนใจผลิตภัณฑ์ </label>
                            <div style="margin-left: 5%;">
                                <p style="font-size: 18px;" class="form-label" id="ItemName"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" style="font-size: 20px;font-weight: bold;" class="form-label">สถานะ </label>
                            <div style="margin-left: 5%;">
                                <p style="font-size: 18px;" class="form-label" id="UrgencyLevel"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" style="font-size: 20px;font-weight: bold;" class="form-label">Note </label>
                            <div style="margin-left: 5%;">
                                <p style="font-size: 18px;" class="form-label" id="Note"></p>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="Modal_report" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">เรียกดูรายงาน</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6" id="div_Select_Customer">
                            <label for="" style="font-size: 20px;font-weight: bold;" class="form-label">วันที่ </label>
                            <input style="margin-left: 1%;" type="text" autocomplete="off" class="form-control  datepicker-here " id="txt_sDate" data-language='en' data-date-format='dd-mm-yyyy' placeholder="วันที่" readonly>
                        </div>
                        <div class="col-md-6" id="div_Select_Customer">
                            <label for="" style="font-size: 20px;font-weight: bold;" class="form-label">ถึงวันที่ </label>
                            <input style="margin-left: 1%;" type="text" autocomplete="off" class="form-control  datepicker-here " id="txt_eDate" data-language='en' data-date-format='dd-mm-yyyy' placeholder="ถึงวันที่" readonly>
                        </div>

                    </div>



                </div>
                <div class="modal-footer">

                    <button type="button" style="width: 25%; float: right;" class="btn btn-success" onclick="open_report();"> เปิด </button>
                </div>
            </div>
        </div>
    </div>




</body>
<script>
    $(document).ready(function() {



        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var output = (('' + day).length < 2 ? '0' : '') + day + '-' +
            (('' + month).length < 2 ? '0' : '') + month + '-' +
            d.getFullYear();

        $("#txt_sDate").val(output);
        $("#txt_eDate").val(output);

        $('.js-example-basic-single').select2();
        get_Select_Area();

        setTimeout(function() {
            Show_Data();
        }, 300);


        $('.numonly').on('input', function() {
            this.value = this.value.replace(/[^0-9.]/g, ''); //<-- replace all other than given set of values
        });
    });


    function get_Select_Area() {

        $.ajax({
            url: "process/History_Bootn.php",
            type: 'POST',
            data: {
                'FUNC_NAME': 'get_Select_Area'
            },
            success: function(result) {
                var ObjData = JSON.parse(result);
                $("#Select_Area").empty();
                var Str = "";

                if (!$.isEmptyObject(ObjData)) {
                    Str += "<option value='000' >กรุณาเลือกเขต</option>";
                    $.each(ObjData, function(key, value) {
                        Str += "<option value=" + value.Code + " >" + value.Name + "</option>";

                    });
                    Str += "<option value='01' > อื่นๆ </option>";
                }

                $("#Select_Area").append(Str);

            }
        });

    }


    function open_modalreport() {
        $('#Modal_report').modal('toggle');
    }

    function open_report() {
        var txt_sDate = $("#txt_sDate").val();
        var txt_eDate = $("#txt_eDate").val();

        var Url = "tcreport/Report_Booth.php?sDate=" + txt_sDate + "&eDate=" + txt_eDate;
        window.open(Url);

    }


    function Show_Data() {

        var Select_Area = $("#Select_Area").val();
        var Text_Customer = $("#Text_Customer").val();

        $.ajax({
            url: "process/History_Bootn.php",
            type: 'POST',
            data: {
                'FUNC_NAME': 'Show_Data',
                'Select_Area': Select_Area,
                'Text_Customer': Text_Customer
            },

            success: function(result) {
                var ObjData = JSON.parse(result);
                $("#Div_list_Data").empty();
                var Str = "";

                if (!$.isEmptyObject(ObjData)) {

                    $.each(ObjData, function(key, value) {

                        if (value.UrgencyLevel == 'very_urgent') {
                            var stu_Doc = " <span style='color: #FF0000;'> ด่วนมาก </span>";
                        }

                        if (value.UrgencyLevel == 'urgent') {
                            var stu_Doc = " <span style='color: #FF8C00;'> ด่วน </span>";
                        }

                        if (value.UrgencyLevel == 'normal') {
                            var stu_Doc = " <span style='color: #0000FF;'> ปกติ </span>";
                        }

                        if (value.AreaCodeCus == '' || value.AreaCodeCus == null) {
                            var AreaCodeCus = "-";
                        }else{
                            var AreaCodeCus = value.AreaCodeCus;
                        }
                        

                        // Str += " <div class='card mt-3' onclick='show_Model_DetailDoc(\"" + value.ID + "\");'> " +
                        //             " <div class='card-header'>" +
                        //                 " <h3>เขต " + value.AreaCode + "</h3> " +
                        //             " <div class='card-body'>" +
                        //                 " <form>" +
                        //                     " <div class='form-group row'>" +
                        //                         " <label class='col-sm-2 col-form-label' >ชื่อลูกค้า : </label>" +
                        //                         " <div class='col-sm-10'>" +
                        //                             " <h5 >" + value.FnameCus + " </h5>" +
                        //                         " </div>" +
                        //                     " </div>" +
                        //                     " <div class='form-group'>" +
                        //                         " <h4 >ผู้สนใจ : </h4>" +
                        //                         " <span >" + value.InformantName + " </span>" +
                        //                     " </div>" +
                        //                     " <div class='form-group'>" +
                        //                         " <h4 >ผู้แทน : </h4>" +
                        //                         " <span >" + value.FName + " </span>" +
                        //                     " </div>" +
                        //                     " <div class='form-group'>" +
                        //                         " <h4 >สถานะ : </h4>" +
                        //                         " <span >" + stu_Doc + " </span>" +
                        //                     " </div>" +
                        //                 " </form>" +
                        //             " </div>" +
                        //         " </div>";
                        Str += " <div class='card mb-2'  onclick='show_Model_DetailDoc(\"" + value.ID + "\");'>" +
                            " <div class='card-header'>" +

                            " <div class='row'>" +
                                " <div class='col-6'>" +
                                    " <h3>เขต " + AreaCodeCus + "</h3> " +
                                " </div>" +
                                " <div class='col-6 '>" +
                                    " <h3 style='text-align: right;'> " + stu_Doc + "</h3> " +
                                " </div>" +
                            " </div>" +

         
                            " </div>" +
                            " <div class='card-body '>" +
                            " <p class='card-text label2' style='font-weight: bold;font-size: 20px;'>ชื่อลูกค้า  :  <span style='font-size: 17px;font-weight: inherit;'>" + value.FnameCus + " </span>  </p>  " +
                            " <p class='card-text label2' style='font-weight: bold;font-size: 20px;'>ผู้สนใจ   :    <span style='font-size: 17px;font-weight: inherit;'>" + value.InformantName + " </span>  </p>" +
                            " <p class='card-text label2' style='font-weight: bold;font-size: 20px;'>เซลล์ที่รับลูกค้า   :    <span style='font-size: 17px;font-weight: inherit;'>" + value.FName + " "+value.LName+" ( เขต "+value.AreaCode+" ) </span>  </p>" +
                            // " <p class='card-text label2' style='font-weight: bold;font-size: 20px;'>สถานะ :  <span style='font-size: 17px;font-weight: inherit;'>" + stu_Doc + " </span>   </p>" +
                            " </div>" +
                            " </div>";
                    });

                } else {
                    Str += "<hr><center><h3> ไม่มีรายการเอกสาร </h3></center>";
                }

                $("#Div_list_Data").html(Str);

            }
        });

    }

    function show_Model_DetailDoc(ID) {
        $('#DocDetail').modal('toggle');

        $.ajax({
            url: "process/History_Bootn.php",
            type: 'POST',
            data: {
                'FUNC_NAME': 'show_Model_DetailDoc',
                'ID': ID
            },
            success: function(result) {
                var ObjData = JSON.parse(result);



                if (!$.isEmptyObject(ObjData)) {
                    $.each(ObjData.booth, function(key, value) {
                        if (value.UrgencyLevel == 'very_urgent') {
                            var stu_Doc = " <span style='color: #FF0000;'> ด่วนมาก </span>";
                        }

                        if (value.UrgencyLevel == 'urgent') {
                            var stu_Doc = " <span style='color: #FF8C00;'> ด่วน </span>";
                        }

                        if (value.UrgencyLevel == 'normal') {
                            var stu_Doc = " <span style='color: #0000FF;'> ปกติ </span>";
                        }

                        if (value.AreaCodeCus == '' || value.AreaCodeCus == null) {
                            var AreaCodeCus = "-";
                        }else{
                            var AreaCodeCus = value.AreaCodeCus;
                        }

                        $("#FName").text(value.FnameCus);
                        $("#InformantName").text(value.InformantName);
                        $("#PhoneNumber").text(value.PhoneNumber);
                        $("#UrgencyLevel").html(stu_Doc);
                        $("#Note").text(value.Note);
                        $("#Text_Area").text(AreaCodeCus);

                    });
                    var Str_department = "";
                    $.each(ObjData.bootn_department, function(key_department, value_department) {
                        Str_department += " <p  style='font-size: 18px;' class='form-label'  >" + (key_department + 1) + ". " + value_department.DepartmentName + "</p>";
                    });
                    $("#DepartmentName").html(Str_department);

                    var Str_Item = "";
                    $.each(ObjData.booth_Items, function(key_Items, value_Items) {
                        if (value_Items.Detail == "") {
                            var detail = "";
                        } else {
                            var detail = " ( " + value_Items.Detail + " )";
                        }

                        Str_Item += " <p  style='font-size: 18px;' class='form-label'  >" + (key_Items + 1) + ". " + value_Items.ItemName + detail + "</p>";
                    });
                    $("#ItemName").html(Str_Item);




                }
            }
        });
    }

    function clean() {
        location.reload();
    }
</script>

</html>