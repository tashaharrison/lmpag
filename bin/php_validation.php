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
			'd1Spout3', 'd2Spout3', 'diameterSpout3', 'typeSpout1Default',
			'typeSpout2Default', 'typeSpout3Default', 'widthSpout1',
			'd1Spout1', 'd2Spout1', 'diameterSpout1',
			'widthInchesSpout1Default', 'd1InchesSpout1Default',
			'd2InchesSpout1Default', 'diameterInchesSpout1Default',
			'widthInchesSpout2Default', 'd1InchesSpout2Default',
			'd2InchesSpout2Default', 'diameterInchesSpout2Default',
			'widthInchesSpout3Default', 'd1InchesSpout3Default',
			'd2InchesSpout3Default', 'diameterInchesSpout3Default', 'to', 'cc',
			'message');
	$required = array('to');

	if (!isset($_POST['typeSpout1Default'])) {
		$_POST['typeSpout1Default'] = '';
	}
	if (!isset($_POST['typeSpout2Default'])) {
		$_POST['typeSpout2Default'] = '';
	}
	if (!isset($_POST['typeSpout3Default'])) {
		$_POST['typeSpout3Default'] = '';
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
	// validate the spout 1 dimensions
	if (!$suspect && !empty($typeSpout1Default)) {
		if ($typeSpout1Default == 'flat-bag'
				&& empty($widthInchesSpout1Default)) {
			$errors['widthSpout1'] = true;
		} elseif ($typeSpout1Default == 'four-sided-bag'
				&& (empty($d1InchesSpout1Default)
						|| empty($d2InchesSpout1Default))) {
			$errors['d1d2Spout1'] = true;
		} elseif ($typeSpout1Default == 'can-jar'
				&& empty($diameterInchesSpout2Default)) {
			$errors['diameterSpout1'] = true;
		}
	}
	// validate the spout 2 dimensions
	if (!$suspect && !empty($typeSpout2Default)) {
		if ($typeSpout2Default == 'flat-bag'
				&& empty($widthInchesSpout2Default)) {
			$errors['widthSpout2'] = true;
		} elseif ($typeSpout2Default == 'four-sided-bag'
				&& (empty($d1InchesSpout2Default)
						|| empty($d2InchesSpout2Default))) {
			$errors['d1d2Spout2'] = true;
		} elseif ($typeSpout2Default == 'can-jar'
				&& empty($diameterInchesSpout2Default)) {
			$errors['diameterSpout2'] = true;
		}
	}
	// validate the spout 3 dimensions
	if (!$suspect && !empty($typeSpout3Default)) {
		if ($typeSpout3Default == 'flat-bag'
				&& empty($widthInchesSpout3Default)) {
			$errors['widthSpout3'] = true;
		} elseif ($typeSpout3Default == 'four-sided-bag'
				&& (empty($d1InchesSpout3Default)
						|| empty($d2InchesSpout3Default))) {
			$errors['d1d2Spout3'] = true;
		} elseif ($typeSpout3Default == 'can-jar'
				&& empty($diameterInchesSpout3Default)) {
			$errors['diameterSpout3'] = true;
		}
	}

	$mailer = false;

	if (!$suspect && !$missing && !$errors) {
		include_once 'bin/email_processing.php';
	}
}

?>