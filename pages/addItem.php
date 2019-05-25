<?php

	if(isset($_POST['addItem'])){

	if($_POST['item_name']=='' || $_POST['item_desc']=='' || $_POST['item_price']=='') ;
	else{
		$target_dir = "uploaded_assets/";
		$target_file = $target_dir . basename($_FILES["uploaded_file"]["name"]);
		$item_name = strip_tags($_POST['item_name']);
	 	$item_desc = strip_tags($_POST['item_desc']);
	  $item_price = strip_tags($_POST['item_price']);
	  $stock = strip_tags($_POST['stock']);
	  $item_photo = strip_tags($_FILES['uploaded_file']['name']);
	  $db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
	  $stmt = $db->prepare("INSERT INTO `item` (`item_name`, `item_desc`, `item_price`, `item_photo`, `stock`) VALUES ('$item_name', '$item_desc', '$item_price', '$item_photo', '$stock');");
	  $stmt->execute();
		move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $target_file);




		header("Location: productpage.php");
	}
}

?>

<!doctype html>
<html lang="en">
  <head>
		<title>ADD ITEM</title>

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

		<!-premade styles-!>
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
				  <button class="btn btn-outline-success my-2 my-sm-0 mr-1" type="button"  data-toggle="modal" data-target = "#logIn">Log In</button>
			  </div>
		</nav>
		<!-end of navbar-!>


		<div class="card bg1-light">
			<article class="card-body mx-auto" style="max-width: 400px;">
				<h4 class="card-title mt-3 text-center">Add New Item</h4>
				<p class="text-center">Please fill out all the fields</p>

				<form method = 'post' action = '' enctype="multipart/form-data">

					<div class="form-group input-group" style="display: flex; justify-content: center">
						<input id="uploaded_file" style="display: none" name="uploaded_file" type="file" >
						<a href="" onclick="document.getElementById('uploaded_file').click(); return false"><i class="fa fa-image" style="align:center; font-size: 10em" ></i></a>
					</div>
					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> Item Name </span>
						 </div>
						<input name="item_name" class="form-control" type="text" required>
					</div>
					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> Description </span>
						 </div>
						<input name="item_desc" class="form-control" type="text" required>
					</div>
					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> Price </span>
						 </div>
						<input name="item_price" class="form-control" type="number" placeholder = "Philippine Peso" required>
					</div>
					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text"> Stock </span>
						 </div>
						<select name="item_stock" class="form-control" type="number" required>
								<option value = 'available'>Available</option>
								<option value = 'out-of-stock'>Out-of-Stock</option>
								<option value = 'limited'>Limited</option>
							
							</select>
					</div>


					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block" name = "addItem">ADD ITEM</button>
					</div> <!-- form-group// -->
				</form>
			</article>
		</div>

  </body>
 </html>
