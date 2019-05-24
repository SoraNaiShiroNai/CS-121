<?php
	session_start();
	$password1 = '47130110150220053410';
	$email1 = 'sora@disboard.com';
	$password2 = 'kuroyukihime';
	$email2 = 'shiro@disboard.com';
	
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);
	$firstname = '';
	
	
		
		$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
		$stmt = $db->prepare('SELECT firstname, surname FROM user WHERE email=? AND password=?');
		$stmt->execute(array($email, $password));
		$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$_SESSION['checker'] = $results_arr;
		
		
		foreach ($results_arr as $i => $values) {
			foreach ($values as $key => $value) {
				if($key=="firstname")
					$firstname = $value;
			}
		}
		
		//ADMIN CREDENTIALS HERE
		if(($_POST['email']==$email1 && $_POST['password']==$password1) || ($_POST['email']==$email2 && $_POST['password']==$password2)){
			echo "<h2>Admin User is logged in</h2>";
			$_SESSION['email'] = $_POST['email']; 
			$_SESSION['firstname'] = "Admin"; 
		}//USER CREDENTIALS HERE
		else if(!empty($results_arr)){
			//echo "<h2>User is logged in</h2>";
			$_SESSION['email'] = $_POST['email']; 
			$_SESSION['firstname'] = $firstname; 
		}
		else echo "Invalid email or password.";
		
		
		//$stmt->debugDumpParams();
		//echo "<br><br> Result Array: ";
		//print_r($results_arr);
	
	
	//INSERT A CODE TO REDIRECT TO HOMEPAGE HERE
	//header("Location: redirect.html");
?>

<!DOCTYPE html>
<html>
	<body>
		<script>
			window.location.replace("../index.php");
		</script>
	</body>

</html>