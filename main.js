jQuery(document).ready(function(){
	var input = document.querySelector("#phone");
	if(input){
  		window.intlTelInput(input,{initialCountry:'CY'});
	}

	var click_counter = 0;
	jQuery('body').on('click', '.accordion-checklist', function(){
		jQuery(this).closest('.child_row').find('.accordion-checklist-box').toggleClass('hide');

		if(jQuery(this).find('.fas').hasClass('fa-user-plus')){
			jQuery(this).find('.fas').removeClass('fa-user-plus');
			jQuery(this).find('.fas').addClass('fa-user-minus');

			jQuery(this).find('.fas > i').removeClass('wp-svg-plus');
			jQuery(this).find('.fas > i').addClass('wp-svg-minus');

			jQuery(this).find('.fas > i').removeClass('plus');
			jQuery(this).find('.fas > i').addClass('minus');
		}
		else{
			jQuery(this).find('.fas').addClass('fa-user-plus');
			jQuery(this).find('.fas').removeClass('fa-user-minus');

			jQuery(this).find('.fas > i').addClass('wp-svg-plus');
			jQuery(this).find('.fas > i').removeClass('wp-svg-minus');

			jQuery(this).find('.fas > i').addClass('plus');
			jQuery(this).find('.fas > i').removeClass('minus');
		}
		click_counter++;
	});
	jQuery( function() {
	  var initDate = new Date();
	  initDate.setFullYear(2004);
	  initDate.setMonth(1-1);
	  initDate.setDate(1);
    	jQuery( ".bday" ).datepicker({
    		changeMonth: true,
      		changeYear: true,
			yearRange:"2004:2015",
			defaultDate: initDate
    	});
  	} );
	console.log('do');
	var child_counter = 0;
	jQuery('body').on('click','#add_child', function(e){
		var childform = 
		'<div class="child_row" style="margin-top:30px;padding-top:10px;"><input class="childname required" name="childname[]" type="text" placeholder="Child\'s full name" /><input type="text" class="bday required" name="bday[]" placeholder="Date of Birth" /><br/><label><b>Childs packages</b></label>'; 
		child_counter ++;


		e.preventDefault();
		
		//jQuery('.childspackages').html('');

		// jQuery('.packages:checked').each(function(index,item){
		// 	let item_val = jQuery(item).attr('value');
		// 	let newitem = item_val+'<input type="checkbox" name="childspackages[]" value="'+item_val+'" /><br/>';
		// 	jQuery('.childspackages').append(newitem);
		// });
		let child_checked = jQuery('.child_row').last().find('.packages:checked').length;
		//console.log(child_checked);

		if(child_checked > 0){
			let outer = jQuery('.packages-wrapper')[0].outerHTML;
			let checklist = jQuery('.accordion-checklist-box')[0].outerHTML;

			//console.log(outer);

			childform = childform + outer;

			childform = childform + '<div class="accordion-checklist"><h6><i class="fas fa-user-plus"><i class="wp-svg-plus plus"></i></i> Fill in your child s medical checklist</h6></div>' + checklist  + '</div>';

			jQuery('#child_box').append(childform);

			jQuery('.child_row').last().find('.accordion-checklist-box').addClass('hide');

			let cur_id = jQuery('.child_row').last().find('.css-checkbox').attr('id');

			jQuery('.child_row').find('.check-row').each(function(i,item){
				jQuery(item).find('.css-checkbox').attr('id','chk'+i);
				jQuery(item).find('.css-label').attr('for','chk'+i);
			});

			jQuery('.accordion-checklist-box').find('.check-row').each(function(i,item){
				jQuery(item).find('.css-checkbox').attr('id','chkx'+i);
				jQuery(item).find('.css-label').attr('for','chkx'+i);
			});

			updateChildSummary();
			discountPrice();
		}
		else{
			alert('Please choice package for Child 1');
		}
	});
	var discount_price = 0;
	var original_price = 0;
	var extras_price = 0;
	
	jQuery('body').on('click','#remove_child', function(e){
		child_counter --;


		e.preventDefault();
		
		jQuery('.child_row').last().remove();
		
		discount_price = 0;
		original_price = 0;
		jQuery('.child_row').each(function(index,item){
			jQuery(item).find('.packages:checked').each(function(index2,item2){
				discount_price = parseFloat(discount_price) + parseFloat(jQuery(item2).data('price'));
				original_price = parseFloat(original_price) + parseFloat(jQuery(item2).data('price'));				
			});
		});	


		updateChildSummary();
		discountPrice();
	});


	
	jQuery('body').on('change','.packages',function(e){
		if(jQuery(this).is(':checked')){
			discount_price = parseFloat(discount_price) + parseFloat(jQuery(this).data('price'));
			original_price = parseFloat(original_price) + parseFloat(jQuery(this).data('price'));
		}
		else{
			discount_price = parseFloat(discount_price) - parseFloat(jQuery(this).data('price'));
			original_price = parseFloat(original_price) - parseFloat(jQuery(this).data('price'));
		}
		console.log(jQuery(this).data('price'));
		
		discountPrice();

		let packages = '';
		jQuery('.childspackages').html('');

		jQuery('.packages:checked').each(function(index,item){
			let item_val = jQuery(item).attr('value');
			let item_child = jQuery(item).closest('.child_row').find('.childname').attr('value');

			packages += '<li><b>'+item_child + ':</b> ' + item_val+'</li>';
			let newitem = item_val+'<input type="checkbox" name="childspackages[]" value="'+item_val+'" />';
			jQuery('.childspackages').append(newitem);
		});
		console.log(packages);
		jQuery('#choosenPackages > span').html('<ul>'+packages+'</ul>');
	    // jQuery('html,body').animate({
	    //     scrollTop: jQuery(this).offset().top
	    // }, 0);
		e.preventDefault();
	});


	// jQuery('body').on('change','.childspackages', function(){
	// 	var childname = jQuery(this).closest('.child_row').find('.childname').attr('value');

	// 	jQuery(this).
	// a
	jQuery('body').on('change','.extras',function(){
		if(jQuery(this).is(':checked')){
			extras_price = parseFloat(extras_price) + parseFloat(jQuery(this).data('price'));
			original_price = parseFloat(original_price) + parseFloat(jQuery(this).data('price'));
			jQuery(this).closest('.check-row').find('.qty').attr('value',1);
		}
		else{
			extras_price = parseFloat(extras_price) - parseFloat(jQuery(this).data('price'));
			original_price = parseFloat(original_price) - parseFloat(jQuery(this).data('price'));
			jQuery(this).closest('.check-row').find('.qty').attr('value',0);
		}	

		discountPrice();

		let extras = '';
		jQuery('.extras:checked').each(function(index,item){
			let item_val = jQuery(item).attr('value');
			let qnt = jQuery(item).closest('.check-row').find('.qty').attr('value');
			extras += '<li>'+qnt + ' x ' + item_val+'</li>';
		});
		console.log(extras);
		jQuery('#choosenExtras > span').html('<ul>'+extras+'</ul>');


	});

	jQuery('body').on('change','.checklist',function(){
		
		let list = '';
		jQuery('.checklist:checked').each(function(index,item){
			let child = jQuery(item).closest('.child_row').find('.childname').attr('value');
			let item_val = jQuery(item).attr('value');
			if(item_val == 'Other'){
				let other_txt = jQuery(item).closest('.check-row').find('textarea').val();
				item_val = ' Other: ' + other_txt;
			}
			list += '<li>(' + child + ')' + item_val +'</li>';
		});
		console.log(list);
		jQuery('#userChecklist > span').html('<ul>' + list + '</ul>');
	});
	
	jQuery('body').on('change input','.qty',function(){
		let extras = '';
		
		jQuery('.extras:checked').each(function(index,item){
			let item_val = jQuery(item).attr('value');
			let qty = jQuery(item).closest('.check-row').find('.qty').attr('value');
			extras += '<li>'+qty + ' x ' + item_val+'</li>';
		});
		console.log(extras);
		jQuery('#choosenExtras > span').html('<ul>'+extras+'</ul>');
		let item_price = jQuery(this).closest('.check-row').find('.extras').attr('data-price');

		let qty = jQuery(this).attr('value');
		
		
		if(qty > 0){
			let temp_price = parseFloat(item_price) * parseInt(qty);
		
		//console.log('temp: ' + temp_price);
			//jQuery(this).closest('.check-row').find('.extra-price').html(temp_price + '€');
		}
		else{
			//jQuery(this).closest('.check-row').find('.extra-price').html(item_price + '€');
		}
		// let new_extras_price = parseInt(jQuery(this).attr('value')) * parseInt(jQuery(this).closest('.check-row').find('.extras').attr('data-price'));
		// jQuery(this).closest('.check-row').find('.extras').attr('data-price',new_extras_price);
		// console.log(new_extras_price);
		discountPrice();
	});

	jQuery('body').on('click','#member-cta',function(e){
		e.preventDefault();
		discountPrice();
	});

	jQuery('body').on('click','#promo-cta',function(e){
		e.preventDefault();
		discountPrice();
	});

	jQuery('.book-control').on('click','a',function(e){
		let refclass = jQuery(this).attr('href');
		console.log(refclass);

		let required = jQuery(this).closest('.step').find('.required');
		let can_next = true;
		e.preventDefault();
		
		let dial = '+'+jQuery('.iti__active').attr('data-dial-code');

		// initialise plugin
		//let telInput = document.querySelector("#phone");

		//let dial = window.intlTelInput(telInput,"getSelectedCountryData").dialCode;
		
		jQuery('#dial').attr('value',dial);
		
		if(jQuery(this).hasClass('move-next')){
			required.each(function(i,item){
				console.log(jQuery(item).attr('value'));
				if(jQuery(item).attr('value') == '' || jQuery(item).attr('value') === null || jQuery(item).attr('value') == false ){
					can_next = false;
					return false;
					console.log('here');
				}
				if(jQuery(this).closest('.step').find('input[type="checkbox"].required').length > 0){
					if(jQuery(item).is(':checked')){
						can_next = true;
						return false;
					}
					else{
						can_next = false;
					}
				}
				
			});
			
			jQuery('.child_row').each(function(index,item){
				let checked_length = jQuery(item).find('.checklist:checked').length;
				if(checked_length == 0) can_next = false;
			});

			let email_check = jQuery(this).closest('.step').find('input[type="email"]').val();
			let phone_check = jQuery(this).closest('.step').find('input[type="tel"]').val();

			if(email_check && phone_check){
				if(isEmail(email_check) && jQuery.isNumeric(phone_check)){
					can_next = true;
				}
				else{
					can_next = false;
				}
			}

			let temp_price = 0;
			let extras = '';
			jQuery('.extras:checked').each(function(index,item){
				let item_val = jQuery(item).attr('value');
				let item_price = jQuery(item).attr('data-price');

				let qty = jQuery(item).closest('.check-row').find('.qty').attr('value');
				
				temp_price = temp_price + (parseFloat(item_price) * parseInt(qty));
				console.log(item_price,qty);
				extras += '<li>'+qty + ' x ' + item_val+'</li>';
			});			
			console.log(temp_price);
			jQuery('#choosenExtras > span').html('<ul>'+extras+'</ul>');

			let list = '';
			jQuery('.checklist:checked').each(function(index,item){
				let child = jQuery(item).closest('.child_row').find('.childname').attr('value');
				let item_val = jQuery(item).attr('value');
				if(item_val == 'Other'){
					let other_txt = jQuery(item).closest('.check-row').find('textarea').val();
					item_val = ' Other: ' + other_txt;
				}
				list += '<li>(' + child + ')' + item_val +'</li>';
			});
			console.log(list);
			jQuery('#userChecklist > span').html('<ul>' + list + '</ul>');
			
			extras_price = temp_price;
			discountPrice();
		}

		if(can_next){
			jQuery(this).closest('.step').addClass('step-hidden');
			jQuery('.'+refclass).removeClass('step-hidden');
		}
		else{
			alert('Populate required fields or enter valid email and phone to continue!');
		}
		
	});

	jQuery('body').on('click','input[name="submitPaymentButton"]',function(e){
		var price = jQuery('#sumPrice').attr('value');

        grecaptcha.ready(function () {
            grecaptcha.execute('6Lft2v8UAAAAAF96Ojuk0EdfB-0HTm0qY0W9zTCA', { action: 'submitPaymentButton' }).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });

		var childs_arr = [];
		var checklist_arr = [];
		
		jQuery('.child_row').each(function(index,item){
			let childname = jQuery(item).find('input[name="childname[]"]').attr('value');
			let bday = jQuery(item).find('input[name="bday[]"]').attr('value');
			//let checklist = jQuery(item).find('input[name="checklist[]"]').attr('value');
			jQuery(item).find('input[name="checklist[]"]:checked').each(function(index2,item2){
				let childslist = jQuery(item2).attr('value');
				checklist_arr.push({child: childname, checklist: childslist, birthday: bday });
			});

			jQuery(item).find('input[name="childspackages[]"]:checked').each(function(index2,item2){
				let childspackage = jQuery(item2).attr('value');
				childs_arr.push({child: childname, package: childspackage, birthday: bday });
			});
			
		});

		let encoded_packages = encodeURIComponent(JSON.stringify(childs_arr));
		let encoded_list = encodeURIComponent(JSON.stringify(checklist_arr));
		//console.log(checklist_arr);
		//jQuery('#sumChildsPackages').attr('value',encoded_packages);
		encoded_packages = encoded_packages.toString();
		encoded_list = encoded_list.toString();
		var form = jQuery(this).closest('form');
		var formposts = form.serialize();
		$this = this;
		e.preventDefault();
		//console.log(encoded_packages);
		//console.log(encoded_list);

		//console.log(formposts);


		jQuery.ajax({ 
			type: 'post',
			url: ajaxurl,
			data: { 
				action: 'savePostToSession',
				posts: formposts,
				childs: encoded_packages,
				checklist: encoded_list
			},	
			//traditional:true,
			success:function(response){
				//var form_payment = jQuery(jQuery('#booksys')[0].elements).not('input[name="childname[]"],input[name="bday[]"],input[name="childspackages[]"],[name="checklist[]"],input[name="fathername"],input[name="mothername"],input[name="email"],input[name="phone"],[name="address"],input[name="extras[]"],input[name="quantity[]"],input[name="action"],input[value=""],#sumPrice,[name="note"],[name="promo"],[name="approve"],[name="gdpr"]');
				//let ser_pay = form_payment.serialize();
				//console.log(jQuery('#booksys')[0].elements);
				//console.log(ser_pay);
				//console.log(ser_pay);	
				//console.log(jQuery('#booksys')[0].elements);

				if(response){
					if(jQuery('input[name="approve"]').is(':checked') && jQuery('input[name="gdpr"]').is(':checked')){
						jQuery('#paymentJCC').attr('action','https://tjccpg.jccsecure.com/EcomPayment/RedirectAuthLink');
						jQuery('#paymentJCC').submit();
					}
					else{
						alert('You must approve agreements to submit form. Try again.');
					}
				}
				else{
					alert('Your captcha answers are wrong. Try again.');
				}
			},
			error:function(x,y,z){
				console.log(x,y,z);
			}
		});
	});

	jQuery('body').on('input','input[name="mothername"]', function(e){
		jQuery('#childsMother > span').html('<u>'+jQuery(this).val()+'</u>');
	});

	jQuery('body').on('input','input[name="fathername"]', function(e){
		jQuery('#childsFather > span').html('<u>'+jQuery(this).val()+'</u>');
	});

	jQuery('body').on('input','input[name="email"]', function(e){
		jQuery('#userEmail > span').html('<u>'+jQuery(this).val()+'</u>');
	});

	jQuery('body').on('input','input[name="phone"]', function(e){
		jQuery('#userPhone > span').html('<u>'+ jQuery('#dial').attr('value') + ' ' + jQuery(this).val()+'</u>');
	});
	

	jQuery('body').on('input','textarea[name="address"]', function(e){
		jQuery('#userAddress > span').html('<u>'+jQuery(this).val()+'</u>');
	});

	jQuery('body').on('input','input[name="childname[]"]', function(e){
		updateChildSummary();
	});

	jQuery('body').on('change','input[name="bday[]"]', function(e){
		updateChildSummary();
	});

	jQuery('body').on('change','input[name="age[]"]', function(e){
		updateChildSummary();
	});

	jQuery('body').on('click','#log-out',function(e){
		e.preventDefault();
		console.log('test');
		jQuery.ajax({
			type: 'post',
			url: ajaxurl,
			dataType:'json',
			data: { action:'logOut' },
			success:function(response){
				window.location.href = 'https://summercamp.zaffasoft.com/account/';
			},
			error:function(x,y,z){
				console.log(x,y,z);
			}
		});		
	});

	function isEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}

	function updateChildSummary(){
	  var initDate = new Date();
	  initDate.setFullYear(2004);
	  initDate.setMonth(1-1);
	  initDate.setDate(1);
	  
    	jQuery( ".bday" ).datepicker({
    		changeMonth: true,
      		changeYear: true,
			yearRange:"2004:2016",
			defaultDate: initDate
    	}); 
		// let childs =  '';
		// jQuery('.child_row').each(function(index,item){
		// 	console.log(item);
		// 	let row = jQuery(item);

		// 	let childname = row.find('input[name="childname[]"]').attr('value');
		// 	let bday = row.find('input[name="bday[]"]').attr('value');
		// 	let age = row.find('input[name="age[]"]').attr('value');

		// 	childs += '<li>' + childname + ' (' + bday + ')</li>';
		// });
		// jQuery('#userChilds > span').html('<ul>' + childs + '</ul>' );
	}



   // This button will increment the value
    jQuery('body').on('click','.qtyplus',function(e){
    	console.log('test');
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = jQuery(this).attr('field');
        
        var selector = jQuery(this).closest('.check-row').find('input[name="'+fieldName+'"]');
        // Get its current value
        var currentVal = parseInt(selector.attr('value'));
        console.log(selector);
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            selector.attr('value',currentVal + 1);
        } else {
            // Otherwise put a 0 there
            selector.attr('value',0);
        }
		
		if( (currentVal+1) > 0){
			jQuery(this).closest('.check-row').find('.extras').prop('checked',true);
		}
		else{
			jQuery(this).closest('.check-row').find('.extras').prop('checked',false);			
		}
		
		jQuery('.qty').trigger('change');
			let temp_price = 0;
			let extras = '';
			jQuery('.extras:checked').each(function(index,item){
				let item_val = jQuery(item).attr('value');
				let item_price = jQuery(item).attr('data-price');

				let qty = jQuery(item).closest('.check-row').find('.qty').attr('value');
				
				temp_price = temp_price + (parseFloat(item_price) * parseInt(qty));
				console.log(item_price,qty);
				extras += '<li>'+qty + ' x ' + item_val+'</li>';
			});			
			console.log(temp_price);
			jQuery('#choosenExtras > span').html('<ul>'+extras+'</ul>');

			extras_price = temp_price;
			discountPrice();
    });
    // This button will decrement the value till 0
    jQuery('body').on('click','.qtyminus',function(e){
        // Stop acting like a button
        e.preventDefault();
        var selector = jQuery(this).closest('.check-row').find('input[name="'+fieldName+'"]');

        // Get the field name
        fieldName = jQuery(this).attr('field');
        // Get its current value
        var currentVal = parseInt(selector.attr('value'));
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            selector.attr('value',currentVal - 1);
        } else {
            // Otherwise put a 0 there
            selector.attr('value',0);
        }
		if( (currentVal-1) > 0){
			jQuery(this).closest('.check-row').find('.extras').prop('checked',true);
		}
		else{
			jQuery(this).closest('.check-row').find('.extras').prop('checked',false);			
		}		
		
		jQuery('.qty').trigger('change');
			let temp_price = 0;
			let extras = '';
			jQuery('.extras:checked').each(function(index,item){
				let item_val = jQuery(item).attr('value');
				let item_price = jQuery(item).attr('data-price');

				let qty = jQuery(item).closest('.check-row').find('.qty').attr('value');
				
				temp_price = temp_price + (parseFloat(item_price) * parseInt(qty));
				console.log(item_price,qty);
				extras += '<li>'+qty + ' x ' + item_val+'</li>';
			});			
			console.log(temp_price);
			jQuery('#choosenExtras > span').html('<ul>'+extras+'</ul>');

			extras_price = temp_price;
			discountPrice();
    });

	function discountPrice(){
		let new_price = discount_price;
		let checkedchilds = jQuery('.child_row').find('.packages:checked').closest('.child_row');
		
		let childs_num = checkedchilds.length;
		
		let childsposition = checkedchilds.index();
		let childspackages = [];
	    jQuery('.child_row').find('.packages:checked').each(function(index,item){
			let child_index = jQuery(item).closest('.child_row').index();

			childspackages.push({ childindex: child_index, price: jQuery(item).attr('data-price') });
		});
		//console.log(childspackages);
		
		let packages_num = jQuery('.packages:checked').length;
		let user_pid = jQuery('#user_pid').attr('value');
		let promoCode = jQuery('#promo').attr('value');
		
		//console.log(childs_num);
		//console.log(packages_num);
		//console.log(ajaxurl);
		//console.log(promoCode);
		console.log(user_pid);

		let childs = jQuery('.child_row').length;
		if(childs > 1){
			jQuery('.fa-user-minus').removeClass('hide');
		}
		else{
			jQuery('.fa-user-minus').addClass('hide');
		}

		let dprice = 0;
		jQuery.ajax({
			type: 'post',
			url: ajaxurl,
			dataType:'json',
			data: { action:'discountPrice', price:discount_price, childs_num:childs_num, 
			packages_num:packages_num, user_pid:user_pid, promoCode:promoCode, childspackages:childspackages },
			success:function(response){
				//console.log(response);
				dprice = response.price;
				setPrice(response.price);
			},
			error:function(x,y,z){
				console.log(x,y,z);
			}
		});	
	}


	function formatPrice(xprice){
		console.log(ajaxurl);
		jQuery.ajax({
			type: 'post',
			url: ajaxurl,
			dataType:'json',
			data: { action:'formatPrice', price:xprice },
			success:function(response){
				console.log(response);
				jQuery('.PurchaseAmt').attr('value',response.price);
				jQuery('.signature').attr('value',response.signature);
				jQuery('.orderid').attr('value',response.orderid);
			},
			error:function(x,y,z){
				console.log(x,y,z);
			}
		});			
	}
	
	function setPrice(discount_price){
		let fee_price = 25 * jQuery('.child_row').length;
		console.log(discount_price,extras_price);
		let show_price = fee_price + parseFloat(discount_price) + parseFloat(extras_price) ;
		jQuery('#sumPrice').attr('value',show_price);
		jQuery('#packPrice > span').html('<u>'+discount_price+'€</u>');
		jQuery('#extrasPrice > span').html('<u>'+extras_price+'€</u>');
		jQuery('#totalMoney').html('<b>'+show_price+'€</b>');
		
		

		jQuery('.price-fee').html(fee_price+'€');
		jQuery('#feePrice > span').html('<u>'+fee_price+'€</u>');
		jQuery('.price-package').html(discount_price+'€');
		jQuery('.price-extras').html(extras_price+'€');
		jQuery('.price-live').html('<b>'+show_price+'€</b>');
		formatPrice(show_price.toFixed(2));
	}
	


});

