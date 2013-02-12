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
            widthInches : dimensionValidationRules,
            heightInches : dimensionValidationRules,
            diameterInches : dimensionValidationRules
        },
        messages : {
            widthInches : dimensionValidationMessages,
            heightInches : dimensionValidationMessages,
            diameterInches : dimensionValidationMessages
        }
    });

    /*
     *  Declare global variables
     */

    var $machineModelDesc = $('.machine-model-description'), $machineImage = $('#machine-image'), $nextMachineImage = $('#machine-image').next('#machine-title'), $btnAdd = $('#btnAdd'), $btnDel = $('#btnDel'), $grandTotalContainer = $('#cost-container .amount'), grandTotal = parseInt($grandTotalContainer.text(), 10),
    // S-4 Machine attributes
    $s4Machine = $('label[for="s4"]'),
    // s4MachineName = $s4Machine.find('.machineName').text(), s4MachineType = $s4Machine.find('.machineType').text(), s4MachineDesc = $s4Machine.find('.description p:first').text(), s4MachinePrice = $s4Machine.find('.amount').text(),
    // S-5Machine attributes
    $s5Machine = $('label[for="s5"]'),
    // s5MachineName = $s5Machine.find('.machineName').text(), s5MachineType = $s5Machine.find('.machineType').text(), s5MachineDesc = $s5Machine.find('.description p:first').text(), s5MachinePrice = $s5Machine.find('.amount').text(),
    // S-6 Machine attributes
    $s6Machine = $('label[for="s6"]'),
    // s6MachineName = $s6Machine.find('.machineName').text(), s6MachineType = $s6Machine.find('.machineType').text(), s6MachineDesc = $s6Machine.find('.description p:first').text(), s6MachinePrice = $s6Machine.find('.amount').text(),
    // S-7 Machine attributes
    $s7Machine = $('label[for="s7"]');
    // s7MachineName = $s7Machine.find('.machineName').text(), s7MachineType = $s7Machine.find('.machineType').text(), s7MachineDesc = $s7Machine.find('.description p:first').text(), s7MachinePrice = $s7Machine.find('.amount').text();

    $('.field-name-machine-model label').each(function(index) {
        var machineID = $(this).attr('id');
    });

    //Create instances of the machine object and assign
    //properties
    machineS4 = {
        machineName : $s4Machine.find('.machineName').text(),
        machineType : $s4Machine.find('.machineType').text(),
        machineDesc : $s4Machine.find('.description p:first').text(),
        machinePrice : $s4Machine.find('.amount').text()
    };
    machineS5 = {
        machineName : $s5Machine.find('.machineName').text(),
        machineType : $s5Machine.find('.machineType').text(),
        machineDesc : $s5Machine.find('.description p:first').text(),
        machinePrice : $s5Machine.find('.amount').text()
    };
    machineS6 = {
        machineName : $s6Machine.find('.machineName').text(),
        machineType : $s6Machine.find('.machineType').text(),
        machineDesc : $s6Machine.find('.description p:first').text(),
        machinePrice : $s6Machine.find('.amount').text()
    };
    machineS7 = {
        machineName : $s7Machine.find('.machineName').text(),
        machineType : $s7Machine.find('.machineType').text(),
        machineDesc : $s7Machine.find('.description p:first').text(),
        machinePrice : $s7Machine.find('.amount').text()
    };

    /*
    *  Document ready JS
    */

    // Hide fallback content, add and delete button
    $('.large-discharge-funnel,.field-name-dimensions li,#step-2,#step-3,#step-4,#step-5,#hidden-accessories-page,.spout-shape-images > *,#btnAdd,#btnDel,.btnCalculate,.spoutCalculation,.flatBagDesc,.fourSidedBagDesc,.canJarDesc').hide();
    // Remove fallback form elements
    $('.default-spout,.default-discharge-funnel,#btnQuote').remove();
    // .bottom class puts a negative z-index on the hidden
    // accessories page so that it loads underneath the rest of
    // the content. This removes that class on load.
    $('.bottom').removeClass('bottom');
    // Hide all but the first machine model description
    $machineModelDesc.not('.machine-model-description:first').hide();
    // Remove .hidden class from JS ready content
    $('.small-discharge-funnel,.large-discharge-funnel,#btnAdd,#btnDel,#btnFront,#btnSide,.cloneSpout,.step-submit,#sidebar,#btnPrint,#btnEmail,#btnClose,#btnContinue,.order-summary,#hidden-accessories-page,#machine-title,#order-summary').removeClass('hidden');
    // Check the default discharge funnel field
    $('#small-standard-discharge-funnel').prop('checked', true).addClass('active');

    // Add a waypoint to the sidebar
    var $mi_container = $('#sidebar');
    // Remove the no-sidebar class for fallback
    $('#main-content').removeClass('no-sidebar');
    // Set the .sticky class when waypoint is reached
    $mi_container.waypoint(function(direction) {
        $('#machine-image-container').toggleClass('sticky', direction === 'down');
    });

    /*
    *  General functions
    */

    // Calculate the grand total
    function calculateTotal($fieldID) {
        var price = parseInt($fieldID.next('label').find(".amount").text(), 10), siblingAmounts = 0, radioName = $fieldID.attr("name");

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

        var fields = $(":input").serializeArray();
        $("#results").empty();
        $.each(fields, function(i, field) {
            $("#results").append("<tr><td>" + field.name + "</td><td>" + field.value + "</td></tr>");
        });
    }

    /*
     *  Pages 1 - 3 selection actions
     */

    function radioSelect() {
        var $radioInputFields = $('input[name=machine-model],input[name=weight-hopper],input[name=discharge-funnel]');

        $radioInputFields.click(function(e) {
            var $fieldID = $(this), inputVal = $fieldID.closest('ul.field-type-radio').find('.active').attr('id'), objectVal = $fieldID.attr('id');

            if (inputVal == objectVal) {
                e.preventDefault();
                //add this to prevent default click behaviour
            } else {

                var fieldVal = $fieldID.val(), radioName = $fieldID.attr("name");

                switch (fieldVal) {
                    case 'S-4':
                        $machineModelDesc.hide();
                        $s4Machine.find('.machine-model-description').show();
                        $machineImage.removeClass('s4 s5 s6 s7').addClass('s4');
                        $nextMachineImage.html(machineS4.machineName + " " + machineS4.machineType);
                        break;
                    case 'S-5':
                        $machineModelDesc.hide();
                        $s5Machine.find('.machine-model-description').show();
                        $machineImage.removeClass('s4 s5 s6 s7').addClass('s5');
                        $nextMachineImage.html(machineS5.machineName + " " + machineS5.machineType);
                        break;
                    case 'S-6':
                        $machineModelDesc.hide();
                        $s6Machine.find('.machine-model-description').show();
                        $machineImage.removeClass('s4 s5 s6 s7').addClass('s6');
                        $nextMachineImage.html(machineS6.machineName + " " + machineS6.machineType);
                        break;
                    case 'S-7':
                        $machineModelDesc.hide();
                        $s7Machine.find('.machine-model-description').show();
                        $machineImage.removeClass('s4 s5 s6 s7').addClass('s7');
                        $nextMachineImage.html(machineS7.machineName + " " + machineS7.machineType);
                        break;
                    case 'small-weight-hopper':
                        $('.small-discharge-funnel').show().find('#small-standard-discharge-funnel').prop('checked', true);
                        $('.large-discharge-funnel').hide().find('input').prop('checked', false);
                        $machineImage.removeClass('smwh lrgwh std-fnl steep-fnl').addClass('smwh std-fnl');
                        break;
                    case 'large-weight-hopper':
                        $('.large-discharge-funnel').show().find('#large-standard-discharge-funnel').prop('checked', false);
                        $('.small-discharge-funnel').hide().find('input').prop('checked', false);
                        $machineImage.removeClass('smwh lrgwh std-fnl steep-fnl').addClass('lrgwh std-fnl');
                        break;
                    case 'small-steep-funnel':
                    case 'large-steep-funnel':
                    case 'small-standard-discharge-funnel':
                    case 'large-standard-discharge-funnel':
                        $machineImage.toggleClass('std-fnl steep-fnl');
                        break;

                }
                calculateTotal($fieldID);
            }
        });
    }

    radioSelect();

    /*
    *  'Select spouts' page
    */

    // React to the selection of the spout type
    function spoutSelect() {
        $('input.spout-type').click(function() {
            var $fieldID = $(this), fieldVal = $fieldID.val(), $spoutContainer = $fieldID.closest('fieldset');

            $spoutContainer.find('.btnCalculate').show();
            // Toggle active class
            $spoutContainer.find('input.active').removeClass('active');
            $fieldID.addClass('active');
            // Show the spout image
            $machineImage.find('.spout').removeClass('hidden');
            // Hide all the dimensions fields and images
            $spoutContainer.find('.field-name-dimensions li').hide();
            $spoutContainer.find('.spout-shape-images > *').hide();
            $spoutContainer.find('p').hide();

            switch (fieldVal) {
                case 'flag-bag':
                    $spoutContainer.find('.spout-width-inches').show();
                    $spoutContainer.find('.spout-shape-images > .flat-bag-spout-shape').show();
                    $spoutContainer.find('.description .flatBagDesc').show();
                    break;
                case '4-sided-bag':
                    $spoutContainer.find('.spout-width-inches,.spout-height-inches').show();
                    $spoutContainer.find('.spout-shape-images > .four-sided-bag-spout-shape').show();
                    $spoutContainer.find('.description .fourSidedBagDesc').show();
                    break;
                case 'can-jar':
                    $spoutContainer.find('.spout-diameter-inches').show();
                    $spoutContainer.find('.spout-shape-images > .can-or-jar-spout-shape').show();
                    $spoutContainer.find('.description .canJarDesc').show();
                    break;
            }

        });
    }

    spoutSelect();

    // Calculate the size of the spout based on the container
    function calculateSpoutSize() {
        $('.btnCalculate').click(function() {

            var num = $('.cloneSpout').length, $spoutContainer = $(this).closest('fieldset'),
            // The selected spout type
            $spoutSelected = $spoutContainer.find('.field-name-spout-type input:checked'), spoutSelectedVal = $spoutSelected.val(), spoutSelectedTitle = $spoutSelected.next('label').find('h4').text();
            // Spout dimension values
            dimensionFieldWidth = $spoutContainer.find('#spout1WidthInches').val(), dimensionFieldHeight = $spoutContainer.find('#spout1HeightInches').val(), dimensionFieldDiameter = $spoutContainer.find('#spout1DiameterInches').val(),
            // Visisble dimension fields
            $dimensionFieldsVisible = $spoutContainer.find('.field-type-textfield input').filter(":visible");

            if ($dimensionFieldsVisible.valid()) {
                var spoutSize = 0;
                switch (spoutSelectedVal) {
                    case 'flag-bag':
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
                    case '4-sided-bag':
                        alert(dimensionFieldWidth + " " + dimensionFieldHeight);
                        break;
                    case 'can-jar':
                        alert(dimensionFieldDiameter);
                        break;
                }
                $spoutContainer.find('.spoutCalculation').show().find('.spout-name').text(spoutSelectedTitle).next('.spout-size').text(spoutSize);
                if (num < 3) {
                    $btnAdd.show();
                }
                $(this).hide();
                $spoutContainer.find('.field-name-spout-type,.description').hide();
                $dimensionFieldsVisible.prop("disabled", true);
                $btnDel.show().prop('disabled', false);
            }
        });
    }

    calculateSpoutSize();

    // Buttons for adding a deleting spouts
    $btnAdd.click(function() {
        var num = $('.cloneSpout').length, newNum = new Number(num + 1),
        // the numeric ID of the new input field
        // being
        // added
        newSpoutID = 'spout' + newNum, newSpoutTypeID = 'spout' + newNum + "type", newSpoutDimensionsID = 'spout' + newNum + "dimensions",
        // create the new element via clone(),
        // and
        // manipulate it's ID using newNum value
        newElem = $('#spout' + num).clone().attr('id', newSpoutID),
        // manipulate the name/id values of the
        // elements
        // inside the new element
        radioFieldID = 1;
        newElem.children('legend').html('Spout ' + newNum).next().attr('id', newSpoutTypeID).find('input').attr({
            "id" : function(arr) {
                return newSpoutTypeID + arr
            },
            'name' : newSpoutTypeID
        }).prop('checked', false).removeClass('active').next().attr('for', function(arr) {
            return newSpoutTypeID + arr
        });

        newElem.find('.spout-shape-images > *').hide()
        newElem.children('.field-name-dimensions').attr('id', newSpoutDimensionsID).find('li').hide().find('.spout-width-inches input').attr('id', newSpoutID + "-width-inches").closest('.field-name-dimensions').find('.spout-height-inches input').attr('id', newSpoutID + "-height-inches").closest('.field-name-dimensions').find('.spout-diameter-inches input').attr('id', newSpoutID + "-diameter-inches");
        newElem.find('.field-name-spout-type').show().find('input').prop('checked', false);
        newElem.find('.description').show().find('p').hide().filter('.spout-selection').show();
        newElem.find('.field-name-dimensions li input').prop('disabled', false).val("");
        newElem.find('.spoutCalculation').hide()
        // insert the new element after the last
        // "duplicatable" input field
        $('#spout' + num).after(newElem);

        // enable the "remove" button
        $btnDel.show().prop('disabled', false);

        // business rule: you can only add 5
        // names
        $btnAdd.hide();

        spoutSelect();
        calculateSpoutSize();

    });

    $btnDel.click(function() {
        // Check the number of spouts
        var num = $('.cloneSpout').length, $spoutField = $("#spout" + num);

        //if ($('#spout' + num + ' input').hasClass('active')) {
        //    price = parseInt($('#spout' + num + ' input.active + label .amount').text(), 10);
        //    grandTotal -= price;
        //    $grandTotalContainer.html(grandTotal);
        //}

        // Disable the "remove" button
        if (num == 1) {
            //$btnDel.hide().attr('disabled', 'disabled');
            $spoutField.find('.field-name-spout-type').show().find('input').prop('checked', false);
            $spoutField.find('.description').show().find('p').hide().filter('.spout-selection').show();
            $spoutField.find('.field-name-dimensions li').hide().find('input').prop('disabled', false).val("");
            $spoutField.find('.spout-shape-images > *').hide();
            $spoutField.find('.spoutCalculation').hide()
            $btnAdd.hide();
            $btnDel.hide();
        } else {
            // Remove the last spout
            $('#spout' + num).remove();
        }
        // Show the "add" button
        if (num == 3) {
            $btnAdd.show();
        }
    });

    /*
     *  Navigation
     */

    $('.step-submit').click(function() {
        var $stepContainer = $(this).closest('.step-container'), nextStepContainerID = $stepContainer.next().attr('id'), prevStepContainerID = $stepContainer.prev().attr('id');
        $('#pag-navigation a').removeClass('active');

        if ($(this).is('.next')) {
            $stepContainer.hide().next().show();
            $('#pag-navigation a[href*=' + nextStepContainerID + ']').addClass('active');
        } else {
            $stepContainer.hide().prev().show();
            $('#pag-navigation a[href*=' + prevStepContainerID + ']').addClass('active');
        }
        if ($(this).is('#step-4-next')) {
            showValues();
        }
    });

    $('#pag-navigation a').click(function() {
        var stepValue = $(this).attr('href');
        $('#pag-navigation a').removeClass('active');
        $(this).addClass('active');
        $('.step-container').hide();
        $(stepValue).show();
        if (stepValue === "#step-5") {
            showValues();
        }
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
