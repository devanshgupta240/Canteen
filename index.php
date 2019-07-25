<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Signup</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-gra-01 p-t-90 p-b-90 font-poppins">
        <div class="wrapper wrapper--w780">
            <div class="card card-3">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Signup</h2>
                    <?php
	                    if(isset($_GET["error"])){
	                    	if($_GET["error"]==="emptyfields"){
	                    		echo '<p class="input--style-3">Please Fill All Feilds!</p>';
	                		}
	                		if($_GET["error"]==="usernametaken"){
	                    		echo '<p class="input--style-3">Username not available</p>';
	                		}
	                		if($_GET["error"]==="passwordCheck"){
	                    		echo '<p class="input--style-3">Password do not match</p>';
	                		}
	                    }
                         if(isset($_GET["signup"])){
                               
                                echo '<p class="input--style-3">Signup Successful!</p>';
                            
                         }
                	   echo '<br>';
                    ?>
                    <form method="POST" action="./includes/signup.inc.php">
                        <div class="input-group">
                            <input class="input--style-3" type="text" placeholder="Full Name" name="name">
                        </div>
                        <div class="input-group">
                            <input class="input--style-3" type="email" placeholder="Email" name="email">
                        </div>
                        <div class="input-group">
                            <input class="input--style-3" type="number" placeholder="Phone" name="phone" max="9999999999" min="1000000000"> 
                        </div>
						<div class="input-group">
                            <input class="input--style-3" type="text" placeholder="Room number/Lab number" name="address">
                        </div>
						<div class="input-group">
                            <input class="input--style-3" type="text" placeholder="Username" name="username">
                        </div>
						<div class="input-group">
                            <input class="input--style-3" type="password" placeholder="Password" name="password">
                        </div>
						<div class="input-group">
                            <input class="input--style-3" type="password" placeholder="Confirm Password" name="passwordRepeat">
                        </div>
						 
                        <div class="p-t-10">
                            <button class="btn btn--pill btn--green" type="submit" name="signup_sumbit">Submit</button>
                        </div>
						<br>
						<div>
						<a href ="./login/login.php" class="input--style-3" >Already have a account? Login Here</a>
						</div>	
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->