$(document)
		.ready(
				function() {

					// Hide fallback content and delete button
					$(
							'.large-discharge-funnel,.field-name-dimensions li,#js-warning,#btnDel,#step-2,#step-3,#step-4,#step-5,#hidden-accessories-page')
							.hide();

					// Remove fallback form elements
					$('.default-spout,#js-warning, .default-discharge-funnel')
							.remove();
					$('.machine-model-description').not(
							'.machine-model-description:first').hide();
					// Remove .hidden class from js ready content
					$(
							'.small-discharge-funnel,.large-discharge-funnel,#btnAdd,#btnDel,#btnFront,#btnSide,.cloneSpout,.step-submit')
							.removeClass('hidden');
					// Check the default discharge funnel
					$('#small-standard-discharge-funnel').prop('checked', true);

					// Add a waypoint to the sidebar
					var mi_container = $('#sidebar');
					// Remove the fixed positioning on the sidebar for fallback
					mi_container.removeClass('sticky sidebar-sticky-position');
					mi_container.waypoint(function(direction) {
						mi_container
								.toggleClass('sticky', direction === 'down');
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
									var machineImageClass = '';

									switch (fieldValue) {
									case 'S-4':
										$('.machine-model-description').hide();
										$('#s-4-description').show();
										machineImage
												.removeClass('s-4 s-5 s-6 s-7');
										machineImageClass = 's-4';
										break;
									case 'S-5':
										$('.machine-model-description').hide();
										$('#s-5-description').show();
										machineImage
												.removeClass('s-4 s-5 s-6 s-7');
										machineImageClass = 's-5';
										break;
									case 'S-6':
										$('.machine-model-description').hide();
										$('#s-6-description').show();
										machineImage
												.removeClass('s-4 s-5 s-6 s-7');
										machineImageClass = 's-6';
										break;
									case 'S-7':
										$('.machine-model-description').hide();
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
										spoutContainer.find(
												'.field-name-dimensions li')
												.hide();
										spoutContainer.find(
												'.spout-width-inches').show();
										break;
									case '4-sided-bag':
										machineImageClass = 'spout';
										spoutContainer.find(
												'.field-name-dimensions li')
												.hide();
										spoutContainer
												.find(
														'.spout-width-inches,.spout-height-inches')
												.show();
										break;
									case 'can-jar':
										machineImageClass = 'spout';
										spoutContainer.find(
												'.field-name-dimensions li')
												.hide();
										spoutContainer.find(
												'.spout-diameter-inches')
												.show();
										break;
									case 'Front':
										machineImage.toggleClass('front side');
										break;
									case 'Side':
										machineImage.toggleClass('front side');
										break;

									return machineImageClass;
								}

								machineImage.addClass(machineImageClass);

							});

					}
					radioSelect();

					$('.step-submit').click(function() {
						var stepContainer = $(this).closest('.step-container');
						if ($(this).is('.next')) {
							stepContainer.hide().next().show();
						} else {
							stepContainer.hide().prev().show();
						}
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
										newElem.children('legend').html(
												'Spout ' + newNum).next().attr(
												'id', newSpoutTypeID).find(
												'input').attr(
												{
													"id" : function(arr) {
														return newSpoutTypeID
																+ "-" + arr
													},
													'name' : newSpoutTypeID
												}).prop('checked', false)

										.next().attr('for', function(arr) {
											return newSpoutTypeID + "-" + arr
										});

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
										/*
										 * if (newNum == 5)
										 * $('#btnAdd').attr('disabled','disabled');
										 */
										radioSelect();
									});

					$('#btnDel').click(function() {
						var num = $('.cloneSpout').length;
						// how many "duplicatable" input fields we currently
						// have
						$('#spout-' + num).remove();
						// remove the last element

						// enable the "add" button
						// $('#btnAdd').attr('disabled', '');

						// if only one element remains, disable the "remove"
						// button
						if (num - 1 == 1)
							$('#btnDel').hide().attr('disabled', 'disabled');
					});

				});
