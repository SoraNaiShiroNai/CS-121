<?php
if(session_id() == ''){
    //session has not started
    session_start();
}
$password1 = 'haramitsurenge';
$email1 = 'sora@disboard.com';
$password2 = 'kuroyukihime';
$email2 = 'shiro@disboard.com';
$firstname = '';
$email = '';
$checker = '';
$searchHolder = '';

if(isset($_POST['search'])){
  $_SESSION['search']=$_POST['toSearch'];
}


if(isset($_GET['searchQuery2'])){
	unset($_SESSION['search']);
}

if(isset($_SESSION['email'])){
	$email = $_SESSION['email'];
	$firstname = $_SESSION['firstname'];
	$checker = $_SESSION['checker'];
}

if(isset($_POST['logout'])){
	unset($_SESSION['email']);
	unset($_SESSION['firstname']);
	//unset($_SESSION['results_arr']);
}

if(isset($_GET['add2cart'])){

	$item_id = $_GET['toCart'];

	$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
	$stmt = $db->prepare("SELECT * FROM `item` WHERE `item_id`='$item_id'");
	$stmt->execute();
	$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$item_id = $_GET['toCart'];
	$quantity = $_GET['quantity'];
	$item_name = '';
	$item_desc = '';
	$item_price = '';
	$item_photo = "";
	$cart_id = '';

	foreach ($results_arr as $i => $values) {
		foreach ($values as $key => $value) {
			if($key=="item_name")
				$item_name =  $value;
			if($key=="item_desc")
				$item_desc =  $value;
			if($key=="item_price")
				$item_price =  $value;

		}
	}



	$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
	$stmt = $db->prepare("SELECT * FROM `cart` WHERE `email`='$email'");
	$stmt->execute();
	$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//$stmt->debugDumpParams();
	//echo "<br>";

	foreach ($results_arr as $i => $values) {
		foreach ($values as $key => $value) {
			if($key=="cart_id")
				$cart_id =  $value;
		}
	}

	
	$stmt = $db->prepare("SELECT * FROM `cart_detail` WHERE `item_id`='$item_id' AND `cart_id` = '$cart_id'");
	$stmt->execute();
	$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	foreach ($results_arr as $i => $values) {
		foreach ($values as $key => $value) {
			if($key=="quantity")
				$quantity2 =  $value;
		}
	}
	
	if($stmt->rowCount() == 0){
		$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
		$stmt = $db->prepare("INSERT INTO `cart_detail` (`cart_id`, `item_id`, `quantity`) VALUES ('$cart_id', '$item_id', '$quantity');");
		$stmt->execute();
	}
	else{
		$newQuantity = $quantity + $quantity2;
		$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
		$stmt = $db->prepare("UPDATE cart_detail SET quantity = '$newQuantity' WHERE `item_id`='$item_id' AND `cart_id` = '$cart_id'");
		$stmt->execute();
	}




}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Truthful Chicken - Products</title>

  <!-- Bootstrap core CSS -->
  <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../assets/css/index.css" rel="stylesheet">
    <link href="../styles.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="../index.php"><img src="../images/logowtitle.jpg" width="200px"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item ">
            <a class="nav-link" href="../index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="productpage.php">Products</a>
          </li>
          <!--CART (ONLY FOR USERS)-->
          <?php
          if(isset($_SESSION["email"]) && $_SESSION["email"]!=$email1 && $_SESSION["email"]!=$email2 ){
             print '<li class="nav-item"><li class="dropdown">
                    <a href="" class="btn btn-light dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <i class="fas fa-shopping-cart"></i> VIEW CART </a>
                    <ul class=" dropdown-menu dropdown-cart" role="menu">
                    ';
                        						$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
                        						$stmt = $db->prepare("SELECT * FROM `cart` WHERE `email`='$email'");
                        						$stmt->execute();
                        						$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        						//$stmt->debugDumpParams();
                        						//echo "<br>";

                        						$cart_id ="";

                        						foreach ($results_arr as $i => $values) {
                        							foreach ($values as $key => $value) {
                        								if($key=="cart_id")
                        									$cart_id =  $value;
                        							}
                        						}

                        						$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
                        						$stmt = $db->prepare("SELECT * FROM `cart_detail` WHERE `cart_id`= '$cart_id';");
                        						$stmt->execute();

                        						//$stmt->debugDumpParams();

                        						$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        						$item_id = '';
                        						$quantity = '';

                        						foreach ($results_arr as $i => $values) {
                        							foreach ($values as $key => $value) {
                        								if($key=="item_id")
                        									$item_id =  $value;
                        								if($key=="quantity")
                        									$quantity =  $value;
                        							}

                        							$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
                        							$stmt = $db->prepare("SELECT * FROM `item` WHERE `item_id`='$item_id'");
                        							$stmt->execute();
                        							$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                      $item_photo = '';
                        							$item_name = '';
                        							$item_price = '';
                        							$cart_id = '';
                        							foreach ($results_arr as $i => $values) {
                        								print "";
                        								foreach ($values as $key => $value) {
                        									if($key=="item_name"){
                        										$item_name=$value;
                        									}
                        								}
                        								print '<li><span class="item" >
                                          <span class="item-left">
                                              <span class="item-info">
                                                <span  style = "padding-left: 20px"><b> '.$item_name.'<b></span><br>
                                                  <span  style = "padding-left: 20px"> Quantity: '.$quantity.'</span>
                                              </span>
                                          </span>
                                      </span></li><br>';
                        							}
                        						}

                                    print'<hr>
                                  <a  style = "margin-left: 20px" class="btn btn-success text-center" href="cart.php">Go to Cart</a>
                                </ul></li></li>';

                        					}

          ?>


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
                  <a class="dropdown-item" href="addItem.php">Add new item</a>
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
      				  <a href="signUp.html" class="btn btn-light my-2 my-sm-0"  >Sign up</a>
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
  <img src="../images/grocery(o_75)sm.png" alt="Grocery" style="width:100%;">
  <div class="centered">
    <span style="background"><h2 style="color:white;">Browse for items</h2></span>
    <form method="post" action="productpage.php">
      <div class="input-group mb-3">
        <input type="text" class="form-control" name="toSearch" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
        <div class="input-group-append">
          <button class="btn btn-light" type="submit" id="button-addon2" name="search">Search</button>
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
        <h2>Products</h2></div>
        <?php if(isset($_SESSION['search'])){
          print'<div class="row"><h5>Search Results:</h5></div>'; } ?>

