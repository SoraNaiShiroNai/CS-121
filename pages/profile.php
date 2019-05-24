

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>User Profile</title>
	
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
	<link rel="stylesheet" href="profileStyles.css">
	
	<script>
		$(document).ready(function(){
		  $('.js-edit, .js-save').on('click', function(){
			var $form = $(this).closest('form');
			$form.toggleClass('is-readonly is-editing');
			var isReadonly  = $form.hasClass('is-readonly');
			$form.find('input,textarea').prop('disabled', isReadonly);
		  });
		});
	</script>
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
				<a class="pt-0" href="#"><a href="../index.html"><img src="../images/logowtitle.jpg" style="width:200px; height: 50px;"></a>
			  </li>
			</ul>
			  <h3 class = "profile" style = "color: #d16b54;">User Profile</h3>
		  </div>
	</nav>
	
	<div class="container emp-profile">
            <form class="is-readonly" method="post">
				<div class = "form-group">
					<div class="row">
						<div class="col-md-4">
							<div class="profile-img">
								<img src="../images/defaultProfPic.png" class="img-circle" alt=""/>
								<div class="file btn btn-lg btn-primary">
									Change Photo
									<input type="file" name="file"/>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="profile-head">
										<h5>
											Guest User
										</h5>
										<h6>
											anonymous
										</h6>
										<p class="proile-rating">Satisfaction Rating : <span>9/10</span></p>
								<ul class="nav nav-tabs" id="myTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Purchase History</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">Pending Purchases</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-md-2">
							<button type="button" name="editBTN" class="profile-edit-btn btn btn-default btn-edit js-edit">Edit Profile</button>
							<button type="button" class="profile-edit-btn btn btn-default btn-save js-save">Save</button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="preferences">
								<p>Preferences</p>
								<a>Cooking Tools</a><br/>
								<a>Dairy Products</a><br/>
								<a>Chocolates</a>
							</div>
						</div>
						<div class="col-md-8">
							<div class="tab-content profile-tab" id="myTabContent">
								<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
											
											<div class="row">
												<div class="col-md-5 mt-1">
													<label>Name</label>
												</div>
												<div class="col-md-5">
													<input type = "text" class = "form-control is-disabled" id = "userName" placeholder = "Name" value = "Guest User" disabled>
												</div>
											</div>
											<div class="row">
												<div class="col-md-5">
													<label>Email</label>
												</div>
												<div class="col-md-5">
													<input type = "email" class = "form-control is-disabled" id = "userEmail" placeholder = "Email" value = "chickenFeet@cs121.com" disabled>
												</div>
											</div>
											<div class="row">
												<div class="col-md-5">
													<label>Phone</label>
												</div>
												<div class="col-md-5">
													<input type = "text" class = "form-control is-disabled" id = "telNo" placeholder = "Phone Number" value = "(02) 251 4005" disabled>
												</div>
											</div>
											<div class="row">
												<div class="col-md-5">
													<label>Address</label>
												</div>
												<div class="col-md-5">
													<input type = "text" class = "form-control is-disabled" id = "userName" placeholder = "Name" value = "Padre Faura, University of The Philippines Manila" disabled>
												</div>
											</div>
								</div>
								<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
											<div class="row">
												<div class="col-md-6">
													<label>Soft Boiled Eggs (x12)</label>
												</div>
												<div class="col-md-6">
													<p>PHP 240.00</p>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<label>Schezwan Chicken McNugget Sauce (x3)</label>
												</div>
												<div class="col-md-6">
													<p>PHP 2700.00</p>
												</div>
											</div>
								</div>
								<div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
								
								
								
								</div>
							</div>
						</div>
					</div>
				</div>
            </form>           
        </div>
	
	

  </body>