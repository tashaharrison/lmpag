<?php
		//Please note that the standard weigh hopper and the small weigh hopper are the same. 
$spoutSizes = "0.5, 0.75, 1, 1.25, 1.5, 1.75, 2, 2.25, 2.5, 2.75, 3, 3.25, 3.5";
$settings = array(
		// Machine settings
		"machinemodel" => array(
				"S-4" => array("name" => "S-4", "type" => "Weigh Fill System",
						"description" => "The standard S-4 includes the standard weigh hopper, small discharge funnel and Logical Controller II. It comes fully assembled and ready to operate.",
						"price" => "6150"),
				"S-5" => array("name" => "S-5", "type" => "Bulk Fill System",
						"description" => "The S-5 includes a standard Discharge Funnel, and Logical Controller II. It comes fully assembled and ready to operate. ",
						"price" => "5450"),
				"S-6" => array("name" => "S-6",
						"type" => "Cascading Weigh Filler",
						"description" => "The S-6 includes a standard Weigh Hopper, standard Discharge Chute, and Logical Controller II. It comes fully assembled and ready to operate.",
						"price" => "9950"),
				"S-7" => array("name" => "S-7",
						"type" => "Dual-Lane Weigh Filler",
						"description" => "The S-7 includes two standard Weigh Hoppers, standard S-7 Discharge Chute, and two Logical Controller IIs. It comes fully assembled and ready to operate. ",
						"price" => "12000")),
		// Weigh hopper settings
		"weighhopper" => array(
				"no-weigh-hopper" => array("name" => " ",
						"description" => "The S-5 uses a table-style scale instead of a Weigh Hopper.",
						"price" => "0"),
				"small-weigh-hopper" => array("name" => "250 cubic inch Small Weigh Hopper",
						"description" => "The small weigh hopper comes by default. Its 250 cubic inch capacity (about a gallon of dry measure) handles net weights from a few grams to 3 lbs.",
						"price" => "0"),
				"standard-weigh-hopper" => array("name" => "250 cubic inch Standard Weigh Hopper",
						"description" => "The standard weigh hopper comes by default. Its 250 cubic inch capacity (about a gallon of dry measure) handles net weights from a few grams to 3 lbs.",
						"price" => "0"),
				"large-weigh-hopper" => array("name" => "650 cubic inch Large Weigh Hopper",
						"description" => "For larger volumes, the large weigh hopper's 650 cubic inch capacity (about 2.5 gallons of dry measure) handles net weights from 2 oz. to 10 lbs.",
						"price" => "100"),
				"large-weigh-hopper-two" => array("name" => "650 cubic inch Large Weigh Hopper",
						"description" => "For larger volumes, the large weigh hopper's 650 cubic inch capacity (about 2.5 gallons of dry measure) handles net weights from 2 oz. to 10 lbs.",
						"price" => "200")),
		// Discharge funnel settings > Fallback copy for use when Javascript is disabled
		"dischargefunnel" => array(
				"standard" => array("name" => "Standard Discharge Funnel",
						"description" => "This is the standard funnel for use with the standard and large weigh hoppers. It is practical for most free-flowing materials."),
				"discharge" => array("name" => "Discharge Chute",
						"description" => 'Used for larger-grained products like popcorn or crackers to allow for free flow from Weigh Hopper. Comes with a standard 5" Discharge Chute.'),
				"steep" => array("name" => "Steep-Sided Discharge Funnel",
						"description" => "This steep sided funnel is used for fine powdered materials such as flour or other products that can stick to metal surfaces."),
				// Discharge funnel settings > Normal copy for use when Javascript is enabled
				"small" => array(
						"standard" => array(
								"name" => "Standard Discharge Funnel",
								"description" => "This is the standard funnel for use with the standard weigh hopper. It works best for free flowing products.",
								"price" => "0"),
						"discharge" => array("name" => "Discharge Chute",
							"description" => "Used for larger-grained products like popcorn or crackers to allow for free flow from Weigh Hopper. Comes in 3.5”, 4.5”, 5” standard sizes.",
							"price" => "0"),
						"steep" => array(
								"name" => "Steep-Sided Discharge Funnel",
								"description" => "This steep sided funnel is used for fine powdered materials such as flour or other products that can stick to metal surfaces.",
								"price" => "125")),
				"large" => array(
						"standard" => array(
								"name" => "Large Discharge Funnel",
								"description" => "This is the standard funnel for use with the large weigh hopper. It works best with free flowing products.",
								"price" => "150"),
						"steep" => array(
								"name" => "Large Steep-Sided Discharge Funnel",
								"description" => "This steep sided funnel is used for fine powdered materials such as flour or other products that can stick to metal surfaces.",
								"price" => "400"))),
		"spout" => array("price" => "150",
				"type" => array("flat-bag" => array("width"),
						"four-sided-bag" => array("d1", "d2"),
						"can-jar" => array("diameter"))));


