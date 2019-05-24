<?php
	session_start();
	if(isset($_SESSION['email'])){
		$email = $_SESSION['email'];
	}
		$cart_id = "";
		$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
		$stmt = $db->prepare('SELECT cart_id FROM cart WHERE email=?');
		$stmt->execute(array($email));
		$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($results_arr as $i => $values) {
			foreach ($values as $key => $value) {
				if($key=="cart_id")
					$cart_id = $value;
			}
		}
		
	if(isset($_POST['updateQuantity'])){
		$quantity = $_POST['quantity'];
		$item_id = $_POST['item_id'];
		$stmt = $db->prepare("UPDATE cart_detail SET `quantity` = '$quantity' WHERE `cart_id` = '$cart_id' AND `item_id` = '$item_id'");
		$stmt->execute(array($email));
		$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	}
	if(isset($_POST['deleteEntry'])){
		$item_id = $_POST['item_id'];
		$stmt = $db->prepare("DELETE FROM cart_detail WHERE `cart_id` = '$cart_id' AND `item_id` = '$item_id'");
		$stmt->execute(array($email));
		$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt -> debugDumpParams();
		
	}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Cart</title>
	
	<script src="../js/jquery-3.3.1.min_2.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/util.js"></script>

	
    <link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../styles.css">
	
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">

    <!-- Bootstrap core CSS -->


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
	
    <!-- Custom styles for this template -->
    <link href="album.css" rel="stylesheet">
	<link rel="stylesheet" href="cartStyles.css">
  </head>
  <body>

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
			<h3 class = "profile" style = "color: #d16b54;">Cart</h3>
		  </div>
	</nav>

	
	<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">Your Shopping Cart</h1>
     </div>
</section>

<div class="container mb-4">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Availability</th>
							<th scope="col">Product Price</th>
                            <th scope="col" class="text-center">Quantity</th>
							<th scope="col" class="text-right">Update</th>
                            <th scope="col" class="text-right">Price</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
							$totalPrice = 0;
							$stmt = $db->prepare('SELECT * FROM cart_detail WHERE cart_id=?');
							$stmt->execute(array($cart_id));
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
										<td><input class="form-control" type="text" name = "quantity" value="<?php echo $quantity ?>" /></td>
										<td class="text-right"><button class="btn btn-sm btn-success" type = "submit" name = "updateQuantity"><i class="fa fa-check"></i> </button> </td>
										<td class="text-right"><?php $subprice = $quantity*$item_price; $totalPrice = $totalPrice + $subprice; echo $subprice ?></td>
								</form>
								<form method = 'post'>
									<input type = "text" name = "item_id" value = "<?php echo $item_id ?>" hidden>
									<td class="text-right"><button type = 'submit' name = 'deleteEntry' class="btn btn-sm btn-danger mx-auto"><i class="fa fa-trash"></i> </button> </td>
								</form>
								</tr>
								<?php
							}
						?>
                        <tr>
                            <td></td>
                            <td></td>
							<td></td>
                            <td></td>
                            <td></td>
                            <td>Sub-Total</td>
                            <td class="text-right">PHP <?php echo $totalPrice ?>.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
							<td></td>
                            <td></td>
                            <td></td>
                            <td>Shipping</td>
                            <td class="text-right">PHP 100.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
							<td></td>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td class="text-right"><strong>PHP <?php echo ($totalPrice + 100) ?>.00</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col mb-2">
            <div class="row">
                <div class="col-sm-12  col-md-6">
                    
					<button class="btn btn-success my-2 my-sm-0 mr-1 text-uppercase mx-auto" style = "width:80%;" type="button"  data-toggle="modal" data-target = "#paypal">Check Out with  <img src="https://cdnjs.cloudflare.com/ajax/libs/minicart/3.0.1/paypal_65x18.png" width="65" height="18" alt="PayPal"></button>
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                    <button class="btn btn-success my-2 my-sm-0 mr-1 text-uppercase mx-auto" style = "width:80%;">Cash on Delivery</button>
                </div>
            </div>
        </div>
    </div>	
</div>
	<div class = "col-sm-6  mx-auto" style = "width:30%;">
		<a href = "productpage.php" class="btn btn-block btn-light">Continue Shopping</a>
	</div>
	
	<div class="modal fade" id="paypal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Check out with Paypal</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <form method = 'post' action = "export.php">
				<div class="modal-body">
				<input type = 'text' name = 'cart_id' value = "<?php echo $cart_id ?>" hidden>
				<input type = 'text' name = 'pmethod' value = "pp" hidden>
				
				  <div class="form-group">
					<label for="exampleInputEmail1">Credit Card Number</label>
					<input type="text" name = "ccn" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
					<label for="exampleInputEmail1">Name of Card Holder</label>
					<input type="text" name = "name" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
					<label for="exampleInputEmail1">Month and Year of Expiration</label>
					<input type="text" name = "exp" class="form-control" id="exampleInputEmail1">
					
					<!--small details if needed<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
				  </div>
				  <div class="form-group">
					<label for="exampleInputPassword1">CVC</label>
					<input type="password" name = "cvc" class="form-control" id="exampleInputPassword1" placeholder="Enter a 3 DIGIT number">
				  </div>
				  
				  <div class = "row">
					<div class = "col">
						  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						  <button type="submit" class="btn btn-primary">Submit</button>
					</div>
				  </div>
				  
		  
			<!------------------------>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
  </body>