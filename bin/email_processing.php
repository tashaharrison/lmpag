<?php

require_once 'swiftmailer/lib/swift_required.php';

if (isset($_POST['nojs'])) {
	// Retreive the list of available spouts from the HTML
	$availableSpouts = preg_replace('/\s+/', '', $spoutSizes);
	$availableSpouts = explode(",", $availableSpouts);
	// Calculate the nearest available spout according to the calculated spout size
	function nearestSpout($containerDiameter, $availableSpouts) {
		$closest = null;
		$calculatedSpoutSize = $containerDiameter * 0.72;
		foreach ($availableSpouts as $value) {
			if ($closest == null
					|| abs($value - $calculatedSpoutSize)
					< abs($closest - $calculatedSpoutSize)) {
				$closest = $value;
			}
		}
		;
		return $closest;
	}
	// Process the correct dimension fields according to the spout type selection
	$spoutRows = "";
	$index = 0;
	foreach ($spoutFields as $key => $value) {
		$index++;
		$spoutID = "Spout" . $index;
		$spoutwidth = "width" . $spoutID . "Fallback";
		$spoutd1 = "d1" . $spoutID . "Fallback";
		$spoutd2 = "d2" . $spoutID . "Fallback";
		$spoutdiameter = "diameter" . $spoutID . "Fallback";
		if (!empty($value)) {
			switch ($value) {
			case 'flat-bag':
				$containerDiameter = ${$spoutwidth} * 2 / M_PI;
				$spoutSize = nearestSpout($containerDiameter, $availableSpouts);
				break;
			case 'four-sided-bag':
				$containerDiameter = (${$spoutd1} + ${$spoutd2}) * 2 / M_PI;
				$spoutSize = nearestSpout($containerDiameter, $availableSpouts);
				break;
			case 'can-jar':
				foreach ($availableSpouts as $value) {
					if ($spoutSize == null
							|| ${$spoutdiameter} - $value >= 0.125) {
						$spoutSize = $value;
					}
				}
				;
				break;
			}
			$spoutRows .= "<tr><td>Spout</td><td>" . $spoutSize . " inch"
					. "</td><td>" . $settings["spout"]["price"] . "</td></tr>";
		}
	}
	// Determine the weigh hopper size and discharge funnel type in order to list the correct name, description and price for the dischgarge funnel on the order summar
	$weighHopperSize = explode("-", $weighhopper);
	$dischargeFunnelType = explode("-", $dischargefunnel);
	// Format the message or set the variable as empty if not set
	if (!empty($message)) {
		$message = urldecode($message) . "\n\r";
	} else {
		$message = "";
	}
	// Create the HTML message
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
			. $settings["dischargefunnel"][$weighHopperSize[0]][$dischargeFunnelType[0]]["name"]
			. "</td><td>"
			. $settings["dischargefunnel"][$weighHopperSize[0]][$dischargeFunnelType[0]]["description"]
			. "</td><td>"
			. $settings["dischargefunnel"][$weighHopperSize[0]][$dischargeFunnelType[0]]["price"]
			. "</td></tr>" . $spoutRows . "</tbody></table>";

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
	//header('Location: index.php');
	unset($_POST['typeSpout1Fallback'], $_POST['typeSpout2Fallback'], $_POST['typeSpout3Fallback']);
		$_POST['typeSpout1Fallback'] = "";
		$_POST['typeSpout2Fallback'] = "";
		$_POST['typeSpout3Fallback'] = "";
	$response = "<div class=\"success\"><p>Thank you. Your email has been successfully sent.</p><p>To print your quote press CTRL + P on your keyboard or select print from your browser's menu.</p></div>" . $messageHTML;
} else {
	$errors['mailfail'] = true;
}

?>