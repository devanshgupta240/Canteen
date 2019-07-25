<?php
include '../includes/database.php';
session_start();
  $total = 0;
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
  }
  else{
    header("Location: ../login/login.php");
    exit();
  }
$total = 0;
$totaltime = 0;
$address = $_POST['address'];
$total = $_POST['total'];
$totaltime = $_POST['totaltime'];
$end_date = $_POST['end_date'];
$current_date = $_POST['current_date'];
	
	$sql = "INSERT INTO orders (customer_id, address, total, date, duration, end_time) 
	VALUES ($user_id, '$address', $total, '$current_date', $totaltime, '$end_date')";
	if ($conn->query($sql) === TRUE){
		
		$order_id =  $conn->insert_id;
		foreach ($_POST as $key => $value)
		{	echo $key;
			echo $value;
			if(is_numeric($key)){
				 if($value==0){
                    continue;
                  }
				$result = mysqli_query($conn, "SELECT * FROM items WHERE item_id = $key");
				while($row = mysqli_fetch_array($result))
				{
					$item_name = $row['name'];
					if($item_name=="Tea" || $item_name =="Coffee"){
						$new_quantity = $row['quantity'];	
					}
					else{
						$new_quantity = $row['quantity']-$value;
					}
					$sql = "UPDATE items SET quantity = '$new_quantity' WHERE item_id = $key;";
					$conn->query($sql) === TRUE;
					$price = $row['price'];
					$duration = $row["time"];

				}
					$price = $value*$price;
					$duration = $value*$duration;
				$sql = "INSERT INTO order_details (order_id, item_id, quantity, price, duration) VALUES ($order_id, $key, $value, $price, $duration )";
				$conn->query($sql) === TRUE;		
			}
		}
		header("Location: ../users/orders.php");
	}



?>