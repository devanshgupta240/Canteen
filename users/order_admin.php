<?php
  include '../includes/database.php';
  session_start();
  if (isset($_SESSION['username'])) {
    if(strcmp($_SESSION['username'], 'root') == 0){

    }
    else{
      header("Location: ../login/login.php");
      exit();
    }
  }
  else{
    header("Location: ../login/login.php");
    exit();
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>   <title>Order List</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    
  <!-- CORE CSS-->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- <link href="css/style.min.css" type="text/css" rel="stylesheet"> -->
  <!-- Custome CSS-->    
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nothing+You+Could+Do" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
                   <a class="navbar-brand" href="home.php"><span class="flaticon-pizza-1 mr-1"></span>Core-II<br><small>Canteen</small></a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
          </button>
          <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="home.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="menu.php" class="nav-link">Menu</a></li>
            <li class="nav-item"><a href="edit_admin.php" class="nav-link">Edit Menu</a></li>
            <li class="nav-item active"><a href="order_admin.php" class="nav-link">View Sales</a></li>
            <li class="nav-item"><a href="order_queue.php" class="nav-link">View Orders</a></li>
            <li class="nav-item"><a href="../includes/logout.php" class="nav-link">Logout</a></li>
          </ul>
            </ul>
          </div>
          </div>
      </nav>
   
        


      <!-- START CONTENT -->
      <section id="content">



        <!--start container-->
        <div class="container">
          <!--editableTable-->

			<div id="work-collections" class="seaction">
            <h3 class="mb-3">Select Date</h3>
            <form action="../includes/filter_orders.php" method="POST">
              <div class="d-md-flex">
                <div class="form-group">
                  <input type="date" name="start_date" class="form-control" placeholder="From" >
                </div>&nbsp&nbsp&nbsp
                <div class="form-group">
                  <input type="date" name="end_date" class="form-control" placeholder="To" >
                </div>&nbsp&nbsp&nbsp
                <div class="form-group">
                <input type="submit" value="See Sales" style="margin-top: 20px " class="btn btn-primary ">
              </div>
              </div>              
              
            </form>
    
             
					<?php

					if(isset($_GET['start'])) {
            $start = $_GET['start'];
            $end =  $_GET['end'];
            $sql = mysqli_query($conn, "SELECT * FROM orders WHERE (CAST(date AS DATE)>='$start') AND (CAST(date AS DATE)<='$end') ORDER BY date DESC ");
          }
          else{
					 $sql = mysqli_query($conn, "SELECT * FROM orders ORDER BY date DESC");
          }
          

          
						echo '<div class="row">
                			<div class="col-md-12">
                    			<h4 class="header">Order List</h4>
                    				<ul id="issues-collection" class="collection">';
					while($row = mysqli_fetch_array($sql))
					{
			            date_default_timezone_set("Asia/Kolkata");
			            $current_date = date('Y-m-d H:i:s', time());
			            $order_date =  $row['date'];
			            $diff = abs(strtotime($current_date) - strtotime($order_date));
			            
			            $customer_id = $row['customer_id'];
			            $sql_customer = mysqli_query($conn, "SELECT * FROM users WHERE user_id= '$customer_id'");
			            while($customer = mysqli_fetch_array($sql_customer)){
			              $customer_name = $customer['name'];
			              $customer_email = $customer['email'];
			              $customer_phone = $customer['phone'];
			            }

						echo '<li class="collection-item avatar">
                              <i class="mdi-content-content-paste deep-purple circle"></i>
                              <span class="collection-header">Order No. '.$row['order_id'].'</span>
                              <p><strong>Date:</strong> '.$row['date'].'</p>
                              <p><strong>Name:</strong> '.$customer_name.'</p>
                              <p><strong>Phone:</strong> '.$customer_phone.'</p>
                              <p><strong>Email:</strong> '.$customer_email.'</p>
							  <p><strong>Address: </strong>'.$row['address'].'</p>';
							  if($diff <= $row['duration']*60){
							  	echo '<p><strong>Status: </strong> Not Completed </p>';
							  }
							  else{
							  	echo '<p><strong>Status: </strong> Completed </p>';
							  }
							  echo '<a href="#" class="secondary-content"><i class="mdi-action-grade"></i></a>
                              </li>';
						$order_id = $row['order_id'];
						$sql1 = mysqli_query($conn, "SELECT * FROM order_details WHERE order_id = $order_id;");
						while($row1 = mysqli_fetch_array($sql1))
						{
							$item_id = $row1['item_id'];
							$sql2 = mysqli_query($conn, "SELECT * FROM items WHERE item_id = $item_id;");
							while($row2 = mysqli_fetch_array($sql2)){
								$item_name = $row2['name'];
							}
							echo '<li class="collection-item">
                            <div class="row">
                            <div class="col s5">
                            <p class="collections-title"><strong>#'.$row1['item_id'].'</strong> '.$item_name.'</p>
                            </div>
                            <div class="col s2">
                            <span>'.$row1['quantity'].' Pieces</span>
                            </div>
                            <div class="col s3">
                            <span>'.$row1['duration'].' minutes</span>
                            </div>
                            <div class="col s2">
                            <span>Rs. '.$row1['price'].'</span>
                            </div>
                            </div>
                            </li>';
							$id = $row1['order_id'];
						}
								echo'<li class="collection-item">
                                        <div class="row">
                                            <div class="col s6">
                                                <p class="collections-title">Preparetion Time</p>
                                            </div>
                                            <div class="col s2">
                      <span> </span>
                                            </div>
                                            <div class="col s2">
                      <span> <strong>'.$row['duration'].' minutes</strong></span>
                                            </div>
                                            <div class="col s2">
                                                
                                            </div>
                                            </div>
                                             <div class="row">
                                            <div class="col s6">
                                                <p class="collections-title">Dilevery Time</p>
                                            </div>
                                            <div class="col s2">
                      <span> </span>
                                            </div>
                                            <div class="col s2">
                      <span> <strong>2 minutes</strong></span>
                                            </div>
                                            <div class="col s2">
                                                
                                            </div>
                                            </div>
                                             <div class="row">
                                            <div class="col s6">
                                                <p class="collections-title">Expected Arrival(incluing waiting time)</p>
                                            </div>
                                            <div class="col s2">
                      <span> </span>
                                            </div>
                                            <div class="col s2">
                      <span> <strong>'.$row['end_time'].'</strong></span>
                                            </div>
                                            <div class="col s2">
                                                
                                            </div>
                                            </div>
                                        <div class="row">
                                            <div class="col s6">
                                                <p class="collections-title"> Total</p>
                                            </div>
                                            <div class="col s2">
											<span> </span>
                                            </div>
                                            <div class="col s2">
                      <span> </span>
                                            </div>
                                            <div class="col s2">
                                                <span><strong>Rs. '.$row['total'].'</strong></span>
                                            </div>
                                            </div>

                    </li>';


					}
					?>
					 </ul>
                </div>
              </div>
            </div>
        </div>
        <!--end container-->

      </section>
      <!-- END CONTENT -->
     <?php include('footer.php'); ?>
  



  <!-- //////////////////////////////////////////////////////////////////////////// -->





    <!-- ================================================
    Scripts
    ================================================ -->
    
    <!-- jQuery Library -->
    <script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>    
    <!--angularjs-->
    <script type="text/javascript" src="js/plugins/angular.min.js"></script>
    <!--materialize js-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>       
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="js/plugins.min.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="js/custom-script.js"></script>
</body>

</html>
