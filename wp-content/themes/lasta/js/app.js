jQuery(document).ready(function($){
	$('body').on('input click','input[type="search"]',function(e){
		console.log('tes');
		var $this = this;
		var tip = $(this).closest('.tab-pane').attr('id');
		console.log($(this).closest('.search-wrapper').find('.ajax-result'));
		$(this).closest('.search-wrapper').find('.ajax-result').show();
	    $.ajax({
	        url: ajaxurl,
	        type: 'post',
	        data: { action: 'data_search', keyword: jQuery(this).val(), tip:tip },
	        success: function(data) {
	        	console.log(data);
	            $($this).closest('.search-wrapper').find('.ajax-result').html(data);
				let first_opt = $($this).closest('.search-wrapper').find('.ajax-result').find('li').first().attr('data-id');
				console.log(first_opt);
				$($this).closest('.search-wrapper').find('.way').attr('value',first_opt);
	        },
	        error:function(x,y,z){
	        	console.log(x,y,z);
	        }
	    });		
	});
	$('body').on('click','.swap',function(){
		let next_id = $(this).closest('.search-wrapper').next().find('.way').attr('value');
		let cur_id = $(this).closest('.search-wrapper').find('.way').attr('value');
		
		let next_val = $(this).closest('.search-wrapper').next().find('input[type="search"]').attr('value');
		let cur_val = $(this).closest('.search-wrapper').find('input[type="search"]').attr('value');
		
		$(this).closest('.search-wrapper').next().find('.way').attr('value',cur_id);
		$(this).closest('.search-wrapper').find('.way').attr('value',next_id);
		
		$(this).closest('.search-wrapper').next().find('input[type="search"]').attr('value',cur_val);
		$(this).closest('.search-wrapper').find('input[type="search"]').attr('value',next_val);
		
	});
	$('body').on('click','.ajax-result>ul>li',function(e){

		$(this).closest('.search-wrapper').find('input[type="search"]').attr('value',$(this).html());
		$(this).closest('.search-wrapper').find('.way').attr('value',$(this).attr('data-id'));

		$(this).closest('.search-wrapper').find('.ajax-result').hide();
		$('.search-wrapper').last().find('input[type="search"]').focus();
		
		console.log($(this).attr('data-id'));
	});

	// Datepicker min date
	//$( ".datepicker-bus" ).datepicker($.datepicker.regional[ "sr-SR" ]);
	$( "#datepicker-medjunarodni" ).datepicker({ minDate: 0});
	$( "#datepicker-domaci" ).datepicker({ minDate: 0});
	
	


	$(window).load(function() {
	// The slider being synced must be initialized first
	$('#carousel').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: true,
		slideshow: true,
		itemWidth: 125,
		itemMargin: 8,
		touch: true,
		minItems: 4,
		maxItems: 4,
		asNavFor: '#slider'
	});
	
	$('#slider').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: true,
		slideshow: true,
		sync: "#carousel"
	});
	});

	

	//add show class on dropdpwns when clicked
	$(document).ready(function()
	{
		$('a.dropdown-toggle[data-toggle="dropdown"]').on('click', function(event) 
		{
		var currentTarget = $(this),
		parent        = currentTarget.parent(),
		siblings      = parent.siblings();

		//event.preventDefault(); 
		event.stopPropagation(); 

		siblings.removeClass('show');
		siblings.find('ul').removeClass('show');
		parent.toggleClass('show');
		parent.children('ul').toggleClass('show');
		});
		});
	
	$('body').on('mouseenter mouseleave', '.dropdown', function (e) {
		var dropdown = $(e.target).closest('.dropdown');
		var menu = $('.dropdown-menu', dropdown);
		dropdown.addClass('show');
		menu.addClass('show');
		setTimeout(function () {
			dropdown[dropdown.is(':hover') ? 'addClass' : 'removeClass']('show');
			menu[dropdown.is(':hover') ? 'addClass' : 'removeClass']('show');
		}, 300);
	});

	// AOS Init
	AOS.init();

	jQuery(document).ready(function($){
		if (top.location.pathname === '/rezultat-pretrage/') {
			$('html,body').animate({scrollTop: $('#results').offset().top - 40}, 500);
		}
	});

	$('.swap').on('click', function(){
		$(this).toggleClass('rotate');
	  });


	//To top btn
	jQuery(document).ready(function($){
		var offset = 200;
		var speed = 250;
		var duration = 500;
		   $(window).scroll(function(){
				if ($(this).scrollTop() < offset) {
					 $('.topbutton') .fadeOut(duration);
				} else {
					 $('.topbutton') .fadeIn(duration);
				}
			});
		$('.topbutton').on('click', function(){
			$('html, body').animate({scrollTop:0}, speed);
			return false;
			});
	});  

	
	


});