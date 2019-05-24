<?php
session_start();
$password1 = 'haramitsurenge';
$email1 = 'sora@disboard.com';
$password2 = 'kuroyukihime';
$email2 = 'shiro@disboard.com';
$firstname = '';
$email = '';
$checker = '';
$searchHolder = '';



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

	

	//$stmt->debugDumpParams();




}

?>

<!doctype html>
<html lang="en">
  <head>


	<title>Products</title>
    <!-- Required meta tags -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="product.css" >
    <script src="../js/jquery-3.3.1.min_2.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js" type="text/javascript"></script>


    <!-- font-->
  </head>

  <body>

  <!-- Navbar -->
  <nav class="navbar">
  <a href="../index.php"><img src="../images/logowtitle.jpg" style="width:200px; height: 50px;"></a>
  <?php if(isset($_SESSION['email'])){
					echo "<h3>Logged in as ".$_SESSION['email']."</h3>";
  }?>

  <div class="dropdown">
  <?php if(isset($_SESSION['email'])){
			if($_SESSION['email']==$email1 || $_SESSION['email']==$email2){
			echo '<a href = "addItem.php"><button class="btn btn-outline-success my-2 my-sm-0 mr-1 profilebtn">Add Item</button></a>';
			}
		}
	?>
  </div>
  <div class="dropdown">
    <a href="profile.html"><button type="button" class="btn btn-outline-success my-2 my-sm-0 mr-1 profilebtn">Go to Profile</button></a>


</div>
  </nav>

<div class="container-fluid no-gutters" style="padding-right:0px; ">
  <div class="row">
    <div class="card col-sm ctg">
      <div class="body " >
        <div class="input-group input-group-sm mb-3">
			<form method = 'get' action = ''>


					<input name = "searchWord" type="text" class="form-control"><br>
					<button type="submit" class="btn btn-secondary btn-sm" name = "searchQuery1">SEARCH</button>


			</form>
			<form method = 'get' action = ''>


					<button type="submit" class="btn btn-secondary btn-sm" name = "searchQuery2">Reset Search</button>


			</form>
        </div>
        <p1><b>PRODUCTS:</b></p1><br><div class="card activeprod">
        <a href="#">Beverages</a><br></div><div class="card">
        <a href="#">Bread</a><br></div><div class="card">
        <a href="#">Canned Goods</a><br></div><div class="card ">
        <a href="#">Dairy</a><br></div><div class="card ">
        <a href="#">Dry Goods</a><br></div><div class="card ">
        <a href="#">Frozen Goods</a><br></div><div class="card ">
        <a href="#">Non-Food Items</a><br></div><div class="card ">
        <a href="#">Produce</a><br></div><div class="card">
        <a href="#">Snacks</a><br></div><div class="card">
        <a href="#">Others</a><br></div>
        </div>
      </div>

      <div class="card col-8">
        <div class="body" id="products">


		<?php
			if(isset($_GET['searchQuery1'])){
				$_SESSION['search'] = $_GET["searchWord"];
				$searchHolder = $_SESSION['search'];

				$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
				$stmt = $db->prepare("SELECT * FROM `item` WHERE `item_name`LIKE'%$searchHolder%' OR `item_desc` LIKE '%$searchHolder%' OR `item_price` LIKE '%$searchHolder%';");
				$stmt->execute();
				$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

				//$stmt->debugDumpParams();
				//print_r($results_arr);

				foreach ($results_arr as $i => $values) {
					print "<tr><td>";
					foreach ($values as $key => $value) {
					  if($key=="item_id"){
						if($_SESSION['email']==$email1 || $_SESSION['email']==$email2){
							print "
								<form></form>


							  <form method = 'post' action = 'editItem.php'>

								<input type = 'text' name = 'toUpdate' value = '$value' hidden>
								<input value = 'Update' class='btn btn-secondary btn-sm' type = 'submit'>
							  </form>

							  <form method = 'post' action = 'deleteItem.php'>
								<input type = 'text' name = 'toDelete' value = '$value' hidden>
								<button class='btn btn-secondary btn-sm' type = 'submit' name = 'delete'>Delete</button>
							  </form>

							  <form method = 'post' action = 'item_details.php'>
								<input type = 'text' name = 'toView' value = '$value' hidden>
								<button class='btn btn-secondary btn-sm' type = 'submit' name = 'expandDetails'>More Details</button>
							  </form>


								  <br>";
						}
						else print "
								<form></form>

							 <form method = 'post' action = 'item_details.php'>
								<input type = 'text' name = 'toView' value = '$value' hidden>
								<button class='btn btn-secondary btn-sm' type = 'submit' name = 'expandDetails'>More Details</button>
							  </form>

							  <form method = 'get' action = ''>
								<input type = 'text' name = 'toCart' value = '$value' hidden>
								<input type = 'number' name = 'quantity' value = '1' style = 'width: 35px'>
								<button class='btn btn-secondary btn-sm' type = 'submit' name = 'add2cart'>Add to Cart</button>
							  </form>
								  ";
					  }
						if ($key=="item_photo")
						print "<img src='uploaded_assets/$value'><br>";
					  if($key=="item_name")
					  print " <b>Name: </b> $value <br>";
						if($key=="stock")
					  print " <b>Stock: </b> $value <br>";
					  if($key=="item_price")
					  print " <b>Price: </b> $value <br>";


					}
					print "</td></tr>";
				}

}



		?>





			  <hr>
			  <!------>


                <?php if(!isset($_SESSION['search'])){
					$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
					$stmt = $db->prepare("SELECT * FROM `item`;");
					$stmt->execute();

					$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

					foreach ($results_arr as $i => $values) {
						print "<tr><td>";
						foreach ($values as $key => $value) {
						  if($key=="item_id"){
							if(isset($_SESSION['email'])){
								if($_SESSION['email']==$email1 || $_SESSION['email']==$email2){
									print "
										<form></form>


									  <form method = 'post' action = 'editItem.php'>

										<input type = 'text' name = 'toUpdate' value = '$value' hidden>
										<input value = 'Update' class='btn btn-secondary btn-sm' type = 'submit'>
									  </form>
									  <form method = 'post' action = 'deleteItem.php'>
										<input type = 'text' name = 'toDelete' value = '$value' hidden>
										<button class='btn btn-secondary btn-sm' type = 'submit' name = 'delete'>Delete</button>
									  </form>

									  <form method = 'post' action = 'item_details.php'>
										<input type = 'text' name = 'toView' value = '$value' hidden>
										<button class='btn btn-secondary btn-sm' type = 'submit' name = 'expandDetails'>More Details</button>
									  </form>

									  <br>";
								}
								else print "
										<form></form>

									 <form method = 'post' action = 'item_details.php'>
										<input type = 'text' name = 'toView' value = '$value' hidden>
										<button class='btn btn-secondary btn-sm' type = 'submit' name = 'expandDetails'>More Details</button>
									  </form>

									  <form method = 'get' action = ''>
										<input type = 'text' name = 'toCart' value = '$value' hidden>
										<input type = 'number' name = 'quantity' value = '1' style = 'width: 35px'>
										<button class='btn btn-secondary btn-sm' type = 'submit' name = 'add2cart'>Add to Cart</button>
									  </form>

									  ";
							}
						  }
							if ($key=="item_photo")
							print "<img src='uploaded_assets/$value'><br>";
						  if($key=="item_name")
						  print " <b>Name: </b> $value <br>";
						  if($key=="item_price")
						  print " <b>Price: </b> $value <br>";
						  if($key=="stock")
						  print " <b>Stock: </b> $value <br>";

						}
						print "</td></tr>";
					}



				}
				?>
				</div>
          </div>
          <div class="card col-sm">
            <div class="body" id="cartside">
                  <p class="title"> CART </p>


				  <?php if(isset($_SESSION['email'])){


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



							$item_name = '';
							$item_price = '';
							$cart_id = '';


							foreach ($results_arr as $i => $values) {
								print "<tr><td>";
								foreach ($values as $key => $value) {
									if($key=="item_name"){
										print " <b>Name: </b> $value <br>";
										print " <b>Quantity: </b> $quantity <br>";
									}



								}
								print "</td></tr>";
							}
						}



					}

					?>


				  <form class="form-inline my-2 my-lg-0" action = "cart.php">
					  <button class="btn btn-outline-success my-2 my-sm-0 mr-1" type="submit" data-toggle="modal" data-target = "#logIn">Go to Cart</button>
				   </form>

                </div>
        </div>
    </div>

    <!-- Product Modal -->
