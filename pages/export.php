<?php

ob_start();
require('../fpdf.php');

class PDF extends FPDF
{
	
//Header
function Header()
{
    // Select Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Framed title
    $this->Cell(30,10,'Thank you for purchasing at Truthful Chicken',0,0,'C');
    // Line break
    $this->Ln(20);
}
// Load data


// Colored table
function FancyTable()
{
    // Colors, line width and bold font
    $this->SetFillColor(67, 52, 71);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(40, 35, 40, 45);
    $this->Cell(40,7,'Item Name',1,0,'C',true);
	$this->Cell(35,7,'Item Price',1,0,'C',true);
	$this->Cell(40,7,'Quantity',1,0,'C',true);
	$this->Cell(45,7,'Subtotal',1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
	
		session_start();

		
		$email = $_SESSION['email'];
		$cart_id = $_POST['cart_id'];
	
		$db = new PDO('mysql:host=localhost;dbname=cs 121 grocery shop','root','');
		$stmt = $db->prepare('SELECT * FROM cart_detail WHERE cart_id=?');
		$stmt->execute(array($cart_id));
		$results_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
			$totalprice = 0;				
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
					}
						
					$this->Cell($w[0],6,$item_name,'LR',0,'L',$fill);
					$this->Cell($w[1],6,$item_price,'LR',0,'L',$fill);
					$this->Cell($w[2],6,$quantity,'LR',0,'R',$fill);
					$this->Cell($w[3],6,'PHP '.($quantity*$item_price).'.00','LR',0,'R',$fill);
					$this->Ln();
					$fill = !$fill;
					$totalprice = $totalprice + ($quantity*$item_price);
					
				}
				
			
	
			// Closing line
				
			
			}
			
				$this->Cell(40,6,'','LR',0,'R',false);
				$this->Cell(35,6,'','LR',0,'R',false);
				$this->Cell(40,6,'Subtotal: ','LR',0,'R',false);
				$this->Cell(45,6,'PHP '.$totalprice.'.00','LR',0,'R',false);
				$this->Ln();
				$this->Cell(40,6,'','LR',0,'R',false);
				$this->Cell(35,6,'','LR',0,'R',false);
				$this->Cell(40,6,'Shipping Fee: ','LR',0,'R',false);
				$this->Cell(45,6,'PHP 100.00','LR',0,'R',false);
				$this->Ln();
				$this->Cell(40,6,'','LR',0,'R',false);
				$this->Cell(35,6,'','LR',0,'R',false);
				$this->Cell(40,6,'Total: ','LR',0,'R',false);
				$this->Cell(45,6,'PHP '.($totalprice+100).'.00','LR',0,'R',false);
				$this->Ln();
			$this->Cell(array_sum($w),0,'','T');
}
function paymentDetails()
{
	$pmethod = strip_tags($_POST['pmethod']);
	$default_address = strip_tags($_POST['default_address']);
	
		
	if($pmethod == "Credit Card: Paypal"){
		$ccn = strip_tags($_POST['ccn']);
		$name = strip_tags($_POST['name']);
		$exp = strip_tags($_POST['exp']);
		$cvc = strip_tags($_POST['cvc']);
		$this->Ln(10);

		$this->Cell(40,7,'Payment Method: ',0,0,'L',false);
		$this->Cell(45,7,'Paypal',0,0,'L',false);
		$this->Ln();
		$this->Cell(40,7,'CC Number: ',0,0,'L',false);
		$this->Cell(35,7,$ccn,0,0,'L',false);
		$this->Ln();
		$this->Cell(40,7,'Card Holder: ',0,0,'L',false);
		$this->Cell(45,7,$name,0,0,'L',false);
		$this->Ln();
		$this->Cell(40,7,'EXP Date: ',0,0,'L',false);
		$this->Cell(45,7,$exp,0,0,'L',false);
		$this->Ln();
		
	}
	else{
		$this->Ln(10);
		$this->Cell(40,7,'Payment Method: ',0,0,'L',false);
		$this->Cell(45,7,'Cash on Delivery',0,0,'L',false);
		$this->Ln();
	}
	$this->Cell(40,7,'Delivery Address: ',0,0,'L',false);
	$this->Cell(45,7,$default_address,0,0,'L',false);
	$this->Ln();
	if($pmethod == "Cash on Delivery"){
		$comment = strip_tags($_POST['comment']);
		$this->Cell(40,7,'Comment: ',0,0,'L',false);
		$this->Cell(45,7,$comment,0,0,'L',false);
		$this->Ln();
	}
}

}



$pdf = new PDF();
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->FancyTable();
$pdf->paymentDetails();
$pdf->Output('F','doc.pdf');//
ob_end_flush();
header('Location: mailer.php');
?>