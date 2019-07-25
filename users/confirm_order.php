<?php
  include '../includes/database.php';
  session_start();
  $total = 0;
  $totaltime = 0;
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
  }
  else{
    header("Location: ../login/login.php");
    exit();
  }
    $result = mysqli_query($conn, "SELECT * FROM users where user_id = $user_id");
    while($row = mysqli_fetch_array($result)){
        $name = $row['name'];
        $contact = $row['phone'];
        $address = $row['address'];
    }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Confirm Order</title>
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
          <a class="navbar-brand" href="index.html"><span class="flaticon-pizza-1 mr-1"></span>Pizza<br><small>Delicous</small></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
          </button>
          <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a href="home.php" class="nav-link">Home</a></li>  
              <li class="nav-item"><a href="menu.php" class="nav-link">Menu</a></li>
            <li class="nav-item"><a href="orders.php" class="nav-link">Order</a></li>
            <li class="nav-item"><a href="../includes/logout.php" class="nav-link">Logout</a></li>
            </ul>
          </div>
          </div>
      </nav>
<section class="ftco-appointment">
            <div class="overlay"></div>
        <div class="container-wrap">
            <div class="row no-gutters d-md-flex align-items-center">
                <div class="col-md-12 appointment ftco-animate">
                    <h3 class="mb-3">Order Confirmation</h3>
                    <form action="../includes/order-router.php" method="post" class="appointment-form">
                        <?php
                        echo '<div class="d-md-flex">
                            <div class="form-group">
                                Name: '.$name.'
                            </div>
                        </div>
                        <div class="d-me-flex">
                            <div class="form-group">
                                Contact: '.$contact.'
                            </div>
                        </div>';
                        
                    foreach ($_POST as $key => $value)
                    {   

                        if(is_numeric($key)){  
                          if($value<0){
                            header("Location: ./menu.php?error3=ok");
                            exit();
                          }
                          if($value==0){
                            continue;
                          }

                        $result = mysqli_query($conn, "SELECT * FROM items WHERE item_id = $key");
                        while($row = mysqli_fetch_array($result))
                        {   
                          $item_name = $row['name'];
                          if ($row['name']=="Tea" || $row['name']=="Coffee"){

                          }
                          else{
                            if($row['quantity']-$value<0){
                                header("Location: ./menu.php?error=$item_name");
                                exit();
                            }
                          } 
                          $price = $row['price'];
                          $time = $row['time'];
                          $item_name = $row['name'];
                          $item_id = $row['item_id'];
                        }

                            $price = $value*$price;
                            $time = $value*$time;
                                echo '
                        <div class="row">
                            <div class="col s6">
                                <p class="collections-title"><strong>#'.$item_id.' </strong>'.$item_name.'</p>
                            </div>
                            <div class="col s2">
                                <span>'.$value.' Pieces</span>
                            </div>
                            <div class="col s2">
                              <span>'.$time.' minutes</span>
                            </div>
                            <div class="col s2">
                                <span>Rs. '.$price.'</span>
                            </div>
                        </div> ';
                        $total = $total + $price;
                        $totaltime = $totaltime + $time;

                    }

                    }
                    if($total==0){
                      header("Location: menu.php?error2=none");
                        exit();
                    }

                    // $end_date = 0;
                    $totaltime = $totaltime;
                    $finaltime = $totaltime+2;

                    $result = mysqli_query($conn, "SELECT * FROM orders");
              
          
                    $resultCheck=mysqli_num_rows($result);
                    
                    if($resultCheck==0){
                        date_default_timezone_set("Asia/Kolkata");
                        $current_date = new Datetime(date('Y-m-d H:i:s', time()));
                        $end_date = new Datetime(date('Y-m-d H:i:s', time()));
                        $end_date->add(new DateInterval('PT'.$finaltime.'M'));
                        $end_date = $end_date->format('Y-m-d  H:i:s' );
                        $current_date = $current_date->format('Y-m-d  H:i:s' );
                   

                    }
                    else{
                      
                      $sql =  mysqli_query($conn, "SELECT * FROM orders ORDER BY order_id DESC LIMIT 1;");
                      while($row = mysqli_fetch_array($sql))
                      {
                        date_default_timezone_set("Asia/Kolkata");
                        $current_date = new Datetime(date('Y-m-d H:i:s', time()));
                         $current_date = $current_date->format('Y-m-d  H:i:s' );
                      

                        $diff = strtotime($row['end_time']) - strtotime($current_date);
                       
                        if($diff>0){
                            $end_date = new Datetime($row['end_time']);
                                
                        }
                        else{
                            $end_date = new Datetime(date('Y-m-d H:i:s', time()));
                         }
                        $end_date->add(new DateInterval('PT'.$finaltime.'M'));
                        $end_date = $end_date->format('Y-m-d  H:i:s' );
                        
                      
                      } 
                      

                    }   
            
           
                
                
            
                    echo ' <div class="row">
                            <div class="col s6">
                                <p class="collections-title"> Total</p>
                            </div>
                            <div class="col s2">
                                <span>&nbsp;</span>
                            </div>
                            <div class="col s2">
                                <span>&nbsp;</span>
                            </div>
                            <div class="col s2">
                                <span><strong>Rs. '.$total.'</strong></span>
                            </div>
                            </div>
                          
                            <div class="row">
                            <div class="col s6">
                                <p class="collections-title"> Preperation time</p>
                            </div>
                            <div class="col s2">
                                <span>&nbsp;</span>
                            </div>
                            <div class="col s2">
                                <span><strong>'.$totaltime.' minutes</strong></span>
                            </div>
                            <div class="col s2">
                                <span>&nbsp;</span>
                            </div>

                          </div>
                             <div class="row">
                            <div class="col s6">
                                <p class="collections-title">Dilevery time</p>
                            </div>
                            <div class="col s2">
                                <span>&nbsp;</span>
                            </div>
                            <div class="col s2">
                                <span><strong>2 minutes</strong></span>
                            </div>
                            <div class="col s2">
                                <span>&nbsp;</span>
                            </div>

                          </div>
                           <div class="row">
                            <div class="col s6">
                                <p class="collections-title">Expected Arrival(including waiting time)</p>
                            </div>
                            <div class="col s2">
                                <span>&nbsp;</span>
                            </div>

                            <div class="col s2">
                                <span><strong>'.$end_date.'</strong></span>
                            </div>
                            <div class="col s2">
                                <span>&nbsp;</span>
                            </div>

                          </div>
                    <div class="form-group">
                    <div class="d-me-flex">
                            <div class="form-group">
                                Address: <input type="text" name = "address" class="form-control" value="'.$address.'">
                            </div>
                        </div>
                  <input type="submit" value="Confirm Order" class="btn btn-primary py-3 px-4">
                </div>';
                    foreach ($_POST as $key => $value)
                    {
                        if(is_numeric($key)){
                            echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
                        }
                    }

                    ?>
                    <input type="hidden" name="total" value="<?php echo $total;?>">
                    <input type="hidden" name="totaltime" value="<?php echo $totaltime;?>">
                    <input type="hidden" name="end_date" value="<?php echo $end_date;?>">
                   
                     <input type="hidden" name="current_date" value="<?php echo $current_date;?>">
                    </form>
                </div>              
            </div>
        </div>
    </section>
    

  <footer class="ftco-footer ftco-section img">
      <div class="overlay"></div>
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-3 col-md-6 mb-5 mb-md-5">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">About Us</h2>
              <p>Core 2 Canteen, IIT Guwhati</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          
          <div class="col-lg-3 col-md-6 mb-5 mb-md-5">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Have a Questions?</h2>
              <div class="block-23 mb-3">
                <ul>
                  <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                  <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                  <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            
          </div>
        </div>
      </div>
    </footer>
    
  

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
