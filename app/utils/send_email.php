<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

return function(array $toEmail,string $subject, string $message,$isHtml=false){
    $mail = new PHPMailer(true);
    $mail->isSMTP();                                           
    $mail->Host= 'smtp.gmail.com';                     
    $mail->SMTPAuth= true;                                   
    $mail->Username= 'rwaidluqa@gmail.com';               
    $mail->Password= 'yourpassword';                     
    $mail->SMTPSecure= 'tls';                                  
    $mail->Port= 587;                                    
    
    $mail->setFrom('rwaidluqa@gmail.com', 'Rwaid Kalka');
    foreach ($toEmail as $address) {
        $mail->addAddress($address);
    }

    $mail->isHTML($isHtml);
    $mail->Subject = $subject;
    $mail->Body= $message;
    
    try {
        $mail->send();
        echo 'Email sent successfully';
    } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    }    
}

?>