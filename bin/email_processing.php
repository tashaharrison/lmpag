<?php

require_once 'swiftmailer/lib/swift_required.php';

// Get current directory
$dir = dirname(__FILE__);

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
	$spoutRowsHTML = "";
	$spoutRowsText = "";
	$spoutPrice = 0;
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
			$spoutRowsHTML .= '<tr><th style="text-align:right;border-right: 1px solid #0c4b81;">Spout</th><td>'
					. $spoutSize . ' inch' . '</td><td>$'
					. $settings["spout"]["price"] . '</td></tr>';
			$spoutRowsText .= "Spout: " . $spoutSize . " inch - $"
					. $settings["spout"]["price"] . "\r";
			$spoutPrice = $spoutPrice + abs($settings["spout"]["price"]);
		}
	}
	$spoutRowsText .= "\r";
	// Determine the weigh hopper size and discharge funnel type in order to list the correct name, description and price for the dischgarge funnel on the order summar
	$weighHopperSize = explode("-", $weighhopper);
	$dischargeFunnelType = explode("-", $dischargefunnel);
	// Format the message or set the variable as empty if not set
	if (!empty($message)) {
		$message = urldecode($message) . "\n\r";
	} else {
		$message = "";
	}
	$total = $settings["machinemodel"][$machinemodel]["price"]
			+ $settings["weighhopper"][$weighhopper]["price"]
			+ $settings["dischargefunnel"][$weighHopperSize[0]][$dischargeFunnelType[0]]["price"]
			+ $spoutPrice;
	// Create the HTML message
	$messageHTML = $message
			. '<table border="0" cellpadding="10" cellspacing="0" style="margin:14px;border-collapse:collapse;"><thead style="border-bottom:1px solid #0c4b81;"><tr><th style="text-align:right;">Item</th><th style="text-align:left;">Description</th><th style="text-align:left;">Price</th></tr></thead><tbody><tr bgcolor="#EBFFEA"><th style="text-align:right;border-right: 1px solid #0c4b81;">'
			. $settings["machinemodel"][$machinemodel]["name"] . ' '
			. $settings["machinemodel"][$machinemodel]["type"] . '</th><td>'
			. $settings["machinemodel"][$machinemodel]["description"]
			. '</td><td>$' . $settings["machinemodel"][$machinemodel]["price"]
			. '</td></tr><tr><th style="text-align:right;border-right: 1px solid #0c4b81;">'
			. $settings["weighhopper"][$weighhopper]["name"] . "</th><td>"
			. $settings["weighhopper"][$weighhopper]["description"]
			. '</td><td>$' . $settings["weighhopper"][$weighhopper]["price"]
			. '</td></tr><tr bgcolor="#EBFFEA"><th style="text-align:right;border-right: 1px solid #0c4b81;">'
			. $settings["dischargefunnel"][$weighHopperSize[0]][$dischargeFunnelType[0]]["name"]
			. '</th><td>'
			. $settings["dischargefunnel"][$weighHopperSize[0]][$dischargeFunnelType[0]]["description"]
			. '</td><td>$'
			. $settings["dischargefunnel"][$weighHopperSize[0]][$dischargeFunnelType[0]]["price"]
			. '</td></tr>' . $spoutRowsHTML
			. '<tr class="total" style="text-align:right;border-top:1px solid #0c4b81;"><td>&nbsp;</td><th>Total:</th><td>$'
			. $total . '</td></tr></tbody></table>';

	$messageText = $message . "Your Quote Summary \r\r"
			. $settings["machinemodel"][$machinemodel]["name"] . " "
			. $settings["machinemodel"][$machinemodel]["type"] . " - $"
			. $settings["machinemodel"][$machinemodel]["price"] . "\r"
			. $settings["machinemodel"][$machinemodel]["description"] . "\r\r"
			. $settings["weighhopper"][$weighhopper]["name"] . " - $"
			. $settings["weighhopper"][$weighhopper]["price"] . "\r"
			. $settings["weighhopper"][$weighhopper]["description"] . "\r\r"
			. $settings["dischargefunnel"][$weighHopperSize[0]][$dischargeFunnelType[0]]["name"]
			. " - $"
			. $settings["dischargefunnel"][$weighHopperSize[0]][$dischargeFunnelType[0]]["price"]
			. "\r"
			. $settings["dischargefunnel"][$weighHopperSize[0]][$dischargeFunnelType[0]]["description"]
			. "\r\r" . $spoutRowsText . "Total: $" . $total;
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

// Get the contents of the PDF into a variable
ob_start();
require_once($dir.'/pdf.tpl.php');
$pdfHTML = ob_get_contents();
ob_end_clean();

// Load the dompdf files
require_once($dir.'/dompdf/dompdf_config.inc.php');
$dompdf = new DOMPDF(); // Create new instance of dompdf
$dompdf->load_html($pdfHTML); // Load the html
$dompdf->render(); // Parse the html, convert to PDF
$pdf_content = $dompdf->output(); // Put contents of pdf into variable for later

// Get the contents of the HTML email into a variable
ob_start();
require_once($dir.'/email.tpl.php');
$htmlBody = ob_get_contents();
ob_end_clean();

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
$emailMessage = Swift_Message::newInstance('Logical Machines Quote Generator');
$emailMessage
		->setBody($htmlBody, 'text/html')
		->addPart($messageText, 'text/plain')
		->attach(Swift_Attachment::newInstance($pdf_content, 'logical-machines-quote.pdf', 'application/pdf'))
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
	unset($_POST['typeSpout1Fallback'], $_POST['typeSpout2Fallback'],
			$_POST['typeSpout3Fallback']);
	$_POST['typeSpout1Fallback'] = "";
	$_POST['typeSpout2Fallback'] = "";
	$_POST['typeSpout3Fallback'] = "";
	$response = "<div class=\"success\"><p>Thank you. Your email has been successfully sent.</p><p>To print your quote press CTRL + P on your keyboard or select print from your browser's menu.</p></div>"
			. $messageHTML;
} else {
	$errors['mailfail'] = true;
}

?>