jQuery(function($) {
	'use strict',

	$(window).scroll(function() {
	  if ($(document).scrollTop() > 50) {
	    $('.top-bar').hide();
	  } else {
	    $('.top-bar').show();
	  }
	});

	//Initiat WOW JS
	new WOW().init();

	//#main-slider
	$(function(){
		console.log("Triggered");
	});


	// accordian
	$('.accordion-toggle').on('click', function(){
		$(this).closest('.panel-group').children().each(function(){
		$(this).find('>.panel-heading').removeClass('active');
		 });

	 	$(this).closest('.panel-heading').toggleClass('active');
	});

$(document).on('ready', function(evt, data){
	var url = window.location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	//console.log(filename);
	if(filename == ''){
		localStorage.setItem("autoPopup", "0");
		setTimeout(function(){ 
			if(localStorage.getItem("autoPopup") == "0"){
				$("#myModal").modal();
				localStorage.setItem("autoPopup", "1");
			}
		}, 5000);
	} else if(filename == "shortcodes.html"){
		$("#courses").modal();
		$("#popupCourseClose").on('click',function(){
			//alert("Clicked");
			$("#courses").modal('hide');
		});
	} 
});

	// portfolio filter
$(window).load(function(){
	'use strict';
	/*localStorage.setItem("autoPopup", "0");

	setTimeout(function(){ 
		if(localStorage.getItem("autoPopup") == "0"){
			$("#myModal").modal();
			localStorage.setItem("autoPopup", "1");
		}
	}, 5000);*/
	var $portfolio_selectors = $('.portfolio-filter >li>a');
	var $portfolio = $('.portfolio-items');
	$portfolio.isotope({
		itemSelector : '.portfolio-item',
		layoutMode : 'fitRows'
	});
	
	$portfolio_selectors.on('click', function(){
		$portfolio_selectors.removeClass('active');
		$(this).addClass('active');
		var selector = $(this).attr('data-filter');
		$portfolio.isotope({ filter: selector });
		return false;
	});
});

	//Email Validate Function
	function validateEmail($email) {
	    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	    if (!emailReg.test($email)) {
	        return false;
	    } else {
	        return true;
	    }
	}

	// Registration Form
	var registerForm = $('#submitData');
	registerForm.click(function(event){
		//alert("Here");
		var flag = 0;
	    var phonenumber = $("#phoneNumber").val();
	    var numberPattern = /^[a-zA-Z!@#\$%\^\&*\)\(+=._-]+$/g;
	    var email = $("#emailId").val();
		event.preventDefault();
		console.log(flag);
		
		$("#registerForm input").each(function() {
	        var type = this.type;
	        var tag = this.tagName.toLowerCase();
	        if (type == 'text') {
	            if (this.value == '' || this.value == null || this.value == undefined) {
	                flag = 1;
	                $('#' + this.id).addClass("error");
	            } else {
	                $('#' + this.id).removeClass("error");
	            }
	        }
	    });
		
		if (phonenumber == false || phonenumber.length < 10 || phonenumber.match(numberPattern)) {
	        flag = 1;
	        console.log(flag);
	        $("#phoneNumber").addClass("error");
	    } else {
	        $("#phoneNumber").removeClass("error");
	    }

	    if (!validateEmail(email) || email == '') {
	        flag = 1;
	        console.log(flag);
	        $("#emailId").addClass("error");
	    } else {
	        $("#emailId").removeClass("error");
	    }

	    if (flag != 1) {
	    	$.ajax({
				url     : "http://www.techninzaz.com/backend_code.php",
				type    : "POST",
				data    : {
							"name" : $("#inputname").val(),
							"email" : $("#emailId").val(),
							"phonenumber" : $("#phoneNumber").val(),
							"subject" : $("#subject").val(),
							"func" : 'registerV2'
						},
				success : function (data){
					alert("We have Received your Request");
					//console.log(data);
					$("input[type=text],[type=email], [type='tel'], textarea").val("");
				},
				error : function(e){
					console.log(e.responseText);
				}
			});
			$("input[type='text'],[type='email'], [type='tel'], textarea").val("");
	    }
	});


	// Contact form
	var form = $('#main-contact-form');
	form.submit(function(event){
		event.preventDefault();
		var form_status = $('<div class="form_status"></div>');
		$.ajax({
			url: $(this).attr('action'),

			beforeSend: function(){
				form.prepend( form_status.html('<p><i class="fa fa-spinner fa-spin"></i> Email is sending...</p>').fadeIn() );
			}
		}).done(function(data){
			form_status.html('<p class="text-success">' + data.message + '</p>').delay(3000).fadeOut();
		});
	});
	// Registration C2C Form

	var registerC2CForm = $('#submitDataC2C');
	registerC2CForm.click(function(event){
		event.preventDefault();
		if($("#inputname").val() == null || $("#inputname").val() == '' && $("#emailId").val() == null || $("#emailId").val() == '' && $("#phoneNumber").val() == null || $("#phoneNumber").val() == ''){
			alert("All the fields are Mandatory");
			//console.log($("#inputname").val()+'  '+$("#emailId").val()+' '+$("#phoneNumber").val());
		} else {
			alert("We have Received your Request");
			//console.log($("#inputname").val()+'  '+$("#emailId").val()+' '+$("#phoneNumber").val()+'  '+$("#subject").val());
			$.ajax({
				url     : "http://www.techninzaz.com/backend_code.php",
				type    : "POST",
				data    : {
							"name" : $("#inputname").val(),
							"email" : $("#emailId").val(),
							"phonenumber" : $("#phoneNumber").val(),
							"subject" : $("#subject").val(),
							"func" : 'registerV2'
						},
				success : function (data){
					//alert("We have Received your Request");
					//console.log(data);
					$("input[type=text],[type=email], [type='tel'], textarea").val("");
				},
				error : function(e){
					console.log(e.responseText);
				}
			});
			$("input[type='text'],[type='email'], [type='tel'], textarea").val("");
		}
	});

	//Feedback Form
	var feedBackForm = $('#feedBackForm');
	feedBackForm.click(function(event){
		event.preventDefault();
		if($("#ur_name").val() == null || $("#ur_name").val() == '' && $("#ur_experiance").val() == null || $("#ur_experiance").val() == ''){
			alert("All the fields are Mandatory");
			console.log($("#ur_name").val()+'  '+$("#ur_experiance").val());
		} else {
			alert("We have Received your Request");
			console.log($("#ur_name").val()+'  '+$("#ur_experiance").val());
			$.ajax({
				url     : "http://www.techninzaz.com/backend_code.php",
				type    : "POST",
				data    : {
							"name" : $("#ur_name").val(),
							"experiance" : $("#ur_experiance").val(),
							"func" : 'feedback'
						},
				success : function (data){
					//alert("We have Received your Request");
					//console.log(data);
					$("input[type=text],[type=email], [type='number'], textarea").val("");
				},
				error : function(e){
					console.log(e.responseText);
				}
			});
			$("input[type='text'],[type=email], [type='number'], textarea").val("");
		}
	});

	//Contact-Us form
	var contactNew = $('#contactNew');
	contactNew.click(function(event){
		event.preventDefault();
		if($("#ur_name").val() == null || $("#ur_name").val() == '' && $("#ur_email").val() == null || $("#ur_email").val() == '' && $("#ur_number").val() == null || $("#ur_number").val() == '' && $("#ur_course").val() == null || $("#ur_course").val() == ''){
			alert("All the fields are Mandatory");
			//console.log($("#ur_name").val()+'  '+$("#ur_experiance").val());
		} else {
			alert("We have Received your Request");
			console.log($("#ur_name").val()+'  '+$("#ur_email").val()+'  '+$("#ur_number").val()+'  '+$('#ur_message').val()+'  '+$("#ur_course").val());
			$.ajax({
				url     : "http://www.techninzaz.com/backend_code.php",
				type    : "POST",
				data    : {
							"name" : $("#ur_name").val(),
							"email" : $("#ur_email").val(),
							"phone" : $("#ur_number").val(),
							"course" : $("#ur_course").val(),
							"query" : $('#ur_message').val(),
							"func" : 'contactV2'
						},
				success : function (data){
					//alert("We have Received your Request");
					//console.log(data);
					$("input[type=text], [type=email], [type='tel'], textarea").val("");
				},
				error : function(e){
					console.log(e.responseText);
				}
			});
			$("input[type='text'], [type=email], [type='tel'], textarea").val("");
		}
	});


	//Corporate Feedback Form
	var corporateFeedBack = $("#submitCFBForm");
	corporateFeedBack.click(function(e){
		e.preventDefault();
		if(!$('#cfbf_name').val() || !$('#cfbf_email').val() || !$('#cfbf_phoneNo').val() || !$('#cfbf_textareaOne').val() || !$('#cfbf_textareaTwo').val() || !$('#cfbf_textareaThree').val()){
			alert('All fields mandatory');
		}else{
			alert("We have Received your Request");
			$.ajax({
				url     : "http://www.techninzaz.com/backend_code.php",
				type    : "POST",
				data    : {
							"name" : $("#cfbf_name").val(),
							"email" : $("#cfbf_email").val(),
							"phone" : $("#cfbf_phoneNo").val(),
							"textareaOne" : $("#cfbf_textareaOne").val(),
							"textareaTwo" : $('#cfbf_textareaTwo').val(),
							"textareaThree" : $('#cfbf_textareaThree').val(),
							"courseRating":{
								'one':$('input[name=courseRatingOne]:checked').val(),
								'two':$('input[name=courseRatingTwo]:checked').val(),
								'three':$('input[name=courseRatingThree]:checked').val(),
								'four':$('input[name=courseRatingFour]:checked').val()
							},
							"facultyRating":{
								'one':$('input[name=facultyRatingOne]:checked').val(),
								'two':$('input[name=facultyRatingTwo]:checked').val(),
								'three':$('input[name=facultyRatingThree]:checked').val(),
								'four':$('input[name=facultyRatingFour]:checked').val()
							},
							'courseName':$("#cfbf_courseName option:selected").val(),
							'facultyName':$("#cfbf_staffName option:selected").val(),
							'func': 'corporateFeedBackForm'
						},
				success : function (data){
					//alert("We have Received your Request");
					//console.log(data);
					$("input[type=text], [type=email], [type='tel'], textarea").val("");
				},
				error : function(e){
					console.log(e.responseText);
				}
			});

		}
	});

	
	//goto top
	$('.gototop').click(function(event) {
		event.preventDefault();
		$('html, body').animate({
			scrollTop: $("body").offset().top
		}, 500);
	});	

	//Pretty Photo
	$("a[rel^='prettyPhoto']").prettyPhoto({
		social_tools: false
	});	


});