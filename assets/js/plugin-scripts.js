jQuery(document).ready(function ($) {
    var currentStep = 1;
    var form = $('#pr-multi-step-form');
    var formContainer = $('#pr-multi-step-form-container');
    var statusDiv = form.find('.pr-form-status');
    var steps = form.find('.pr-form-step');
    var totalSteps = steps.length;
    var submitButton = form.find('.pr-submit-btn'); 

    // --- Client-Side Validation ---
    function validateStep(stepNumber) {
        var isValid = true;
        var currentStepElement = $('#pr-step-' + stepNumber);
        var requiredFields = currentStepElement.find('[required]').filter(function() {
            return $(this).closest('.pr-conditional-field.hidden').length === 0 && $(this).is(':visible');
        });

        // Remove previous error styling within the current step
        currentStepElement.find('.error').removeClass('error');
        clearStatusMessage(); 

        requiredFields.each(function() {
            var field = $(this);
            var fieldValue = field.val() ? $.trim(field.val()) : '';
            var fieldType = field.attr('type');
            var tagName = field.prop("tagName").toLowerCase();
            var fieldName = field.attr('name');
            var validationFailed = false;

            if (tagName === 'select') {
                if (!fieldValue) {
                   validationFailed = true;
                }
            } else if (fieldType === 'radio') {
                if ($('input[name="' + fieldName + '"]:checked', currentStepElement).length === 0) {
                    field.closest('.pr-radio-group').addClass('error');
                    validationFailed = true;
                } else {
                     field.closest('.pr-radio-group').removeClass('error');
                }
            } else if (fieldType === 'checkbox') {
                 if (!field.is(':checked')) {
                    field.closest('.pr-checkbox-option').addClass('error'); 
                    validationFailed = true;
                 } else {
                     field.closest('.pr-checkbox-option').removeClass('error');
                 }
            } else if (fieldType === 'date') {
                 if (!fieldValue) {
                    validationFailed = true;
                 } else if (!/^\d{4}-\d{2}-\d{2}$/.test(fieldValue)) { 
                     console.warn('Invalid date format detected for:', fieldName);
                 }
            } else if (fieldType === 'tel') {
                  if (!fieldValue && field.is('[required]')) {
                     validationFailed = true;
                  }
            }
            else { 
                if (!fieldValue) {
                     validationFailed = true;
                }
            }
            if (validationFailed && fieldType !== 'radio' && fieldType !== 'checkbox') {
                field.addClass('error');
                isValid = false;
            } else if (!validationFailed && fieldType !== 'radio' && fieldType !== 'checkbox') {
                 field.removeClass('error');
            } else if (validationFailed && (fieldType === 'radio' || fieldType === 'checkbox')){
                isValid = false;
            }

        }); 

        if (!isValid) {
             showStatusMessage( 'error', '<p>' + pr_ajax.validation_message + '</p>' );
        } else {
            clearStatusMessage(); 
        }

        return isValid;
    }

    // --- Conditional Logic for Flight Info (Step 2) ---
    var sameFlightSelect = $('#pr-same-flight');
    var flightInfoWrapper = $('#pr-flight-info-wrapper');
    var flightInfoTextarea = $('#pr-departure-flight-info');
    var flightInfoRequiredAsterisk = $('#pr-flight-info-required');

    function toggleFlightInfo() {
        if (sameFlightSelect.val() === 'Yes') {
            flightInfoWrapper.slideDown(200).removeClass('hidden');
            flightInfoTextarea.prop('required', true);
            flightInfoRequiredAsterisk.show();
        } else {
            flightInfoWrapper.slideUp(200, function() { $(this).addClass('hidden'); }); 
            flightInfoTextarea.prop('required', false);
            flightInfoTextarea.removeClass('error'); 
            flightInfoRequiredAsterisk.hide();
        }
    }
    if(sameFlightSelect.length) {
        toggleFlightInfo();
        sameFlightSelect.on('change', toggleFlightInfo);
    }


    // --- Navigation ---
    function showStep(stepNumber) {
      
        steps.not('#pr-step-' + stepNumber).find('.error').removeClass('error');
        steps.filter('.active').find('.pr-radio-group.error, .pr-checkbox-option.error').removeClass('error'); 

        steps.removeClass('active');
        $('#pr-step-' + stepNumber).addClass('active').hide().fadeIn(300);
        $('.pr-indicator', '.pr-step-indicators').removeClass('active');
        $('.pr-indicator:nth-child(' + stepNumber + ')', '.pr-step-indicators').addClass('active');
        currentStep = stepNumber;

        // Handle prev/next/submit button states
        form.find('.pr-prev-btn').prop('disabled', (stepNumber === 1));
        form.find('.pr-next-btn').toggle(stepNumber < totalSteps); 
        submitButton.toggle(stepNumber === totalSteps); 

        clearStatusMessage(); 
    }

    form.on('click', '.pr-next-btn', function () {
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                showStep(currentStep + 1);
            }
        }
    });

    form.on('click', '.pr-prev-btn', function () {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    });

    // --- Form Submission ---
    form.on('submit', function (e) {
        e.preventDefault();
        if (!validateStep(currentStep)) {
            $('html, body').animate({ scrollTop: statusDiv.offset().top - 50 }, 300); 
        }

        clearStatusMessage();
        showLoading(true);

        var formData = form.serialize();
         formData += '&action=pr_submit_form'; 
         formData += '&pr_nonce_field=' + pr_ajax.nonce; 


        $.ajax({
            url: pr_ajax.ajax_url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                showLoading(false);
                if (response.success) {
                    showStatusMessage('success', '<p>' + (response.data.message || pr_ajax.success_message) + '</p>');
                    form[0].reset();
                     if(sameFlightSelect.length) { toggleFlightInfo(); }
                    showStep(1);
                    $('html, body').animate({ scrollTop: formContainer.offset().top - 50 }, 300);

                } else {
                    var errorMessage = '<p>' + (response.data.message || pr_ajax.error_message) + '</p>';
                    if (response.data.errors) {
                        errorMessage += '<ul>';
                        var firstErrorField = null;
                        $.each(response.data.errors, function(key, value) {
                            errorMessage += '<li>' + value + '</li>';
                            var fieldWithError = form.find('[name="' + key + '"]');
                             if(fieldWithError.length){
                                 if (!firstErrorField) firstErrorField = fieldWithError; 
                                if (fieldWithError.attr('type') === 'radio') {
                                    fieldWithError.closest('.pr-radio-group').addClass('error');
                                } else if (fieldWithError.attr('type') === 'checkbox') {
                                     fieldWithError.closest('.pr-checkbox-option').addClass('error');
                                } else {
                                     fieldWithError.addClass('error');
                                }
                             }
                        });
                        errorMessage += '</ul>';
                        if (firstErrorField) {
                             $('html, body').animate({ scrollTop: firstErrorField.offset().top - 70 }, 300, function() {
                                firstErrorField.focus();
                             });
                        } else {
                             $('html, body').animate({ scrollTop: statusDiv.offset().top - 50 }, 300);
                        }
                    } else {
                         $('html, body').animate({ scrollTop: statusDiv.offset().top - 50 }, 300);
                    }
                    showStatusMessage('error', errorMessage);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                showLoading(false);
                console.error("AJAX Error:", textStatus, errorThrown, jqXHR.responseText);
                 showStatusMessage('error', '<p>' + pr_ajax.server_error_message + '</p>');
                 $('html, body').animate({ scrollTop: statusDiv.offset().top - 50 }, 300);
            }
        });
    });

    // --- Helper Functions ---
    function showLoading(show) {
        var overlay = formContainer.find('.pr-loading-overlay');
        if (show) {
            if (overlay.length === 0) {
                formContainer.append('<div class="pr-loading-overlay">' + pr_ajax.loading_message + '</div>');
                overlay = formContainer.find('.pr-loading-overlay'); 
            }
            overlay.fadeIn(200);
            form.find('button, input[type="submit"], .pr-next-btn, .pr-prev-btn').prop('disabled', true);
        } else {
             overlay.fadeOut(200);
             form.find('button, input[type="submit"], .pr-next-btn').prop('disabled', false);
              if (currentStep === 1) {
                 form.find('.pr-prev-btn').prop('disabled', true);
              } else {
                  form.find('.pr-prev-btn').prop('disabled', false);
              }
        }
    }

    function showStatusMessage(type, message) {
        statusDiv.removeClass('success error').addClass(type).html(message).slideDown(300);
    }

     function clearStatusMessage() {
        statusDiv.slideUp(200, function() {
            $(this).empty().removeClass('success error');
        });
    }
    showStep(1); 

}); 




