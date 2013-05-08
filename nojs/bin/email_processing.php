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
			. '<h3 style="margin-left:10px;">Your Quote Summary</h3><table border="0" cellpadding="10" cellspacing="0" style="margin:14px;border-collapse:collapse;"><thead style="border-bottom:1px solid #0c4b81;"><tr><th style="text-align:right;">Item</th><th style="text-align:left;">Description</th><th style="text-align:left;">Price</th></tr></thead><tbody><tr bgcolor="#EBFFEA"><th style="text-align:right;border-right: 1px solid #0c4b81;">'
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
		->setBody(
				'<html>'
						. ' <head>	<style type="text/css">
		#outlook a{
			padding:0;
		}
		body{
			width:100% !important;
		}
		body{
			-webkit-text-size-adjust:none;
		}
		body{
			margin-bottom:0;
			margin-left:0;
			margin-right:0;
			margin-top:10px;				
			padding:0;
		}
		img{
			border:0;
			height:auto;
			line-height:100%;
			outline:none;
			text-decoration:none;
		}
		table td{
			border-collapse:collapse;
		}
		#backgroundTable{
			height:100% !important;
			margin:0;
			padding:0;
			width:100% !important;
		}
			body,#backgroundTable{
			background-color:#FAFAFA;
		}
		#templateContainer{
			border:1px solid #DDDDDD;
		}
		h1,.h1{
			color:#202020;
			display:block;
			font-family:Arial;
			font-size:34px;
			font-weight:bold;
			line-height:100%;
			margin-top:0;
			margin-right:0;
			margin-bottom:10px;
			margin-left:0;
			text-align:left;
		}
		h2,.h2{
			color:#202020;
			display:block;
			font-family:Arial;
			font-size:30px;
			font-weight:bold;
			line-height:100%;
			margin-top:0;
			margin-right:0;
			margin-bottom:10px;
			margin-left:0;
			text-align:left;
		}
		h3,.h3{
			color:#202020;
			display:block;
			font-family:Arial;
			font-size:26px;
			font-weight:bold;
			line-height:100%;
			margin-top:0;
			margin-right:0;
			margin-bottom:10px;
			margin-left:0;
			text-align:left;
		}
		h4,.h4{
			color:#202020;
			display:block;
			font-family:Arial;
			font-size:22px;
			font-weight:bold;
			line-height:100%;
			margin-top:0;
			margin-right:0;
			margin-bottom:10px;
			margin-left:0;
			text-align:left;
		}
		#templatePreheader{
			background-color:#FAFAFA;
		}
		.preheaderContent div{
			color:#505050;
			font-family:Arial;
			font-size:10px;
			line-height:100%;
			text-align:left;
		}
		.preheaderContent div a:link,.preheaderContent div a:visited,.preheaderContent div a .yshortcuts {
			color:#336699;
			font-weight:normal;
			text-decoration:underline;
		}
		#templateHeader{
			background-color:#FFFFFF;
			border-bottom:0;
		}
		.headerContent{
			color:#202020;
			font-family:Arial;
			font-size:34px;
			font-weight:bold;
			line-height:100%;
			padding:0;
			text-align:center;
			vertical-align:middle;
		}
		.headerContent a:link,.headerContent a:visited,.headerContent a .yshortcuts {
			color:#336699;
			font-weight:normal;
			text-decoration:underline;
		}
		#headerImage{
			height:auto;
			max-width:600px !important;
		}
		#templateContainer,.bodyContent{
			background-color:#FFFFFF;
		}
		.bodyContent div{
			color:#505050;
			font-family:Arial;
			font-size:14px;
			line-height:150%;
			text-align:left;
		}
		.bodyContent div a:link,.bodyContent div a:visited,.bodyContent div a .yshortcuts {
			color:#336699;
			font-weight:normal;
			text-decoration:underline;
		}
		.bodyContent img{
			display:inline;
			height:auto;
		}
		#templateFooter{
			background-color:#FFFFFF;
			border-top:0;
		}
		.footerContent div{
			color:#707070;
			font-family:Arial;
			font-size:12px;
			line-height:125%;
			text-align:left;
		}
		.footerContent div a:link,.footerContent div a:visited,.footerContent div a .yshortcuts {
			color:#336699;
			font-weight:normal;
			text-decoration:underline;
		}
		.footerContent img{
			display:inline;
		}
				</style></head>'
						. ' <body leftmargin="0" marginwidth="0" topmargin="10" marginheight="0" offset="0">'
						. '<center>'
				// Background container
						. '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable"><tbody>'
						. '<tr><td align="center" valign="top">'
				// Email container
						. '<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer"><tbody>'
						. '<tr><td align="center" valign="top">'
				// Header container
						. '<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader"><tbody>'
						. '<tr><td class="headerContent">' . '</td></tr>'
						. '</tbody></table>'
						. '</td></tr><tr><td align="center" valign="top">'
				// Body container
						. '<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody"><tbody>'
						. '<tr><td valign="top" class="bodyContent">'
						. '<table border="0" cellpadding="20" cellspacing="0" width="100%"><tbody>'
						. '<tr><td valign="top">' . $messageHTML . '</td></tr>'
						. '</tbody></table></td></tr></tbody></table>'
						. '</td></tr>' . '<tr><td align="center" valign="top">'
				// Footer container
						. '<table border="0" cellpadding="10" cellspacing="0" width="100%" id="templateFooter"><tbody>'
						. '<tr><td valign="top" class="footerContent">'
						. '<table border="0" cellpadding="10" cellspacing="0" width="100%"><tbody>'
						. '<tr><td colspan="2" valign="middle"></td></tr>'
						. '</tbody></table>' . '</td></tr>'
						. '</tbody></table>' . '</td></tr>'
						. '</tbody></table>' . '<br></td></tr>'
						. '</tbody></table></center>' . '</body>' . '</html>',
				'text/html');
$emailMessage->addPart($messageText, 'text/plain');
$emailMessage->setFrom(array('pete@spirelightmedia.com' => 'Logical Machines'))
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