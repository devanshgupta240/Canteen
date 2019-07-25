<?php
include './database.php';

$name = $_POST['add_name'];
$price = $_POST['add_price'];
$time = $_POST['add_time'];
$quantity = $_POST['add_quantity'];
$info = $_POST['add_info'];
$filename = addslashes($_FILES["fileupload"]["name"]);
$tmpname = addslashes(file_get_contents($_FILES['fileupload']['tmp_name']));
//$filesize = addslashes($_FILES['img']['size']);
$array = array('jpg','jpeg');
$ext = pathinfo($filename, PATHINFO_EXTENSION);
if(!empty($filename)){
	if(in_array($ext, $array)){
		$sql = "INSERT INTO items (name, price, time, quantity, info, image) VALUES ('$name', $price, $time, $quantity, '$info', '$tmpname' )";
		$conn->query($sql);
		//mysql_query("Insert into upl(name,image) values('$filename','$tmpname')");
		//echo "uploaded";
	}
	else{
	echo "unsupported file type";
	exit();
	}
}
else{
	echo "please select a image";
	exit();
}

header("location: ../users/edit_admin.php");
?>