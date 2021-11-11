<html>
<head>
<title>ThaiCreate.Com Tutorial</title>
</head>
<body>
<?php
if(move_uploaded_file($_FILES["filUpload"]["tmp_name"],"imageSlip/".$_FILES["filUpload"]["name"]))
{
	echo "Copy/Upload Complete";
}else{
	echo "No";
}

?>
</body>
</html>