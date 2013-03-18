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

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
	<!--<![endif]-->

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Logical Machines Quote Generator</title>
		<meta name="description" content="Scoop no more with Logical Machines automatic weigh and fill machines. Small to medium sized companies save time and money with our automated filling machines">
		<meta name="viewport" content="width=device-width">

		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

		<link rel="stylesheet" href="css/lm.css">
		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/forms.css">
		<script src="js/vendor/modernizr-2.6.2.min.js"></script>
		<script type="text/javascript" src="js/ahah.js" ></script>
	</head>

	<body>
		<!--[if lt IE 7]>
		<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->

		<!-- Add your site or application content here -->
		<div id="PageDiv">
			<header id="header" class="clearfix">
				<div id="LMLogo1">
					<a href="index.html"><img src="img/lmlogo1.jpeg" width=258 height=96 alt="LMLogo1" style="float:left"></a>
				</div>
				<div id="h1-header">
					<h1 class="f-lp"><span class="style8">Logical Machines
						<br />
						Quote Generator</span></h1>
				</div>
				<div id="scoop15a">
					<img src="img/scoop15a.jpeg" width=105 height=118 alt="scoop15a" style="float:left">
				</div>
			</header>

			<nav id="main-navigation" class="clearfix">
				<div id="lft-nav1">
					<p class="lftnav f-lp">
						<span class="style3"><a href="table-of-contents.html">Table of Contents</a></span><a href="http://www.logicalmachines.com"><span class="style3">
							<br>
						</span></a><span class="style3">&#8226;
							<br>
							<a href="what-are-logical-machines.html">What Are Logical Machines?</a></span><a href="http://logicalmachines.com/what.php"><span class="style3">
							<br>
						</span></a><span class="style3">&#8226;
							<br>
							<a href="which-logical-machine.html">Which machine is
							<br>
							right for me?</a></span><a href="http://logicalmachines.com/which.php"><span class="style3">
							<br>
						</span></a><span class="style3">&#8226;
							<br>
							<a href="sample-videos.html">Sample Videos</a></span><a href="http://logicalmachines.com/videos.php"><span class="style3">
							<br>
						</span></a><span class="style3">&#8226;
							<br>
							<a href="testimonials.html">Testimonials</a></span><a href="http://logicalmachines.com/testimonials.php"><span class="style3">
							<br>
						</span></a><span class="style3">&#8226;
							<br>
							<a href="distributor-support.html">Distributor
							<br>
							Support</a></span><a href="http://logicalmachines.com/distributor-support.php"><span class="style3">
							<br>
						</span></a><span class="style3">&#8226;
							<br>
							<a href="customer-support.html">Customer
							<br>
							Support</a></span><a href="http://logicalmachines.com/customer-support.php"><span class="style3">
							<br>
						</span></a><span class="style3">&#8226;
							<br>
							<a href="contact.html">Contact Us</a></span>
					</p>
				</div>
			</nav>

			<nav id="pag-navigation" class="clearfix">
				<ol>
					<li>
						<a href="#step-1" class="active"><span class="list-no">1</span>
						<br/>
						Select your machine</a>
					</li>
					<li>
						<a href="#step-2"><span class="list-no">2</span>
						<br/>
						Select a Weigh Hopper</a>
					</li>
					<li>
						<a href="#step-3"><span class="list-no">3</span>
						<br/>
						Select a Discharge Funnel</a>
					</li>
					<li>
						<a href="#step-4"><span class="list-no">4</span>
						<br/>
						Select Spouts</a>
					</li>
					<li>
						<a href="#step-5"><span class="list-no">5</span>
						<br/>
						Your Quote Summary</a>
					</li>
				</ol>
			</nav>

			<section id="section-content" class="clearfix">
				<article id="main-content" class="clearfix no-sidebar">
					<pre> <?php print_r($_POST); ?>	</pre>
					<?php echo isset($response) && !empty($response) ? $response
		: '';
					?>				
					 <?php if (($_POST && $suspect)
							|| ($_POST && isset($errors['mailfail']))) {
					 ?>
         			<p class="warning">Sorry, your mail could not be sent. Please try later.</p>
        			<?php } elseif ($missing || $errors) { ?>
           			<p class="warning">Please fix the item(s) indicated.</p>
        			<?php } ?>
					<form method="post" name="logical-machines-quote-generator" id="logical-machines-quote-generator" action="<?php echo htmlspecialchars(
		$_SERVER["PHP_SELF"]);
																															  ?>">
					<input type="hidden" name="nojs" value="nojs">
						<div id="form-pages">

							<div id="step-1" class="step-container" name="step-1">
								<div id="welcome-text">
									<h2>Welcome to the Logical Machines
									<br />
									Quote Generator</h2>
									<p>
										We have developed this guide to help you select and equip your Logical Machine to meet the needs of your business.
									</p>
									<p>
										In 5 simple steps you can:
									</p>
									<ol>
										<li>
											Select the Logical Machine model that best fits your needs;
										</li>
										<li>
											Select the Weigh Hopper appropriate for the volumes that you are packaging;
										</li>
										<li>
											Select the Discharge Funnel that best fits the flow qualities of your product;
										</li>
										<li>
											Select the spout or spouts that work best for the containers that you use;
										</li>
										<li>
											Generate a summary of your quote and print or email that summary.
										</li>
									</ol>
								</div>
								<h3>Logical Machines Models</h3>
								<h4>Please begin by selecting your model.</h4>
								<ul id="field-name-machine-model" class="field-container field-type-radio">
									<li>
										<input type="radio" id="s4" class="radio active" name="machinemodel" value="S-4" 
										<?php
																															  if (!$_POST
																																	  || ($_POST
																																			  && $_POST['machinemodel']
																																					  == 'S-4')) {
																																  echo 'checked';
																															  }
										?>/>
										<label for="s4"><h4><span class="name">S-4</span>&nbsp;<span class="type">Weigh Fill System</span></h4>
											<p class="description">
												The standard S-4 includes the small weigh hopper, small discharge funnel, Logical Controller II and one spout. It comes fully assembled and ready to operate.
											</p>
											<p class="specification">
												<h5>S-4 Specifications:</h5>
												<ul>
													<li>
														Self-adjusting controller
													</li>
													<li>
														Reads out to 1 gram or .001 lb
													</li>
													<li>
														Controller range up to 10lbs.
													</li>
													<li>
														Supply Hopper cap. 3.5 cu.ft.
													</li>
													<li>
														Powder-coated chassis
													</li>
													<li>
														All product contact surfaces stainless steel
													</li>
													<li>
														Footprint 4.6 sq.ft., 67" high
													</li>
													<li>
														120V 60Hz (240V 50Hz option)
													</li>
													<li>
														Handles all dry bulk from powders to large parts
													</li>
													<li>
														Can be used with all bags and rigid containers
													</li>
													<li>
														Automatic tare adjustment
													</li>
													<li>
														On-the-fly, self-adjusting bulk &amp; dribble speed control
													</li>
													<li>
														600-800 fills/hour
													</li>
												</ul>
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount">6150</span>
											</p></label>
									</li>
									<li>
										<input type="radio" id="s5" name="machinemodel" value="S-5" 
										<?php
										if ($_POST
												&& $_POST['machinemodel']
														== 'S-5') {
											echo 'checked';
										}
										?>/>
										<label for="s5"><h4><span class="name">S-5</span>&nbsp;<span class="type">Bulk Fill System</span></h4>
											<p class="description">
												The standard S-5 includes... It comes fully assembled and ready to operate.
											</p> <!-- class="machine-model-description" -->
											<p class="price clear">
												<b>Price: </b>$<span class="amount">5450</span>
											</p></label>
									</li>
									<li>
										<input type="radio" id="s6" name="machinemodel" value="S-6" 
										<?php
										if ($_POST
												&& $_POST['machinemodel']
														== 'S-6') {
											echo 'checked';
										}
										?>/>
										<label for="s6"><h4><span class="name">S-6</span>&nbsp;<span class="type">Cascading Weigh FIller</span></h4>
											<p class="description">
												The standard S-6 includes... It comes fully assembled and ready to operate.
											</p> <!-- class="machine-model-description" -->
											<p class="price clear">
												<b>Price: </b>$<span class="amount">9950</span>
											</p></label>
									</li>
									<li>
										<input type="radio" id="s7" name="machinemodel" value="S-7" 
										<?php
										if ($_POST
												&& $_POST['machinemodel']
														== 'S-7') {
											echo 'checked';
										}
										?>/>
										<label for="s7"><h4><span class="name">S-7</span>&nbsp;<span class="type">Dual-Lane Weigh FIller</span></h4>
											<p class="description">
												The standard S-7 includes... It comes fully assembled and ready to operate.
											</p> <!-- class="machine-model-description" -->
											<p class="price clear">
												<b>Price: </b>$<span class="amount">12000</span>
											</p></label>
									</li>
								</ul>
							</div><!-- id="step-1" -->

							<div id="step-2" class="step-container" name="step-2">
								<h3>Select your Weigh Hopper</h3>
								<p>
									The <b>Weigh Hopper</b> is the scale portion of the unit which handles and weighs your products. Select a hopper by clicking its image.
								</p>
								<ul id="field-name-weigh-hopper" class="field-type-radio field-container">
									<li class="small">
										<input type="radio" id="smwh" class="active" name="weighhopper" value="small-weigh-hopper" 
										<?php
										if (!$_POST
												|| ($_POST
														&& $_POST['weighhopper']
																== 'small-weigh-hopper')) {
											echo 'checked';
										}
										?>/>
										<label for="smwh" class="clearfix"><h4 class="name">Small Weigh Hopper</h4>
											<div class="component-image ir">
												Small Weigh Hopper image
											</div>
											<p class="description">
												The small weigh hopper comes standard on the S-4. Its 250 cubic inch capacity handles net weights from a few grams to 3 lbs.
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount">0</span> included on standard S-4
											</p></label>

									</li>
									<li class="large">
										<input type="radio" id="lrgwh" name="weighhopper" value="large-weigh-hopper" 
										<?php
										if ($_POST
												&& $_POST['weighhopper']
														== 'large-weigh-hopper') {
											echo 'checked';
										}
										?>/>
										<label for="lrgwh" class="clearfix"><h4 class="name">Large Weigh Hopper</h4>
											<div class="component-image ir">
												Large Weigh Hopper image
											</div>
											<p class="description">
												For larger volumes, the large weigh hopper's 650 cubic inch capacity handles net weights from 2 oz. to 10 lbs.
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount">100</span> upcharge
											</p></label>

									</li>
								</ul>
							</div><!-- id="step-2" -->

							<div id="step-3" class="step-container" name="step-3">
								<h3>Select your Discharge Funnel</h3>
								<p>
									The <b>Discharge Funnel</b> directs your product from the weigh hopper to the spout. Select a funnel by clicking its image.
								</p>
								<ul id="field-name-discharge-funnel" class="field-type-radio field-container">
									<li class="small hidden">
										<input type="radio" id="small-std-fnl" name="dischargefunnel" value="small-standard-funnel" />
										<label for="small-std-fnl" class="std-fnl clearfix"><h4 class="name">Small Standard Discharge Funnel</h4>
											<div class="component-image ir">
												Small Standard Discharge Funnel image
											</div>
											<p class="description">
												This is the standard funnel for use with the small weigh hopper. It is practical for most free-flowing materials.
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount">0</span> included on standard S-4
											</p></label>
									</li>
									<li class="small hidden">
										<input type="radio" id="small-steep-fnl" name="dischargefunnel" value="small-steep-funnel" />
										<label for="small-steep-fnl" class="steep-fnl clearfix"><h4 class="name">Small Steep-Sided Discharge Funnel</h4>
											<div class="component-image ir">
												Small Steep-Sided Discharge image
											</div>
											<p class="description">
												This steep sided funnel is used for fine powdered materials such as flour or other products that can stick to metal surfaces.
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount">125</span> upcharge
											</p></label>
									</li>
									<li class="large hidden">
										<input type="radio" id="large-std-fnl" name="dischargefunnel" value="large-standard-funnel" />
										<label for="large-std-fnl" class="std-fnl clearfix"><h4 class="name">Large Standard Discharge Funnel</h4>
											<div class="component-image ir">
												Large Standard Discharge Funnel image
											</div>
											<p class="description">
												This is the standard funnel for use with the large weigh hopper. It works best with free flowing products.
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount">150</span>
											</p></label>
									</li>
									<li class="large hidden">
										<input type="radio" id="large-steep-fnl" name="dischargefunnel" value="large-steep-funnel" />
										<label for="large-steep-fnl" class="steep-fnl clearfix"><h4 class="name">Large Steep-Sided Discharge Funnel</h4>
											<div class="component-image ir">
												Large Steep-Sided Discharge image
											</div>
											<p class="description">
												This steep sided funnel is used for fine powdered materials such as flour or other products that can stick to metal surfaces.
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount">400</span> upcharge
											</p></label>
									</li>
									<li class="small default-discharge-funnel">
										<input type="radio" id="std-fnl" class="active" name="dischargefunnel" value="standard-discharge-funnel" 
										<?php
										if (!$_POST
												|| ($_POST
														&& $_POST['dischargefunnel']
																== 'standard-discharge-funnel')) {
											echo 'checked';
										}
										?>/>
										<label for="std-fnl" class="std-fnl clearfix"><h4 class="name">Standard Discharge Funnel</h4>
											<div class="component-image ir">
												Standard Discharge Funnel image
											</div>
											<p class="description">
												This is the standard funnel for use with the small and large weigh hoppers. It is practical for most free-flowing materials.
											</p>
											<p class="price clear">
												<b>Price with Small Weigh Hopper: </b>
												<br/>
												$<span class="amount">0</span> included on standard S-4
												<br />
												<b>Price with Large Weigh Hopper: </b>
												<br/>
												$<span class="amount">150</span>
											</p></label>

									</li>
									<li class="small default-discharge-funnel">
										<input type="radio" id="steep-fnl" name="dischargefunnel" value="steep-funnel" 
										<?php
										if ($_POST
												&& $_POST['dischargefunnel']
														== 'steep-funnel') {
											echo 'checked';
										}
										?>/>
										<label for="steep-fnl" class="steep-fnl clearfix"><h4 class="name">Steep-Sided Discharge Funnel</h4>
											<div class="component-image ir">
												Steep-Sided Discharge image
											</div>
											<p class="description">
												This steep sided funnel is used for fine powdered materials such as flour or other products that can stick to metal surfaces.
											</p>
											<p class="price clear">
												<b>Price with Small Weigh Hopper: </b>
												<br/>
												$<span class="amount">125</span> upcharge
												<br />
												<b>Price with Large Weigh Hopper: </b>
												<br/>
												$<span class="amount">400</span> upcharge
											</p></label>
									</li>
								</ul>
							</div><!-- id="step-3" -->

							<div id="step-4" class="step-container" name="step-4">
								<h3>Select your Spout</h3>
								<div class="spout-sprite main-spout-image ir">
									Spout image
								</div>
								<p>
									The spout attaches to the bottom of the discharge funnel and directs the materials into your container.
								</p>
								<p>
									Use the <b>Spout Calculator</b> below to help you determine which size spout is right for your container.
								</p>
								<div id="field-name-spout" class="field-container">
									<fieldset id="spout1" class="field-spout hidden">
										<legend>
											Spout 1
										</legend>
										<ul class="field-type-radio field-name-spout-type">
											<li class="flat-bag">
												<input type="radio" id="type1Spout1" name="typeSpout1" value="flat-bag" />
												<label for="type1Spout1">
													<div class="spout-sprite ir">
														Flat bag spout image
													</div><h4 class="name">Flat bag</h4></label>
											</li>
											<li class="four-sided-bag">
												<input type="radio" id="type2Spout1" name="typeSpout1" value="four-sided-bag" />
												<label for="type2Spout1">
													<div class="spout-sprite ir">
														4 sided bag spout image
													</div><h4 class="name">4 sided bag</h4></label>
											</li>
											<li class="can-jar">
												<input type="radio" id="type3Spout1" name="typeSpout1" value="can-jar" />
												<label for="type3Spout1">
													<div class="spout-sprite ir">
														Bottle or Jar spout image
													</div><h4 class="name">Bottle or Jar</h4></label>
											</li>
										</ul>
										<div class="instructions">
											<p class="spout-selection">
												Click on the diagram above that most accurately depicts your container.
											</p>
											<p class="flat-bag">
												Enter the width of the bag opening (W).
											</p>
											<p class="four-sided-bag">
												Looking down at the top of your bag, enter the dimensions (D1) and (D2) of the bag opening.
											</p>
											<p class="can-jar">
												Enter the inside diameter of the bottle or can opening (D).
											</p>
										</div>
										<ul class="field-type-textfield field-name-dimensions">
											<li class="width flat-bag">
												<label>Width in inches</label>
												<input class="required number" type="text" name="widthSpout1" />
											</li>
											<li class="d1 four-sided-bag">
												<label>D1</label>
												<input class="required number" type="text" name="d1Spout1" />
											</li>
											<li class="d2 four-sided-bag">
												<label>D2</label>
												<input class="required number" type="text" name="d2Spout1" />
											</li>
											<li class="diameter can-jar">
												<label>Diameter in inches</label>
												<input class="required number" type="text" name="diameterSpout1" />
											</li>
										</ul>
										<div class="container-shape-images">
											<div class="spout-sprite flat-bag ir">
												Flat bag spout shape image
											</div>
											<div class="spout-sprite four-sided-bag ir">
												4 sided bag spout shape image
											</div>
											<div class="spout-sprite can-jar ir">
												Bottle or Jar spout shape image
											</div>
										</div>
										<button type="button" value="Calculate" class="calculate">
											Calculate
										</button>
										<p class="spout-calculation">
											You have selected a <span class="spout-size">&nbsp;</span> inch spout
										</p>
									</fieldset>

									<fieldset id="defaultSpout1" class="default-field-spout">
										<legend>
											Spout 1
										</legend>	
										<div class="instructions">
											<p>
												Click on the diagram that most accurately depicts your container and then enter the size of the bags to be filled in inches.
											</p>
										</div>								
										<ul class="field-type-radio field-name-spout-type">
											<li class="flat-bag">
												<input type="radio" id="type1Spout1Default" name="typeSpout1Default" value="flat-bag" 
												<?php
										if ($_POST
												&& $_POST['typeSpout1Default']
														== 'flat-bag') {
											echo 'checked';
										}
												?>/>

												<label for="type1Spout1Default">
													<div class="spout-sprite flat-bag-spout ir">
														Flat bag spout image
													</div><h4>Flat bag</h4></label>
											</li>
											<li class="four-sided-bag">
												<input type="radio" id="type2Spout1Default" name="typeSpout1Default" value="four-sided-bag" 
												<?php
												if ($_POST
														&& $_POST['typeSpout1Default']
																== 'four-sided-bag') {
													echo 'checked';
												}
												?>/>
												<label for="type2Spout1Default">
													<div class="spout-sprite four-sided-bag-spout ir">
														4 sided bag spout image
													</div><h4>4 sided bag</h4></label>
											</li>
											<li class="can-jar">
												<input type="radio" id="type3Spout1Default" name="typeSpout1Default" value="can-jar" 
												<?php
												if ($_POST
														&& $_POST['typeSpout1Default']
																== 'can-jar') {
													echo 'checked';
												}
												?>/>
												<label for="type3Spout1Default">
													<div class="spout-sprite can-or-jar-spout ir">
														Can or Jar spout image
													</div><h4>Can or Jar</h4></label>
											</li>
										</ul>
										<div class="instructions">
											<p>
												Please enter:
											</p>
											<ul>
												<li>
													<b>Flat Bag:</b> Enter the width of the bag opening (W).
												</li>
												<li>
													<b>4 sided bag Bag:</b> Looking down at the top of your bag, enter the dimensions (D1) and (D2) of the bag opening.
												</li>
												<li>
													<b>Bottle or Jar:</b> Enter the inside diameter of the bottle or can opening (D).
												</li>
											</ul>
										</div>
										<ul class="field-type-textfield field-name-dimensions">
											<li class="width">
												<label>Width in inches</label>
												<input type="text" name="widthInchesSpout1Default" <?php if (!empty(
														$widthInchesSpout1Default)
														&& ($missing || $errors)) {
													echo 'value="'
															. htmlentities(
																	$widthInchesSpout1Default,
																	ENT_COMPAT,
																	'UTF-8')
															. '"';
												}
																								   ?>/>
											</li>
											<li class="d1">
												<label>D1</label>
												<input type="text" name="d1InchesSpout1Default" <?php if (!empty(
																										   $d1InchesSpout1Default)
																										   && ($missing
																												   || $errors)) {
																									   echo 'value="'
																											   . htmlentities(
																													   $d1InchesSpout1Default,
																													   ENT_COMPAT,
																													   'UTF-8')
																											   . '"';
																								   }
																								?>/>
											</li>
											<li class="d2">
												<label>D2</label>
												<input type="text" name="d2InchesSpout1Default" <?php if (!empty(
																										$d2InchesSpout1Default)
																										&& ($missing
																												|| $errors)) {
																									echo 'value="'
																											. htmlentities(
																													$d2InchesSpout1Default,
																													ENT_COMPAT,
																													'UTF-8')
																											. '"';
																								}
																								?>/>
											</li>
											<li class="diameter">
												<label>Diameter in inches</label>
												<input type="text" name="diameterInchesSpout1Default" <?php if (!empty(
																										$diameterInchesSpout1Default)
																										&& ($missing
																												|| $errors)) {
																									echo 'value="'
																											. htmlentities(
																													$d2InchesSpout1Default,
																													ENT_COMPAT,
																													'UTF-8')
																											. '"';
																								}
																									  ?>/>
											</li>
										</ul>
										<?php if (isset($errors['widthSpout1'])) { ?>
                  							<label class="error clear">Please enter a width measurement in the 'Width in inches' field</label>
                						<?php } elseif (isset(
		$errors['d1d2Spout1'])) {
										?>
                  							<label class="error clear">Please enter a measurement in both the 'D1' & 'D2' fields</label>
                						<?php } elseif (isset(
		$errors['diameterSpout1'])) {
										?>
                  								<label class="error clear">Please enter a diameter measurement in the 'Diameter in inches' field</label>
                						<?php } ?>
										<div class="container-shape-images">
											<div class="spout-sprite flat-bag ir">
												Flat bag spout shape image
											</div>
											<div class="spout-sprite four-sided-bag ir">
												4 sided bag spout shape image
											</div>
											<div class="spout-sprite can-jar ir">
												Can or Jar spout shape image
											</div>
										</div>
									</fieldset>

									<fieldset id="defaultSpout2" class="default-field-spout">
										<legend>
											Spout 2
										</legend>	
										<div class="instructions">
											<p>
												Click on the diagram that most accurately depicts your container and then enter the size of the bags to be filled in inches.
											</p>
										</div>								
										<ul class="field-type-radio field-name-spout-type">
											<li class="flat-bag">
												<input type="radio" id="type1Spout2Default" name="typeSpout2Default" value="flat-bag" 
												<?php