include_once 'bin/php_validation.php';

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
		<div id="PageDiv" class="top">
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
								<ul id="field-name-machine-model" class="field-container field-type-radio label-format-block">
									<li class="s4">
										<input type="radio" id="s4" class="radio" name="machinemodel" value="S-4" 
										/>
										<label for="s4"><h4><span class="name"><?php echo $settings["machinemodel"]["S-4"]["name"]; ?></span>&nbsp;<span class="type"><?php echo $settings["machinemodel"]["S-4"]["type"]; ?></span></h4>
											<div class="description">
												<?php echo $settings["machinemodel"]["S-4"]["description"]; ?>
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
														 Standard chassis:
														<ul>
															<li>Powder Coated</li>
															<li>Footprint 4.6 sq.ft., 67" high</li>
															<li>4 locking casters</li>
														</ul>
													</li>
													<li>
														All product contact surfaces 304 stainless steel
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
														Up to 800 fills/hour
													</li>
												</ul>
											</div>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["machinemodel"]["S-4"]["price"]; ?></span>
											</p></label>
									</li>

									<li class="s5">
										<input type="radio" id="s5" name="machinemodel" value="S-5" 
										<?php
											if ($_POST && $_POST['machinemodel'] == 'S-5') {
												echo 'checked';
											}
										?>/>
										<label for="s5"><h4><span class="name"><?php echo $settings["machinemodel"]["S-5"]["name"]; ?></span>&nbsp;<span class="type"><?php echo $settings["machinemodel"]["S-5"]["type"]; ?></span></h4>
											<div class="description">
												<?php echo $settings["machinemodel"]["S-5"]["description"]; ?>
												<h5>S-5 Specifications:</h5>
												<ul>
													<li>
														Bulk filling for weights of up to 50lbs.
													</li>
													<li>
														Self-adjusting controller 
													</li>
													<li>
														Reads out to .01 lbs.
													</li>
													<li>
														Controller range up to 50lbs., 3.5cu.ft. hopper
													</li>
													<li>
														 Support Frame:
														<ul>
															<li>Powder Coated</li>
															<li>Footprint 4.6 sq.ft., 67" high</li>
															<li>4 locking casters</li>
														</ul>
													</li>
													<li>
														All product contact surfaces 304 stainless steel
													</li>
													<li>
														120V, 60Hz (240V, 50Hz option)
													</li>
													<li>
														 Handles all dry bulk products from powders to large parts
													</li>
													<li>
														Can be used with all bags or rigid containers 
													</li>
													<li>
														Automatic tare adjustment
													</li>
													<li>
														On-the-fly, self-adjusting bulk &amp; dribble speed control
													</li>
													<li>
														Up to 400 fills/hour
													</li>
												</ul>
											</div>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["machinemodel"]["S-5"]["price"]; ?></span>
											</p></label>
									</li>
									<li class="s6">
										<input type="radio" id="s6" name="machinemodel" value="S-6" 
										<?php
