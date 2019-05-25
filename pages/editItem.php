<?php
	$item_id = $_POST['toUpdate'];
	$item_name = "";
	$item_desc = "";
	$item_price = "";
	//echo "<h2>iD: $item_id</h2>";
	$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
	$stmt = $db->prepare("SELECT * FROM `item` WHERE `item_id`='$item_id'");
	$stmt->execute();
	$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//print_r($results_arr);

	foreach ($results_arr as $i => $values) {
		foreach ($values as $key => $value) {

			if($key=="item_name")
				$item_name =  $value;
			if($key=="item_desc")
				$item_desc =  $value;
			if($key=="item_price")
				$item_price =  $value;
			if($key=="item_photo")
				$item_photo = $value;
			if($key=="stock")
				$item_stock = $value;
		}
	}


	if(isset($_POST['editItem'])){

		if($_POST['item_name']=='' || $_POST['item_desc']=='' || $_POST['item_price']=='') echo "Please fill out all fields";
		else{
			$target_dir = "uploaded_assets/";
			$target_file = $target_dir . basename($_FILES["uploaded_file"]["name"]);
			$item_name = strip_tags($_POST['item_name']);
			$item_desc = strip_tags($_POST['item_desc']);
			$item_price = strip_tags($_POST['item_price']);
			$item_photo = strip_tags($_FILES['uploaded_file']['name']);
			$item_stock = strip_tags($_POST['item_stock']);
			$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
			if ($item_photo == "") {
				$stmt = $db->prepare("UPDATE `item` SET `item_name`='$item_name', `item_desc`='$item_desc', `item_price`='$item_price', `stock`='$item_stock' WHERE `item_id`='$item_id';");
			}
			else {
				$stmt = $db->prepare("UPDATE `item` SET `item_name`='$item_name', `item_desc`='$item_desc', `item_price`='$item_price', `item_photo`='$item_photo', `stock`='$item_stock'  WHERE `item_id`='$item_id';");
				move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $target_file);
			}
			$stmt->execute();
			//$stmt->debugDumpParams();
			//INSERT A CODE TO CHECK SQL QUERY IS SUCCESSFUL
			header("Location: redirect.html");
		}
	}
?>

<!doctype html>
<html lang="en">
  <head>
		<title>EDIT ITEM</title>

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
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
		<link href="album.css" rel="stylesheet">
		<link rel="stylesheet" href="signUpStyles.css">

		<!-premade styles -!>
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

			.image_formatting:hover {
				transform: scale(1.02);
			}
    </style>
  </head>


  <body>

	<!-navbar-!>
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
			<h4 class="card-title mt-3 text-center">Edit Item</h4>
			<p class="text-center">Please fill out all the fields</p>

			<form id = "newUser" method = 'post' action = '' enctype="multipart/form-data">

				
				<!--<-->

				<div class="form-group input-group">
					<div class="input-group-prepend">
					 </div>
					
					<img class="image_formatting" src='<?php if($item_photo!=""){ echo "uploaded_assets/".$item_photo; }else{ echo "../images/image.png"; }?>' onclick="document.getElementById('uploaded_file').click(); return false">
					<input id="uploaded_file" name="uploaded_file" type="file" >
				</div>


				<input type = 'text' name = 'toUpdate' value = '<?php echo "$item_id";?>' hidden>
				<div class="form-group input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"> Item Name </span>
					 </div>
					<input name="item_name" class="form-control" type="text" required value = '<?php echo "$item_name";?>'>
				</div>
				<div class="form-group input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"> Description </span>
					 </div>
					<input name="item_desc" class="form-control" type="text" required value = '<?php echo "$item_desc";?>'>
				</div>
				<div class="form-group input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"> Stock </span>
					 </div>
					<select name="item_stock" class="form-control" type="number" required value = '<?php echo "$item_stock";?>'>
						<option value = 'available' <?php if("$item_stock"=='available') echo "selected" ?>>Available</option>
						<option value = 'out-of-stock' <?php if("$item_stock"=='out-of-stock') echo "selected" ?>>Out-of-Stock</option>
						<option value = 'limited' <?php if("$item_stock"=='limited') echo "selected" ?>>Limited</option>
					</select>
				</div>
				<div class="form-group input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"> Price </span>
					 </div>
					<input name="item_price" class="form-control" type="number" required value = '<?php echo "$item_price";?>'>
				</div>
				


				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block" name = "editItem">UPDATE ITEM</button>
				</div> <!-- form-group// -->
			</form>
		</article>
	</div>


  </body>
 </html>
