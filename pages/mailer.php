<?php
session_start();
$email = $_SESSION['email'];
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
$mail->addAddress($email, 'You');
$mail->Subject = 'Recent Purchase';
$mail->AltBody = 'Unknown error';
$mail->Body = 'Here is a PDF of your recent purchases.';
$mail->addAttachment("doc.pdf", "Invoice");
$mail->send();
?>