<div class="modal fade" id="productmod" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="producttitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" class="card-img-top" alt="..." style="width: 300px" id="productimg">
        <p id="productdesc"></p>
          <p id="productprice"></p>
      </div>
    </div>
  </div></div>

<!-- Add Listing Modal -->
<div class="modal fade" id="listingmod" role="dialog" >
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Add item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Input item details:</p>
		<!--ADD NEW ITEM FORM-->
		<form method = 'post' action = 'addItem.php'>
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon2">Name:</span>
			  </div>
			  <input type="text" name = "item_name" class="form-control" placeholder="Product Name">
			</div>
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
				<span class="input-group-text" id="basic-addon2">Description:</span>
			  </div>
			  <input type="text" name = "item_desc" class="form-control" placeholder="Product Description">
			</div>
			<div class="input-group mb-3">
			  <div class="custom-file">
				<input type="file" class="custom-file-input" id="inputGroupFile02" >
				<label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose Product Picture</label>
			  </div>
			  <div class="input-group-append">
				<span class="input-group-text" id="inputGroupFileAddon02">Upload</span>
			  </div>
			</div>
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
				<span class="input-group-text">Price:</span>
			  </div>
			  <input type="number" name = "item_price" class="form-control" aria-label="Amount in Peso">
			  <div class="input-group-append">
				<span class="input-group-text">PHP</span>
			  </div>
			</div>
			<input type="button" class="btn btn-secondary submitadd" name = "addNewItem" value = "Submit">
			<text id = "addStatus"></text>
		</form>
      </div>
	</div>
</div>
</div>

      <!-- Add Listing Modal -->
      <div class="modal fade" id="editmod" role="dialog" >
        <div class="modal-dialog" >
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" >Edit item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Input item details:</p>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon2">Name:</span>
                </div>
                <input type="text" class="form-control" placeholder="Product Name" aria-label="Recipient's username" aria-describedby="basic-addon2">
              </div>
              <div class="input-group mb-3">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="inputGroupFile02" >
                  <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose Product Picture</label>
                </div>
                <div class="input-group-append">
                  <span class="input-group-text" id="inputGroupFileAddon02">Upload</span>
                </div>
              </div>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Product Description:</span>
                </div>
                <textarea class="form-control" ></textarea>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">Price:</span>
                </div>
                <input type="number" class="form-control" aria-label="Amount in Peso">
                <div class="input-group-append">
                  <span class="input-group-text">PHP</span>
                </div>
              </div>
              <button type="button" class="btn btn-secondary submitedit">Submit</button>
            </div></div></div></div>


    </div>
  </div>
</div>

</body>

</html>
