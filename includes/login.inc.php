<?php

if (isset($_POST['login_sumbit'])) {

	require 'database.php';
	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($username) || empty($password) ) {
		header("Location: ../login/login.php?error=emptyfeilds");
			exit();
	}
	else{
		$sql = "SELECT * FROM users WHERE username=?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("Location: ../login/login.php?error=sqlerror");
			exit();		
		}
		else{
				
				mysqli_stmt_bind_param($stmt,"s",$username);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				if($row = mysqli_fetch_assoc($result)){
					$pwdCheck = password_verify($password,$row['password']);
					if($pwdCheck == false){ 
						header("Location: ../login/login.php?error=wrongpwd");
						exit();	
					}
					else if($pwdCheck == true){
						session_start();
						$_SESSION['user_id'] = $row['user_id'];
						$_SESSION['username'] = $row['username'];
						header("Location: ../users/home.php");
						exit();
					}
					else{
						header("Location: ../login/login.php?error=wrongpwd");
						exit();	
					}

				}
				else{
					header("Location: ../login/login.php?error=wrongusername");
					exit();
				}
		}
	}	
}

else {
	header("Location: ../login/login.php");
	exit();	
}