<?php

require_once 'swiftmailer/lib/swift_required.php';

if (isset($_POST['nojs'])) {
	$availableSpouts = array(0.5, 0.75, 1, 1.25, 1.5, 1.75, 2, 2.25, 2.5, 2.75, 3, 3.25, 3.5);
	function nearestSpout($availableSpouts, $containerDiameter) {
		$closest = null;
		$calculatedSpoutSize = $containerDiameter * 0.72;
		foreach($availableSpouts as &$value) {
			if ($closest == null || $value - $calculatedSpoutSize < $closest - $calculatedSpoutSize) {
				$closest = $value;
			}
		};
		return $closest;
	}
	$weightHopperSize = explode("-", $weighhopper);
	$dischargeFunnelType = explode("-", $dischargefunnel);
	if (!empty($message)) {
		$message = urldecode($message) . "\n\r";
	} else {
		$message = "";
	}
	if (!empty($typeSpout1Default)) {
		switch ($typeSpout1Default) {
			case 'flat-bag':
				$containerDiameter = $widthInchesSpout1Default * 2 / M_PI;
				$spoutSize = nearestSpout($availableSpouts, $containerDiameter);
				break;
			case 'four-sided-bag':
				$containerDiameter = ($d1InchesSpout1Default + $d2InchesSpout1Default) * 2 / M_PI;
				$spoutSize = nearestSpout($containerDiameter);
				break;
			case 'can-jar':
				foreach($availableSpouts as &$value) {
					if ($spoutSize == null || $diameterInchesSpout1Default - $value >= 0.125) {
						$spoutSize = $value;
					}
				};
				break;
		}
		$spoutRow1 = "<tr><td>Spout</td><td>"
			. $spoutSize . " inch"
			. "</td><td>"
			. $settings["spout-price"]
			. "</td></tr>";
		}
	$messageHTML = $message
			. "<h3>Your Quote Summary</h3><table><thead><tr><th>Item</th><th>Description</th><th>Price</th></tr></thead><tbody><tr><td>"
			. $settings["machinemodel"][$machinemodel]["name"] . " "
			. $settings["machinemodel"][$machinemodel]["type"] . "</td><td>"
			. $settings["machinemodel"][$machinemodel]["description"]
			. "</td><td>" . $settings["machinemodel"][$machinemodel]["price"]
			. "</td></tr><tr><td>"
			. $settings["weighhopper"][$weighhopper]["name"] . "</td><td>"
			. $settings["weighhopper"][$weighhopper]["description"]
			. "</td><td>" . $settings["weighhopper"][$weighhopper]["price"]
			. "</td></tr><tr><td>"
			. $settings["dischargefunnel"][$weightHopperSize[0]][$dischargeFunnelType[0]]["name"]
			. "</td><td>"
			. $settings["dischargefunnel"][$weightHopperSize[0]][$dischargeFunnelType[0]]["description"]
			. "</td><td>"
			. $settings["dischargefunnel"][$weightHopperSize[0]][$dischargeFunnelType[0]]["price"]
			. "</td></tr>" . $spoutRow1 . "</tbody></table>";

	$messageText = "Text of the message : " . urldecode($message)
			. "Your Quote Summary \r"
			. $settings["machinemodel"][$machinemodel]["name"] . " "
			. $settings["machinemodel"][$machinemodel]["type"] . " \n "
			. $weighhopper . " \n " . $dischargefunnel;
} else {
	$to = $_POST['to'];
	$cc = $_POST['cc'];
	if (!empty($message)) {
		$message = urldecode($_POST['message']) . "\n\r";
	} else {
		$message = "";
	}
	$quoteHTML = $_POST['quoteHTML'];
	$quoteText = $_POST['quoteText'];
	$messageHTML = $message . urldecode($quoteHTML);
	$messageText = $message . urldecode($quoteText);
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
$emailMessage = Swift_Message::newInstance('Logical Machines Quote Generator')
		->setBody($messageHTML, 'text/html')
		->addPart($messageText, 'text/plain')
		->setFrom(array('pete@spirelightmedia.com' => 'Logical Machines'))
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