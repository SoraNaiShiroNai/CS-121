<?php
	$firstname = strip_tags($_POST['firstname']);
	$surname = strip_tags($_POST['surname']);
	$default_address = strip_tags($_POST['default_address']);
	$email = strip_tags($_POST['email']);
	$phone_number = strip_tags($_POST['phone_number']);
	$password1 = strip_tags($_POST['password1']);
	
	$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
	$stmt = $db->prepare("INSERT INTO `user` (`firstname`, `surname`, `default_address`, `email`, `phone_number`, `password`) VALUES ('$firstname', '$surname', '$default_address', '$email', '$phone_number', '$password1');");
	$stmt->execute();
	
	$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
	$stmt = $db->prepare("INSERT INTO `cart` (`email`) VALUES ('$email');");
	$stmt->execute();
	//$stmt->debugDumpParams();
	
	//INSERT A CODE TO CHECK SQL QUERY IS SUCCESSFUL
	header("Location: redirect.html");
?>