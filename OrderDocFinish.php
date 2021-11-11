<?php
require 'connect.php';
if ($_POST) {
    $xDocNo = $_POST["tDocNo"];
    $xDetail = $_POST["tDetail"];
    $tDate = $_POST["tDate"];
    $xPO = $_POST["xPO"];

    $IsQT = $_POST["xQT"];
    $IsST = $_POST["xST"];
    $IsBV = $_POST["xBV"];

    $Dt = date('Y-m-d H:i:s');

    $folderPath = "/var/www/html/phc/uploads/";

    echo "=================== $folderPath ===================<br>";
    if($_FILES["Pic1"]["tmp_name"] != "") echo "1> ".$_FILES["Pic1"]["tmp_name"]." <br>";

    if($_FILES["Pic1"]["tmp_name"] != "") {
        echo  $_FILES['Pic1']['size'] . "<br />";
        $fileSize = $_FILES['Pic1']['size'];
        $file = $_FILES['Pic1']['tmp_name'];
        $sourceProperties = getimagesize($file);
        $fileNewName = $Area."_1_".date("Ymd_His");
        $ext = pathinfo($_FILES['Pic1']['name'], PATHINFO_EXTENSION);
        $ReN1 = $xDocNo.".".$ext;
        if (move_uploaded_file($file, $folderPath.$ReN1)) {
            echo "File is valid, and was successfully uploaded.<br />";
        } else {
            echo "Upload failed<br />";
        }
        echo '<pre>';
        echo 'Here is some more debugging info:';
        print_r($_FILES);
        print "</pre>";
    }
    echo "========================";
    $Sql = "UPDATE saleorder SET ";
    $Sql .= "IsSave=1,IsPO='$xPO',IsQT='$IsQT',IsBV='$IsBV',tDate='$tDate',IsST='$IsST',Detail='$xDetail',Modify_Date=NOW() ";
    $Sql .= "WHERE DocNo = '$xDocNo'";

    $meQuery = mysqli_query($conn, $Sql);

    $_SESSION["DocNo"] = "";
    $_SESSION["ItemCode"] = "";
    $_SESSION["Qty"] = "";
    $_SESSION["Price"] = "";
    $_SESSION["Detail"] = "";
}
header('location:order.php');
?>
