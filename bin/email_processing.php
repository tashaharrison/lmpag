<?php 

require_once 'swiftmailer/lib/swift_required.php';

		if (isset($_POST['nojs'])) {
			$messageHTML = "Text of the message : " . urldecode($message)
					. " <h3>Your Quote Summary</h3><table><thead><tr><th>Item</th><th>Description</th><th>Price</th></tr></thead><tbody><tr><td>" . $machinemodel . "</td><td></td><td></td></tr><tr><th>Item</th><th>Description</th><th>Price</th></tr></thead><tbody><tr><td>" . $weighhopper . "</td><td></td><td></td></tr><tr><th>Item</th><th>Description</th><th>Price</th></tr></thead><tbody><tr><td>" . $dischargefunnel . "</td><td></td><td></td></tr></tbody></table>";
			$messageText = "Text of the message : " . urldecode($message)
					. "Your Quote Summary \r " . $machinemodel . " \n " . $weighhopper . " \n " . $dischargefunnel;
		} else {
			$to = $_POST['to'];
			$cc = $_POST['cc'];
			$message =  $_POST['message'];
			$quoteHTML = $_POST['quoteHTML'];
			$quoteText = $_POST['quoteText'];
			$messageHTML = urldecode($quoteHTML) . " \r " . urldecode($message);
			$messageText = urldecode($quoteText) . " \r " . urldecode($message);
		}

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
		
		// Create a message
		$emailMessage = Swift_Message::newInstance(
				'Logical Machines Quote Generator')
				->setBody($messageHTML, 'text/html')
				->addPart($messageText, 'text/plain')
				->setFrom(
						array('pete@spirelightmedia.com' => 'Logical Machines'))
				->setSender('pgjainsworth@gmail.com')
				->setReturnPath('pgjainsworth@gmail.com')
				->setBcc(array('pgjainsworth@gmail.com'))->setMaxLineLength(78)
				->setTo(array($to));
		if (!empty($cc)) {
			$emailMessage->setCc(array($cc));
		}

		if ($mailer->send($emailMessage)) {
			$response = "<div class=\"success\"><p>Thank you. Your email has been successfully sent.</p></div>";
		} else {
			$errors['mailfail'] = true;
		}

?>