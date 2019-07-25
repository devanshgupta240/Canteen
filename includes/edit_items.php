<?php
include '../includes/database.php';
	foreach ($_POST as $key => $value)
	{
		echo $key;
		echo $value;
		if(preg_match("/[0-9]+_name/",$key)){
			if($value != ''){
			$key = strtok($key, '_');
			$value = htmlspecialchars($value);
			$sql = "UPDATE items SET name = '$value' WHERE item_id = $key;";
			$conn->query($sql);
			}
		}
		if(preg_match("/[0-9]+_price/",$key)){
			$key = strtok($key, '_');
			$sql = "UPDATE items SET price = $value WHERE item_id = $key;";
			$conn->query($sql);
		}
		if(preg_match("/[0-9]+_time/",$key)){
			$key = strtok($key, '_');
			$sql = "UPDATE items SET time = $value WHERE item_id = $key;";
			$conn->query($sql);
		}
		if(preg_match("/[0-9]+_quantity/",$key)){
			$key = strtok($key, '_');
			$sql = "UPDATE items SET quantity = $value WHERE item_id = $key;";
			$conn->query($sql);
		}
		if(preg_match("/[0-9]+_info/",$key)){
			if($value != ''){
			$key = strtok($key, '_');
			$value = htmlspecialchars($value);
			$sql = "UPDATE items SET info = '$value' WHERE item_id = $key;";
			$conn->query($sql);
			}
		}
	}
 header("location: ../users/edit_admin.php");
?>