if ($_POST && $_POST['machinemodel'] == 'S-6') {
	echo 'checked';
}
										?>/>
										<label for="s6"><h4><span class="name"><?php echo $settings["machinemodel"]["S-6"]["name"]; ?></span>&nbsp;<span class="type"><?php echo $settings["machinemodel"]["S-6"]["type"]; ?></span></h4>
											<div class="description">
												<?php echo $settings["machinemodel"]["S-6"]["description"]; ?>
												<h5>S-6 Specifications:</h5>
												<ul>
													<li>
														Cascading feed pans 
													</li>
													<li>
														Self-adjusting controller 
													</li>
													<li>
														Reads out to 1 gram or .001 lbs.
													</li>
													<li>
														Controller range up to 10 lbs.
													</li>
													<li>
														Supply hopper 3.5 cu.ft.
													</li>
													<li>
														All product surfaces 304 stainless steel
													</li>
													<li>
														Discharge Chute
													</li>
													<li>
														 Support Frame:
														<ul>
															<li>Powder Coated</li>
															<li>Footprint 7.5 sq.ft., 74.5" high</li>
															<li>4 locking casters</li>
														</ul>
													</li>
													<li>
														120V, 60Hz (240V, 50Hz option)
													</li>
													<li>
														 Handles all dry bulk products from powders to large parts
													</li>
													<li>
														Compatible with all bags, rigid containers, bagging machines and conveyors 
													</li>
													<li>
														Automatic tare adjustment
													</li>
													<li>
														On-the-fly, self-adjusting bulk &amp; dribble speed control
													</li>
													<li>
														Up to 800 fills/hour
													</li>
												</ul>
											</div>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["machinemodel"]["S-6"]["price"]; ?></span>
											</p></label>
									</li>
									<li class="s7">
										<input type="radio" id="s7" name="machinemodel" value="S-7" 
										<?php
if ($_POST && $_POST['machinemodel'] == 'S-7') {
	echo 'checked';
}
										?>/>
										<label for="s7"><h4><span class="name"><?php echo $settings["machinemodel"]["S-7"]["name"]; ?></span>&nbsp;<span class="type"><?php echo $settings["machinemodel"]["S-7"]["type"]; ?></span></h4>
											<div class="description">
												<?php echo $settings["machinemodel"]["S-7"]["description"]; ?>
												<h5>S-7 Specifications:</h5>
												<ul>
													<li>
														Two lanes for twice the speed 
													</li>
													<li>
														Self-adjusting controller 
													</li>
													<li>
														Reads out to 1 gram or .001 lbs.
													</li>
													<li>
														Controller range up to 10 lbs.
													</li>
													<li>
														5.1 cu.ft. supply hopper
													</li>
													<li>
														All product surfaces 304 stainless steel
													</li>
													<li>
														 Support Frame:
														<ul>
															<li>Powder Coated</li>
															<li>Footprint 7.25 sq.ft., 68" high</li>
															<li>4 locking casters</li>
														</ul>
													</li>
													<li>
														120V, 60Hz (240V, 50Hz option)
													</li>
													<li>
														 Handles all dry bulk products from powders to large parts
													</li>
													<li>
														Compatible with all bags, rigid containers, and bagging machines 
													</li>
													<li>
														Automatic tare adjustment
													</li>
													<li>
														On-the-fly, self-adjusting bulk &amp; dribble speed control
													</li>
													<li>
														Up to 1500 fills/hour
													</li>
												</ul>
											</div>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["machinemodel"]["S-7"]["price"]; ?></span>
											</p></label>
									</li>
								</ul>
							</div><!-- id="step-1" -->

							<div id="step-2" class="step-container" name="step-2">
								<h3>Select your Weigh Hopper</h3>
								<p class="not-wh5">
									The <b>Weigh Hopper</b> is the scale portion of the unit which handles and weighs your products. Select a hopper by clicking its image.
								</p>
								<p class="wh5">
									The S-5 uses a table-style scale instead of a Weigh Hopper. Please click the "Next Step” arrow below to select a Discharge Funnel.
								</p>
								<ul id="field-name-weigh-hopper" class="field-type-radio field-container label-format-block">
									<li class="small">
										<input type="radio" id="no-wh" class="active" name="weighhopper" value="small-weigh-hopper" 
										/>
										<label for="no-wh" class="clearfix"><h4 class="name"><?php echo $settings["weighhopper"]["no-weigh-hopper"]["name"]; ?></h4>
											<div class="component-image ir">
												Small Weigh Hopper image
											</div>
											<p class="description">
												<?php echo $settings["weighhopper"]["no-weigh-hopper"]["description"]; ?>
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["weighhopper"]["no-weigh-hopper"]["price"]; ?></span> included on standard <span class="machine-name"></span>
											</p></label>

									</li>
									<li class="small">
										<input type="radio" id="smwh" class="active" name="weighhopper" value="small-weigh-hopper" 
										/>
										<label for="smwh" class="clearfix"><h4 class="name"><?php echo $settings["weighhopper"]["small-weigh-hopper"]["name"]; ?></h4>
											<div class="component-image ir">
												Small Weigh Hopper image
											</div>
											<p class="description">
												<?php echo $settings["weighhopper"]["small-weigh-hopper"]["description"]; ?>
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["weighhopper"]["small-weigh-hopper"]["price"]; ?></span> included on standard <span class="machine-name"></span>
											</p></label>

									</li>
									<li class="small">
										<input type="radio" id="stwh" class="active" name="weighhopper" value="standard-weigh-hopper" 
										<?php
