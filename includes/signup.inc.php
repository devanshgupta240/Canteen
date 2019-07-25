<?php

if (isset($_POST['signup_sumbit'])) {

	require 'database.php';

	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$passwordRepeat = $_POST['passwordRepeat'];

	if (empty($name) || empty($username) || empty($email) || empty($phone) || empty($address) || empty($password) ) {
		header("Location: ../index.php?error=emptyfields");
		exit();
	}
	elseif ($password !== $passwordRepeat) {
		header("Location: ../index.php?error=passwordCheck");
		exit();
	}
	else{
		$sql = "SELECT * FROM users WHERE username=?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../index.php?error=sqlerror1");
			exit();		
		}
		else{
			mysqli_stmt_bind_param($stmt,"s",$username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$resultCheck = mysqli_stmt_num_rows($stmt);
			if($resultCheck > 0){
				header("Location: ../index.php?error=usernametaken");
				exit();
			}
			else{
				
				$sql = "INSERT INTO users (name, email, phone, address, username, password) VALUES (?, ?, ?, ?, ?, ?)";
				$stmt = mysqli_stmt_init($conn);
				
				if(!mysqli_stmt_prepare($stmt,$sql)){
					header("Location: ../index.php?error=sqlerror2");
					exit();		
				}
				else{

					$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
					mysqli_stmt_bind_param($stmt,"ssisss", $name, $email, $phone, $address, $username, $hashedPwd);
					mysqli_stmt_execute($stmt);
					header("Location: ../index.php?signup=success");
					exit();

				
				}

			}


		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else{
	header("Location: ../index.php");
	exit();	
}