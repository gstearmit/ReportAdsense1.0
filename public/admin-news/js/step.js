$(document).ready(function () {
    function adjustIframeHeight() {
        var $body   = $('body'),
            $iframe = $body.data('iframe.fv');
        if ($iframe) {
            // Adjust the height of iframe
            $iframe.height($body.height());
        }
    }
    $("#multiphase").steps({
        headerTag: "h2",
        bodyTag: "section",
        saveState: true,
        onStepChanged: function(e, currentIndex, priorIndex) {
                // You don't need to care about it
                // It is for the specific demo
                adjustIframeHeight();
            },
            // Triggered when clicking the Previous/Next buttons
            onStepChanging: function(e, currentIndex, newIndex) {
                var fv         = $('#multiphase').data('formValidation'), // FormValidation instance
                    // The current step container
                    $container = $('#multiphase').find('section[data-step="' + currentIndex +'"]');

                // Validate the container
                fv.validateContainer($container);

                var isValidStep = fv.isValidContainer($container);
                if (isValidStep === false || isValidStep === null) {
                    // Do not jump to the next step
                    return false;
                }

                return true;
            },
            // Triggered when clicking the Finish button
            onFinishing: function(e, currentIndex) {
                var fv         = $('#multiphase').data('formValidation'),
                    $container = $('#multiphase').find('section[data-step="' + currentIndex +'"]');

                // Validate the last step container
                fv.validateContainer($container);

                var isValidStep = fv.isValidContainer($container);
                if (isValidStep === false || isValidStep === null) {
                    return false;
                }

                return true;
            },
            onFinished: function(e, currentIndex) {
                // Uncomment the following line to submit the form using the defaultSubmit() method
                //$('#multiphase').formValidation('defaultSubmit');

                // For testing purpose
                $('#welcomeModal').modal("show");
            }
			
        }).formValidation({
        excluded: ':disabled',
        message: 'This value is not valid',
        container: 'tooltip',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            //last name validation  
            sd_lastname_: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The Last Name is required and cannot be empty'
                    }
                }
            },
            daterange: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The Last Name is required and cannot be empty'
                    }
                }
            },
            //first name validation
            sd_firstname: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            vadate: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            amount: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            currency: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            charges: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            priority: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            fromsaved: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            bank_country: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            postal: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            bank_state: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            bank_city: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            other: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            add: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            street: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            bank_name: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            code_type: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            bank_code: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            country: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            city: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            state: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            account_number: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            name: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            //validation of Parent's details step start
            //last name validation  
            pd_lastname: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The Last Name is required and cannot be empty'
                    }
                }
            },
            //first name validation
            pd_firstname: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The First Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 30,
                        message: 'The First Name must be more than 7 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z]+$/i,
                        message: 'The First Name can only consist of alphabetical characters'
                    }
                }
            },
            // Validation for Reference details starts
            //School reference name
            rd_schoolrefname: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The School Reference Name is required and cannot be empty'
                    },
                    stringLength: {
                        min: 7,
                        max: 40,
                        message: 'The School Reference Name must be more than 7 and less than 40 characters long'
                    },
                    regexp: {
                        regexp: /^[A-Z\s]+$/i,
                        message: 'The School Reference Name can only consist of alphabetical characters'
                    }
                }
            },
            //School reference phone
            rd_schoolrefmobile: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The Phone or Mobile is required and cannot be empty'
                    }
                }
            },
            rd_schoolrefemail: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The E-Mail ID is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /[a-zA-Z0-9]+(?:(\.|_)[A-Za-z0-9!#$%&'*+\/=?^`{|}~-]+)*@(?!([a-zA-Z0-9]*\.[a-zA-Z0-9]*\.[a-zA-Z0-9]*\.))(?:[A-Za-z0-9](?:[a-zA-Z0-9-]*[A-Za-z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?/g,
                        message: 'The E-Mail ID is not a valid E-Mail'
                    }
                }
            },
			email: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The E-Mail ID is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /[a-zA-Z0-9]+(?:(\.|_)[A-Za-z0-9!#$%&'*+\/=?^`{|}~-]+)*@(?!([a-zA-Z0-9]*\.[a-zA-Z0-9]*\.[a-zA-Z0-9]*\.))(?:[A-Za-z0-9](?:[a-zA-Z0-9-]*[A-Za-z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?/g,
                        message: 'The E-Mail ID is not a valid E-Mail'
                    }
                }
            },
			email_veryfile: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The E-Mail ID is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /[a-zA-Z0-9]+(?:(\.|_)[A-Za-z0-9!#$%&'*+\/=?^`{|}~-]+)*@(?!([a-zA-Z0-9]*\.[a-zA-Z0-9]*\.[a-zA-Z0-9]*\.))(?:[A-Za-z0-9](?:[a-zA-Z0-9-]*[A-Za-z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?/g,
                        message: 'The E-Mail ID is not a valid E-Mail'
                    }
                }
            },
			mobiphone: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The Phone or Mobile is required and cannot be empty'
                    }
                }
            },
			PersonOccupation: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The PersonOccupation is required and cannot be empty'
                    }
                }
            },
			cardtype: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The Card Type is required and cannot be empty'
                    }
                }
            },
			cart_curency: {
                container: 'popover',
                validators: {
                    notEmpty: {
                        message: 'The Card Curency is required and cannot be empty'
                    }
                }
            },
        }

    })

});