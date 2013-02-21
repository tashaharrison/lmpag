<?php
$mail = $_POST['mail'];
$name = $_POST['firstName'] . " " . $_POST['lastName'];
$subject = $_POST['company'];
$text = $_POST['message'];
$to = urldecode($_POST['recipient']);
$message = " You received  a mail from " . $mail;
$message .= " Text of the message : " . urldecode($text);
if (mail($to, $subject, $message)) {
	echo "mail successful send";
} else {
	echo "there’s some errors to send the mail, verify your server options";
}
?>