if (!$_POST || ($_POST && $_POST['weighhopper'] == 'standard-weigh-hopper')) {
	echo 'checked';
}
										?>/>
										<label for="stwh" class="clearfix"><h4 class="name"><?php echo $settings["weighhopper"]["standard-weigh-hopper"]["name"]; ?></h4>
											<div class="component-image ir">
												Standard Weigh Hopper image
											</div>
											<p class="description">
												<?php echo $settings["weighhopper"]["standard-weigh-hopper"]["description"]; ?>
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["weighhopper"]["standard-weigh-hopper"]["price"]; ?></span> included on standard <span class="machine-name"></span>
											</p></label>

									</li>
									<li class="large">
										<input type="radio" id="lrgwh" class="" name="weighhopper" value="large-weigh-hopper" 
										<?php
if ($_POST && $_POST['weighhopper'] == 'large-weigh-hopper') {
	echo 'checked';
}
										?>/>
										<label for="lrgwh" class="clearfix"><h4 class="name"><?php echo $settings["weighhopper"]["large-weigh-hopper"]["name"]; ?></h4>
											<div class="component-image ir">
												Large Weigh Hopper image
											</div>
											<p class="description">
												<?php echo $settings["weighhopper"]["large-weigh-hopper"]["description"]; ?>
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["weighhopper"]["large-weigh-hopper"]["price"]; ?></span> upcharge
											</p></label>

									</li>
									<li class="large">
										<input type="radio" id="lrgwh2" class="" name="weighhopper" value="large-weigh-hopper-two" 
										<?php