if ($_POST && $_POST['typeSpout2Default'] == 'flat-bag') {
	echo 'checked';
}
												?>/>
												<label for="type1Spout2Default">
													<div class="spout-sprite flat-bag-spout ir">
														Flat bag spout image
													</div><h4>Flat bag</h4></label>
											</li>
											<li class="four-sided-bag">
												<input type="radio" id="type2Spout2Default" name="typeSpout2Default" value="four-sided-bag" 
												<?php
												if ($_POST
														&& $_POST['typeSpout2Default']
																== 'four-sided-bag') {
													echo 'checked';
												}
												?>/>
												<label for="type2Spout2Default">
													<div class="spout-sprite four-sided-bag-spout ir">
														4 sided bag spout image
													</div><h4>4 sided bag</h4></label>
											</li>
											<li class="can-jar">
												<input type="radio" id="type3Spout2Default" name="typeSpout2Default" value="can-jar" 
												<?php
												if ($_POST
														&& $_POST['typeSpout2Default']
																== 'can-jar') {
													echo 'checked';
												}
												?>/>
												<label for="type3Spout2Default">
													<div class="spout-sprite can-or-jar-spout ir">
														Can or Jar spout image
													</div><h4>Can or Jar</h4></label>
											</li>
										</ul>
										<div class="instructions">
											<p>
												Please enter:
											</p>
											<ul>
												<li>
													<b>Flat Bag:</b> Enter the width of the bag opening (W).
												</li>
												<li>
													<b>4 sided bag Bag:</b> Looking down at the top of your bag, enter the dimensions (D1) and (D2) of the bag opening.
												</li>
												<li>
													<b>Bottle or Jar:</b> Enter the inside diameter of the bottle or can opening (D).
												</li>
											</ul>
										</div>
										<ul class="field-type-textfield field-name-dimensions">
											<li class="width">
												<label>Width in inches</label>
												<input type="text" name="widthInchesSpout2Default" <?php if (!empty(
														$widthInchesSpout2Default)
														&& ($missing || $errors)) {
													echo 'value="'
															. htmlentities(
																	$widthInchesSpout2Default,
																	ENT_COMPAT,
																	'UTF-8')
															. '"';
												}
																								   ?>/>
											</li>
											<li class="d1">
												<label>D1</label>
												<input type="text" name="d1InchesSpout2Default" <?php if (!empty(
																										   $d1InchesSpout2Default)
																										   && ($missing
																												   || $errors)) {
																									   echo 'value="'
																											   . htmlentities(
																													   $d1InchesSpout2Default,
																													   ENT_COMPAT,
																													   'UTF-8')
																											   . '"';
																								   }
																								?>/>
											</li>
											<li class="d2">
												<label>D2</label>
												<input type="text" name="d2InchesSpout2Default" <?php if (!empty(
																										$d2InchesSpout2Default)
																										&& ($missing
																												|| $errors)) {
																									echo 'value="'
																											. htmlentities(
																													$d2InchesSpout2Default,
																													ENT_COMPAT,
																													'UTF-8')
																											. '"';
																								}
																								?>/>
											</li>
											<li class="diameter">
												<label>Diameter in inches</label>
												<input type="text" name="diameterInchesSpout2Default" <?php if (!empty(
																										$diameterInchesSpout2Default)
																										&& ($missing
																												|| $errors)) {
																									echo 'value="'
																											. htmlentities(
																													$d2InchesSpout2Default,
																													ENT_COMPAT,
																													'UTF-8')
																											. '"';
																								}
																									  ?>/>
											</li>
										</ul>
										<?php if (isset($errors['widthSpout2'])) { ?>
                  							<label class="error clear">Please enter a width measurement in the 'Width in inches' field</label>
                						<?php } elseif (isset(
		$errors['d1d2Spout2'])) {
										?>
                  							<label class="error clear">Please enter a measurement in both the 'D1' & 'D2' fields</label>
                						<?php } elseif (isset(
		$errors['diameterSpout2'])) {
										?>
                  								<label class="error clear">Please enter a diameter measurement in the 'Diameter in inches' field</label>
                						<?php } ?>
										<div class="container-shape-images">
											<div class="spout-sprite flat-bag ir">
												Flat bag spout shape image
											</div>
											<div class="spout-sprite four-sided-bag ir">
												4 sided bag spout shape image
											</div>
											<div class="spout-sprite can-jar ir">
												Can or Jar spout shape image
											</div>
										</div>
									</fieldset>
									
									<fieldset id="defaultSpout3" class="default-field-spout">
										<legend>
											Spout 3
										</legend>	
										<div class="instructions">
											<p>
												Click on the diagram that most accurately depicts your container and then enter the size of the bags to be filled in inches.
											</p>
										</div>								
										<ul class="field-type-radio field-name-spout-type">
											<li class="flat-bag">
												<input type="radio" id="type1Spout3Default" name="typeSpout3Default" value="flat-bag" 
												<?php
