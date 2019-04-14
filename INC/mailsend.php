<?php
require_once('PHPMailer/PHPMailerAutoload.php');
class Mail{
  //This is a class for sending mail using the phpmailer
  public static function sendMail($subject, $body, $address){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '465';
    $mail->isHTML();
    $mail->Username = 'declan.teaching@gmail.com';
    $mail->Password = 'Bling2king13';
    $mail->SetFrom('');
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($address);

    $mail->Send();
  }
}

 ?>
