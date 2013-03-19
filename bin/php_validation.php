<?php
// define variables and initialize with empty values
$errors = array();
$missing = array();

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST['btnSubmit'])) {
	$expected = array('nojs', 'machinemodel', 'weighhopper', 'dischargefunnel',
			'typeSpout1', 'widthSpout1', 'd1Spout1', 'd2Spout1',
			'diameterSpout1', 'typeSpout2', 'widthSpout2', 'd1Spout2',
			'd2Spout2', 'diameterSpout2', 'typeSpout3', 'widthSpout3',
			'd1Spout3', 'd2Spout3', 'diameterSpout3', 'typeSpout1Fallback',
			'typeSpout2Fallback', 'typeSpout3Fallback', 'widthSpout1',
			'd1Spout1', 'd2Spout1', 'diameterSpout1', 'widthSpout1Fallback',
			'd1Spout1Fallback', 'd2Spout1Fallback', 'diameterSpout1Fallback',
			'widthSpout2Fallback', 'd1Spout2Fallback', 'd2Spout2Fallback',
			'diameterSpout2Fallback', 'widthSpout3Fallback',
			'd1Spout3Fallback', 'd2Spout3Fallback', 'diameterSpout3Fallback',
			'to', 'cc', 'message');
	$required = array('to');

	if (!isset($_POST['typeSpout1Fallback'])) {
		$_POST['typeSpout1Fallback'] = "";
	}
	if (!isset($_POST['typeSpout2Fallback'])) {
		$_POST['typeSpout2Fallback'] = "";
	}
	if (!isset($_POST['typeSpout3Fallback'])) {
		$_POST['typeSpout3Fallback'] = "";
	}
	
	// assume nothing is suspect
	$suspect = false;
	// create a pattern to locate suspect phrases
	$pattern = '/Content-Type:|Bcc:|Cc:/i';

	// function to check for suspect phrases
	function isSuspect($val, $pattern, &$suspect) {
		// if the variable is an array, loop through each element
		// and pass it recursively back to the same function
		if (is_array($val)) {
			foreach ($val as $item) {
				isSuspect($item, $pattern, $suspect);
			}
		} else {
			// if one of the suspect phrases is found, set Boolean to true
			if (preg_match($pattern, $val)) {
				$suspect = true;
			}
		}
	}

	// check the $_POST array and any subarrays for suspect content
	isSuspect($_POST, $pattern, $suspect);

	if (!$suspect) {
		foreach ($_POST as $key => $value) {
			// assign to temporary variable and strip whitespace if not an array
			$temp = is_array($value) ? $value : trim($value);
			// if empty and required, add to $missing array
			if (empty($temp) && in_array($key, $required)) {
				$missing[] = $key;
			} elseif (in_array($key, $expected)) {
				// otherwise, assign to a variable of the same name as $key
				${$key} = $temp;
			}
		}
	}

	if ($message) {
		$message = trim($message);
	}

	// validate the to email
	if (!$suspect && !empty($to)) {
		$validto = filter_input(INPUT_POST, 'to', FILTER_VALIDATE_EMAIL);
		if (!$validto) {
			$errors['to'] = true;
		}
	}
	// validate the cc email
	if (!$suspect && !empty($cc)) {
		$validcc = filter_input(INPUT_POST, 'cc', FILTER_VALIDATE_EMAIL);
		if (!$validcc) {
			$errors['cc'] = true;
		}
	}
	$spoutFields = array_intersect_key($_POST,
			array_flip(preg_grep('/^typeSpout/', array_keys($_POST))));
	$spoutFieldCount = count($spoutFields);
	
	for($i = 0; $i <= $spoutFieldCount; $i++) {
		$spoutID = "Spout" . $i;
		$spouttype = "type" . $spoutID . "Fallback";
		$spoutwidth = "width" . $spoutID . "Fallback";
		$spoutd1 = "d1" . $spoutID . "Fallback";
		$spoutd2 = "d2" . $spoutID . "Fallback";
		$spoutdiameter = "diameter" . $spoutID . "Fallback";
		$widtherror = "width" . $spoutID;
		$d1d2error = "d1d2" . $spoutID;
		$diametererror = "diameter" . $spoutID;
		if (!$suspect && !empty(${$spouttype})) {
			if (${$spouttype} == 'flat-bag' && empty(${$spoutwidth})) {
				$errors[$widtherror] = true;
			} elseif (${$spouttype} == 'four-sided-bag'
					&& (empty(${$spoutd1}) || empty(${$spoutd2}))) {
				$errors[$d1d2error] = true;
			} elseif (${$spouttype} == 'can-jar'
					&& empty(${$spoutdiameter})) {
				$errors[$diametererror] = true;
			}
		}
	}
	
	$mailer = false;

	if (!$suspect && !$missing && !$errors) {
		include_once 'bin/email_processing.php';
	}
}

?>