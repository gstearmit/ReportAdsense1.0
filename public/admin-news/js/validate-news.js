$(document).ready(function() {
    $('#bootstrapSelectForm')
        .find('[name="elect_one"]')
            .selectpicker()
            .change(function(e) {
                // revalidate the color when it is changed
                $('#bootstrapSelectForm').formValidation('revalidateField', 'elect_one');
            })
            .end()
        .find('[name="elect_two"]')
            .selectpicker()
            .change(function(e) {
                // revalidate the language when it is changed
                $('#bootstrapSelectForm').formValidation('revalidateField', 'elect_two');
            })
            .end()
            .formValidation({
            excluded: ':disabled',
            message: 'This value is not valid',
            container: 'tooltip',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: { 
                date_range: {
                    container: 'popover',
                    validators: {
                        notEmpty: {
                            message: 'The Last Name is required and cannot be empty'
                        }
                    }
                },
            }
        }
    });

    $('#zendcode')
        .formValidation({
            framework: 'bootstrap',
            excluded: ':disabled',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                zend_input1: {
                    validators: {
                        notEmpty: {
                            message: 'Please select your native period.'
                        }
                    }
                },
                zend_input2: {
                    validators: {
                        notEmpty: {
                            message: 'Please select your native Records per page.'
                        }
                    }
                },
                zend_input3: {
                    validators: {
                        notEmpty: {
                            message: 'Please select your native Records per page.'
                        }
                    }
                },
                zend_input4: {
                    validators: {
                        notEmpty: {
                            message: 'Please select your native Records per page.'
                        }
                    }
                },
                zend_input5: {
                    validators: {
                        notEmpty: {
                            message: 'Please select your native Records per page.'
                        }
                    }
                },
                zend_input6: {
                    validators: {
                        notEmpty: {
                            message: 'Please select your native Records per page.'
                        }
                    }
                }
        }
    });
});