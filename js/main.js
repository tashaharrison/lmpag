$(document)
		.ready(
				function() {

					// create the dynamic buttons and fields
					var strAddSpoutButton = '<input type="button" id="btnAdd" value="add another spout" />';
					var strDelSpoutButton = '<input type="button" id="btnDel" value="remove spout" />';
					var strSpoutWidthFieldValue = '<label for="spout-2-width-inches">Width in inches</label><input type="text" id="spout-2-width-inches" class="required number" name="width-inches" />';
					var strSpoutHeightFieldValue = '<label for="spout-2-height-inches">Height in inches</label><input type="text" id="spout-2-height-inches" class="required number" name="height-inches" />';
					var strSpoutDiameterFieldValue = '<label for="spout-2-diameter-inches">Diameter in inches</label><input type="text" id="spout-2-diameter-inches" class="required number" name="height-inches" />';

					// remove fallback form elements
					$(
							'.clonedInput:not(:first-child),#js-warning, .default-discharge-funnel')
							.remove();
					$('.machine-model-description').not(
							'.machine-model-description:first').hide();
					// insert the 'add another spout' button
					$('#edit-field-spout').append(strAddSpoutButton);
					// Insert the default content in field-name-discharge-funnel
					$('.large-discharge-funnel,.field-name-dimensions li')
							.hide();
					$('#small-standard-discharge-funnel').prop('checked', true);
					$('.small-discharge-funnel, .large-discharge-funnel')
							.removeClass('hidden');

					// Add a waypoint to the sidebar
					var mi_container = $('#sidebar');
					// Remove the fixed positioning on the sidebar for fallback
					mi_container.removeClass('sticky sidebar-sticky-position');
					mi_container.waypoint(function(direction) {
						mi_container
								.toggleClass('sticky', direction === 'down');
					});

					function radioSelect() {
						var radioInputFields = $('input[name=machine-model],input[name=weight-hopper],input[name=discharge-funnel],input.spout-type');
						// var machineImage = $('#machine-image');
						radioInputFields
								.click(function() {

									var fieldID = $(this);
									var spoutContainer = fieldID.closest('fieldset');
									var fieldValue = fieldID.val();
									var machineImage = $('#machine-image');
									var machineImageClass = '';

									$('.machine-model-description').hide();

									switch (fieldValue) {
									case 'S-4':
										$('#s-4-description').show();
										machineImage
												.removeClass('s-4 s-5 s-6 s-7');
										machineImageClass = 's-4';
										break;
									case 'S-5':
										$('#s-5-description').show();
										machineImage
												.removeClass('s-4 s-5 s-6 s-7');
										machineImageClass = 's-5';
										break;
									case 'S-6':
										$('#s-6-description').show();
										machineImage
												.removeClass('s-4 s-5 s-6 s-7');
										machineImageClass = 's-6';
										break;
									case 'S-7':
										$('#s-7-description').show();
										machineImage
												.removeClass('s-4 s-5 s-6 s-7');
										machineImageClass = 's-7';
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
										machineImage
												.removeClass('swh lwh ssdf sssdf lsdf lssdf');
										machineImageClass = 'swh ssdf';
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
										machineImage
												.removeClass('swh lwh ssdf sssdf lsdf lssdf');
										machineImageClass = 'lwh lsdf';
										break;
									case 'small-standard-discharge-funnel':
										machineImage
												.removeClass('ssdf sssdf lsdf lssdf');
										machineImageClass = 'ssdf';
										break;
									case 'small-steep-funnel':
										machineImage
												.removeClass('ssdf sssdf lsdf lssdf');
										machineImageClass = 'sssdf';
										break;
									case 'large-standard-discharge-funnel':
										machineImage
												.removeClass('ssdf sssdf lsdf lssdf');
										machineImageClass = 'lsdf';
										break;
									case 'large-steep-funnel':
										machineImage
												.removeClass('ssdf sssdf lsdf lssdf');
										machineImageClass = 'lssdf';
										break;
									case 'flag-bag':
										machineImageClass = 'spout';
										spoutContainer.find('.field-name-dimensions li').hide();
										spoutContainer.find('.spout-width-inches').show();
										break;
									case '4-sided-bag':
										machineImageClass = 'spout';
										spoutContainer.find('.field-name-dimensions li').hide();
										spoutContainer.find('.spout-width-inches,.spout-height-inches').show();
										break;
									case 'can-jar':
										machineImageClass = 'spout';
										spoutContainer.find('.field-name-dimensions li').hide();
										spoutContainer.find('.spout-diameter-inches').show();
										break;

									return machineImageClass;
								}

								machineImage.addClass(machineImageClass);

							});

					}
					radioSelect();
					
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
