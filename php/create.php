<?php
	$firstname = strip_tags($_POST['firstname']);
	$surname = strip_tags($_POST['surname']);
	$default_address = strip_tags($_POST['default_address']);
	$email = strip_tags($_POST['email']);
	$phone_number = strip_tags($_POST['phone_number']);
	$password1 = md5(strip_tags($_POST['password1']));

	$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
	$stmt = $db->prepare("INSERT INTO `user` (`firstname`, `surname`, `default_address`, `email`, `phone_number`, `password`) VALUES ('$firstname', '$surname', '$default_address', '$email', '$phone_number', '$password1');");
	$stmt->execute();

	$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
	$stmt = $db->prepare("INSERT INTO `cart` (`email`) VALUES ('$email');");
	$stmt->execute();
	require ('../vendor/autoload.php');
	$mail = new PHPMailer\PHPMailer\PHPMailer();
	$mail->isSMTP();
	$mail->SMTPDebug = 2;
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPOptions = array(
	                    'ssl' => array(
	                        'verify_peer' => false,
	                        'verify_peer_name' => false,
	                        'allow_self_signed' => true
	                    )
	                );
	$mail->SMTPAuth = true;
	$mail->Username = '121chicken121@gmail.com';
	$mail->Password = 'cmsc-121';
	$mail->setFrom('121chicken121@gmail.com', 'Truthful Chicken');
	$mail->addAddress($email, 'Dear Customer');
	$mail->Subject = 'Welcome!';
	$mail->Body = 'This is to confirm that we have saved your email address. We hope you find our store useful.';
	$mail->send();
	header("Location: redirect.html");
?>
