$(document).ready(function() {

    var $form = $('#logical-machines-quote-generator');
    
    /*
     * Validation criteria
     */

    	var email = {
            email: true 
        };
        var emailMessages = {
        	emails : "Please enter a valid email address.",
            };
        var requiredEmail = {
            required : true,
            email: true, 
        };
        var requiredEmailMessages = {
            required : "Please enter an email address.",
        	emails : "Please enter a valid email address.",
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
    $fieldContainer = $('.field-container'), $machineModel = $('#field-name-machine-model'), $weighHopper = $('#field-name-weigh-hopper'), $dischargeFunnel = $('#field-name-discharge-funnel'), $spout = $('#field-name-spout'), $spout1 = $spout.find('#spout1'), $spout2 = $spout.find('#spout2'), $spout3 = $spout.find('#spout3'),
    // Field labels for extracting data
    $machineData = $machineModel.find('label'), $weighHopperData = $weighHopper.find($('label')), $dischargeFunnelData = $dischargeFunnel.find($('label')), spoutPrice = parseInt($('input[name=spout-price]').val()),
    // Machine image variables
    $machineImage = $('#machine-image'), $spoutImage = $machineImage.find('.spout'), $nextMachineImage = $('#machine-image').next('#machine-title'), $grandTotalContainer = $('#cost-container .amount'), grandTotal = parseInt($grandTotalContainer.text(), 10),
    // Controls
    $btnAdd = $('#btnAdd'), $btnDel = $('#btnDel'), $btnEmail = $('#btnEmail'), $btnSubmit = $('#btnSubmit');

    // Create an instance of the machine object and default assign properties
    var machine = {
        id : $machineData.first().attr('for'),
        name : $machineData.first().find('.name').text(),
        type : $machineData.first().find('.type').text(),
        description : $machineData.first().find('.description').text().trim(),
        price : $machineData.first().find('.amount').text(),
        weighHopper : {
            id : $weighHopperData.first().attr('for'),
            name : $weighHopperData.first().find('.name').text(),
            description : $weighHopperData.first().find('.description').text().trim(),
            price : $weighHopperData.first().find('.amount').text()
        },
        dischargeFunnel : {
            id : $dischargeFunnelData.first().attr('for'),
            name : $dischargeFunnelData.first().find('.name').text(),
            description : $dischargeFunnelData.first().find('.description').text().trim(),
            price : $dischargeFunnelData.first().find('.amount').text()
        }
    };

    /*
    * Document ready JS
    */

    // Hide fallback content, add and delete button
    $('#field-name-discharge-funnel .large, .field-name-dimensions li, #step-2, #step-3, #step-4, #step-5, #hidden-accessories-page, .container-shape-images > *, #btnAdd, #btnDel, .calculate, .spout-calculation, .field-spout .instructions p, #emailQuote, .field-spout .warning').hide();
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
    $('#field-name-discharge-funnel li, #btnAdd, #btnDel, #btnFront, #btnSide, .field-spout, .step-submit, #sidebar, #btnPrint, #btnEmail,#btnClose, #btnContinue, .quote-summary, #hidden-accessories-page, #machine-title, #quote-summary').removeClass('hidden');
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
            class : 'step-pager'
        }).appendTo($(this));

    })
    // Create pager buttons and add them to the created div
    $('.step-pager').not(':first').append($('<button/>', {
        class : 'prev',
        type : 'button',
    }).text('Previous step'));
    $('.step-pager').not(':last').append($('<button/>', {
        class : 'next',
        type : 'button',
    }).text('Next step'));

    /*
    * General functions
    */

    // Capitalise first letter of a variable
    String.prototype.capitalise = function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    }
    
    // Calculate the grand total
    function calculateTotal($fieldID) {
        var price = parseInt($fieldID.next('label').find(".amount").text(), 10), siblingAmounts = 0, radioName = $fieldID.attr("name");
        if (!isNaN(price)) {
            $("input[name='" + radioName + "'].active").not($fieldID).each(function() {
                siblingAmounts += parseInt($(this).next("label").find(".amount").text(), 10);
            });
            $fieldID.toggleClass("active");
            $("input[name='" + radioName + "']").not($fieldID).removeClass("active");
            if ($fieldID.hasClass("active")) {
                grandTotal -= siblingAmounts;
                grandTotal += price;
            } else {
                grandTotal -= price;
            }
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

    $('.step-pager button').click(function() {
    	changeCostContainerText()
        var $stepContainer = $(this).closest('.step-container'), nextStepContainerID = $stepContainer.next().attr('id'), prevStepContainerID = $stepContainer.prev().attr('id');
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
            showValues();
    	$('#thankYouMessage').remove();
    	// Reload the page to reset the form if moving to page 1
        if ($(this).is('#step-2-pager button.prev'))
            location.reload();
    });

    $('#pag-navigation a').click(function() {
    	changeCostContainerText();
        var stepValue = $(this).attr('href');
        // Remove active class from current page and add to next page
        $('#pag-navigation a').removeClass('active');
        $(this).addClass('active');
        // Hide the current page a show the next page
        $('.step-container').hide();
        $(stepValue).show();
        // Execute showvalues() to display results if moving to the summary page
        if (stepValue === "#step-5")
            showValues();
    	$('#thankYouMessage').remove();
    	// Reload the page to reset the form if moving to page 1
        if (stepValue === "#step-1")
            location.reload();
    });
    
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

    $fieldContainer.on('click', 'input[type=radio]', function(e) {
        var $fieldID = $(this), fieldContainerID = $(this).closest($fieldContainer).attr('id');
        objectName = $fieldID.attr('name'), objectVal = $fieldID.attr('id'), inputVal = $fieldID.closest('ul.field-type-radio').find('.active').attr('id'), $fieldLabel = $(this).next('label');
        // Check if the clicked field is the same as the selected field
        if (inputVal == objectVal) {
            e.preventDefault();
        } else {
        // If it is different execute the following actions according to which field was clicked
            switch (fieldContainerID) {
                case 'field-name-machine-model':
                    // Assign properties to the machine object
                    machine.id = $fieldID.attr('id');
                    machine.name = $fieldLabel.find('.name').text();
                    machine.type = $fieldLabel.find('.type').text();
                    machine.description = $fieldLabel.find('.description').text().trim();
                    machine.price = $fieldLabel.find('.amount').text();
                    // Show/Hide descriptions
                    $machineData.children(':not(h4,.price)').hide();
                    $fieldLabel.find('*').show();
                    // Assign classes to machine image and change name
                    $machineImage.removeClass('s4 s5 s6 s7').addClass(machine.id);
                    $nextMachineImage.html(machine.name + " " + machine.type);
                    break;
                case 'field-name-weigh-hopper':
                    // Assign properties to the machine.weighHopper object
                    machine.weighHopper.id = $fieldID.attr('name');
                    machine.weighHopper.name = $fieldLabel.find('.name').text();
                    machine.weighHopper.description = $fieldLabel.find('.description').text().trim();
                    machine.weighHopper.price = $fieldLabel.find('.amount').text();
                    // Assign classes to machine image
                    $machineImage.removeClass('smwh lrgwh std-fnl steep-fnl').addClass(objectVal + ' std-fnl');
                    // Show/Hide discharge funnels and reset checked properties
                    componentSize = $fieldID.closest('li').attr('class');
                    $dischargeFunnel.find($('li')).hide().filter($('.' + componentSize)).show();
                    $dischargeFunnel.find($('input')).prop('checked', false).removeClass('active');
                    if (componentSize === 'small') {
                        $dischargeFunnel.find($('.small #small-std-fnl')).prop('checked', true).addClass('active');
                    } else {
                        $dischargeFunnel.find($('.large #large-std-fnl')).prop('checked', true).addClass('active');
                    }
                    break;
                case 'field-name-discharge-funnel':
                    // Assign properties to the machine.weighHopper object
                    machine.dischargeFunnel.id = $fieldID.attr('name');
                    machine.dischargeFunnel.name = $fieldLabel.find('.name').text();
                    machine.dischargeFunnel.description = $fieldLabel.find('.description').text().trim();
                    machine.dischargeFunnel.price = $fieldLabel.find('.amount').text();
                    // Assign classes to machine image
                    $machineImage.toggleClass('std-fnl steep-fnl');
                    break;
                case 'field-name-spout':
                    var fieldVal = $fieldID.val(), $spoutContainer = $fieldID.closest('fieldset');
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

        var num = $('fieldset.field-spout').length, $spoutContainer = $(this).closest('fieldset'), spoutTitle = $spoutContainer.find('legend').text().trim(),
        // The selected spout type
        $spoutSelected = $spoutContainer.find('.field-name-spout-type input:checked'), spoutSelectedVal = $spoutSelected.val(), spoutSelectedTitle = $spoutSelected.next('label').find('h4').text(),
        // Spout dimension values
        dimensionFieldWidth = parseFloat($spoutContainer.find('.width input').val()), dimensionFieldD1 = parseFloat($spoutContainer.find('.d1 input').val()), dimensionFieldD2 = parseFloat($spoutContainer.find('.d2 input').val()), dimensionFieldDiameter = $spoutContainer.find('.diameter input').val(), spoutSize = null,
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
            	calculatedSpoutSizes.push(parseFloat($(this).text().trim()));
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
        $spoutContainer.slideUp('slow', function() {    
        	$spoutContainer.after('<p class="spout-calculation">' + spoutTitle + ': <span class="spout-size">' + spoutSize + '</span>"<button type="button" class="btnEdit" value="Edit spout">Edit spout</button></p>');
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
    
    // Buttons for adding, deleting and editing spouts
    
    // Add button
    $btnAdd.click(function() {
        // Find out the amount of existing fields and add the next number
        var num = $('fieldset.field-spout').length, newNum = +num + 1,
        // The numeric ID of the new input field being added
        newSpoutID = 'spout' + newNum, newSpoutIDUpper = newSpoutID.capitalise(), newSpoutTypeID = "type" + newSpoutIDUpper,
        // Create the new element via clone() give it the new ID using newNum value
        newElem = $('#spout' + num).clone().attr('id', newSpoutID);
        // Manipulate the name/id values of the spout type inputs inside the new element
        newElem.find('legend').html('Spout ' + newNum).next().show().find('input').attr({
            "id" : function(arr) {
                return "type" + (arr + 1) + newSpoutIDUpper;
            },
            'name' : newSpoutTypeID
        }).prop('checked', false).removeClass('active').next().attr('for', function(arr) {
            return "type" + (arr + 1) + newSpoutIDUpper;
        });
        // Reset the field descriptions
        newElem.find('.description').show().find('p').hide().filter('.spout-selection').show();
        // Reset the dimension fields
        newElem.find('.field-name-dimensions li').hide().find('input').prop('disabled', false).val("").attr('name', function(index, attr) {
            return attr + newSpoutIDUpper;
        });
        // Hide container shape images
        newElem.find('.container-shape-images > *').hide();
        // Remove spout calculation result and hide the calculate button
        newElem.find('.spout-calculation').remove();
        newElem.find('.calculate').hide();
        newElem.find('fieldset').slideDown();
        // Insert the new element after the last spout
        $('#spout' + num).after(newElem);
        // enable the "remove" button and hide the 'add'
        // button
        $btnDel.show().prop('disabled', false);
        $btnAdd.hide();
    });
    
    // Delete button
    $btnDel.click(function() {
        // Check the number of spouts
        var num = $('fieldset.field-spout').length, $spoutField = $("#spout" + num);
        // Adjust the spout price
        grandTotal -= spoutPrice;
        $grandTotalContainer.html(grandTotal);
        // If the first field is being removed then reset it to its default state
        if (num == 1) {
        	$spoutField.find('fieldset').slideDown().find('.calculate').hide();
            $spoutField.find('.field-name-spout-type').show().find('input').removeClass('active').prop('checked', false);
            $spoutField.find('.instructions').show().find('p').hide().filter('.spout-selection').show();
            $spoutField.find('.field-name-dimensions,.container-shape-images').show();
        	$spoutField.find('.field-name-dimensions li').hide().find('input').prop('disabled', false).val("");
        	$spoutField.find('.container-shape-images > *').hide();
        	$spoutField.find('.spout-calculation').hide().find('.spout-size').empty();
            $btnAdd.hide();
            $btnDel.hide();
            $spoutImage.addClass('hidden');
        } else {
            // Otherwise remove the last spout
            $('#spout' + num).remove();
        }
        // Show the "add" button if the 3rd spout is being removed
        if (num == 3)
            $btnAdd.show();
    });

    // Edit button
    $('#field-name-spout').on('click', '.btnEdit', function() {
    	var $spoutWrapper = $(this).closest('.spout-wrapper'), $spoutFieldset = $spoutWrapper.find('fieldset');
    	$spoutFieldset.slideDown().next().remove();
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
        message = encodeURIComponent($('#message').val().trim()),
        $emailFields = $('#to,#cc'),
        $HTMLresults = showValues(),
        $HTMLresults = $HTMLresults.replace(/\"/g,''),
        $HTMLheader = '<h3 style=margin-left:10px;>Your Quote Summary</h3><table border=0 cellpadding=10 cellspacing=0 style=margin:14px;border-collapse:collapse;><thead style=border-bottom:1px solid #0c4b81;><tr><th style=text-align:right;>Item</th><th style=text-align:left;>Description</th><th style=text-align:left;>Price</th></tr></thead><tbody>', 
    	$HTMLfooter = '</tbody></table>',
    	quoteHTML =  encodeURIComponent($HTMLheader + $HTMLresults + $HTMLfooter), 
        quoteText = encodeURIComponent(machine.name + " " + machine.type + " - $" + machine.price + "\r" + machine.description + "\r\r" + machine.weighHopper.name + " - $" + machine.weighHopper.price + "\r" + machine.weighHopper.description + "\r\r" + machine.dischargeFunnel.name + " - $" + machine.dischargeFunnel.price + "\r" + machine.dischargeFunnel.description + "\r\r" + spoutRowsText + "\rTotal: $" + grandTotal);
        // Create the datastring from the form values
    	var dataString = 'to=' + to + '&cc=' + cc + '&message=' + message + '&quoteHTML=' + quoteHTML + '&quoteText=' + quoteText;
        // Send the email via an AJAX request the PHP script
        if ($emailFields.valid()) {
            $.ajax({
                type : "POST",
                url : "bin/email_processing.php",
                data : dataString,
                success : function(response) {
                    $btnEmail.text('Email Quote').val('Email Quote');
                    $('#emailQuote').slideToggle('fast').find('input').not('input[type=submit]').val('');
                    $('#quote-summary').after("<div id='thankYouMessage'></div>");
                    $('#thankYouMessage').html("<h3>Thank you.</h3>").append("<p>Your email has been sent to the recipients your entered.</p>");
                }
            });
            return false;
        }
    });

});
