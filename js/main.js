$(document).ready(function() {

    var $form = $('#logical-machines-quote-generator');
    
    /*
     * Validation criteria
     */

    	var email = {
            email: true 
        };
        var emailMessages = {
        	emails : "Please enter a valid email address."
            };
        var requiredEmail = {
            required : true,
            email: true
        };
        var requiredEmailMessages = {
            required : "Please enter an email address.",
            emails : "Please enter a valid email address."
        };
        $form.validate({
            rules : {
                to : requiredEmail,
                cc : email
            },
            messages : {
                to : requiredEmailMessages,
                cc : emailMessages
            }
        });

    /*
    * Declare global variables
    */
        
    // Retreive list of spouts available for sale from the HTML
		var spoutSizes = $('input[name=spout-sizes]').val(),
		spoutSizes = spoutSizes.replace(/\s+/g,''),
		availableSpouts = spoutSizes.split(','),
    // Field containers
		$fieldContainer = $('.field-container'), 
		$machineModel = $('#field-name-machine-model'), 
		$weighHopper = $('#field-name-weigh-hopper'), 
		$dischargeFunnel = $('#field-name-discharge-funnel'), 
		$spout = $('#field-name-spout'), 
		$spout1 = $spout.find('#spout1'), 
		$spout2 = $spout.find('#spout2'), 
		$spout3 = $spout.find('#spout3'),
    // Field labels for extracting data
		$machineData = $machineModel.find('label'), 
		$weighHopperData = $weighHopper.find($('label')), 
		$dischargeFunnelData = $dischargeFunnel.find($('label')), 
		spoutPrice = parseInt($('input[name=spout-price]').val()),
    // Machine image variables
		$machineImage = $('#machine-image'), 
		$spoutImage = $machineImage.find('.spout'), 
		$nextMachineImage = $('#machine-image').next('#machine-title'), 
		$grandTotalContainer = $('#cost-container .amount'), 
		grandTotal = parseInt($grandTotalContainer.text(), 10),
    // Controls
		$btnAdd = $('#btnAdd'), 
		$btnDel = $('#btnDel'), 
		$btnEmail = $('#btnEmail'), 
		$btnSubmit = $('#btnSubmit');

    // Create an instance of the machine object and default assign properties
    var machine = {
        id : $machineData.first().attr('for'),
        name : $machineData.first().find('.name').text(),
        type : $machineData.first().find('.type').text(),
        description : $.trim($machineData.first().find('.description').text()),//.trim(),
        price : $machineData.first().find('.amount').text(),
        weighHopper : {
            id : $weighHopperData.first().attr('for'),
            name : $weighHopperData.first().find('.name').text(),
            description : $.trim($weighHopperData.first().find('.description').text()),//.trim(),
            price : $weighHopperData.first().find('.amount').text()
        },
        dischargeFunnel : {
            id : $dischargeFunnelData.first().attr('for'),
            name : $dischargeFunnelData.first().find('.name').text(),
            description : $.trim($dischargeFunnelData.first().find('.description').text()),//.trim(),
            price : $dischargeFunnelData.first().find('.amount').text()
        }
    };
    /*
    * Document ready JS
    */

    // Hide fallback content, add and delete button
    $('#field-name-discharge-funnel .large, .field-name-dimensions li, #step-2, #step-3, #step-4, #step-5, #hidden-accessories-page, .container-shape-images > *, #btnAdd, #btnDel, .calculate, .spout-calculation, .field-spout .instructions p, #emailQuote, .field-spout .warning, #sending').hide();
    $('.field-spout .instructions p.spout-selection').show();
    // Remove fallback form elements
    $('.fallback-field-spout,.fallback-discharge-funnel,input[name=nojs]').remove();
    $btnSubmit.val('Send Email');
    // .bottom class puts a negative z-index on the hidden
    // accessories page so that it loads underneath the rest of
    // the content. This removes that class on load.
    $('.bottom').removeClass('bottom');
    // Hide all but the first machine model description
    $machineModel.find('.description').not(':first').hide();
    // Remove .hidden class from JS ready content
    $('#field-name-discharge-funnel li, #btnAdd, #btnDel, #btnFront, #btnSide, .field-spout, .step-submit, #sidebar, #btnPrint, #btnEmail,#btnClose, #btnContinue, .quote-summary, #hidden-accessories-page, #machine-title, #quote-summary, #sending').removeClass('hidden');
    // Check the fallback discharge funnel field
    $dischargeFunnel.find($('.small #small-std-fnl')).prop('checked', true).addClass('active');
    // Remove the no-sidebar class for fallback
    $('#main-content').removeClass('no-sidebar');
    
    /* 
       Add a waypoint to the sidebar
       var $mi_container = $('#sidebar');
       Set the .sticky class when waypoint is reached
       $mi_container.waypoint(function(direction) {
       $('#machine-image-container').toggleClass('sticky',
       direction === 'down');
       });
    */

    // Create a div on each page for the pager button
    $('.step-container').each(function() {
        containerID = $(this).attr('id');
        $('<div/>', {
            id : containerID + '-pager',
            "class" : 'step-pager'
        }).appendTo($(this));

    })
    // Create pager buttons and add them to the created div
    $('.step-pager').not(':first').append($('<button/>', {
        "class" : 'prev',
        type : 'button'
    }).text('Previous step'));
    $('.step-pager').not(':last').append($('<button/>', {
        "class" : 'next',
        type : 'button'
    }).text('Next step'));

    /*
    * General functions
    */

    // Capitalise first letter of a variable
    String.prototype.capitalise = function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    }

// Calculate the grand total - passed a particular input and called when that input has been selected
    function calculateTotal($fieldID) {
        var price = parseInt($fieldID.next('label').find(".amount").text(), 10), 
			siblingAmounts = 0, 
			radioName = $fieldID.attr("name");
        if (!isNaN(price)) { // If price is a number
			// Get active inputs in same group excluding clicked:
				var $siblingInputs = $("input[name='" + radioName + "'].active").not($fieldID);
			// Add price of each to siblingAmounts:
				$siblingInputs.each(function() {
					siblingAmounts += parseInt($(this).next("label").find(".amount").text(), 10);
				});
			// Toggle active status for selected input and remove from all other inputs:
				$fieldID.toggleClass("active");
				$siblingInputs.removeClass("active");
			// Test whether clicked input is 'active' and proceed accordingly
				if ($fieldID.hasClass("active")) {
					// subtract sibling amounts from grand total and add price
						grandTotal -= siblingAmounts;
						grandTotal += price;
				} else {
					// subtract price from grand total
						grandTotal -= price;
				}
			// Insert grand total amount into box below machine image
				$grandTotalContainer.html(grandTotal);
        }
    }    

    // Change the machine image between front and side view
    $('#machine-image-container').on('click', 'button', function() {
        var btnDirection = $(this).attr('id');
        if(!$(this).hasClass('active')) {
            $('#machine-image-container button').toggleClass('active');
        }
        if (btnDirection === 'btnFront') {
            $machineImage.addClass('front').removeClass('side');
        } else {
            $machineImage.addClass('side').removeClass('front');
        }
    });
    
    /*
     *  Navigation
     */

    $('.step-pager button').click(function() { // Action for 'prev' & 'next' buttons
    	changeCostContainerText()
        var $stepContainer = $(this).closest('.step-container'), 
			nextStepContainerID = $stepContainer.next().attr('id'), 
			prevStepContainerID = $stepContainer.prev().attr('id');
    	// Remove active class from the current page 
        $('#pag-navigation a').removeClass('active');
        // Move the app forward if the clicked button is next or back if is previous and add the active class
        if ($(this).is('.next')) {
            $stepContainer.hide().next().show();
            $('#pag-navigation a[href*=' + nextStepContainerID + ']').addClass('active');
        } else {
            $stepContainer.hide().prev().show();
            $('#pag-navigation a[href*=' + prevStepContainerID + ']').addClass('active');
        }
        // Execute showvalues() to display results if moving to the summary page
        if ($(this).is('#step-4-pager button.next'))
			showValues()
    	$('#thankYouMessage').remove();
    	// Reload the page to reset the form if moving to page 1
        if ($(this).is('#step-2-pager button.prev'))
            location.reload();
    	// Reload the page to reset the form if moving to page 1
        if ($(this).is('#step-3-pager button.prev')) {
			defaultHopperS4();
		}
    });

    $('#pag-navigation a').click(function() { // Action for left-hand step tabs
    	changeCostContainerText();
        var stepValue = $(this).attr('href');
        // Remove active class from current page and add to selected page
        $('#pag-navigation a').removeClass('active');
        $(this).addClass('active');
        // Hide the current page and show the selected page
        $('.step-container').hide();
        $(stepValue).show();
        // Execute showvalues() to display results if moving to the summary page
        if (stepValue === "#step-5")
            showValues();
    	$('#thankYouMessage').remove();
    	// Reload the page to reset the form if moving to page 1
        if (stepValue === "#step-1")
            location.reload();
    	// Reset the hopper to S4 default if moving to page 2
        if (stepValue === "#step-2") {
			defaultHopperS4();
		}
    });
	
	function defaultHopperS4 () {
		$('#smwh').prop('checked', true).trigger('change');
	}
    
    // Display Base Price as title on the front page and Price as Configured on every other page
    function changeCostContainerText() {
    	var costContainerText = $('#cost-container .title').text(); 
    	if (costContainerText !== 'Price as Configured:') {
    		$('#cost-container .title').text('Price as Configured:');
    	} 
    }

    /*
     * Pages 1 - 3 selection actions
     */

    $fieldContainer.on('change', 'input[type=radio]', function(e) { // Action when choosing options - registers & indicates selection, determines knock-on choices, updates image, updates cost.
		
		var $fieldID = $(this), 
			fieldContainerID = $(this).closest($fieldContainer).attr('id'), // Id of container element - type of option selected
			objectName = $fieldID.attr('name'), // Name of input - Appears unused - equates to fieldContainerID
			objectVal = $fieldID.attr('id'), // ID - precise name of item selected
			inputVal = $fieldID.closest('ul.field-type-radio').find('.active').attr('id'), // Id of currently active option
			$fieldLabel = $(this).next('label'); // Label that corresponds to selected input
        // Check if the clicked field is the same as the selected field
        if (inputVal == objectVal) {
			if (inputVal == "smwh" && machine.dischargeFunnel.id !== "small-std-fnl") {
				// Select default radio input for selected discharge funnel:
					var $defaultFunnel = $('#small-std-fnl')
					$defaultFunnel.prop('checked', true);
				// Recalculate total for default discharge funnel:	
					calculateTotal($defaultFunnel);
				// Get data for discharge funnel:
					$defaultFunnelData = $defaultFunnel.siblings('label')
				// Assign properties to the machine.dischargeFunnel object
					machine.dischargeFunnel.id = $defaultFunnel.attr('id');
					machine.dischargeFunnel.name = $defaultFunnelData.find('.name').text();
					machine.dischargeFunnel.description = $.trim($defaultFunnelData.find('.description').text())//.trim();
					machine.dischargeFunnel.price = $defaultFunnelData.find('.amount').text();
			}
		    e.preventDefault();
        } else {
        // If it is different execute the following actions according to which field was clicked
            switch (fieldContainerID) {
                case 'field-name-machine-model':
                    // Assign properties to the machine object
						machine.id = $fieldID.attr('id');
						machine.name = $fieldLabel.find('.name').text();
						machine.type = $fieldLabel.find('.type').text();
						machine.description = $.trim($fieldLabel.find('.description').text())//.trim();
						machine.price = $fieldLabel.find('.amount').text();
                    // Show/Hide descriptions - once more than one machine is available this will hide all descriptions except for that of selected machine
						$machineData.children(':not(h4,.price)').hide();
						$fieldLabel.find('*').show();
                    // Assign classes to machine image and change name displayed below
						$machineImage.removeClass('s4 s5 s6 s7').addClass(machine.id);
						$nextMachineImage.html(machine.name + " " + machine.type);
                    break;
                case 'field-name-weigh-hopper':
                    // Assign properties to the machine.weighHopper object
						machine.weighHopper.id = $fieldID.attr('id');
						machine.weighHopper.name = $fieldLabel.find('.name').text();
						machine.weighHopper.description = $.trim($fieldLabel.find('.description').text())//.trim();
						machine.weighHopper.price = $fieldLabel.find('.amount').text();
                    // Assign classes to machine image
						$machineImage.removeClass('smwh lrgwh std-fnl steep-fnl').addClass(objectVal + ' std-fnl');
                    // Show/Hide discharge funnels and reset checked properties:
						// Get name of required category of discharge funnels
							var componentSize = $fieldID.closest('li').attr('class');
						// Hide all list items then show those that are in the required category:
							$dischargeFunnel.find($('li')).hide().filter($('.' + componentSize)).show();
						// Uncheck selection of any discharge funnel and de-activate seletion flag:
							$dischargeFunnel.find($('input')).prop('checked', false);
						// Check which weigh hopper is being selected:
						if (machine.weighHopper.id == 'smwh') {
							// Select default radio input for selected discharge funnel:
								var $defaultFunnel = $('#small-std-fnl')
								$defaultFunnel.prop('checked', true);
							// Recalculate total for default discharge funnel:	
								calculateTotal($defaultFunnel);
							// Get data for discharge funnel:
								$defaultFunnelData = $defaultFunnel.siblings('label')
							// Assign properties to the machine.dischargeFunnel object
								machine.dischargeFunnel.id = $defaultFunnel.attr('id');
								machine.dischargeFunnel.name = $defaultFunnelData.find('.name').text();
								machine.dischargeFunnel.description = $.trim($defaultFunnelData.find('.description').text())//.trim();
								machine.dischargeFunnel.price = $defaultFunnelData.find('.amount').text();
						} else {
							calculateTotal($('#field-name-weigh-hopper input.active'))
						}
					break;
                case 'field-name-discharge-funnel':
                    // Assign properties to the machine.dischargeFunnel object
						machine.dischargeFunnel.id = $fieldID.attr('name');
						machine.dischargeFunnel.name = $fieldLabel.find('.name').text();
						machine.dischargeFunnel.description = $.trim($fieldLabel.find('.description').text())//.trim();
						machine.dischargeFunnel.price = $fieldLabel.find('.amount').text();
                    // Assign classes to machine image
						$machineImage.toggleClass('std-fnl steep-fnl');
                    break;
                case 'field-name-spout':
                    var fieldVal = $fieldID.val(), 
					$spoutContainer = $fieldID.closest('fieldset');
                    // Show calculate button
						$spoutContainer.find('.calculate').show();
                    // Toggle active class
						$spoutContainer.find('input.active').removeClass('active');
						$fieldID.addClass('active');
                    // Hide all the dimensions fields and images
						$spoutContainer.find('.field-name-dimensions li').hide();
						$spoutContainer.find('.container-shape-images > *').hide();
						$spoutContainer.find('p').hide();
                    // Show the appropriate instructions and fields for the spout type choice
						$spoutContainer.find('.instructions .' + fieldVal).show();
						$spoutContainer.find('.field-name-dimensions .' + fieldVal).show();
						$spoutContainer.find('.container-shape-images .' + fieldVal).show();
                    break;
            }
            
			calculateTotal($fieldID);
        }

    });

    /*
     *  'Select spouts' page
     */

    // Calculate the size of the spout based on the container
    $spout.on('click', '.calculate', function() {
        var num = $('fieldset.field-spout').length, 
			$spoutContainer = $(this).closest('fieldset'), 
			spoutTitle = $.trim($spoutContainer.find('legend').text())//.trim(),
        // The selected spout type
			$spoutSelected = $spoutContainer.find('.field-name-spout-type input:checked'), 
			spoutSelectedVal = $spoutSelected.val(), 
			spoutSelectedTitle = $spoutSelected.next('label').find('h4').text(),
        // Spout dimension values
			dimensionFieldWidth = parseFloat($spoutContainer.find('.width input').val()), 
			dimensionFieldD1 = parseFloat($spoutContainer.find('.d1 input').val()), 
			dimensionFieldD2 = parseFloat($spoutContainer.find('.d2 input').val()), 
			dimensionFieldDiameter = $spoutContainer.find('.diameter input').val(), 
			spoutSize = null,
        // Visisble dimension fields
			$dimensionFieldsVisible = $spoutContainer.find('.field-type-textfield input').filter(":visible");
        // If the fields are valid, calculate the spout size
        if ($dimensionFieldsVisible.valid()) {
            switch (spoutSelectedVal) {
                case 'flat-bag':
                    var containerDiameter = dimensionFieldWidth * 2 / Math.PI, spoutSize = nearestSpout(containerDiameter);
                    break;
                case 'four-sided-bag':
                    var containerDiameter = (dimensionFieldD1 + dimensionFieldD2) * 2 / Math.PI, spoutSize = nearestSpout(containerDiameter);
                    break;
                case 'can-jar':
                    $.each(availableSpouts, function() {
                        if (spoutSize == null || dimensionFieldDiameter - this >= 0.125) {
                            spoutSize = this;
                        }
                    });
                    break;
            }
            spoutSize = parseFloat(spoutSize);
           // Display a warning if the spout size is the same as an existing one else run spoutValid()
           var calculatedSpoutSizes = [];
           $('.spout-calculation .spout-size').each(function(){
            	calculatedSpoutSizes.push(parseFloat($.trim($(this).text())));
           });
            	if (calculatedSpoutSizes.length !== 0 && $.inArray(spoutSize, calculatedSpoutSizes) !== -1) {
            		$spoutContainer.find('.warning').show().find('.calculatedSpoutSize').text(spoutSize);
            	} else {
            		spoutValid(num, $spoutContainer, spoutTitle, spoutSize);
            	}
        }
    });
    
    // Find out what the nearest spout is to the calculated spout size
    function nearestSpout(containerDiameter) {
        var closest = null, calculatedSpoutSize = Math.round(containerDiameter * 0.72 * 1000) / 1000;
        $.each(availableSpouts, function() {
            if (closest == null || Math.abs(this - calculatedSpoutSize) < Math.abs(closest - calculatedSpoutSize)) {
                closest = this;
            }
        });
        return closest;
    }
    
    function spoutValid(num, $spoutContainer, spoutTitle, spoutSize) {
    	// Hide invalid warning message
    	$spoutContainer.find('.warning').hide();
    	// Show add button when the number of fields is less that 3
        if (num < 3) {
            $btnAdd.show();
        }
        // Slide the fieldset up and display the results and edit button
        $spoutContainer.slideUp('fast', function() {    
        	$spoutContainer.after('<p class="spout-calculation"><span class="spoutNum">' + spoutTitle + '</span>: <span class="spout-size">' + spoutSize + '</span>"<button type="button" class="btnRemove" value="Remove spout">Remove</button><button type="button" class="btnEdit" value="Edit spout">Edit</button></p>');
        });
        // Show delete button
        $btnDel.show().prop('disabled', false);
        // Adjust the grand total
        grandTotal += spoutPrice;
        $grandTotalContainer.html(grandTotal);
        // Show the spout image
        if ($spoutImage.hasClass('hidden')) {
        	$spoutImage.removeClass('hidden');
        }
       }
    
    // Buttons for adding, removing and editing spouts
    
    // Add button
    $btnAdd.click(function() {
        // Find out the amount of existing fields and add the next number
        var num = $('fieldset.field-spout').length, newNum = +num + 1,
        // The numeric ID of the new input field being added
        newSpoutID = 'spout' + newNum, newSpoutIDUpper = newSpoutID.capitalise(), newSpoutTypeID = "type" + newSpoutIDUpper,
        // Create the new element via clone() give it the new ID using newNum value
        $newElem = $('#spout' + num).clone().attr('id', newSpoutID);
        // Manipulate the name/id values of the spout type inputs inside the new element
        spoutNumber($newElem,newNum,newSpoutID,newSpoutIDUpper,newSpoutTypeID);
        // Show spout type fields and reset
        $newElem.find('.field-name-spout-type').show().find('input').prop('checked', false).removeClass('active');
        // Reset the field descriptions
        $newElem.find('.description').show().find('p').hide().filter('.spout-selection').show();
        // Reset the dimension fields
        $newElem.find('.field-name-dimensions li').hide().find('input').prop('disabled', false).val("");
        // Hide container shape images
        $newElem.find('.container-shape-images > *').hide();
        // Remove spout calculation result and hide the calculate button
        $newElem.find('.spout-calculation').remove();
        $newElem.find('.calculate').hide();
        $newElem.find('fieldset').slideDown('fast');
        // Insert the new element after the last spout
        $('#spout' + num).after($newElem);
        // enable the "remove" button and hide the 'add'
        // button
        $btnDel.show().prop('disabled', false);
        $btnAdd.hide();
    });

    // Remove button
    $('#field-name-spout').on('click', '.btnRemove', function() {
    	var num = $('fieldset.field-spout').length, 
			$spoutField = $("#spout" + num), 
			$spoutWrapper = $(this).closest('.spout-wrapper'), 
			$spoutFieldset = $spoutWrapper.find('fieldset');
    	if (num == 1) {
        	$spoutField.find('fieldset').slideDown().find('.calculate').hide();
            $spoutField.find('.field-name-spout-type').show().find('input').removeClass('active').prop('checked', false); 
            $spoutField.find('.instructions').show().find('p').hide().filter('.spout-selection').show();
            $spoutField.find('.field-name-dimensions,.container-shape-images').show();
        	$spoutField.find('.field-name-dimensions li').hide().find('input').prop('disabled', false).val("");
        	$spoutField.find('.container-shape-images > *').hide();
        	$spoutField.find('.spout-calculation').remove();
            $btnAdd.hide();
            $btnDel.hide();
            $spoutImage.addClass('hidden');
        } else {
        // Show the 'add another spout' button
        $btnAdd.show();
    	// Delete the spout
    	$spoutWrapper.remove();
    	// Reset the ID and label numbering for the remaining fields
    	$('.spout-wrapper').each(function(index) {
    		var $newElem = $(this); newNum = index + 1, newSpoutID = 'spout' + newNum, newSpoutIDUpper = newSpoutID.capitalise(), newSpoutTypeID = "type" + newSpoutIDUpper;
    		spoutNumber($newElem,newNum,newSpoutID,newSpoutIDUpper,newSpoutTypeID);
    		$newElem.find('.spout-calculation .spoutNum').text('Spout ' + newNum);
    	});
        }
    	// Adjust the spout price
        grandTotal -= spoutPrice;
        $grandTotalContainer.html(grandTotal);
        // Show the "add" button if the 3rd spout is being removed
        if (num == 3)
            $btnAdd.show();
    });
    
    function spoutNumber($newElem,newNum,newSpoutID,newSpoutIDUpper,newSpoutTypeID) {
    	$newElem.attr('id', 'spout' + newNum).find('legend').html('Spout ' + newNum).next().find('input').attr({
            "id" : function(arr) {
                return "type" + (arr + 1) + newSpoutIDUpper;
            },
            'name' : newSpoutTypeID
        }).next().attr('for', function(arr) {
            return "type" + (arr + 1) + newSpoutIDUpper;
        });
		$newElem.find('.field-name-dimensions li input').attr('name', function(index, attr) {
            attr = attr.substring(0, attr.length - 1);
        	return attr + newNum;
        });
    }
    
    // Edit button
    $('#field-name-spout').on('click', '.btnEdit', function() {
		// Get spout wrapper and related form in objects:
			var $spoutWrapper = $(this).closest('.spout-wrapper'), 
				$spoutFieldset = $spoutWrapper.find('fieldset');
		// Show still-complete form and delete spout-calculation
			$spoutFieldset.slideDown('fast').next().remove();
		// Adjust the spout price
			grandTotal -= spoutPrice;
			$grandTotalContainer.html(grandTotal);
		//Show add button:
			$btnAdd.hide();
    });
    
    /*
     *  Hidden accessories page
     */

    $('#hidden-accessories-page-btn').click(function() {
        $('#hidden-accessories-page').show();
    });
    $('#btnClose,#btnContinue').click(function() {
        $(this).closest('.step-container').hide();
    });
    
    /*
     *  Display, Email and Print Summary
     */
    
    // Retrieve form values for display on summary
    function showValues() {
    	// Create the machine type, weight hopper and discharge funnel rows for the summary table
    	var resultsHTML = '<tr bgcolor="#EBFFEA"><th style="text-align:right;border-right: 1px solid #0c4b81;">' + machine.name + ' ' + machine.type + '</th><td>' + machine.description + '</td><td>$' + machine.price + '</td></tr><tr><th style="text-align:right;border-right: 1px solid #0c4b81;">' + machine.weighHopper.name + '</th><td>' + machine.weighHopper.description + '</td><td>$' + machine.weighHopper.price + '</td></tr><tr bgcolor="#EBFFEA"><th style="text-align:right;border-right: 1px solid #0c4b81;">' + machine.dischargeFunnel.name + '</th><td>' + machine.dischargeFunnel.description + '</td><td>$' + machine.dischargeFunnel.price + '</td></tr>',
        // Create the spout rows for the summary table
    	num = parseInt($('.spout-size').text());
        if (!isNaN(num)) {
            $('.spout-size').each(function() {
            	resultsHTML += '<tr><th style="text-align:right;border-right: 1px solid #0c4b81;">Spout</th><td>' + $(this).text() + ' inch</td><td>$' + spoutPrice + '</td></tr>';
            });
        }
        // Create the total row for the summary table
        resultsHTML += '<tr class="total" style="text-align:right;border-top:1px solid #0c4b81;"><td>&nbsp;</td><th>Total:</th><td>$' + grandTotal + '</td></tr>';
        // Empty the current summary table and add the new rows in
        $('#results').empty().append(resultsHTML);
        // Stripe the results table
        $('#results tr').filter(':even').addClass('even').css("background-color", "#EBFFEA");
        return resultsHTML;
    }

    // Print button action
    $('#btnPrint').click(function() {
        window.print();
        return false;
    });

    // Email button action
    $btnEmail.on('click', function() {
    	// Change the button value
        var btnEmailText = $(this).val();
        if (btnEmailText == 'Cancel Email') {
            $(this).text('Email Quote').val('Email Quote');
        } else {
            $(this).text('Cancel Email').val('Cancel Email');
            $('#thankYouMessage').remove();
        }
        // Slide out the email form
        $('#emailQuote').slideToggle('fast');
    });

    // Email send button action
    $btnSubmit.on('click', function() {
        var $disabled = $form.find('input:disabled').prop('disabled', false), quoteSummary = $('#quote-summary').html(), spoutRowsText = '', num = parseInt($('.spout-size').text());
        // Add spout rows to the email
        if (!isNaN(num)) {
        	$('.spout-size').each(function() {
        		spoutRowsText += 'Spout: ' + $(this).text() + ' inch $ - ' + spoutPrice + '\r';
            });
        }
        // Compile the values from the form
    	var to = $('#to').val(),
        cc = $('#cc').val(),
        message = $.trim(encodeURIComponent($('#message').val())),
        $emailFields = $('#to,#cc'),
        $HTMLresults = showValues(),
        $HTMLresults = $HTMLresults.replace(/\"/g,''),
        $HTMLheader = '<table border=0 cellpadding=10 cellspacing=0 style=margin:14px;border-collapse:collapse;><thead style=border-bottom:1px solid #0c4b81;><tr><th style=text-align:right;>Item</th><th style=text-align:left;>Description</th><th style=text-align:left;>Price</th></tr></thead><tbody>', 
    	$HTMLfooter = '</tbody></table>',
    	quoteHTML =  encodeURIComponent($HTMLheader + $HTMLresults + $HTMLfooter), 
        quoteText = encodeURIComponent(machine.name + " " + machine.type + " - $" + machine.price + "\r" + machine.description + "\r\r" + machine.weighHopper.name + " - $" + machine.weighHopper.price + "\r" + machine.weighHopper.description + "\r\r" + machine.dischargeFunnel.name + " - $" + machine.dischargeFunnel.price + "\r" + machine.dischargeFunnel.description + "\r\r" + spoutRowsText + "\rTotal: $" + grandTotal);
        // Create the datastring from the form values
    	var dataString = 'to=' + to + '&cc=' + cc + '&message=' + message + '&quoteHTML=' + quoteHTML + '&quoteText=' + quoteText;
        // Send the email via an AJAX request the PHP script
        if ($emailFields.valid()) {
        	$('#sending').show();
        	$('#btnSubmit').prop('disabled', true);
            $.ajax({
                type : "POST",
                url : "bin/email_processing.php",
                data : dataString,
                success : function(response) {
                    $btnEmail.text('Email Quote').val('Email Quote');
                    $('#emailQuote').slideToggle('fast').find('input').not('input[type=submit]').val('');
                    $('#quote-summary').after("<div id='thankYouMessage'></div>");
                    $('#thankYouMessage').html("<h3>Thank you.</h3>").append("<p>Your email has been sent to the recipients your entered.</p>");
                	$('#sending').hide();
                	$('#btnSubmit').prop('disabled', false);
                }
            });
            return false;
        }
    });

});
