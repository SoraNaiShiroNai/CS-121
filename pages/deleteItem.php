<?php
	
	$item_id = $_POST['toDelete'];
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
		 
		}
	}
	
	
	if(isset($_POST['deleteItem'])){
			
			$item_name = strip_tags($_POST['item_name']);
			$item_desc = strip_tags($_POST['item_desc']);
			$item_price = strip_tags($_POST['item_price']);
			$item_photo = "";
			
			$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
			$stmt = $db->prepare("DELETE FROM `item` WHERE `item_id`='$item_id';");
			$stmt->execute();
			
			//$stmt->debugDumpParams();
			
			//INSERT A CODE TO CHECK SQL QUERY IS SUCCESSFUL
			header("Location: productpage.php");
			//echo "<script>window.location.replace('../index.php');</script>";
	}
	
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>DELETE ITEM</title>
	
	<script src="../js/jquery-3.3.1.min_2.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/util.js"></script>
	<script src="../js/formValidator.js"></script>

	
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
	<link rel="stylesheet" href="signUpStyles.css">
  </head>
  <body>

	<!--NAV Bar-->

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

	
	<div class="card bg1-light">
		<article class="card-body mx-auto" style="max-width: 400px;">
			<h4 class="card-title mt-3 text-center">Are you sure you want to delete Item: <?php echo "$item_name";?></h4>
			
			
			<form id = "newUser" method = 'post' action = ''>
				<input type = 'text' name = 'toDelete' value = '<?php echo "$item_id";?>' hidden>
		
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block" name = "deleteItem">DELETE ITEM</button>
				</div> <!-- form-group// -->            
			</form>
		</article>
	</div>
	

  </body>
 </html>