<?php
require 'connect.php';
define("MAX_SIZE", "1000");

	function imageResize($imageResourceId,$width,$height) {
		$targetWidth =500;
		$targetHeight =500;
		$targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
		imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);
		return $targetLayer;
	}

    if ($_POST) {
        $Area = $_POST["Area"];
        $xYear = $_POST["xYear"];
        $xMonth = $_POST["xMonth"];
        $Activity = $_POST["Activity"];
        
        $ReN1 = "logo_phc.png";
        $ReN2 = "logo_phc.png";
        $ReN3 = "logo_phc.png";
        $ReN4 = "logo_phc.png";
        $ReN5 = "logo_phc.png";

		$folderPath = "img_a/";

        $Sql = "SELECT ID FROM activity_by_month ORDER BY ID DESC LIMIT 1";
        $meQuery = mysqli_query($conn, $Sql);
        while ($Result = mysqli_fetch_assoc($meQuery)) {
            $rn = $Result["ID"];
        }
        $rn++;
        echo "Area> ".$Area." <br>";
        echo "Year> ".$xYear." <br>";
        echo "Month> ".$xMonth." <br>";
        echo "Activity> ".$Activity." <br>";

        // if($_FILES["Pic1"]["tmp_name"] != "") echo "1> ".$_FILES["Pic1"]["tmp_name"]." <br>";
        // if($_FILES["Pic2"]["tmp_name"] != "") echo "2> ".$_FILES["Pic2"]["tmp_name"]." <br>";
        // if($_FILES["Pic3"]["tmp_name"] != "") echo "3> ".$_FILES["Pic3"]["tmp_name"]." <br>";
        // if($_FILES["Pic4"]["tmp_name"] != "") echo "4> ".$_FILES["Pic4"]["tmp_name"]." <br>";
        // if($_FILES["Pic5"]["tmp_name"] != "") echo "5> ".$_FILES["Pic5"]["tmp_name"]." <br>";

        echo "=================== $folderPath ===================<br>";
        if($_FILES["Pic1"]["tmp_name"] != ""){
            $fileSize = $_FILES['Pic1']['size'];
            echo "1> $fileSize <br>";
            $file = $_FILES['Pic1']['tmp_name'];
            echo "2> $file <br>";
            $sourceProperties = getimagesize($file);
            echo "3> $sourceProperties <br>";
            $fileNewName = $Area."_1_".date("Ymd_His");
            echo "4> $fileNewName <br>";
            $ext = pathinfo($_FILES['Pic1']['name'], PATHINFO_EXTENSION);
            echo "5> $ext <br>";
            $ReN1 = $fileNewName.".".$ext;
            echo "6> $ReN1 <br>";
            $imageType = $sourceProperties[2];
            echo "7> $imageType <br>";
            echo "======================================<br>";
            if ($fileSize > MAX_SIZE) {
                switch ($imageType) {
                        case IMAGETYPE_PNG:
                            echo "> IMAGETYPE_PNG <br>";
                            $imageResourceId = imagecreatefrompng($file);
                            echo "8> $imageResourceId <br>";
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            echo "9> $targetLayer <br>";
                            imagepng($targetLayer, $folderPath. $fileNewName.".".$ext);
                            echo "10> Finish... <br>";
                            break;
                        case IMAGETYPE_GIF:
                            echo "> IMAGETYPE_GIF <br>";
                            $imageResourceId = imagecreatefromgif($file);
                            echo "8> $imageResourceId <br>";
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            echo "9> $targetLayer <br>";
                            imagegif($targetLayer, $folderPath. $fileNewName.".".$ext);
                            echo "10> Finish... <br>";
                            break;
                        case IMAGETYPE_JPEG:
                            echo "> IMAGETYPE_JPEG <br>";
                            $imageResourceId = imagecreatefromjpeg($file);
                            echo "8> $imageResourceId <br>";
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            echo "9> $targetLayer <br>";
                            imagejpeg($targetLayer, $folderPath. $fileNewName.".".$ext);
                            echo "10> Finish... <br>";
                            break;
                        default:
                            echo "Invalid Image type.";
                            exit;
                            break;
                    }
                    echo "1> Image Resize Successfully.<br>";
            } else {
                echo "1> move_uploaded_file.<br>";
                move_uploaded_file($file, $folderPath. $fileNewName. ".".$ext);
            }
        }
        echo "======================================<br>";
        if($_FILES["Pic2"]["tmp_name"] != ""){
            $fileSize = $_FILES['Pic2']['size'];
            echo "1> $fileSize <br>";
            $file = $_FILES['Pic2']['tmp_name'];
            echo "2> $file <br>";
            $sourceProperties = getimagesize($file);
            echo "3> $sourceProperties <br>";
            $fileNewName = $Area."_2_".date("Ymd_His");
            echo "4> $fileNewName <br>";
            $ext = pathinfo($_FILES['Pic2']['name'], PATHINFO_EXTENSION);
            echo "5> $ext <br>";
            $ReN2 = $fileNewName.".".$ext;
            echo "6> $ReN1 <br>";
            $imageType = $sourceProperties[2];
            echo "7> $imageType <br>";
            echo "======================================<br>";
            if ($fileSize > MAX_SIZE) {
                switch ($imageType) {
                        case IMAGETYPE_PNG:
                            $imageResourceId = imagecreatefrompng($file);
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            imagepng($targetLayer, $folderPath. $fileNewName. ".". $ext);
                            break;
                        case IMAGETYPE_GIF:
                            $imageResourceId = imagecreatefromgif($file);
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            imagegif($targetLayer, $folderPath. $fileNewName. ".". $ext);
                            break;
                        case IMAGETYPE_JPEG:
                            $imageResourceId = imagecreatefromjpeg($file);
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            imagejpeg($targetLayer, $folderPath. $fileNewName. ".". $ext);
                            break;
                        default:
                            echo "Invalid Image type.";
                            exit;
                            break;
                    }
                    echo "2> Image Resize Successfully.<br>";
            } else {
                move_uploaded_file($file, $folderPath. $fileNewName. ".".$ext);
            }
            echo "2> move_uploaded_file.<br>";
        }
        echo "======================================<br>";
        if($_FILES["Pic3"]["tmp_name"] != ""){
            $fileSize = $_FILES['Pic3']['size'];
            $file = $_FILES['Pic3']['tmp_name'];
            $sourceProperties = getimagesize($file);
            $fileNewName = $Area."_3_".date("Ymd_His");
            $ext = pathinfo($_FILES['Pic3']['name'], PATHINFO_EXTENSION);
            $ReN3 = $fileNewName.".".$ext;
            $imageType = $sourceProperties[2];
            if ($fileSize > MAX_SIZE) {
                switch ($imageType) {
                        case IMAGETYPE_PNG:
                            $imageResourceId = imagecreatefrompng($file);
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            imagepng($targetLayer, $folderPath. $fileNewName. ".". $ext);
                            break;
                        case IMAGETYPE_GIF:
                            $imageResourceId = imagecreatefromgif($file);
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            imagegif($targetLayer, $folderPath. $fileNewName. ".". $ext);
                            break;
                        case IMAGETYPE_JPEG:
                            $imageResourceId = imagecreatefromjpeg($file);
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            imagejpeg($targetLayer, $folderPath. $fileNewName. ".". $ext);
                            break;
                        default:
                            echo "Invalid Image type.";
                            exit;
                            break;
                    }
                    echo "3> Image Resize Successfully.<br>";
            } else {
                move_uploaded_file($file, $folderPath. $fileNewName. ".".$ext);
                echo "3> move_uploaded_file.<br>";
            }
        }
        echo "======================================<br>";
        if($_FILES["Pic4"]["tmp_name"] != ""){
            $fileSize = $_FILES['Pic4']['size'];
            $file = $_FILES['Pic4']['tmp_name'];
            $sourceProperties = getimagesize($file);
            $fileNewName = $Area."_4_".date("Ymd_His");
            $ext = pathinfo($_FILES['Pic4']['name'], PATHINFO_EXTENSION);
            $ReN4 = $fileNewName.".".$ext;
            $imageType = $sourceProperties[2];
            if ($fileSize > MAX_SIZE) {
                switch ($imageType) {
                        case IMAGETYPE_PNG:
                            $imageResourceId = imagecreatefrompng($file);
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            imagepng($targetLayer, $folderPath. $fileNewName. ".". $ext);
                            break;
                        case IMAGETYPE_GIF:
                            $imageResourceId = imagecreatefromgif($file);
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            imagegif($targetLayer, $folderPath. $fileNewName. ".". $ext);
                            break;
                        case IMAGETYPE_JPEG:
                            $imageResourceId = imagecreatefromjpeg($file);
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            imagejpeg($targetLayer, $folderPath. $fileNewName. ".". $ext);
                            break;
                        default:
                            echo "Invalid Image type.";
                            exit;
                            break;
                    }
                    echo "4> Image Resize Successfully. <br>";
            } else {
                move_uploaded_file($file, $folderPath. $fileNewName. ".".$ext);
                echo "4> move_uploaded_file.<br>";
            }
        }
        echo "======================================<br>";
        if($_FILES["Pic5"]["tmp_name"] != ""){
            $fileSize = $_FILES['Pic5']['size'];
            $file = $_FILES['Pic5']['tmp_name'];
            $sourceProperties = getimagesize($file);
            $fileNewName = $Area."_5_".date("Ymd_His");
            $ext = pathinfo($_FILES['Pic5']['name'], PATHINFO_EXTENSION);
            $ReN5 = $fileNewName.".".$ext;
            $imageType = $sourceProperties[2];
            if ($fileSize > MAX_SIZE) {
                switch ($imageType) {
                        case IMAGETYPE_PNG:
                            $imageResourceId = imagecreatefrompng($file);
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            imagepng($targetLayer, $folderPath. $fileNewName. ".". $ext);
                            break;
                        case IMAGETYPE_GIF:
                            $imageResourceId = imagecreatefromgif($file);
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            imagegif($targetLayer, $folderPath. $fileNewName. ".". $ext);
                            break;
                        case IMAGETYPE_JPEG:
                            $imageResourceId = imagecreatefromjpeg($file);
                            $targetLayer = imageResize($imageResourceId, $sourceProperties[0], $sourceProperties[1]);
                            imagejpeg($targetLayer, $folderPath. $fileNewName. ".". $ext);
                            break;
                        default:
                            echo "Invalid Image type.";
                            exit;
                            break;
                    }
                    echo "5> Image Resize Successfully. <br>";
            } else {
                move_uploaded_file($file, $folderPath. $fileNewName. ".".$ext);
                echo "5> move_uploaded_file.<br>";
            }
        }
        echo "======================================<br>";
        if ($Area <> "" && $xYear <> "" && $xMonth <> "" && $Activity <> "") {
            $Sql = "INSERT INTO activity_by_month (Area,YY,MM,Activity,Pic1,Pic2,Pic3,Pic4,Pic5) VALUES ('$Area','$xYear','$xMonth','$Activity','$ReN1','$ReN2','$ReN3','$ReN4','$ReN5')";
            $meQuery = mysqli_query($conn, $Sql);
        }
        echo "=================== $Sql ===================<br>";
    }
    
	header('location:activity.php');	
?>