if ($_POST && $_POST['typeSpout3Default'] == 'flat-bag') {
	echo 'checked';
}
												?>/>
												<label for="type1Spout3Default">
													<div class="spout-sprite flat-bag-spout ir">
														Flat bag spout image
													</div><h4>Flat bag</h4></label>
											</li>
											<li class="four-sided-bag">
												<input type="radio" id="type2Spout3Default" name="typeSpout3Default" value="four-sided-bag" 
												<?php
												if ($_POST
														&& $_POST['typeSpout3Default']
																== 'four-sided-bag') {
													echo 'checked';
												}
												?>/>
												<label for="type2Spout3Default">
													<div class="spout-sprite four-sided-bag-spout ir">
														4 sided bag spout image
													</div><h4>4 sided bag</h4></label>
											</li>
											<li class="can-jar">
												<input type="radio" id="type3Spout3Default" name="typeSpout3Default" value="can-jar" 
												<?php
												if ($_POST
														&& $_POST['typeSpout3Default']
																== 'can-jar') {
													echo 'checked';
												}
												?>/>
												<label for="type3Spout3Default">
													<div class="spout-sprite can-or-jar-spout ir">
														Can or Jar spout image
													</div><h4>Can or Jar</h4></label>
											</li>
										</ul>
										<div class="instructions">
											<p>
												Please enter:
											</p>
											<ul>
												<li>
													<b>Flat Bag:</b> Enter the width of the bag opening (W).
												</li>
												<li>
													<b>4 sided bag Bag:</b> Looking down at the top of your bag, enter the dimensions (D1) and (D2) of the bag opening.
												</li>
												<li>
													<b>Bottle or Jar:</b> Enter the inside diameter of the bottle or can opening (D).
												</li>
											</ul>
										</div>
										<ul class="field-type-textfield field-name-dimensions">
											<li class="width">
												<label>Width in inches</label>
												<input type="text" name="widthInchesSpout3Default" <?php if (!empty(
														$widthInchesSpout3Default)
														&& ($missing || $errors)) {
													echo 'value="'
															. htmlentities(
																	$widthInchesSpout3Default,
																	ENT_COMPAT,
																	'UTF-8')
															. '"';
												}
																								   ?>/>
											</li>
											<li class="d1">
												<label>D1</label>
												<input type="text" name="d1InchesSpout3Default" <?php if (!empty(
																										   $d1InchesSpout3Default)
																										   && ($missing
																												   || $errors)) {
																									   echo 'value="'
																											   . htmlentities(
																													   $d1InchesSpout3Default,
																													   ENT_COMPAT,
																													   'UTF-8')
																											   . '"';
																								   }
																								?>/>
											</li>
											<li class="d2">
												<label>D2</label>
												<input type="text" name="d2InchesSpout3Default" <?php if (!empty(
																										$d2InchesSpout3Default)
																										&& ($missing
																												|| $errors)) {
																									echo 'value="'
																											. htmlentities(
																													$d2InchesSpout3Default,
																													ENT_COMPAT,
																													'UTF-8')
																											. '"';
																								}
																								?>/>
											</li>
											<li class="diameter">
												<label>Diameter in inches</label>
												<input type="text" name="diameterInchesSpout3Default" <?php if (!empty(
																										$diameterInchesSpout3Default)
																										&& ($missing
																												|| $errors)) {
																									echo 'value="'
																											. htmlentities(
																													$diameterInchesSpout3Default,
																													ENT_COMPAT,
																													'UTF-8')
																											. '"';
																								}
																									  ?>/>
											</li>
										</ul>
										<?php if (isset($errors['widthSpout3'])) { ?>
                  							<label class="error clear">Please enter a width measurement in the 'Width in inches' field</label>
                						<?php } elseif (isset(
		$errors['d1d2Spout3'])) {
										?>
                  							<label class="error clear">Please enter a measurement in both the 'D1' & 'D2' fields</label>
                						<?php } elseif (isset(
		$errors['diameterSpout3'])) {
										?>
                  								<label class="error clear">Please enter a diameter measurement in the 'Diameter in inches' field</label>
                						<?php } ?>
										<div class="container-shape-images">
											<div class="spout-sprite flat-bag ir">
												Flat bag spout shape image
											</div>
											<div class="spout-sprite four-sided-bag ir">
												4 sided bag spout shape image
											</div>
											<div class="spout-sprite can-jar ir">
												Can or Jar spout shape image
											</div>
										</div>
									</fieldset>

								</div>
								<button type="button" id="btnDel" value="Remove spout" class="hidden">
									Remove spout
								</button>
								<button type="button" id="btnAdd" value="Add another spout" class="hidden">
									Add another spout
								</button>
							</div><!-- id="step-4" -->

							<div id="step-5" class="step-container" name="step-5">
								<div id="quote-summary" class="hidden">
									<h3>Your Quote Summary</h3>
									<table>
										<thead>
											<tr>
												<th>Item</th><th>Description</th><th>Price</th>
											</tr>
										</thead>
										<tbody id="results">
											<tr>
												<td>Model S-4</td><td>Standard with small weigh hopper and small discharge funnel</td><td>$6,150</td>
											</tr>
											<tr>
												<td>Small weighhopper</td><td>Standard weigh hopper</td><td>$0</td>
											</tr>
											<tr>
												<td>Small Funnel</td><td>Standard sized funnel</td><td>$0</td>
											</tr>
											<tr class="total">
												<td colspan="2">Total Price:</td><td>$6,150</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div id="emailQuote">
									<fieldset id="field-name-message-details">
										<legend>
											Message details
										</legend>
										<label for="to">To *</label>
										<input type="text" id="to" name="to" <?php if (!empty(
		$to) && ($missing || $errors)) {
	echo 'value="' . htmlentities($to, ENT_COMPAT, 'UTF-8') . '"';
}
																			 ?>/>
											<?php if ($missing
																					 && in_array(
																							 'to',
																							 $missing)) {
											?>
                  							<label class="error">Please enter your email address</label>
                							<?php } elseif (isset($errors['to'])) { ?>
                  							<label class="error">Invalid email address</label>
                							<?php } ?>
										<div class="instructions">
											<p>
												Enter the main email address that you would like to send the quote to.
											</p>
										</div>
										<label for="to">Cc</label>
										<input type="text" id="cc" name="cc" <?php if (!empty(
		$cc) && ($missing || $errors)) {
	echo 'value="' . htmlentities($cc, ENT_COMPAT, 'UTF-8') . '"';
}
																			 ?>/>
											<?php if (isset($errors['cc'])) { ?>
                  							<label class="error">Invalid email address</label>
                							<?php } ?>
										<div class="instructions">
											<p>
												Copy in an additional email address to receive the quote.
											</p>
										</div>
										<label for="message">Message (optional)</label>
										<textarea rows="5" id="message" name="message"><?php if (!empty(
		$message) && ($missing || $errors)) {
	echo htmlentities($message, ENT_COMPAT, 'UTF-8');
}
																					   ?></textarea>
										<input type="submit" id="btnSubmit" name="btnSubmit" value="Calculate Quote" />
											<p class="instructions">
												Your quote will be sent only to the recipients you have designated.
											</p>
									</fieldset>
								</div>
								<div id="submit_buttons">
									<button type="button" id="btnPrint" value="Print your quote" class="hidden">
										Print your quote
									</button>
									<button type="button" id="btnEmail" value="Email your quote" class="hidden">
										Email your quote
									</button>

								</div>
							</div>

						</div><!-- id="form-pages" -->

						<div id="hidden-accessories-page" name="hidden-accessories-page"  class="hidden bottom">
							<button id="btnClose" value="X" class="hidden" >
								X
							</button>
							<h3>Accessory Page</h3>
							<button id="btnContinue" value="Continue" class="hidden">
								Continue
							</button>
						</div>

					</form>
				</article>

				<aside id="sidebar" class="clearfix hidden">
					<div id="machine-image-container">
						<button id="btnFront" value="Front view" class="hidden active">
							Front view
						</button>
						<button id="btnSide" value="Side view" class="hidden">
							Side view
						</button>
						<p>
							This is how YOUR customized machine will look
						</p>
						<div id="machine-image" class="ir s4 smwh std-fnl front">
							<div class="machine-bg">
								&nbsp;
							</div>
							<div class="weigh-hopper ">
								&nbsp;
							</div>
							<div class="funnel">
								&nbsp;
							</div>
							<div class="spout hidden">
								&nbsp;
							</div>
						</div>
						<h3 id="machine-title" class="hidden">S-4 Weigh/Fill System</h3>
						<p id="cost-container">
							Price as configured: <span class="price">$<span class="amount">6150</span></span>
						</p>
					</div>
				</aside>
				<a href="#hidden-accessories-page" id="hidden-accessories-page-btn" class="ir">Add Accessories</a>
			</section>

			<footer id="footer" class="clearfix clear">
				<hr>
				<p class="style10 f-fp f-lp">
					<strong><span class="style13">Logical Machines
						<br>
					</span></strong><span class="style11">1158 Roscoe Road, Charlotte, Vermont 05445 USA &#8226; (802) 425-2888 &#8226; (802) 425-5667 (fax)
						<br>
						&#108;&#109;&#105;&#110;&#107;&#108;&#101;&#114;&#64;&#108;&#111;&#103;&#105;&#99;&#97;&#108;&#109;&#97;&#99;&#104;&#105;&#110;&#101;&#115;&#46;&#99;&#111;&#109;</span>
				</p>
			</footer>

		</div><!-- id="PageDiv" end -->

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script>
            window.jQuery || document.write('<script src="js/vendor/jquery-1.8.3.min.js"><\/script>')
		</script>
		<script src="js/plugins.js"></script>
		<script src="js/main.js"></script>

		<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
		<script>
            var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
            ( function(d, t) {
                    var g = d.createElement(t), s = d.getElementsByTagName(t)[0];
                    g.src = ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js';
                    s.parentNode.insertBefore(g, s)
                }(document, 'script'));
		</script>
	</body>
</html>
