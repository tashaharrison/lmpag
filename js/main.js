$(document)
		.ready(
				function() {

					// create the dynamic buttons and fields
					var addSpoutButton = '<input type="button" id="btnAdd" value="add another spout" />';
					var delSpoutButton = '<input type="button" id="btnDel" value="remove spout" />';
					var spoutWidthFieldValue = '<label for="spout-2-width-inches">Width in inches</label><input type="text" id="spout-2-width-inches" class="required number" name="width-inches" />';
					var spoutHeightFieldValue = '<label for="spout-2-height-inches">Height in inches</label><input type="text" id="spout-2-height-inches" class="required number" name="height-inches" />';
					var spoutDiameterFieldValue = '<label for="spout-2-diameter-inches">Diameter in inches</label><input type="text" id="spout-2-diameter-inches" class="required number" name="height-inches" />';
					var smallStdDischargeFunnelValue = '<li><input type="radio" id="small-standard-discharge-funnel" name="discharge-funnel" value="small-standard-discharge-funnel" checked="checked" /><label for="small-standard-discharge-funnel" class="clearfix"><h4>Small Standard Discharge Funnel</h4><div id="small-standard-discharge-funnel-image" class="accessories-image ir">Small Standard Discharge Funnel image</div><p>This is the standard funnel for use with the small weigh hopper. It is practical for most free-flowing materials.</p><p class="clear"><b>Price: </b>included on standard S-4</p></label></li>';
					var smallSteepDischargeFunnelValue = '<li><input type="radio" id="small-steep-discharge-funnel" name="discharge-funnel" value="small-steep-funnel" /><label for="small-steep-discharge-funnel" class="clearfix"><h4>Small Steep-Sided Discharge Funnel</h4><div id="small-steep-discharge-funnel-image" class="accessories-image ir">Small Steep-Sided Discharge image</div><p>This steep sided funnel is used for fine powdered materials such as flour or other products that can stick to metal surfaces.</p><p class="clear"><b>Price: </b>$125 upcharge</p></label></li>';
					var largeStdDischargeFunnelValue = '<li><input type="radio" id="large-standard-discharge-funnel" name="discharge-funnel" value="large-standard-discharge-funnel" checked="checked" /><label for="large-standard-discharge-funnel" class="clearfix"><h4>Large Standard Discharge Funnel</h4><div id="large-standard-discharge-funnel-image" class="accessories-image ir">Large Standard Discharge Funnel image</div><p>This is the standard funnel for use with the large weigh hopper. It works best with free flowing products.</p><p class="clear"><b>Price: </b>$150</p></label></li>';
					var largeSteepDischargeFunnelValue = '<li><input type="radio" id="large-steep-discharge-funnel" name="discharge-funnel" value="large-steep-funnel" /><label for="large-steep-discharge-funnel" class="clearfix"><h4>Large Steep-Sided Discharge Funnel</h4><div id="large-steep-discharge-funnel-image" class="accessories-image ir">Large Steep-Sided Discharge image</div><p>This steep sided funnel is used for fine powdered materials such as flour or other products that can stick to metal surfaces.</p><p class="clear"><b>Price: </b>$400 upcharge</p></label></li>';
					
					// remove fallback form elements
					$(
							'.clonedInput:not(:first-child), #spout-1-dimensions > *,#js-warning, .field-name-discharge-funnel>*')
							.remove();
					// insert the 'add another spout' button
					$('#edit-field-spout').append(addSpoutButton);
					// Insert the default content in field-name-discharge-funnel
					$('.field-name-discharge-funnel').append(
							smallStdDischargeFunnelValue
									+ smallSteepDischargeFunnelValue);

					// Add a waypoint to the sidebar
					var mi_container = $('#sidebar');
					// Remove the fixed positioning on the sidebar for fallback
					mi_container.removeClass('sticky sidebar-sticky-position');
					mi_container.waypoint(function(direction) {
						mi_container
								.toggleClass('sticky', direction === 'down');
					});

					// Display the correct image for the machine
					$('input[name=machine-model]').click(function() {
						$('.machine-model-description').hide();
						$('#machine-image').removeClass('s-4 s-5 s-6 s-7');
						if ($(this).val() == 'S-4') {
							$('#s-4-description').show();
							$('#machine-image').addClass('s-4');
						} else if ($(this).val() == 'S-5') {
							$('#s-5-description').show();
							$('#machine-image').addClass('s-5');
						} else if ($(this).val() == 'S-6') {
							$('#s-6-description').show();
							$('#machine-image').addClass('s-6');
						} else {
							$('#s-7-description').show();
							$('#machine-image').addClass('s-7');
						}
						;
					});

					// Add the dimension fields appropriate to the type of spout
					$('input[name=weight-hopper]')
							.click(
									function() {
										$('#machine-image')
												.removeClass(
														'swh lwh ssdf sssdf lsdf lssdf');
										if ($(this).val() == 'small-weight-hopper') {
											$(
													'.field-name-discharge-funnel > *')
													.remove();
											$('.field-name-discharge-funnel')
													.append(
															smallStdDischargeFunnelValue
																	+ smallSteepDischargeFunnelValue);
											$('#machine-image').addClass(
													'swh ssdf');
										} else {
											$(
													'.field-name-discharge-funnel > *')
													.remove();
											$('.field-name-discharge-funnel')
													.append(
															largeStdDischargeFunnelValue
																	+ largeSteepDischargeFunnelValue);
											$('#machine-image').addClass(
													'lwh lsdf');

										}
										;
										switchDischargeFunnelClass();
									});

					// Add the correct class to the machine image for the
					// appropriate discharge funnel
					function switchDischargeFunnelClass() {
						var dischargeFunnel = $('input[name=discharge-funnel]');
						dischargeFunnel
								.click(function() {
									$('#machine-image').removeClass(
											'ssdf sssdf lsdf lssdf');
									if ($(this).val() == 'small-standard-discharge-funnel') {
										$('#machine-image').addClass('ssdf');
									} else if ($(this).val() == 'small-steep-funnel') {
										$('#machine-image').addClass('sssdf');
									} else if ($(this).val() == 'large-standard-discharge-funnel') {
										$('#machine-image').addClass('lsdf');
									} else {
										$('#machine-image').addClass('lssdf');
									}
									;
								});
					}
					switchDischargeFunnelClass();

					// Add the discharge funnel types appropriate to the type of
					// hopper
					$('input.spout-type').click(
							function() {
								if ($(this).val() == 'flag-bag') {
									$('#spout-1-dimensions > *').remove();
									$('#spout-1-dimensions').append(
											spoutWidthFieldValue);
								} else if ($(this).val() == '4-sided-bag') {
									$('#spout-1-dimensions > *').remove();
									$('#spout-1-dimensions').append(
											spoutWidthFieldValue
													+ spoutHeightFieldValue);
								} else {
									$('#spout-1-dimensions > *').remove();
									$('#spout-1-dimensions').append(
											spoutDiameterFieldValue);
								}
								;
							});

					$('#btnAdd').click(
							function() {
								var num = $('.clonedInput').length;
								var newNum = new Number(num + 1);
								// the numeric ID of the new input field being
								// added
								var newSpoutID = 'spout-' + newNum;
								// create the new element via clone(), and
								// manipulate it's ID using newNum value
								var newElem = $('#spout-' + num).clone().attr(
										'id', newSpoutID);

								// manipulate the name/id values of the input
								// inside the new element
								newElem.children(':first').attr('id',
										newSpoutID).attr('name', newSpoutID);

								// insert the new element after the last
								// "duplicatable" input field
								$('#spout-' + num).after(newElem);

								// enable the "remove" button
								$('#btnDel').attr('disabled', '');

								// business rule: you can only add 5 names
								/*
								 * if (newNum == 5)
								 * $('#btnAdd').attr('disabled','disabled');
								 */
							});

					$('#btnDel').click(function() {
						var num = $('.clonedInput').length;
						// how many "duplicatable" input fields we currently
						// have
						$('#spout-' + num).remove();
						// remove the last element

						// enable the "add" button
						$('#btnAdd').attr('disabled', '');

						// if only one element remains, disable the "remove"
						// button
						if (num - 1 == 1)
							$('#btnDel').attr('disabled', 'disabled');
					});

				});
