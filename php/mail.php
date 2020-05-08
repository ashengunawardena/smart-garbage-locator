<?php
    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';

	function sendMail($receiverAddress, $subject, $body){
    	$mail = new PHPMailer;   
    	try {
    		$mail->isSMTP();     
        	$mail->Host = 'smtp.gmail.com'; 
        	$mail->SMTPDebug = 3;
        	$mail->SMTPAuth = true;   
        	$mail->SMTPOptions = array(
    			'ssl' => array(
       			'verify_peer' => false,
       			'verify_peer_name' => false,
       			'allow_self_signed' => true
    			)
			);
        	$mail->Username = 'smartgarbagelocator2@gmail.com'; 
        	$mail->Password = 'nsbmje1111';     
        	$mail->SMTPSecure = 'tls';      
        	$mail->Port = 587;        
        	$mail->setFrom('no-reply@smartgarbagelocator.com', 'Smart Garbage Locator'); 

        	$mail->isHTML(true);  
        	$mail->AddAddress($receiverAddress);
        	$mail->Subject = $subject;
        	$mail->Body    = $body;

        	$mail->send();

        } catch (Exception $e) {
          	echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        } 
    }
?>