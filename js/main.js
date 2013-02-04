$(document)
		.ready(
				function() {

					// Define machine object
					function machine(machineName, machineType, machinePrice) {
						this.machineName = machineName;
						this.machineType = machineType;
						this.machinePrice = machinePrice;
					}
					// Create instances of the machine object and assign
					// properties
					machineS4 = new machine("S-4", "Weigh/Fill System", 6150);
					machineS5 = new machine("S-5", "Bulk Fill System", 5450);
					machineS6 = new machine("S-6", "Cascading Weigh FIller",
							9950);
					machineS7 = new machine("S-7", "Dual-Lane Weigh FIller",
							12000);

					// Hide fallback content and delete button
					$(
							'.large-discharge-funnel,.field-name-dimensions li,#btnDel,#step-2,#step-3,#step-4,#step-5,#hidden-accessories-page,.spout-shape-images > *')
							.hide();
					// Remove fallback form elements
					$('.default-spout,.default-discharge-funnel,#btnQuote')
							.remove();
					// .bottom class puts a negative z-index on the hidden
					// accessories page so that it loads underneath the rest of
					// the content. This removes that class on load.
					$('.bottom').removeClass('bottom');
					// Hide all but the first machine model description
					$('.machine-model-description').not(
							'.machine-model-description:first').hide();
					// Remove .hidden class from JS ready content
					$(
							'.small-discharge-funnel,.large-discharge-funnel,#btnAdd,#btnDel,#btnFront,#btnSide,.cloneSpout,.step-submit,#sidebar,#btnPrint,#btnEmail,#btnClose,#btnContinue,.order-summary,#hidden-accessories-page,#machine-title,#order-summary')
							.removeClass('hidden');
					// Check the default discharge funnel field
					$('#small-standard-discharge-funnel').prop('checked', true);

					// Add a waypoint to the sidebar
					var mi_container = $('#sidebar');
					// Remove the no-sidebar class for fallback
					$('#main-content').removeClass('no-sidebar');
					// Set the .sticky class when waypoint is reached
					mi_container.waypoint(function(direction) {
						$('#machine-image-container').toggleClass('sticky',
								direction === 'down');
					});

					function radioSelect() {
						var radioInputFields = $('input[name=machine-model],input[name=weight-hopper],input[name=discharge-funnel],input.spout-type,#btnFront,#btnSide');
						// var machineImage = $('#machine-image');
						radioInputFields
								.click(function() {

									var fieldID = $(this);
									var spoutContainer = fieldID
											.closest('fieldset');
									var fieldValue = fieldID.val();
									var machineImage = $('#machine-image');

									switch (fieldValue) {
									case 'S-4':
										$('.machine-model-description').hide();
										$('#s-4-description').show();
										machineImage.removeClass(
												's-4 s-5 s-6 s-7').addClass(
												's-4');
										machineImage
												.next('#machine-title')
												.html(
														machineS4.machineName
																+ " "
																+ machineS4.machineType);
										break;
									case 'S-5':
										$('.machine-model-description').hide();
										$('#s-5-description').show();
										machineImage.removeClass(
												's-4 s-5 s-6 s-7').addClass(
												's-5');
										machineImage
												.next('#machine-title')
												.html(
														machineS5.machineName
																+ " "
																+ machineS5.machineType);
										break;
									case 'S-6':
										$('.machine-model-description').hide();
										$('#s-6-description').show();
										machineImage.removeClass(
												's-4 s-5 s-6 s-7').addClass(
												's-6');
										machineImage
												.next('#machine-title')
												.html(
														machineS6.machineName
																+ " "
																+ machineS6.machineType);
										break;
									case 'S-7':
										$('.machine-model-description').hide();
										$('#s-7-description').show();
										machineImage.removeClass(
												's-4 s-5 s-6 s-7').addClass(
												's-7');
										machineImage
												.next('#machine-title')
												.html(
														machineS7.machineName
																+ " "
																+ machineS7.machineType);
										break;
									case 'small-weight-hopper':
										$('.small-discharge-funnel')
												.show()
												.find(
														'#small-standard-discharge-funnel')
												.prop('checked', true);
										$('.large-discharge-funnel').hide()
												.find('input').prop('checked',
														false);
										machineImage.removeClass(
												'smwh lrgwh std-fnl steep-fnl')
												.addClass('smwh std-fnl');
										break;
									case 'large-weight-hopper':
										$('.large-discharge-funnel')
												.show()
												.find(
														'#large-standard-discharge-funnel')
												.prop('checked', true);
										$('.small-discharge-funnel').hide()
												.find('input').prop('checked',
														false);
										machineImage.removeClass(
												'smwh lrgwh std-fnl steep-fnl')
												.addClass('lrgwh std-fnl');
										break;
									case 'small-steep-funnel':
									case 'large-steep-funnel':
										machineImage.removeClass(
												'std-fnl steep-fnl').addClass(
												'steep-fnl');
										break;
									case 'small-standard-discharge-funnel':
									case 'large-standard-discharge-funnel':
										machineImage.removeClass(
												'std-fnl steep-fnl').addClass(
												'std-fnl');
										break;
									case 'flag-bag':
										machineImage.find('.spout')
												.removeClass('hidden');
										spoutContainer.find(
												'.field-name-dimensions li')
												.hide();
										spoutContainer.find(
												'.spout-shape-images > *')
												.hide()
										spoutContainer.find(
												'.spout-width-inches').show();
										spoutContainer
												.find(
														'.spout-shape-images > .flat-bag-spout-shape')
												.show();
										spoutContainer
												.find('.description p')
												.html(
														"Enter the width of the bag opening (W).");
										break;
									case '4-sided-bag':
										machineImage.find('.spout')
												.removeClass('hidden');
										spoutContainer.find(
												'.field-name-dimensions li')
												.hide();
										spoutContainer.find(
												'.spout-shape-images > *')
												.hide()
										spoutContainer
												.find(
														'.spout-width-inches,.spout-height-inches')
												.show();
										spoutContainer
												.find(
														'.spout-shape-images > .four-sided-bag-spout-shape')
												.show();
										spoutContainer
												.find('.description p')
												.html(
														"Looking down at the top of your bag, enter the dimensions (D1) and (D2) of the bag opening.");
										break;
									case 'can-jar':
										machineImage.find('.spout')
												.removeClass('hidden');
										spoutContainer.find(
												'.field-name-dimensions li')
												.hide();
										spoutContainer.find(
												'.spout-shape-images > *')
												.hide()
										spoutContainer.find(
												'.spout-diameter-inches')
												.show();
										spoutContainer
												.find(
														'.spout-shape-images > .can-or-jar-spout-shape')
												.show();
										spoutContainer
												.find('.description p')
												.html(
														"Enter the inside diameter of the bottle or can opening (D).");
										break;
									case 'Front':
										machineImage.removeClass('side')
												.addClass('front');
										break;
									case 'Side':
										machineImage.removeClass('front')
												.addClass('side');
										break;

									}

								});

					}
					radioSelect();

					$('.step-submit').click(
							function() {
								var stepContainer = $(this).closest(
										'.step-container');
								var nextContainerID = stepContainer.next()
										.attr('id');
								var prevContainerID = stepContainer.prev()
										.attr('id');
								$('#pag-navigation a').removeClass('active');

								if ($(this).is('.next')) {
									stepContainer.hide().next().show();
									$(
											'#pag-navigation a[href*='
													+ nextContainerID + ']')
											.addClass('active');
								} else {
									stepContainer.hide().prev().show();
									$(
											'#pag-navigation a[href*='
													+ prevContainerID + ']')
											.addClass('active');
								}
							});

					$('#pag-navigation a').click(function() {
						var stepValue = $(this).attr('href');
						$('#pag-navigation a').removeClass('active');
						$(this).addClass('active');
						$('.step-container').hide();
						$(stepValue).show();
					});

					$('#hidden-accessories-page-btn').click(function() {
						$('#hidden-accessories-page').show();
					});
					$('#btnClose,#btnContinue').click(function() {
						$(this).closest('.step-container').hide();
					});

					$('#btnAdd')
							.click(
									function() {
										var num = $('.cloneSpout').length;
										var newNum = new Number(num + 1);
										// the numeric ID of the new input field
										// being
										// added
										var newSpoutID = 'spout-' + newNum;
										var newSpoutTypeID = 'spout-' + newNum
												+ "-type";
										var newSpoutDimensionsID = 'spout-'
												+ newNum + "-dimensions";
										// create the new element via clone(),
										// and
										// manipulate it's ID using newNum value
										var newElem = $('#spout-' + num)
												.clone().attr('id', newSpoutID);

										// manipulate the name/id values of the
										// elements
										// inside the new element
										var radioFieldID = 1;

										newElem
												.children('legend')
												.html('Spout ' + newNum)
												.next()
												.attr('id', newSpoutTypeID)
												.find('input')
												.attr(
														{
															"id" : function(arr) {
																return newSpoutTypeID
																		+ "-"
																		+ arr
															},
															'name' : newSpoutTypeID
														})
												.prop('checked', false)
												.next()
												.attr(
														'for',
														function(arr) {
															return newSpoutTypeID
																	+ "-" + arr
														});
										newElem
												.find('.description p')
												.html(
														"Please enter the spout type spout that you require by clicking on the image above.");
										newElem.find('.spout-shape-images > *')
												.hide()
										newElem
												.children(
														'.field-name-dimensions')
												.attr('id',
														newSpoutDimensionsID)
												.find('li')
												.hide()
												.find(
														'.spout-width-inches input')
												.attr(
														'id',
														newSpoutID
																+ "-width-inches")
												.closest(
														'.field-name-dimensions')
												.find(
														'.spout-height-inches input')
												.attr(
														'id',
														newSpoutID
																+ "-height-inches")
												.closest(
														'.field-name-dimensions')
												.find(
														'.spout-diameter-inches input')
												.attr(
														'id',
														newSpoutID
																+ "-diameter-inches");

										// insert the new element after the last
										// "duplicatable" input field
										$('#spout-' + num).after(newElem);

										// enable the "remove" button
										$('#btnDel').show().prop('disabled',
												false);

										// business rule: you can only add 5
										// names
										if (newNum == 3)
											$('#btnAdd').hide();

										radioSelect();
									});

					$('#btnDel').click(function() {
						var num = $('.cloneSpout').length;
						// how many "duplicatable" input fields we currently
						// have
						$('#spout-' + num).remove();
						// remove the last element

						// enable the "add" button
						if (num == 3)
							$('#btnAdd').show();

						// if only one element remains, disable the "remove"
						// button
						if (num - 1 == 1)
							$('#btnDel').hide().attr('disabled', 'disabled');
					});

				});
