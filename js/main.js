$(document).ready(function() {

    /*
     *  Validation criteria
     */

    var dimensionValidationRules = {
        required : true,
        number : true,
    };
    var dimensionValidationMessages = {
        required : "This is a required field.",
        number : "Please enter a number.",
    };

    $("#logical-machines-price-accesory-guide").validate({
        rules : {
            width : dimensionValidationRules,
            d1 : dimensionValidationRules,
            d2 : dimensionValidationRules,
            diameter : dimensionValidationRules
        },
        messages : {
            width : dimensionValidationMessages,
            d1 : dimensionValidationMessages,
            d2 : dimensionValidationRules,
            diameter : dimensionValidationMessages
        }
    });

    /*
    *  Declare global variables
    */

    // Field containers
    var $fieldContainer = $('.field-container'), $machineModel = $('#field-name-machine-model'), $weighHopper = $('#field-name-weight-hopper'), $dischargeFunnel = $('#field-name-discharge-funnel'), $spout = $('#field-name-spout'),
    // Field labels for extracting data
    $machineData = $machineModel.find('label'), $weighHopperData = $weighHopper.find($('label')), $dischargeFunnelData = $dischargeFunnel.find($('label')),
    // Machine image variables
    $machineImage = $('#machine-image'), $nextMachineImage = $('#machine-image').next('#machine-title'), $grandTotalContainer = $('#cost-container .amount'), grandTotal = parseInt($grandTotalContainer.text(), 10),
    // Controls
    $btnAdd = $('#btnAdd'), $btnDel = $('#btnDel');

    //Create an instance of the machine object and default assign properties
    var machine = {
        id : $machineData.first().attr('for'),
        name : $machineData.first().find('.name').text(),
        type : $machineData.first().find('.type').text(),
        description : $machineData.first().find('.description').text(),
        price : $machineData.first().find('.amount').text(),
        weighHopper : {
            id : $weighHopperData.first().attr('for'),
            name : $weighHopperData.first().find('.name').text(),
            description : $weighHopperData.first().find('.description').text(),
            price : $weighHopperData.first().find('.amount').text()
        },
        dischargeFunnel : {
            id : $dischargeFunnelData.first().attr('for'),
            name : $dischargeFunnelData.first().find('.name').text(),
            description : $dischargeFunnelData.first().find('.description').text(),
            price : $dischargeFunnelData.first().find('.amount').text()
        }
    };

    /*
    *  Document ready JS
    */

    // Hide fallback content, add and delete button
    $('#field-name-discharge-funnel .large, .field-name-dimensions li, #step-2, #step-3, #step-4, #step-5, #hidden-accessories-page, .container-shape-images > *, #btnAdd, #btnDel, .calculate, .spout-calculation, .field-spout .instructions p').hide();
    $('.field-spout .instructions p.spout-selection').show();
    // Remove fallback form elements
    $('.default-field-spout,.default-discharge-funnel,#btnQuote').remove();
    // .bottom class puts a negative z-index on the hidden
    // accessories page so that it loads underneath the rest of
    // the content. This removes that class on load.
    $('.bottom').removeClass('bottom');
    // Hide all but the first machine model description
    $machineModel.find('.description').not(':first').hide();
    // Remove .hidden class from JS ready content
    $('#field-name-discharge-funnel li, #btnAdd, #btnDel, #btnFront, #btnSide, .field-spout, .step-submit, #sidebar, #btnPrint, #btnEmail,#btnClose, #btnContinue, .order-summary, #hidden-accessories-page, #machine-title, #order-summary').removeClass('hidden');
    // Check the default discharge funnel field
    $dischargeFunnel.find($('.small #small-std-fnl')).prop('checked', true).addClass('active');

    // Add a waypoint to the sidebar
    //var $mi_container = $('#sidebar');
    // Remove the no-sidebar class for fallback
    $('#main-content').removeClass('no-sidebar');
    // Set the .sticky class when waypoint is reached
    //$mi_container.waypoint(function(direction) {
    //    $('#machine-image-container').toggleClass('sticky', direction === 'down');
    //});

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
    *  General functions
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
    $('#btnFront,#btnSide').click(function() {
        var btnDirection = $(this).val();

        if (btnDirection === 'Front') {
            $machineImage.addClass('front').removeClass('side');
        } else {
            $machineImage.addClass('side').removeClass('front');
        }

    });

    // Retreive form values for display on summary
    function showValues() {

        $('#results').empty().append('<tr><th>' + machine.name + ' ' + machine.type + '</th><td>' + machine.description + '</td><td>$' + machine.price + '</td></tr><tr><th>' + machine.weighHopper.name + '</th><td>' + machine.weighHopper.description + '</td><td>$' + machine.weighHopper.price + '</td></tr><tr><th>' + machine.dischargeFunnel.name + '</th><td>' + machine.dischargeFunnel.description + '</td><td>$' + machine.dischargeFunnel.price + '</td></tr>' + showProps(machine, 'machine'));
        var num = parseInt($('.spout-size').text());
        if (!isNaN(num)) {
            $('.spout-size').each(function() {
                $('#results').append('<tr><th>Spout</th><td>' + $(this).text() + ' inch</td><td>$150</td></tr>');
            });
        }
        $('#results').append('<tr class="total"><td>&nbsp;</td><th>Total:</th><td>$' + grandTotal + '</td></tr>');
        $('#results tr').filter(':even').addClass('even');

        /*var fields = $(':input').serializeArray();
         $('#results').empty();
         $.each(fields, function(i, field) {
         $('#results').append('<tr><td>' + field.name + '</td><td>' + field.value + '</td></tr>');
         });*/
    }

    function showProps(obj, objName) {
        var result = "";
        for (var i in obj) {
            if (obj.hasOwnProperty(i)) {
                result += objName + "." + i + " = " + obj[i] + "\n";
            }
        }
        return result;
    }

    /*
     *  Pages 1 - 3 selection actions
     */

    $fieldContainer.on('click', 'input[type=radio]', function(e) {
        var $fieldID = $(this), fieldContainerID = $(this).closest($fieldContainer).attr('id');
        objectName = $fieldID.attr('name'), objectVal = $fieldID.attr('id'), inputVal = $fieldID.closest('ul.field-type-radio').find('.active').attr('id'), $fieldLabel = $(this).next('label');

        if (inputVal == objectVal) {
            e.preventDefault();
            //add this to prevent default click behaviour
        } else {

            switch (fieldContainerID) {
                case 'field-name-machine-model':
                    // Assign properties to the machine object
                    machine.id = $fieldID.attr('id');
                    machine.name = $fieldLabel.find('.name').text();
                    machine.type = $fieldLabel.find('.type').text();
                    machine.description = $fieldLabel.find('.description').text();
                    machine.price = $fieldLabel.find('.amount').text();
                    // Show/Hide descriptions
                    $machineData.children(':not(h4,.price)').hide();
                    $fieldLabel.find('*').show();
                    // Assign classes to machine image and change name
                    $machineImage.removeClass('s4 s5 s6 s7').addClass(machine.id);
                    $nextMachineImage.html(machine.name + " " + machine.type);
                    break;
                case 'field-name-weight-hopper':
                    // Assign properties to the machine.weighHopper object
                    machine.weighHopper.id = $fieldID.attr('name');
                    machine.weighHopper.name = $fieldLabel.find('.name').text();
                    machine.weighHopper.description = $fieldLabel.find('.description').text();
                    machine.weighHopper.price = $fieldLabel.find('.amount').text();
                    // Assign classes to machine image
                    $machineImage.removeClass('smwh lrgwh std-fnl steep-fnl').addClass(objectVal + ' std-fnl');
                    // Show/Hide discharge funnels and reset checked properties
                    componentSize = $fieldID.closest('li').attr('class');
                    $dischargeFunnel.find($('li')).hide().filter($('.' + componentSize)).show();
                    $dischargeFunnel.find($('input')).prop('checked', false);
                    if (componentSize === 'small')
                        $dischargeFunnel.find($('.small #small-std-fnl')).prop('checked', true);
                    break;
                case 'field-name-discharge-funnel':
                    // Assign properties to the machine.weighHopper object
                    machine.dischargeFunnel.id = $fieldID.attr('name');
                    machine.dischargeFunnel.name = $fieldLabel.find('.name').text();
                    machine.dischargeFunnel.description = $fieldLabel.find('.description').text();
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
                    // Hide all the dimensions fields and images
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
    *  'Select spouts' page
    */

    // Calculate the size of the spout based on the container

    $spout.on('click', '.calculate', function() {

        var num = $('fieldset.field-spout').length, $spoutContainer = $(this).closest('fieldset'),
        // The selected spout type
        $spoutSelected = $spoutContainer.find('.field-name-spout-type input:checked'), spoutSelectedVal = $spoutSelected.val(), spoutSelectedTitle = $spoutSelected.next('label').find('h4').text(),
        // Spout dimension values
        dimensionFieldWidth = parseInt($spoutContainer.find('.width input').val()), dimensionFieldD1 = $spoutContainer.find('.d1 input').val(), dimensionFieldD2 = $spoutContainer.find('.d2 input').val(), dimensionFieldDiameter = $spoutContainer.find('.diameter input').val(),
        // Visisble dimension fields
        $dimensionFieldsVisible = $spoutContainer.find('.field-type-textfield input').filter(":visible");
        if ($dimensionFieldsVisible.valid()) {
            var spoutSize;
            switch (spoutSelectedVal) {
                case 'flat-bag':
                    if (dimensionFieldWidth < 2) {
                        spoutSize = 0.75;
                    } else if (dimensionFieldWidth >= 2 && 2.4 >= dimensionFieldWidth) {
                        spoutSize = 1;
                    } else if (dimensionFieldWidth >= 2.5 && 2.9 >= dimensionFieldWidth) {
                        spoutSize = 1.25;
                    } else if (dimensionFieldWidth >= 3 && 3.5 >= dimensionFieldWidth) {
                        spoutSize = 1.5;
                    } else if (dimensionFieldWidth >= 3.6 && 3.9 >= dimensionFieldWidth) {
                        spoutSize = 1.75;
                    } else if (dimensionFieldWidth >= 4 && 4.9 >= dimensionFieldWidth) {
                        spoutSize = 2;
                    } else if (dimensionFieldWidth >= 5 && 5.9 >= dimensionFieldWidth) {
                        spoutSize = 2.5;
                    } else if (dimensionFieldWidth >= 6 && 6.5 >= dimensionFieldWidth) {
                        spoutSize = 3;
                    } else {
                        spoutSize = 3.5;
                    }
                    break;
                case 'four-sided-bag':
                    alert(dimensionFieldD1 + " " + dimensionFieldD2);
                    break;
                case 'can-jar':
                    alert(dimensionFieldDiameter);
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
            // price = parseInt($('#spout' + num + ' input.active + label .amount').text(), 10);
            grandTotal += 150;
            $grandTotalContainer.html(grandTotal);
        }

    });

    // Buttons for adding a deleting spouts
    $btnAdd.click(function() {
        // Find out the amount of existing fields and add the next number
        var num = $('fieldset.field-spout').length, newNum = +num + 1,
        // the numeric ID of the new input field being added
        newSpoutID = 'spout' + newNum, newSpoutIDUpper = newSpoutID.capitalise(), newSpoutTypeID = "type" + newSpoutIDUpper,

        // create the new element via clone() give it the new ID using newNum value
        newElem = $('#spout' + num).clone().attr('id', newSpoutID);
        // manipulate the name/id values of the spout type inputs inside the new element
        newElem.find('legend').html('Spout ' + newNum).next().show().find('input').attr({
            "id" : function(arr) {
                return "type" + arr + newSpoutIDUpper;
            },
            'name' : newSpoutTypeID
        }).prop('checked', false).removeClass('active').next().attr('for', function(arr) {
            return "type" + arr + newSpoutIDUpper;
        });

        // Reset the field descriptions
        newElem.find('.description').show().find('p').hide().filter('.spout-selection').show();
        // Reset the dimension fields
        newElem.find('.field-name-dimensions li').hide().find('input').prop('disabled', false).val("");
        // Hide container shape images
        newElem.find('.container-shape-images > *').hide();
        // Hide spout calculation result
        newElem.find('.spout-calculation').hide();

        // Insert the new element after the last spout
        $('#spout' + num).after(newElem);
        // enable the "remove" button and hide the 'add' button
        $btnDel.show().prop('disabled', false);
        $btnAdd.hide();

    });

    $btnDel.click(function() {
        // Check the number of spouts
        var num = $('fieldset.field-spout').length, $spoutField = $("#spout" + num);

        // price = parseInt($('#spout' + num + ' input.active + label .amount').text(), 10);
        grandTotal -= 150;
        $grandTotalContainer.html(grandTotal);

        // Disable the "remove" button
        if (num == 1) {
            //$btnDel.hide().attr('disabled', 'disabled');
            $spoutField.find('.field-name-spout-type').show().find('input').prop('checked', false);
            $spoutField.find('.description').show().find('p').hide().filter('.spout-selection').show();
            $spoutField.find('.field-name-dimensions li').hide().find('input').prop('disabled', false).val("");
            $spoutField.find('.container-shape-images > *').hide();
            $spoutField.find('.spout-calculation').hide();
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
     *  Navigation
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
        if ($(this).is('#step-4-pager button'))
            showValues();

    });

    $('#pag-navigation a').click(function() {
        var stepValue = $(this).attr('href');

        $('#pag-navigation a').removeClass('active');
        $(this).addClass('active');
        $('.step-container').hide();
        $(stepValue).show();
        if (stepValue === "#step-5")
            showValues();

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

});
