<?php

require_once 'swiftmailer/lib/swift_required.php';

// Create the Transport
/*
 $transport = Swift_SmtpTransport::newInstance('smtp.example.org', 25)
 ->setUsername('your username')
 ->setPassword('your password')
 ;
 */
$transport = Swift_MailTransport::newInstance();

// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);
$text = $_POST['message'];
$to = urldecode($_POST['recipient']);
$messageHTML = "Text of the message : " . urldecode($text);

// Create a message
$emailMessage = Swift_Message::newInstance('Logical Machines Quote Generator') -> setBody($messageHTML, 'text/html') -> setFrom(array('pete@spirelightmedia.com' => 'Logical Machines')) -> setSender('pgjainsworth@gmail.com') -> setReturnPath('pgjainsworth@gmail.com') -> setBcc(array('pgjainsworth@gmail.com')) -> setMaxLineLength(78) -> setTo(array($to));

session_start();
if ($mailer -> send($emailMessage)) {
    $_SESSION['response'] = "<div class=\"success\"><p>Thank you. Your email has been successfully sent.</p></div>";
} else {
    $_SESSION['response'] = "<div class=\"warning\"><p>I'm sorry we were unable to send your quote by email. Please check the email addresses that you entered and try again.</p></div>";
}
header('Location: ../index.php');
?>