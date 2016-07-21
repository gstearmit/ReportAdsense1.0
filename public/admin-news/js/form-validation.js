$(document).ready(function() {
    $('#uploadForm-id1').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
		},
        row: {
            valid: 'field-success',
            invalid: 'field-error'
		},
        fields: {
            id1_number: {
                validators: {
                    notEmpty: {
                        message: 'The number is required'
					},
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
					},
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
					}
				}
			},
            id1_issue_date: {
                validators: {
                    notEmpty: {
                        message: 'The issue date is required'
					}
				}
			},
            id1_expiry_date: {
                validators: {
                    notEmpty: {
                        message: 'The expiry date is required'
					}
				}
			},
            id1_issued_by: {
                validators: {
                    notEmpty: {
                        message: 'The issued by is required'
					}
				}
			},
            id1_country_of_issue: {
                validators: {
                    notEmpty: {
                        message: 'The country of issue is required'
					}
				}
			},
            id1_orig_lang: {
                validators: {
                    notEmpty: {
                        message: 'The orig lang is required'
					}
				}
			},
            id1_date_of_birth: {
                validators: {
                    notEmpty: {
                        message: 'The date of birth is required'
					}
				}
			},
            id1_select_file: {
                validators: {
                    notEmpty: {
                        message: 'The select file is required'
					}
				}
			}
		}
	});
    $('#uploadForm-id2').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
		},
        row: {
            valid: 'field-success',
            invalid: 'field-error'
		},
        fields: {
            id2_number: {
                validators: {
                    notEmpty: {
                        message: 'The number is required'
					},
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
					},
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
					}
				}
			},
            id2_issue_date: {
                validators: {
                    notEmpty: {
                        message: 'The issue date is required'
					}
				}
			},
            id2_expiry_date: {
                validators: {
                    notEmpty: {
                        message: 'The expiry date is required'
					}
				}
			},
            id2_issued_by: {
                validators: {
                    notEmpty: {
                        message: 'The issued by is required'
					}
				}
			},
            id2_country_of_issue: {
                validators: {
                    notEmpty: {
                        message: 'The country of issue is required'
					}
				}
			},
            id2_orig_lang: {
                validators: {
                    notEmpty: {
                        message: 'The orig lang is required'
					}
				}
			},
            id2_date_of_birth: {
                validators: {
                    notEmpty: {
                        message: 'The date of birth is required'
					}
				}
			},
            id2_select_file: {
                validators: {
                    notEmpty: {
                        message: 'The select file is required'
					}
				}
			}
		}
	});
    $('#uploadForm-Proof').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
		},
        row: {
            valid: 'field-success',
            invalid: 'field-error'
		},
        fields: {
            proof_number: {
                validators: {
                    notEmpty: {
                        message: 'The number is required'
					},
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
					},
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
					}
				}
			},
            proof_issue_date: {
                validators: {
                    notEmpty: {
                        message: 'The issue date is required'
					}
				}
			},
            proof_expiry_date: {
                validators: {
                    notEmpty: {
                        message: 'The expiry date is required'
					}
				}
			},
            proof_issued_by: {
                validators: {
                    notEmpty: {
                        message: 'The issued by is required'
					}
				}
			},
            proof_country_of_issue: {
                validators: {
                    notEmpty: {
                        message: 'The country of issue is required'
					}
				}
			},
            proof_city: {
                validators: {
                    notEmpty: {
                        message: 'The orig lang is required'
					}
				}
			},
            proof_state: {
                validators: {
                    notEmpty: {
                        message: 'The orig lang is required'
					}
				}
			},
            proof_country: {
                validators: {
                    notEmpty: {
                        message: 'The orig lang is required'
					}
				}
			},
            proof_postal: {
                validators: {
                    notEmpty: {
                        message: 'The orig lang is required'
					}
				}
			},
            proof_add1: {
                validators: {
                    notEmpty: {
                        message: 'The date of birth is required'
					}
				}
			},
            proof_add2: {
                validators: {
                    notEmpty: {
                        message: 'The date of birth is required'
					}
				}
			},
            proof_select_file: {
                validators: {
                    notEmpty: {
                        message: 'The select file is required'
					}
				}
			}
		}
	});
	
    $('#bootstrapSelectForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
		},
        row: {
            valid: 'field-success',
            invalid: 'field-error'
		},
        fields: {
            proof_number: {
                validators: {
                    notEmpty: {
                        message: 'The number is required'
					},
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
					},
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
					}
				}
			},
            proof_issue_date: {
                validators: {
                    notEmpty: {
                        message: 'The issue date is required'
					}
				}
			},
            proof_expiry_date: {
                validators: {
                    notEmpty: {
                        message: 'The expiry date is required'
					}
				}
			},
            proof_issued_by: {
                validators: {
                    notEmpty: {
                        message: 'The issued by is required'
					}
				}
			},
            proof_country_of_issue: {
                validators: {
                    notEmpty: {
                        message: 'The country of issue is required'
					}
				}
			},
            proof_city: {
                validators: {
                    notEmpty: {
                        message: 'The orig lang is required'
					}
				}
			},
            proof_state: {
                validators: {
                    notEmpty: {
                        message: 'The orig lang is required'
					}
				}
			},
            proof_country: {
                validators: {
                    notEmpty: {
                        message: 'The orig lang is required'
					}
				}
			},
            proof_postal: {
                validators: {
                    notEmpty: {
                        message: 'The orig lang is required'
					}
				}
			},
            proof_add1: {
                validators: {
                    notEmpty: {
                        message: 'The date of birth is required'
					}
				}
			},
            proof_add2: {
                validators: {
                    notEmpty: {
                        message: 'The date of birth is required'
					}
				}
			},
            proof_select_file: {
                validators: {
                    notEmpty: {
                        message: 'The select file is required'
					}
				}
			}
		}
	});
	
    $('#paymentForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
		},
        row: {
            valid: 'field-success',
            invalid: 'field-error'
		},
        fields: {
            pay_card: {
                validators: {
                    notEmpty: {
                        message: 'The number is required'
					},
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
					},
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
					}
				}
			},
            pay_exp: {
                validators: {
                    notEmpty: {
                        message: 'The issue date is required'
					}
				}
			},
            pay_year: {
                validators: {
                    notEmpty: {
                        message: 'The expiry date is required'
					}
				}
			},
            pay_ho: {
                validators: {
                    notEmpty: {
                        message: 'The issued by is required'
					}
				}
			},
            pay_cvv: {
                validators: {
                    notEmpty: {
                        message: 'The country of issue is required'
					}
				}
			}
		}
	});
	
    $('#valiForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
		},
        row: {
            valid: 'field-success',
            invalid: 'field-error'
		},
        fields: {
            pay_card: {
                validators: {
                    notEmpty: {
                        message: 'The number is required'
					},
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
					},
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
					}
				}
			},
            pay_exp: {
                validators: {
                    notEmpty: {
                        message: 'The issue date is required'
					}
				}
			},
            pay_year: {
                validators: {
                    notEmpty: {
                        message: 'The expiry date is required'
					}
				}
			},
            pay_ho: {
                validators: {
                    notEmpty: {
                        message: 'The issued by is required'
					}
				}
			},
            birthday: {
                validators: {
                    notEmpty: {
                        message: 'The date of birth is required'
					},
                    date: {
                        format: 'YYYY/MM/DD',
                        message: 'The date of birth is not valid'
					}
				}
			}
		}
	});
	
    
    
    
	$('#SignupMoneyPoint')	
	.find('[name="AccountType"]')
	.selectpicker()
	.change(function(e) {
		// revalidate the language when it is changed
		$('#SignupMoneyPoint').formValidation('revalidateField', 'AccountType');
	})
	.end()	
	.find('[name="country"]')
	.selectpicker()
	.change(function(e) {		
		$('#SignupMoneyPoint').formValidation('revalidateField', 'country');
	})
	.end()	
	.find('[name="get_city"]')
	//.selectpicker()
	.change(function(e) {		
		$('#SignupMoneyPoint').formValidation('revalidateField', 'get_city');
	})
	.end()
	.find('[name="PersonMobile"]')
	.intlTelInput({
		utilsScript: domain_name+'/home/js/utils.js',
		autoPlaceholder: true,
		preferredCountries: ['cz', 'us', 'gb']
	});
	$('#SignupMoneyPoint')
	.formValidation({
		framework: 'bootstrap',
		container: 'tooltip',
		excluded: ':disabled',
		icon: {
			valid: 'glyphicon glyphicon-ok',
			invalid: 'glyphicon glyphicon-remove',
			validating: 'glyphicon glyphicon-refresh'
		},
		fields: {
			AccountType: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'Please select your Select AccountType MoneyPoint.'
					}
				}
			},
			first_name: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'First Name can not be empty.'
					},
					regexp: {                         
						regexp: /^\s*[a-zA-Z0-9,\s]+\s*$/,  // No Special Characters
						message: 'No Special Characters'
					},
					stringLength: {
                        min: 4,
                        max: 40,
                        message: 'The First Name must be more than 4 and less than 40 characters long'
					},	
				}
			},
			last_name: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'Last Name can not be empty.'
					},
					regexp: {                         
						regexp: /^\s*[a-zA-Z0-9,\s]+\s*$/,  // No Special Characters
						message: 'No Special Characters'
					},
					stringLength: {
                        min: 2,
                        max: 40,
                        message: 'The Last Name must be more than 2 and less than 40 characters long'
					},	
				}
			},			
			PersonMobile: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'The phone number can not be empty.'
					},
					callback: {
						message: 'The phone number is not valid',
						callback: function(value, validator, $field) {
							return value === '' || $field.intlTelInput('isValidNumber');							
						}
					}
				}
			},
			CompanyName: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'Company Name can not be empty.'
					}, 
					regexp: {                         
						regexp: /^\s*[a-zA-Z0-9,\s]+\s*$/,  // No Special Characters
						message: 'No Special Characters'
					}
				}
			},
			Address1: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'Addres1 can not be empty.'
					}, 
					regexp: {                         
						regexp: /^\s*[a-zA-Z0-9,\s]+\s*$/,  // No Special Characters
						message: 'No Special Characters'
					}
				}
			},
			Address2: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'Addres2 can not be empty.'
					},
					regexp: {                         
						regexp: /^\s*[a-zA-Z0-9,\s]+\s*$/,  // No Special Characters
						message: 'No Special Characters'
					}
				}
			},
			ZIP: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'Zip Code can not be empty.'
					},
                    regexp: { 
                        regexp: /^[0-9]/,  // No Special Characters
                        message: 'Characters number'
                    }
				}
			},
			PersonPosition: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'Person Position can not be empty.'
					},
                    regexp: { 
                    	regexp: /^\s*[a-zA-Z0-9,\s]+\s*$/,  // No Special Characters
						message: 'No Special Characters'
                    }
				}
			},
			State: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'State can not be empty.'
					},
					regexp: {                         
						regexp: /^\s*[a-zA-Z0-9,\s]+\s*$/,  // No Special Characters
						message: 'No Special Characters'
					}
				}
			},
			person_ruid: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'Person RUID can not be empty.'
					}
				}
			},
			
			userName: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'E-mail Adress  can not be empty.'
					},
					emailAddress: {
                        message: 'The input is not a valid email address'
					}
				}
			},
			password: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'Password can not be empty.'
					},					
					callback: {
                        message: 'The password is not valid',
                        callback: function(value, validator, $field) {
                            if (value === '') {
                                return true;
							}
                            if (value.length < 8) {
                                return {
                                    valid: false,
                                    message: 'It must be more than 8 characters long'
								};
							}
                            if (value === value.toLowerCase()) {
                                return {
                                    valid: false,
                                    message: 'It must contain at least one upper case character'
								}
							}
                            if (value === value.toUpperCase()) {
                                return {
                                    valid: false,
                                    message: 'It must contain at least one lower case character'
								}
							}
                            if (value.search(/[0-9]/) < 0) {
                                return {
                                    valid: false,
                                    message: 'It must contain at least one digit'
								}
							}
							if (!/[!@#$%&^~*_ ]/.test(value)) {
								return {
                                    valid: false,
                                    message: 'It must contain at least one special characters'
								}
							}
                            return true;
						}
					}
				}
			},
			passwordConfirm: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'Confirm Password can not be empty.'
					},
					stringLength: {
                        min: 8,                       
                        message: 'The Confirm Password must be more than 8 characters long'
					},	
					identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
					},
				}
			},
			Country_Code: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'Country can not be empty..'
					}
				}
			},
			get_city: {
				container: 'popover',
				validators: {
					notEmpty: {
						message: 'City can not be empty..'
					}
				}
			},
			
		}
	})
	.on('click', '.country-list', function() {
		$('#SignupMoneyPoint').formValidation('revalidateField', 'PersonMobile');
	});
	$('#PersonMobile').val('+'+$('.country-list .active').attr('data-dial-code'));
	$('.country-list .country').click(function(){
		var phone_country = $(this).attr('data-dial-code');
		$('#PersonMobile').val('+'+phone_country);
	});
});				