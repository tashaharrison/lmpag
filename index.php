<?php
// define variables and initialize with empty values
$machineModel = "";
$weighHopper = "";
$dischargeFunnel = "";
$recipient = "";
$text = "";

$recipientErr = "";
$textErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$machineModel = $_POST["machine-model"];
	$weighHopper = $_POST["weigh-hopper"];
	$dischargeFunnel = $_POST["discharge-funnel"];
	$recipient = $_POST["recipient"];
	$text = $_POST["message"];
	
	if (!filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
		$recipientErr = "Please enter a valid email address.";
	} elseif (empty($_POST["message"])) {
		$textErr = "Missing";
	} else {
		$recipient = $_POST["recipient"];
		$text = $_POST["message"];
		require_once 'bin/swiftmailer/lib/swift_required.php';

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
		$text = $_POST['message'];
		$to = urldecode($_POST['recipient']);
		$messageHTML = "Text of the message : " . urldecode($text)
				. " The full response is: ";

		// Create a message
		$emailMessage = Swift_Message::newInstance(
				'Logical Machines Quote Generator')
				->setBody($messageHTML, 'text/html')
				->setFrom(
						array('pete@spirelightmedia.com' => 'Logical Machines'))
				->setSender('pgjainsworth@gmail.com')
				->setReturnPath('pgjainsworth@gmail.com')
				->setBcc(array('pgjainsworth@gmail.com'))->setMaxLineLength(78)
				->setTo(array($to));

		if ($mailer->send($emailMessage)) {
			$response = "<div class=\"success\"><p>Thank you. Your email has been successfully sent.</p></div>";
		} else {
			$response = "<div class=\"warning\"><p>I'm sorry we were unable to send your quote by email. Please check the email addresses that you entered and try again.</p></div>";
		}
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
					<form method="post" name="logical-machines-quote-generator" id="logical-machines-quote-generator" action="<?php echo htmlspecialchars(
							$_SERVER["PHP_SELF"]);
																															  ?>">
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
										<input type="radio" id="s4" class="radio active" name="machine-model" 
										<?php if (isset($machineModel) && $machineModel == "S-4") echo "checked"; ?> 
										value="S-4" checked="checked" />
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
										<input type="radio" id="s5" name="machine-model" 
										<?php if (isset($machineModel) && $machineModel == "S-5") echo "checked"; ?> 
										value="S-5" />
										<label for="s5"><h4><span class="name">S-5</span>&nbsp;<span class="type">Bulk Fill System</span></h4>
											<p class="description">
												The standard S-5 includes... It comes fully assembled and ready to operate.
											</p> <!-- class="machine-model-description" -->
											<p class="price clear">
												<b>Price: </b>$<span class="amount">5450</span>
											</p></label>
									</li>
									<li>
										<input type="radio" id="s6" name="machine-model" 
										<?php if (isset($machineModel) && $machineModel == "S-6") echo "checked"; ?> 
										value="S-6" />
										<label for="s6"><h4><span class="name">S-6</span>&nbsp;<span class="type">Cascading Weigh FIller</span></h4>
											<p class="description">
												The standard S-6 includes... It comes fully assembled and ready to operate.
											</p> <!-- class="machine-model-description" -->
											<p class="price clear">
												<b>Price: </b>$<span class="amount">9950</span>
											</p></label>
									</li>
									<li>
										<input type="radio" id="s7" name="machine-model" 
										<?php if (isset($machineModel) && $machineModel == "S-7") echo "checked"; ?> 
										value="S-7" />
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
										<input type="radio" id="smwh" class="active" name="weigh-hopper" value="small-weigh-hopper" checked="checked"/>
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
										<input type="radio" id="lrgwh" name="weigh-hopper" value="large-weigh-hopper" />
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
										<input type="radio" id="small-std-fnl" name="discharge-funnel" value="small-standard-funnel" />
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
										<input type="radio" id="small-steep-fnl" name="discharge-funnel" value="small-steep-funnel" />
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
										<input type="radio" id="large-std-fnl" name="discharge-funnel" value="large-standard-funnel" />
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
										<input type="radio" id="large-steep-fnl" name="discharge-funnel" value="large-steep-funnel" />
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
										<input type="radio" id="std-fnl" class="active" name="discharge-funnel" value="standard-discharge-funnel" checked="checked" />
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
										<input type="radio" id="steep-fnl" name="discharge-funnel" value="steep-funnel" />
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
														Flag bag spout image
													</div><h4 class="name">Flag bag</h4></label>
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
												Flag bag spout shape image
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
												<input type="radio" id="type0Spout1Default" name="typeSpout1Default" value="flag-bag" />
												<label for="type0Spout1Default">
													<div class="spout-sprite flat-bag-spout ir">
														Flag bag spout image
													</div><h4>Flag bag</h4></label>
											</li>
											<li class="four-sided-bag">
												<input type="radio" id="type1Spout1Default" name="typeSpout1Default" value="four-sided-bag" />
												<label for="type1Spout1Default">
													<div class="spout-sprite four-sided-bag-spout ir">
														4 sided bag spout image
													</div><h4>4 sided bag</h4></label>
											</li>
											<li class="can-jar">
												<input type="radio" id="type2Spout1Default" name="typeSpout1Default" value="can-jar" />
												<label for="type2Spout1Default">
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
												<input type="text" name="widthInchesSpout1Default" />
											</li>
											<li class="d1">
												<label>D1</label>
												<input type="text" name="d1InchesSpout1Default" />
											</li>
											<li class="d2">
												<label>D2</label>
												<input type="text" name="d2InchesSpout1Default" />
											</li>
											<li class="diameter">
												<label>Diameter in inches</label>
												<input type="text" name="diameterInchesSpout1Default" />
											</li>
										</ul>
										<div class="container-shape-images">
											<div class="spout-sprite flat-bag ir">
												Flag bag spout shape image
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
												<input type="radio" id="type0Spout2Default" name="typeSpout2Default" value="flag-bag" />
												<label for="type0Spout2Default">
													<div class="spout-sprite flat-bag-spout ir">
														Flag bag spout image
													</div><h4>Flag bag</h4></label>
											</li>
											<li class="four-sided-bag">
												<input type="radio" id="type1Spout2Default" name="typeSpout2Default" value="four-sided-bag" />
												<label for="type1Spout2Default">
													<div class="spout-sprite four-sided-bag-spout ir">
														4 sided bag spout image
													</div><h4>4 sided bag</h4></label>
											</li>
											<li class="can-jar">
												<input type="radio" id="type2Spout2Default" name="typeSpout2Default" value="can-jar" />
												<label for="type2Spout2Default">
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
												<input type="text" name="widthInchesSpout2Default" />
											</li>
											<li class="d1">
												<label>D1</label>
												<input type="text" name="d1InchesSpout2Default" />
											</li>
											<li class="d2">
												<label>D2</label>
												<input type="text" name="d2InchesSpout2Default" />
											</li>
											<li class="diameter">
												<label>Diameter in inches</label>
												<input type="text" name="diameterInchesSpout2Default" />
											</li>
										</ul>
										<div class="container-shape-images">
											<div class="spout-sprite flat-bag ir">
												Flag bag spout shape image
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
												<input type="radio" id="type0Spout3Default" name="typeSpout3Default" value="flag-bag" />
												<label for="type0Spout3Default">
													<div class="spout-sprite flat-bag-spout ir">
														Flag bag spout image
													</div><h4>Flag bag</h4></label>
											</li>
											<li class="four-sided-bag">
												<input type="radio" id="type1Spout3Default" name="typeSpout3Default" value="four-sided-bag" />
												<label for="type1Spout3Default">
													<div class="spout-sprite four-sided-bag-spout ir">
														4 sided bag spout image
													</div><h4>4 sided bag</h4></label>
											</li>
											<li class="can-jar">
												<input type="radio" id="type2Spout3Default" name="typeSpout3Default" value="can-jar" />
												<label for="type2Spout3Default">
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
												<input type="text" name="widthInchesSpout3Default" />
											</li>
											<li class="d1">
												<label>D1</label>
												<input type="text" name="d1InchesSpout3Default" />
											</li>
											<li class="d2">
												<label>D2</label>
												<input type="text" name="d2InchesSpout3Default" />
											</li>
											<li class="diameter">
												<label>Diameter in inches</label>
												<input type="text" name="diameterInchesSpout3Default" />
											</li>
										</ul>
										<div class="container-shape-images">
											<div class="spout-sprite flat-bag ir">
												Flag bag spout shape image
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
									<h3>You Quote Summary</h3>
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
										<label for="recipient">To *</label>
										<input type="text" id="recipient" name="recipient" value="<?php echo htmlspecialchars(
																																	  $recipient); ?>"/>
										<span class="error"><?php echo $recipientErr; ?></span>
										<div class="instructions">
											<p>
												Enter as many email addresses as you'd like separated by a comma.
											</p>
										</div>
										<label for="message">Message (optional)</label>
										<textarea rows="5" id="message" name="message"><?php echo htmlspecialchars(
																																	  $text); ?></textarea>
										<span class="error"><?php echo $textErr; ?></span>
										<input type="submit" id="btnSubmit" value="Calculate Quote" />
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