if ($_POST && $_POST['weighhopper'] == 'large-weigh-hopper') {
	echo 'checked';
}
										?>/>
										<label for="lrgwh2" class="clearfix"><h4 class="name"><?php echo $settings["weighhopper"]["large-weigh-hopper-two"]["name"]; ?></h4>
											<div class="component-image ir">
												Large Weigh Hopper image
											</div>
											<p class="description">
												<?php echo $settings["weighhopper"]["large-weigh-hopper-two"]["description"]; ?>
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["weighhopper"]["large-weigh-hopper-two"]["price"]; ?></span> upcharge
											</p></label>

									</li>
								</ul>
							</div><!-- id="step-2" -->

							<div id="step-3" class="step-container" name="step-3">
								<h3>Select your Discharge Funnel</h3>
								<p>
									The <b>Discharge Funnel</b> directs your product from the weigh hopper to the spout. Select a funnel by clicking its image.
								</p>
								<p class="fu6">
									The S-6 comes standard with a 5” Discharge Chute. Custom sized Chutes are available upon request.
								</p>
								<ul id="field-name-discharge-funnel" class="field-type-radio field-container label-format-block">
									<li class="small hidden">
										<input type="radio" id="small-std-fnl" name="dischargefunnel" value="small-standard-funnel" />
										<label for="small-std-fnl" class="std-fnl clearfix"><h4 class="name"><?php echo $settings["dischargefunnel"]["small"]["standard"]["name"]; ?></h4>
											<div class="component-image ir">
												Small Standard Discharge Funnel image
											</div>
											<p class="description">
												<?php echo $settings["dischargefunnel"]["small"]["standard"]["description"]; ?>
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["dischargefunnel"]["small"]["standard"]["price"]; ?></span> included on standard <span class="machine-name"></span>
											</p></label>
									</li>
									<li class="small hidden">
										<input type="radio" id="small-steep-fnl" name="dischargefunnel" value="small-steep-funnel" />
										<label for="small-steep-fnl" class="steep-fnl clearfix"><h4 class="name"><?php echo $settings["dischargefunnel"]["small"]["steep"]["name"]; ?></h4>
											<div class="component-image ir">
												Small Steep-Sided Discharge image
											</div>
											<p class="description">
												<?php echo $settings["dischargefunnel"]["small"]["steep"]["description"]; ?>
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["dischargefunnel"]["small"]["steep"]["price"]; ?></span> upcharge
											</p></label>
									</li>
									<li class="discharge-cht hidden">
										<input type="radio" id="discharge-cht" name="dischargefunnel" value="discharge-cht" />
										<label for="discharge-cht" class="discharge-cht clearfix"><h4 class="name"><?php echo $settings["dischargefunnel"]["discharge"]["name"]; ?></h4>
											<div class="component-image ir">
												Discharge Chute
											</div>
											<p class="description">
												<?php echo $settings["dischargefunnel"]["small"]["discharge"]["description"]; ?>
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["dischargefunnel"]["small"]["discharge"]["price"]; ?></span> included on standard <span class="machine-name"></span>
											</p></label>
									</li>
									<li class="large hidden">
										<input type="radio" id="large-std-fnl" name="dischargefunnel" value="large-standard-funnel" />
										<label for="large-std-fnl" class="std-fnl clearfix"><h4 class="name"><?php echo $settings["dischargefunnel"]["large"]["standard"]["name"]; ?></h4>
											<div class="component-image ir">
												Large Standard Discharge Funnel image
											</div>
											<p class="description">
												<?php echo $settings["dischargefunnel"]["large"]["standard"]["description"]; ?>
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["dischargefunnel"]["large"]["standard"]["price"]; ?></span>
											</p></label>
									</li>
									<li class="large hidden">
										<input type="radio" id="large-steep-fnl" name="dischargefunnel" value="large-steep-funnel" />
										<label for="large-steep-fnl" class="steep-fnl clearfix"><h4 class="name"><?php echo $settings["dischargefunnel"]["large"]["steep"]["name"]; ?></h4>
											<div class="component-image ir">
												Large Steep-Sided Discharge image
											</div>
											<p class="description">
												<?php echo $settings["dischargefunnel"]["large"]["steep"]["description"]; ?>
											</p>
											<p class="price clear">
												<b>Price: </b>$<span class="amount"><?php echo $settings["dischargefunnel"]["large"]["steep"]["price"]; ?></span> upcharge
											</p></label>
									</li>
									<li class="small fallback-discharge-funnel">
										<input type="radio" id="std-fnl" class="active" name="dischargefunnel" value="standard-funnel" 
										<?php
if (!$_POST || ($_POST && $_POST['dischargefunnel'] == 'standard-funnel')) {
	echo 'checked';
}
										?>/>
										<label for="std-fnl" class="std-fnl clearfix"><h4 class="name"><?php echo $settings["dischargefunnel"]["standard"]["name"]; ?></h4>
											<div class="component-image ir">
												Standard Discharge Funnel image
											</div>
											<p class="description">
												<?php echo $settings["dischargefunnel"]["standard"]["description"]; ?>
											</p>
											<p class="price clear">
												<b>Price with Standard Weigh Hopper: </b>
												<br/>
												$<span class="amount"><?php echo $settings["dischargefunnel"]["small"]["standard"]["price"]; ?></span> included on standard <span class="machine-name"></span>
												<br />
												<b>Price with Large Weigh Hopper: </b>
												<br/>
												$<span class="amount"><?php echo $settings["dischargefunnel"]["small"]["steep"]["price"]; ?></span>
											</p></label>

									</li>
									<li class="small fallback-discharge-funnel">
										<input type="radio" id="steep-fnl" name="dischargefunnel" value="steep-funnel" 
										<?php
