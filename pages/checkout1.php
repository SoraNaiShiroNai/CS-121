<?php
	session_start();
	$email = $_SESSION['email'];
	$cart_id = $_POST['cart_id'];
	$pmethod = strip_tags($_POST['pmethod']);
	$default_address = "";
	
	$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
	$stmt = $db->prepare("SELECT * FROM user WHERE email='$email'");
	$stmt->execute();
	//$stmt->debugDumpParams();
	$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($results_arr as $i => $values) {
			foreach ($values as $key => $value) {
				if($key=="default_address")
					$default_address = $value;
			}
		}


?>

<!doctype html>
<html lang="en">
  <head>
		<title>Checkout</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">

		<script src="../js/jquery-3.3.1.min_2.js"></script>
		<script src="../js/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/util.js"></script>
		<script src="../js/formValidator.js"></script>

    <link rel="stylesheet" href="../css/bootstrap.css">
		<link rel="stylesheet" href="../styles.css">
		<link href="album.css" rel="stylesheet">
		<link rel="stylesheet" href="signUpStyles.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">


  </head>

  <body>

		<!-navbar!->
		<nav class="navbar navbar-expand-lg navbar-light " style="background-color:#433447;">
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			  </button>

			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto logoInfo">
				  <li>
				  </li>
				  <li class="nav-item active">
					<a class="pt-0" href="#"><a href="../index.php"><img src="../images/logowtitle.jpg" style="width:200px; height: 50px;"></a>
				  </li>
				</ul>
			  </div>
		</nav>
		<!-end of navbar-!>


		<div class="card bg1-light">
			<article class="card-body mx-auto" style="max-width: 1200px;">
			<h4 class="card-title mt-3 text-center">Order Details</h4><br>
			
			<table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Availability</th>
							<th scope="col">Product Price</th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
			<?php
				$stmt = $db->prepare("SELECT * FROM cart_detail WHERE cart_id='$cart_id'");
				$stmt->execute();
				//$stmt->debugDumpParams();
				$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
							foreach ($results_arr as $i => $values) {
								foreach ($values as $key => $value) {
									if($key=="item_id")
										$item_id = $value;
									if($key=="quantity")
										$quantity = $value;
								}
								
								//inner SQL
								$sql = $db->prepare('SELECT * FROM item WHERE item_id=?');
								$sql->execute(array($item_id));
								$results_arr = $sql->fetchAll(PDO::FETCH_ASSOC);
								
								foreach ($results_arr as $i => $values) {
									foreach ($values as $key => $value) {
										if($key=="item_name")
											$item_name = $value;
										if($key=="item_price")
											$item_price = $value;
										if($key=="stock")
											$stock = $value;
									}
								}
								//end of inner SQL
								?>
								<tr>
								<form method = "post">
										<input type = "text" name = "item_id" value = "<?php echo $item_id ?>" hidden>
										<td><?php echo $item_name ?></td>
										<td><?php echo $stock ?></td>
										<td><?php echo $item_price ?></td>
										<td ><text class="" type="text" name = "quantity" style = "text-align: center"><?php echo $quantity ?></text></td>
								</form>
								</tr>
								<?php
							}
					
			?>
			</tbody>
			</table>
			
				<br>
				<h4 class="card-title mt-3 text-center">Payment Details</h4>
				<p class="text-center">Method: <?php echo $pmethod ?></p>
	

				<?php
				if($pmethod == "Credit Card: Paypal"){
					$ccn = strip_tags($_POST['ccn']);
					$name = strip_tags($_POST['name']);
					$exp = strip_tags($_POST['exp']);
					$cvc = strip_tags($_POST['cvc']); ?>
					<form method = 'post' action = '' enctype="multipart/form-data">
						
						
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> Credit Card Number </span>
							 </div>
							<input name="ccn" class="form-control" type="text" value = "<?php echo $ccn ?>" required>
						</div>
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> Name of Card Holder </span>
							 </div>
							<input name="name" class="form-control" type="text" value = "<?php echo $name ?>" required>
						</div>
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> Month and Year of Expiration </span>
							 </div>
							<input name="exp" class="form-control" type="text" value = "<?php echo $exp ?>" placeholder = "MM/YY" required>
						</div>
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> CVC </span>
							 </div>
							<input name="cvc" class="form-control" type="password" placeholder = "" value = "<?php echo $cvc ?>" required>
						</div>
						
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> Delivery Address </span>
							 </div>
							<input name="default_address" class="form-control" type="text" placeholder = "" value = "<?php echo $default_address ?>" required>
						</div>


						<div class="form-group">
							<div class = "row">
								
								<div class = "col">
									<a href = "cart.php" class="btn btn-secondary btn-block" name = "back">Back</a>
								</div>
								<div class = "col">
									<button type="submit" class="btn btn-danger btn-block" name = "addItem">Confirm</button>
								</div>
							</div>
						</div> <!-- form-group// -->
					</form>
				<?php }else{ ?>
					<form method = 'post' action = '' enctype="multipart/form-data">
						
						<div class="form-group input-group" style="display: flex; justify-content: center">
							<img src="" >
						</div>
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> Delivery Address </span>
							 </div>
							<input name="default_address" class="form-control" type="text" value = "<?php echo $default_address ?>" required>
						</div>
						<div class="form-group input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"> Comment </span>
							 </div>
							<input name="name" class="form-control" type="text" placeholder = "Optional" value = "" required>
						</div>
					


						<div class="form-group">
							<div class = "row">
								
								<div class = "col">
									<a href = "cart.php" class="btn btn-secondary btn-block" name = "back">Back</a>
								</div>
								<div class = "col">
									<button type="submit" class="btn btn-danger btn-block" name = "addItem">Confirm</button>
								</div>
							</div>
						</div> <!-- form-group// -->
					</form>


				<?php } ?>
			</article>
		</div>

  </body>
 </html>
