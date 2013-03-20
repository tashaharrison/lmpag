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
    $machineImage = $('#machine-image'), $nextMachineImage = $('#machine-image').next('#machine-title'), $grandTotalContainer = $('#cost-container .amount'), grandTotal = parseInt($grandTotalContainer.text(), 10),
    // Controls
    $btnAdd = $('#btnAdd'), $btnDel = $('#btnDel'), $btnEmail = $('#btnEmail'), $btnSubmit = $('#btnSubmit');

    // Create an instance of the machine object and default
    // assign properties
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
    $('#field-name-discharge-funnel .large, .field-name-dimensions li, #step-2, #step-3, #step-4, #step-5, #hidden-accessories-page, .container-shape-images > *, #btnAdd, #btnDel, .calculate, .spout-calculation, .field-spout .instructions p, #emailQuote').hide();
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

    // Add a waypoint to the sidebar
    // var $mi_container = $('#sidebar');
    // Remove the no-sidebar class for fallback
    $('#main-content').removeClass('no-sidebar');
    // Set the .sticky class when waypoint is reached
    // $mi_container.waypoint(function(direction) {
    // $('#machine-image-container').toggleClass('sticky',
    // direction === 'down');
    // });

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

    // Retreive form values for display on summary
    function showValues() {
    	var resultsHTML = '<tr bgcolor="#EBFFEA"><th style="text-align:right;border-right: 1px solid #0c4b81;">' + machine.name + ' ' + machine.type + '</th><td>' + machine.description + '</td><td>$' + machine.price + '</td></tr><tr><th style="text-align:right;border-right: 1px solid #0c4b81;">' + machine.weighHopper.name + '</th><td>' + machine.weighHopper.description + '</td><td>$' + machine.weighHopper.price + '</td></tr><tr bgcolor="#EBFFEA"><th style="text-align:right;border-right: 1px solid #0c4b81;">' + machine.dischargeFunnel.name + '</th><td>' + machine.dischargeFunnel.description + '</td><td>$' + machine.dischargeFunnel.price + '</td></tr>';
        var num = parseInt($('.spout-size').text());
        if (!isNaN(num)) {
            $('.spout-size').each(function() {
            	resultsHTML += '<tr><th style="text-align:right;border-right: 1px solid #0c4b81;">Spout</th><td>' + $(this).text() + ' inch</td><td>$' + spoutPrice + '</td></tr>';
            });
        }
        resultsHTML += '<tr class="total" style="text-align:right;border-top:1px solid #0c4b81;"><td>&nbsp;</td><th>Total:</th><td>$' + grandTotal + '</td></tr>';
        $('#results').empty().append(resultsHTML);
        $('#results tr').filter(':even').addClass('even').css("background-color", "#EBFFEA");

        /*var $disabled = $form.find('input:disabled').prop('disabled', false);
        $('#datastring').remove();
        dataString = $form.serialize();
        $disabled.prop('disabled', true);
        $('#quote-summary').append('<div id="datastring">' + dataString + '</div>');*/
        
        return resultsHTML;
    }

    $('#btnPrint').click(function() {
        window.print();
        return false;
    });

    $btnEmail.on('click', function() {
        var btnEmailText = $(this).val();
        if (btnEmailText == 'Cancel Email') {
            $(this).text('Email Quote').val('Email Quote');
        } else {
            $(this).text('Cancel Email').val('Cancel Email');
            $('#thankYouMessage').remove();
        }
        $('#emailQuote').slideToggle('fast');
    });

    $btnSubmit.on('click', function() {
        var $disabled = $form.find('input:disabled').prop('disabled', false);
    	var quoteSummary = $('#quote-summary').html();
        var spoutRowsText = '';
    	var num = parseInt($('.spout-size').text());
        if (!isNaN(num)) {
        	$('.spout-size').each(function() {
        		spoutRowsText += 'Spout: ' + $(this).text() + ' inch $ - ' + spoutPrice + '\r';
            });
        }
        
    	var to = $('#to').val(),
        cc = $('#cc').val(),
        message = encodeURIComponent($('#message').val().trim()),
        $emailFields = $('#to,#cc'),
        quoteHTML = encodeURIComponent('<h3 style="margin-left:10px;">Your Quote Summary</h3><table border="0" cellpadding="10" cellspacing="0" style="margin:14px;border-collapse:collapse;"><thead style="border-bottom:1px solid #0c4b81;><tr"><th style="text-align:right;">Item</th><th style="text-align:left;">Description</th><th style="text-align:left;">Price</th></tr></thead><tbody>' + showValues() + '</tbody></table>'), 
        quoteText = encodeURIComponent(machine.name + " " + machine.type + " - $" + machine.price + "\r" + machine.description + "\r\r" + machine.weighHopper.name + " - $" + machine.weighHopper.price + "\r" + machine.weighHopper.description + "\r\r" + machine.dischargeFunnel.name + " - $" + machine.dischargeFunnel.price + "\r" + machine.dischargeFunnel.description + "\r\r" + spoutRowsText + "\rTotal: $" + grandTotal);
        
    	var dataString = 'to=' + to + '&cc=' + cc + '&message=' + message + '&quoteHTML=' + quoteHTML + '&quoteText=' + quoteText;
    	// $('#quote-summary').append(dataString);
        // alert(dataString); return false;
        
        if ($emailFields.valid()) {
            $.ajax({
                type : "POST",
                url : "bin/email_processing.php",
                data : dataString,
                success : function(response) {
                	// console.log(response);
                    $btnEmail.text('Email Quote').val('Email Quote');
                    $('#emailQuote').slideToggle('fast').find('input').not('input[type=submit]').val('');
                    $('#quote-summary').after("<div id='thankYouMessage'></div>");
                    $('#thankYouMessage').html("<h3>Thank you.</h3>").append("<p>We will be in touch soon.</p>");
                }
            });
            return false;
        }
    });

    /*
     * Pages 1 - 3 selection actions
     */

    $fieldContainer.on('click', 'input[type=radio]', function(e) {
        var $fieldID = $(this), fieldContainerID = $(this).closest($fieldContainer).attr('id');
        objectName = $fieldID.attr('name'), objectVal = $fieldID.attr('id'), inputVal = $fieldID.closest('ul.field-type-radio').find('.active').attr('id'), $fieldLabel = $(this).next('label');

        if (inputVal == objectVal) {
            e.preventDefault();
        } else {

            switch (fieldContainerID) {
                case 'field-name-machine-model':
                    // Assign properties to the
                    // machine object
                    machine.id = $fieldID.attr('id');
                    machine.name = $fieldLabel.find('.name').text();
                    machine.type = $fieldLabel.find('.type').text();
                    machine.description = $fieldLabel.find('.description').text().trim();
                    machine.price = $fieldLabel.find('.amount').text();
                    // Show/Hide descriptions
                    $machineData.children(':not(h4,.price)').hide();
                    $fieldLabel.find('*').show();
                    // Assign classes to machine
                    // image and change name
                    $machineImage.removeClass('s4 s5 s6 s7').addClass(machine.id);
                    $nextMachineImage.html(machine.name + " " + machine.type);
                    break;
                case 'field-name-weigh-hopper':
                    // Assign properties to the
                    // machine.weighHopper object
                    machine.weighHopper.id = $fieldID.attr('name');
                    machine.weighHopper.name = $fieldLabel.find('.name').text();
                    machine.weighHopper.description = $fieldLabel.find('.description').text().trim();
                    machine.weighHopper.price = $fieldLabel.find('.amount').text();
                    // Assign classes to machine
                    // image
                    $machineImage.removeClass('smwh lrgwh std-fnl steep-fnl').addClass(objectVal + ' std-fnl');
                    // Show/Hide discharge funnels
                    // and reset checked properties
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
                    // Assign properties to the
                    // machine.weighHopper object
                    machine.dischargeFunnel.id = $fieldID.attr('name');
                    machine.dischargeFunnel.name = $fieldLabel.find('.name').text();
                    machine.dischargeFunnel.description = $fieldLabel.find('.description').text().trim();
                    machine.dischargeFunnel.price = $fieldLabel.find('.amount').text();
                    $machineImage.toggleClass('std-fnl steep-fnl');
                    break;
                case 'field-name-spout':
                    var fieldVal = $fieldID.val(), $spoutContainer = $fieldID.closest('fieldset');
                    $spoutContainer.find('.calculate').show();
                    // Toggle active class
                    $spoutContainer.find('input.active').removeClass('active');
                    $fieldID.addClass('active');
                    // Show the spout image
                    $machineImage.find('.spout').removeClass('hidden');
                    // Hide all the dimensions
                    // fields and images
                    $spoutContainer.find('.field-name-dimensions li').hide();
                    $spoutContainer.find('.container-shape-images > *').hide();
                    $spoutContainer.find('p').hide();

                    $spoutContainer.find('.instructions .' + fieldVal).show();
                    $spoutContainer.find('.field-name-dimensions .' + fieldVal).show();
                    $spoutContainer.find('.container-shape-images .' + fieldVal).show();
                    break;
            }
            calculateTotal($fieldID);
        }

    });

    /*
     * 'Select spouts' page
     */

    function nearestSpout(containerDiameter) {
        var closest = null, calculatedSpoutSize = containerDiameter * 0.72;
        $.each(availableSpouts, function() {
            if (closest == null || Math.abs(this - calculatedSpoutSize) < Math.abs(closest - calculatedSpoutSize)) {
                closest = this;
            }
        });
        return closest;
    }

    // Calculate the size of the spout based on the container
    $spout.on('click', '.calculate', function() {

        var num = $('fieldset.field-spout').length, $spoutContainer = $(this).closest('fieldset'),
        // The selected spout type
        $spoutSelected = $spoutContainer.find('.field-name-spout-type input:checked'), spoutSelectedVal = $spoutSelected.val(), spoutSelectedTitle = $spoutSelected.next('label').find('h4').text(),
        // Spout dimension values
        dimensionFieldWidth = parseInt($spoutContainer.find('.width input').val()), dimensionFieldD1 = parseInt($spoutContainer.find('.d1 input').val()), dimensionFieldD2 = parseInt($spoutContainer.find('.d2 input').val()), dimensionFieldDiameter = $spoutContainer.find('.diameter input').val(), spoutSize = null,
        // Visisble dimension fields
        $dimensionFieldsVisible = $spoutContainer.find('.field-type-textfield input').filter(":visible");
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
            $spoutContainer.find('.spout-calculation').show().find('.spout-size').text(spoutSize);
            if (num < 3) {
                $btnAdd.show();
            }
            $(this).hide();
            $spoutContainer.find('.field-name-spout-type,.description').hide();
            $dimensionFieldsVisible.prop("disabled", true);
            $btnDel.show().prop('disabled', false);
            // price = parseInt($('#spout' + num
            // + ' input.active + label
            // .amount').text(), 10);
            grandTotal += spoutPrice;
            $grandTotalContainer.html(grandTotal);
        }

    });

    // Buttons for adding a deleting spouts
    $btnAdd.click(function() {
        // Find out the amount of existing fields and
        // add the next number
        var num = $('fieldset.field-spout').length, newNum = +num + 1,
        // the numeric ID of the new input field being
        // added
        newSpoutID = 'spout' + newNum, newSpoutIDUpper = newSpoutID.capitalise(), newSpoutTypeID = "type" + newSpoutIDUpper,

        // create the new element via clone() give it
        // the new ID using newNum value
        newElem = $('#spout' + num).clone().attr('id', newSpoutID);
        // manipulate the name/id values of the spout
        // type inputs inside the new element
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
        // Hide spout calculation result
        newElem.find('.spout-calculation').hide();

        // Insert the new element after the last spout
        $('#spout' + num).after(newElem);
        // enable the "remove" button and hide the 'add'
        // button
        $btnDel.show().prop('disabled', false);
        $btnAdd.hide();

    });

    $btnDel.click(function() {
        // Check the number of spouts
        var num = $('fieldset.field-spout').length, $spoutField = $("#spout" + num);

        // price = parseInt($('#spout' + num + '
        // input.active + label .amount').text(), 10);
        grandTotal -= spoutPrice;
        $grandTotalContainer.html(grandTotal);

        // Disable the "remove" button
        if (num == 1) {
            // $btnDel.hide().attr('disabled',
            // 'disabled');
            $spoutField.find('.field-name-spout-type').show().find('input').removeClass('active').prop('checked', false);
            $spoutField.find('.description').show().find('p').hide().filter('.spout-selection').show();
            $spoutField.find('.field-name-dimensions li').hide().find('input').prop('disabled', false).val("");
            $spoutField.find('.container-shape-images > *').hide();
            $spoutField.find('.spout-calculation').hide().find('.spout-size').empty();
            $btnAdd.hide();
            $btnDel.hide();
        } else {
            // Remove the last spout
            $('#spout' + num).remove();
        }
        // Show the "add" button
        if (num == 3)
            $btnAdd.show();

    });

    /*
     * Navigation
     */

    $('.step-pager button').click(function() {
        var $stepContainer = $(this).closest('.step-container'), nextStepContainerID = $stepContainer.next().attr('id'), prevStepContainerID = $stepContainer.prev().attr('id');

        $('#pag-navigation a').removeClass('active');

        if ($(this).is('.next')) {
            $stepContainer.hide().next().show();
            $('#pag-navigation a[href*=' + nextStepContainerID + ']').addClass('active');
        } else {
            $stepContainer.hide().prev().show();
            $('#pag-navigation a[href*=' + prevStepContainerID + ']').addClass('active');
        }
        if ($(this).is('#step-4-pager button.next'))
            showValues();
    	$('#thankYouMessage').remove();
        if ($(this).is('#step-2-pager button.prev'))
            location.reload();
    });

    $('#pag-navigation a').click(function() {
        var stepValue = $(this).attr('href');

        $('#pag-navigation a').removeClass('active');
        $(this).addClass('active');
        $('.step-container').hide();
        $(stepValue).show();
        if (stepValue === "#step-5")
            showValues();
    	$('#thankYouMessage').remove();
        if (stepValue === "#step-1")
            location.reload();
    });

    /*
     * Hidden accessories page
     */

    $('#hidden-accessories-page-btn').click(function() {
        $('#hidden-accessories-page').show();
    });
    $('#btnClose,#btnContinue').click(function() {
        $(this).closest('.step-container').hide();
    });

});
