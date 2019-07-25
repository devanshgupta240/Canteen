<?php
include './database.php';
$start = $_POST['start_date'];
$end = $_POST['end_date'];
header("location: ../users/order_admin.php?start=$start&end=$end");