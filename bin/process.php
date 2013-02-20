<?php
$mail=$_POST['mail'];
$name=$_POST['firstName']." ".$_POST['lastName'];
$subject=$_POST['company'];
$text=$_POST['zip']." ".$_POST['phone'];
$to="pete@spirelightmedia.com";
$message=" You received  a mail from ".$mail;
$message.=" Text of the message : ".$text;
if(mail($to,$subject,$message)) {
echo "mail successful send";
} else {
echo "there’s some errors to send the mail, verify your server options";
}
?>