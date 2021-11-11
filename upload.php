<style>
.sucess{
color:#088A08;
}
.error{
color:red;
}
</style>

<?php
$file = basename($_REQUEST['Pic1']);

$file_exts = array("jpg", "bmp", "jpeg", "gif", "png");
$upload_exts = end(explode(".", $_FILES["Pic1"]["name"]));
if ((($_FILES["Pic1"]["type"] == "image/gif")
|| ($_FILES["Pic1"]["type"] == "image/jpeg")
|| ($_FILES["Pic1"]["type"] == "image/png")
|| ($_FILES["Pic1"]["type"] == "image/pjpeg"))
&& ($_FILES["Pic1"]["size"] < 2000000)
&& in_array($upload_exts, $file_exts))
{
if ($_FILES["Pic1"]["error"] > 0)
{
echo "Return Code: " . $_FILES["Pic1"]["error"] . "<br>";
}
else
{
$Upload = "Upload: " . $_FILES["Pic1"]["name"];
echo "Type: " . $_FILES["Pic1"]["type"] . "<br>";
echo "Size: " . ($_FILES["Pic1"]["size"] / 1024) . " kB<br>";
echo "Temp file: " . $_FILES["Pic1"]["tmp_name"] . "<br>";
// Enter your path to upload file here
if (file_exists("c:\wamp\www\upload/newupload/" .
$_FILES["Pic1"]["name"]))
{
echo "<div class='error'>"."(".$_FILES["Pic1"]["name"].")".
" already exists. "."</div>";
}
else
{
move_uploaded_file($_FILES["Pic1"]["tmp_name"],
"c:\wamp\www\upload/newupload/" . $_FILES["Pic1"]["name"]);
echo "<div class='sucess'>"."Stored in: " .
"c:\wamp\www\upload/newupload/" . $_FILES["Pic1"]["name"]."</div>";
}
}
}
else
{
echo "<div class='error'>Invalid file</div>";
}
?>

<body>
<textarea  rows='2'  ><?php echo $file ?></textarea>
</body>