<?php
//IF THERE IS A SEARCH QUERY
if(isset($_SESSION['search'])){
  $searchHolder=$_SESSION["search"];
}
else {
  $searchHolder="";
}
  $db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
  $stmt = $db->prepare("SELECT * FROM `item` WHERE `item_name`LIKE'%$searchHolder%' OR `item_desc` LIKE '%$searchHolder%' OR `item_price` LIKE '%$searchHolder%';");
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
    if ($counter%4==0){
      print '<div class="row">';
    }
    print '<div class="col-lg-3 col-md-8 mb-3">
      <div class="card h-100">
        <img class="card-img-top" width="400px" src="uploaded_assets/'.$item_photo.'" alt="" style = "max-height: 300px; width: auto;">
        <div class="card-body">
          <a style = "font-size: 22px" href = "item_details.php?id='.$item_id.'"<h4 class="card-title">'.$item_name.'</h4></a>
          <h5>'.$item_price.'</h5>
          <p class="card-text">'.$item_desc.'</p>';
  //---BUTTONS---
  //ADMIN
  if(isset($_SESSION['email'])){
    if($_SESSION['email']==$email1 || $_SESSION['email']==$email2){
            print "
			<div class = 'row'>
				<div class = 'col' >
				  <form method = 'post' action = 'editItem.php'>
				  <input type = 'text' name = 'toUpdate' value = '$item_id' hidden>
				  <input style = 'width: 100%' value = 'Update' class='btn btn-secondary btn-sm' type = 'submit'>
				  </form>
				</div>
				<div class = 'col'>
				  <form method = 'post' action = 'deleteItem.php'>
				  <input type = 'text' name = 'toDelete' value = '$item_id' hidden>
				  <button style = 'width: 100%' class='btn btn-secondary btn-sm' type = 'submit' name = 'delete'>Delete</button>
				  </form>
				</div>
			</div>";
          }
          //LOGGED IN USER
            else {
            print  "
                 <form method = 'get' action = ''>
                 <input type = 'text' name = 'toCart' value = '$item_id' hidden>
                 <input type = 'number' name = 'quantity' value = '1' style = 'width: 35px'>
                 <button class='btn btn-secondary btn-sm' type = 'submit' name = 'add2cart'>Add to Cart</button>
                 </form>
                   ";

            }
      }


print" </div></div></div>";
    $counter++;
    if ($counter%4==0){
      print '</div>';
    }
  }
  if($counter==0){
    print "<div class='row'><p>Search returned 0 results</p></div>";
  }
  unset($_SESSION['search']);
 ?>

</div>
  </div>

        </div>
        <!-- /.row -->

</div>
  <!--  main container -->

  <!--LOG IN POPUP-->
	<div class="modal fade" id="logIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<form id = "logInDetails" method = 'post' action = '../php/logIn.php'>
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
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="productpage.php">Products</a></li>
                </ul>
            </div>
            <div class="col-sm-4">
                <h5>About us</h5>
                <ul>
                    <li><a href="#">CMSC 121 GROUP</a></li>
                </ul>
            </div>
            <div class="col-sm-4">

            </div>
        </div>
    </div>
       <div class="container">
            <h5 class="logo"><a href="index.php"> <img src="../images/logowtitle.jpg" width="150px"> </a></h5>
        </div>
    <!-- /.container -->
  </footer>


  <!-- Bootstrap core JavaScript -->
  <script src="../assets/jquery/jquery.min.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>