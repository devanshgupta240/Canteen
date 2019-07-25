<?php
  include '../includes/database.php';
  session_start();
  if (isset($_SESSION['user_id'])) {

  }
  else{
    header("Location: ../login/login.php");
    exit();
  }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Menu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
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
	          <li class="nav-item active"><a href="menu.php" class="nav-link">Menu</a></li>
	          <?php
            if(strcmp($_SESSION['username'], 'root') == 0){
              echo '<li class="nav-item"><a href="edit_admin.php" class="nav-link">Edit Menu</a></li>';
              echo '<li class="nav-item"><a href="order_admin.php" class="nav-link">View Sales</a></li>';
              echo '<li class="nav-item"><a href="order_queue.php" class="nav-link">View Orders </a></li>';
            }
            else{
             echo '<li class="nav-item"><a href="orders.php" class="nav-link">View Orders</a></li>';
            }
            ?>
	          <li class="nav-item"><a href="../includes/logout.php" class="nav-link">Logout</a></li>
	        </ul>
	      </div>
		  </div>
	  </nav>
    <!-- END nav -->

    
    
		<section class="ftco-section">
    	

    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-3 mt-5 pt-5">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2 class="mb-4">Our Menu Pricing</h2>
            <p class="flip"><span class="deg1"></span><span class="deg2"></span><span class="deg3"></span></p>
            <p class="mt-5">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
          </div>
        </div>
        <?php
        	if(isset($_GET["error"])){
        	echo '<div class="row justify-content-center mb-5 pb-3 mt-5 pt-5">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2 class="mb-4">Sorry! We do not have that much '.$_GET["error"].' </h2>
            </div>
        </div>';
        }
        if(isset($_GET["error2"])){
        	echo '<div class="row justify-content-center mb-5 pb-3 mt-5 pt-5">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2 class="mb-4">Please Select atleast one item</h2>
            </div>
        </div>';
        }
        if(isset($_GET["error3"])){
          echo '<div class="row justify-content-center mb-5 pb-3 mt-5 pt-5">
          <div class="col-md-7 heading-section text-center ftco-animate">
            <h2 class="mb-4">Cannot order in negatic</h2>
            </div>
        </div>';
        }
        ?>

        <form method="POST" action = './confirm_order.php'>
        	<div class="row">
        		<div class="col-md-1"></div>
        		<div class="col-md-8">Name</div>
        		<div class="col-md-1">&nbsp&nbsp&nbsp&nbspPrice</div>
        		<div class="col-md-1">Time</div>
        		<div class="col-md-1">Quantity</div>
        	</div>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM items WHERE quantity>10;");
        while($row = mysqli_fetch_array($result)){
        

       echo '<div class="row">';
        	echo '<div class="col-md-12">';
        		echo '<div class="pricing-entry d-flex ftco-animate">';
        			 echo '<div class="img" style="background-image: url(data:image/jpeg;base64,'.base64_encode($row['image']).')" ></div>';
        			echo '<div class="desc pl-3">';
	        			echo '<div class="d-flex text align-items-center">';
	        				echo '<h3><span>'.$row["name"].'</span></h3>';
	        				echo '<span class="price">Rs.'.$row["price"].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>';
                  echo '<span class="price">'.$row["time"].'&nbspmin&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>';
                  echo '<input class="quantity_input" style="width:90px;" type="number" name="'.$row["item_id"].'" placeholder="quantity" value="0" min="0" required>';

	        			echo '</div>';
	        			echo '<div class="d-block">';
	        				echo '<p>'.$row["info"].'</p>';
	        			echo '</div>';
        			echo '</div>';
        		echo '</div>';
        		
        	echo '</div>';
          
        	
        echo '</div>';
      }
        ?>
        <?php 
        if(strcmp($_SESSION['username'], 'root') == 0){

        }
        else{ 
          echo '<div class="col-md-12 col-sm-12 text-center ftco-animate">
              <p><button name="order_submit" class="btn btn-primary p-3 px-xl-4 py-xl-3">Order Now</button>
          </div>';    
        }
          ?>
      </form>  
    	</div>
      
    </section>

  
<?php include('footer.php'); ?>

    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>