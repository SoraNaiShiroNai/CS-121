<?php
if(session_id() == ''){
    //session has not started
    session_start();
}
$password1 = '47130110150220053410';
$email1 = 'sora@disboard.com';
$password2 = 'kuroyukihime';
$email2 = 'shiro@disboard.com';
$firstname = '';
$email = '';
$checker = '';

if(isset($_POST['email'])){
	$email = $_SESSION['email'];
	$firstname = $_SESSION['firstname'];
	$checker = $_SESSION['checker'];
}

if(isset($_POST['logout'])){
	unset($_SESSION['email']);
	unset($_SESSION['firstname']);
	//unset($_SESSION['results_arr']);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Truthful Chicken - Home</title>

  <!-- Bootstrap core CSS -->
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="assets/css/index.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php"><img src="images/logowtitle.jpg" width="200px"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item ">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="productspage.php">Products</a>
          </li>
          <li class="nav-item">
            <?php

      			if (isset($_SESSION['email'])) {

      				if($_SESSION['email']==$email1 || $_SESSION['email']==$email2){
      					//CANCEL ORDERS (optional)
      					//DELETE ITEMS ON SALE AND ON AUCTION
      					//VIEW and DELETE USERS
      					//VIEW HISTORY OF USERS
      					//echo "<form method = 'post' action = 'php/list.php'><button type = 'submit'>View Items</button></form>";

      					//THIS IS WHERE ADMIN ACCESS ONLY FUNCTIONS ARE
                print '<div class="px-5 dropdown">
                  <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i> ADMIN</button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <form method="post" action=""><button class="dropdown-item" type="submit" name="logout">Logout</button></form>
                  </div>
                </div>';
      					//echo '<form method = "post" action = ""><button class="btn btn-outline-light my-2 my-sm-0 mr-1" type="submit"  name = "logout">Logout</button></form>';

      					//.............................................
      				}
      				else{
      					//echo "<h3>Email: ".$_SESSION['email']."</h3>";

      					//echo "<a href = 'pages/add_item.html'><button value = ''>Post New Item</button></a><br>";
      					//echo "<form method = 'post' action = 'php/list.php'><button type = 'submit'>View Items</button></form>";

      					//THIS IS WHERE USER ACCESS ONLY FUNCTIONS ARE

      					//echo "<h4> $firstname Logged In as $firstname.</h4>";
      					//echo '<form method = "post" action = ""><button class="btn btn-outline-light my-2 my-sm-0 mr-1" type="submit"  name = "logout">Log Out</button></form>';
                print '<div class="px-5 dropdown">
                  <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i> USER</button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <form method="post" action=""><button class="dropdown-item" type="submit" name="logout">Logout</button></form>
                  </div>
                </div>';
      				}
      			}
      			else { //NOBODY IS LOGGED IN HERE FUNCTIONS
      				 ?>
                <button class="btn btn-light my-2 my-sm-0 mr-1" type="button"  data-toggle="modal" data-target = "#logIn">Log In</button>
      				  <a href="pages/signUp.html" class="btn btn-light my-2 my-sm-0" type="submit" >Sign up</a>
      				<?php
      			}
      			?>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container"><br>
<!-- SEARCH BAR-->


    <div class="row">

      <div class="col-lg">
      <div class="container-fluid">
  <img src="images/grocery(o_75).png" alt="Grocery" style="width:100%;">
  <div class="centered">
    <span style="background"><h2 style="color:white;">Browse for items</h2></span>
    <form method="post" action="productpage.php">
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
        <div class="input-group-append">
          <button class="btn btn-light" type="submit" id="button-addon2">Search</button>
        </div>
      </div>
    </form>
  </div>

</div>
    </div>
</div>
<hr>
    <div class="row">
      <div class="container-fluid">
        <div class="row">
        <h2>Featured Products</h2>
    </div>

      <!-- /.col-lg-3 -->
  <div class="row">

<?php
$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
$stmt = $db->prepare("SELECT * FROM `item` ORDER BY 'item_id'");
$stmt->execute();
$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

$item_id='';
$item_name = '';
$item_desc = '';
$item_price = '';
$item_photo = '';
$cart_id = '';
$counter=0;
foreach ($results_arr as $i => $values) {
  foreach ($values as $key => $value) {
    if($key=="item_id")
      $item_id =  $value;
    if($key=="item_name")
      $item_name =  $value;
    if($key=="item_desc")
      $item_desc =  $value;
    if($key=="item_price")
      $item_price =  $value;
      if($key=="item_photo")
        $item_photo =  $value;
  }
  if($counter<3){
  print '<div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100">
      <img class="card-img-top" width="400px" src="pages/uploaded_assets/'.$item_photo.'" alt="">
      <div class="card-body">
        <h4 class="card-title">'.$item_name.'</h4>
        <h5>'.$item_price.'</h5>
        <p class="card-text">'.$item_desc.'</p>
        <form method = "post" action = "pages/item_details.php">
         <input type = "text" name = "toView" value = '.$item_id.' hidden>
         <button class="btn btn-secondary btn-sm" type = "submit" name = "expandDetails">More Details</button>
         </form>
      </div>
    </div>
  </div>';}
  $counter++;
}



 ?>

</div>
  </div>

        </div>
        <!-- /.row -->
<hr>
<div class="row">
<div class="container">
				<div class="row no-gutters ftco-services">
          <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate fadeInUp ftco-animated">
            <div class="media block-6 services p-4 py-md-5">
              <div class="icon d-flex justify-content-center align-items-center mb-4">
            		<img src="images/card.png" width="75px">
              </div>
              <div class="media-body">
                <h3 class="heading">Card payments</h3>
                <p>Pay via card (paypal)</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate fadeInUp ftco-animated">
            <div class="media block-6 services p-4 py-md-5">
              <div class="icon d-flex justify-content-center align-items-center mb-4">
            		<img src="images/cod.png" width="75px">
              <div class="media-body">
                <h3 class="heading">C.O.D.</h3>
                <p>Cash on Delivery supported</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate fadeInUp ftco-animated">
            <div class="media block-6 services p-4 py-md-5">
              <div class="icon d-flex justify-content-center align-items-center mb-4">
            		<span><img src="images/ship.png" width="75px"></span>
              </div>
              <div class="media-body">
                <h3 class="heading">Delivery</h3>
                <p>Shipping via Integrated Courier</p>
              </div>
            </div>
          </div>
        </div>
			</div>
  </div>
</div>

</div>
  <!--  main container -->

  <!--LOG IN POPUP-->
	<div class="modal fade" id="logIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<form id = "logInDetails" method = 'post' action = 'php/logIn.php'>
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Log In</h5>

			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
		  <!--THIS IS THE LOG IN FORM-->

				  <div class="form-group">
					<label for="exampleInputEmail1">Email address</label>
					<input type="email" class="form-control" name = "email" aria-describedby="emailHelp" placeholder="Enter email">
					<!--small details if needed<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
				  </div>
				  <div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" class="form-control" name = "password" placeholder="Password">
				  </div>

				 <!--
				 <div id = "exampleModalLabel1"><text color = "red"></text></div>
				 <div class="form-group form-check">
					<input type="checkbox" class="form-check-input" id="exampleCheck1" hidden>
					<label class="form-check-label" for="exampleCheck1">Remember me</label>
				  </div>-->


			<!------------------------>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" name = "logIn" class="btn btn-primary" >Login</button>
		  </div>
		</div>
	  </div>
	  </form>
	</div>




  <!-- Footer -->
  <footer class="py-5" id="myFooter">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <h5>Links</h5>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="pages/productpage.php">Products</a></li>
                </ul>
            </div>
            <div class="col-sm-4">
                <h5>About us</h5>
                <ul>
                    <li><a href="aboutus.html">CMSC 121 GROUP</a></li>
                </ul>
            </div>
            <div class="col-sm-4">
                <h5>Contact Us</h5>
                <ul>
                    <li><a href="contactus.html">Email</a></li>
                </ul>
            </div>
        </div>
    </div>
       <div class="container">
            <h5 class="logo"><a href="index.php"> <img src="images/logowtitle.jpg" width="100px"> </a></h5>
        </div>
    <!-- /.container -->
  </footer>


  <!-- Bootstrap core JavaScript -->
  <script src="assets/jquery/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