if ($_POST && $_POST['dischargefunnel'] == 'steep-funnel') {
	echo 'checked';
}
										?>/>
										<label for="steep-fnl" class="steep-fnl clearfix"><h4 class="name"><?php echo $settings["dischargefunnel"]["steep"]["name"]; ?></h4>
											<div class="component-image ir">
												Steep-Sided Discharge image
											</div>
											<p class="description">
												<?php echo $settings["dischargefunnel"]["steep"]["description"]; ?>
											</p>
											<p class="price clear">
												<b>Price with Small Weigh Hopper: </b>
												<br/>
												$<span class="amount"><?php echo $settings["dischargefunnel"]["large"]["standard"]["price"]; ?></span> upcharge
												<br />
												<b>Price with Large Weigh Hopper: </b>
												<br/>
												$<span class="amount"><?php echo $settings["dischargefunnel"]["large"]["steep"]["price"]; ?></span> upcharge
											</p></label>
									</li>
								</ul>
							</div><!-- id="step-3" -->

							<div id="step-4" class="step-container" name="step-4">
							<input type="hidden" name="spout-price" value="<?php echo $settings["spout"]["price"] ?>" />
							<input type="hidden" name="spout-sizes" value="<?php echo $spoutSizes ?>" />
								<h3>Select your Spout</h3>
								<div class="spout-sprite main-spout-image ir">
									Spout image
								</div>
								<p class="s6-sp">
									The S-6 uses Discharge Chutes exclusively. Please click on the “Next Step” button to proceed to your Summary.
								</p>
								<p class="not-s6">
									The spout attaches to the bottom of the discharge funnel and directs the materials into your container.
								</p>
								<p class="not-s6">
									Use the <b>Spout Calculator</b> below to help you determine which size spout is right for your container. Please start with your smallest container first, then add larger ones if you have them.
								</p>
								<div id="field-name-spout" class="field-container label-format-column">
									<div id="spout1" class="spout-wrapper">
									<fieldset class="field-spout hidden">
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
										<p class="warning">The calculated spout size of <span class="calculatedSpoutSize"></span>" is the same as a spout that you have already added.<br/>Please enter different dimensions<br/>or remove this spout.<br/><button type="button" class="btnRemove" value="Remove spout">Remove</button></p>
									</fieldset>
									</div>

									<fieldset id="fallbackSpout1" class="fallback-field-spout">
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
												<input type="radio" id="type1Spout1Fallback" name="typeSpout1Fallback" value="flat-bag" 
												<?php
if ($_POST && $_POST['typeSpout1Fallback'] == 'flat-bag') {
	echo 'checked';
}
												?>/>

												<label for="type1Spout1Fallback">
													<div class="spout-sprite flat-bag-spout ir">
														Flat bag spout image
													</div><h4>Flat bag</h4></label>
											</li>
											<li class="four-sided-bag">
												<input type="radio" id="type2Spout1Fallback" name="typeSpout1Fallback" value="four-sided-bag" 
												<?php
												if ($_POST
														&& $_POST['typeSpout1Fallback']
																== 'four-sided-bag') {
													echo 'checked';
												}
												?>/>
												<label for="type2Spout1Fallback">
													<div class="spout-sprite four-sided-bag-spout ir">
														4 sided bag spout image
													</div><h4>4 sided bag</h4></label>
											</li>
											<li class="can-jar">
												<input type="radio" id="type3Spout1Fallback" name="typeSpout1Fallback" value="can-jar" 
												<?php
												if ($_POST
														&& $_POST['typeSpout1Fallback']
																== 'can-jar') {
													echo 'checked';
												}
												?>/>
												<label for="type3Spout1Fallback">
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
												<input type="text" name="widthSpout1Fallback" <?php if (!empty(
														$widthSpout1Fallback)
														&& ($missing || $errors)) {
													echo 'value="'
															. htmlentities(
																	$widthSpout1Fallback,
																	ENT_COMPAT,
																	'UTF-8')
															. '"';
												}
																							  ?>/>
											</li>
											<li class="d1">
												<label>D1</label>
												<input type="text" name="d1Spout1Fallback" <?php if (!empty(
																									  $d1Spout1Fallback)
																									  && ($missing
																											  || $errors)) {
																								  echo 'value="'
																										  . htmlentities(
																												  $d1Spout1Fallback,
																												  ENT_COMPAT,
																												  'UTF-8')
																										  . '"';
																							  }
																						   ?>/>
											</li>
											<li class="d2">
												<label>D2</label>
												<input type="text" name="d2Spout1Fallback" <?php if (!empty(
																								   $d2Spout1Fallback)
																								   && ($missing
																										   || $errors)) {
																							   echo 'value="'
																									   . htmlentities(
																											   $d2Spout1Fallback,
																											   ENT_COMPAT,
																											   'UTF-8')
																									   . '"';
																						   }
																						   ?>/>
											</li>
											<li class="diameter">
												<label>Diameter in inches</label>
												<input type="text" name="diameterSpout1Fallback" <?php if (!empty(
																								   $diameterSpout1Fallback)
																								   && ($missing
																										   || $errors)) {
																							   echo 'value="'
																									   . htmlentities(
																											   $d2Spout1Fallback,
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

									<fieldset id="fallbackSpout2" class="fallback-field-spout">
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
												<input type="radio" id="type1Spout2Fallback" name="typeSpout2Fallback" value="flat-bag" 
												<?php
if ($_POST && $_POST['typeSpout2Fallback'] == 'flat-bag') {
	echo 'checked';
}
												?>/>
												<label for="type1Spout2Fallback">
													<div class="spout-sprite flat-bag-spout ir">
														Flat bag spout image
													</div><h4>Flat bag</h4></label>
											</li>
											<li class="four-sided-bag">
												<input type="radio" id="type2Spout2Fallback" name="typeSpout2Fallback" value="four-sided-bag" 
												<?php
												if ($_POST
														&& $_POST['typeSpout2Fallback']
																== 'four-sided-bag') {
													echo 'checked';
												}
												?>/>
												<label for="type2Spout2Fallback">
													<div class="spout-sprite four-sided-bag-spout ir">
														4 sided bag spout image
													</div><h4>4 sided bag</h4></label>
											</li>
											<li class="can-jar">
												<input type="radio" id="type3Spout2Fallback" name="typeSpout2Fallback" value="can-jar" 
												<?php
												if ($_POST
														&& $_POST['typeSpout2Fallback']
																== 'can-jar') {
													echo 'checked';
												}
												?>/>
												<label for="type3Spout2Fallback">
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
												<input type="text" name="widthSpout2Fallback" <?php if (!empty(
														$widthSpout2Fallback)
														&& ($missing || $errors)) {
													echo 'value="'
															. htmlentities(
																	$widthSpout2Fallback,
																	ENT_COMPAT,
																	'UTF-8')
															. '"';
												}
																							  ?>/>
											</li>
											<li class="d1">
												<label>D1</label>
												<input type="text" name="d1Spout2Fallback" <?php if (!empty(
																									  $d1Spout2Fallback)
																									  && ($missing
																											  || $errors)) {
																								  echo 'value="'
																										  . htmlentities(
																												  $d1Spout2Fallback,
																												  ENT_COMPAT,
																												  'UTF-8')
																										  . '"';
																							  }
																						   ?>/>
											</li>
											<li class="d2">
												<label>D2</label>
												<input type="text" name="d2Spout2Fallback" <?php if (!empty(
																								   $d2Spout2Fallback)
																								   && ($missing
																										   || $errors)) {
																							   echo 'value="'
																									   . htmlentities(
																											   $d2Spout2Fallback,
																											   ENT_COMPAT,
																											   'UTF-8')
																									   . '"';
																						   }
																						   ?>/>
											</li>
											<li class="diameter">
												<label>Diameter in inches</label>
												<input type="text" name="diameterSpout2Fallback" <?php if (!empty(
																								   $diameterSpout2Fallback)
																								   && ($missing
																										   || $errors)) {
																							   echo 'value="'
																									   . htmlentities(
																											   $d2Spout2Fallback,
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
									
									<fieldset id="fallbackSpout3" class="fallback-field-spout">
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
												<input type="radio" id="type1Spout3Fallback" name="typeSpout3Fallback" value="flat-bag" 
												<?php
if ($_POST && $_POST['typeSpout3Fallback'] == 'flat-bag') {
	echo 'checked';
}
												?>/>
												<label for="type1Spout3Fallback">
													<div class="spout-sprite flat-bag-spout ir">
														Flat bag spout image
													</div><h4>Flat bag</h4></label>
											</li>
											<li class="four-sided-bag">
												<input type="radio" id="type2Spout3Fallback" name="typeSpout3Fallback" value="four-sided-bag" 
												<?php
												if ($_POST
														&& $_POST['typeSpout3Fallback']
																== 'four-sided-bag') {
													echo 'checked';
												}
												?>/>
												<label for="type2Spout3Fallback">
													<div class="spout-sprite four-sided-bag-spout ir">
														4 sided bag spout image
													</div><h4>4 sided bag</h4></label>
											</li>
											<li class="can-jar">
												<input type="radio" id="type3Spout3Fallback" name="typeSpout3Fallback" value="can-jar" 
												<?php
												if ($_POST
														&& $_POST['typeSpout3Fallback']
																== 'can-jar') {
													echo 'checked';
												}
												?>/>
												<label for="type3Spout3Fallback">
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
												<input type="text" name="widthSpout3Fallback" <?php if (!empty(
														$widthSpout3Fallback)
														&& ($missing || $errors)) {
													echo 'value="'
															. htmlentities(
																	$widthSpout3Fallback,
																	ENT_COMPAT,
																	'UTF-8')
															. '"';
												}
																							  ?>/>
											</li>
											<li class="d1">
												<label>D1</label>
												<input type="text" name="d1Spout3Fallback" <?php if (!empty(
																									  $d1Spout3Fallback)
																									  && ($missing
																											  || $errors)) {
																								  echo 'value="'
																										  . htmlentities(
																												  $d1Spout3Fallback,
																												  ENT_COMPAT,
																												  'UTF-8')
																										  . '"';
																							  }
																						   ?>/>
											</li>
											<li class="d2">
												<label>D2</label>
												<input type="text" name="d2Spout3Fallback" <?php if (!empty(
																								   $d2Spout3Fallback)
																								   && ($missing
																										   || $errors)) {
																							   echo 'value="'
																									   . htmlentities(
																											   $d2Spout3Fallback,
																											   ENT_COMPAT,
																											   'UTF-8')
																									   . '"';
																						   }
																						   ?>/>
											</li>
											<li class="diameter">
												<label>Diameter in inches</label>
												<input type="text" name="diameterSpout3Fallback" <?php if (!empty(
																								   $diameterSpout3Fallback)
																								   && ($missing
																										   || $errors)) {
																							   echo 'value="'
																									   . htmlentities(
																											   $diameterSpout3Fallback,
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
												<td>Model S-4</td><td>Standard with standard weigh hopper and small discharge funnel</td><td>$6,150</td>
											</tr>
											<tr>
												<td>Standard weigh hopper</td><td>Standard weigh hopper</td><td>$0</td>
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
										
										<label for="name">Customer Name *</label>
										<input type="text" id="name" name="name" <?php if (!empty(
		$name) && ($missing)) {
	echo 'value="' . htmlentities($name, ENT_COMPAT, 'UTF-8') . '"';
}
																			 ?>/>
											<?php if (isset($missing['name'])) { ?>
                  							<label class="error">Enter your name</label>
                							<?php } ?>
											
										<label for="company">Company Name *</label>
										<input type="text" id="company" name="company" <?php if (!empty(
		$company) && ($missing || $errors)) {
	echo 'value="' . htmlentities($company, ENT_COMPAT, 'UTF-8') . '"';
}
																			 ?>/>

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
											<img src="img/sending.gif" width="328" height="30" id="sending" class="hidden" />
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
						<div id="machine-image" class="ir s4 stwh std-fnl front">
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
							 <span class="title">Base Price:</span> <span class="price">$<span class="amount">0</span></span>
						</p>
					</div>
				</aside>
				<a href="#hidden-accessories-page" id="hidden-accessories-page-btn" class="ir">Add Accessories</a>
			</section>

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
