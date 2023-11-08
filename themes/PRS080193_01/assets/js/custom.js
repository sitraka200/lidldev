function addfl(){
this.$owlItems.removeClass('first last');
this.$owlItems.eq(this.currentItem).addClass('first');
this.$owlItems.eq(this.currentItem + (this.owl.visibleItems.length - 1)).addClass('last');
} 
	
$(document).ready(function(){	  
	
	// tm_top link

		$('#links_block_top .title_block').click(function() {
		    $('#links_block_top .block_content').slideToggle("slow");
		    $('#links_block_top .title_block').toggleClass('active');
		  });
	

		// tm_vertical menu

$('.tmvm-contener .block-title').click(function() {
    $('#_desktop_top_menu #top-menu').slideToggle("slow");
    $('.tmvm-contener .block-title').toggleClass('active');
  });

	//breadcumb//
	$('h1.h1').prependTo('.breadcrumb .container');
	//breadcumb//

			 $('.language-selector-wrapper').appendTo('.user-info');
	 	$('.currency-selector').appendTo('.user-info');

});

// $('.outer_blog').prependTo('#tmsmartblog_block');




function additionalCarousel(sliderId){
	/*======  curosol For Additional ==== */
	 var tmadditional = $(sliderId);
      tmadditional.owlCarousel({
     	 items : 3, //10 items above 1000px browser width
     	 itemsDesktop : [1199,2], 
     	 itemsDesktopSmall : [991,2], 
     	 itemsTablet: [480,2], 
     	 itemsMobile : [320,1] 
      });
      // Custom Navigation Events
      $(".additional_next").click(function(){
        tmadditional.trigger('owl.next');
      })
      $(".additional_prev").click(function(){
        tmadditional.trigger('owl.prev');
      });
}

$(document).ready(function(){
	
								
	bindGrid();
	additionalCarousel("#main #additional-carousel");
	

	$('.cart_block .block_content').on('click', function (event) {
		event.stopPropagation();
	});
	
	
	$('#product #productCommentsBlock').appendTo('#product #tab-content #rating');
	
	// ---------------- start more menu setting ----------------------
	if ($(document).width() >= 992 && $(document).width() <= 1199){
		var max_elem = 7;	
	}


	else if($(document).width() >= 1200 && $(document).width() <= 1450 ){
		var max_elem = 9;	
	}
	else{
		var max_elem = 10;	
	}
	  
	  
	  
		var itemsleft = $('.header-top .menu ul#top-menu > li,#left-column .menu ul#top-menu > li');	
		


		if ( itemsleft.length > max_elem ) {
		
			$('.header-top .menu ul#top-menu, #left-column .menu ul#top-menu').append('<li><div class="more-wrap"><span class="more-view"><i class="material-icons">&#xE145;</i>More</span></div></li>');
		}

		$('.header-top .menu ul#top-menu .more-wrap,#left-column .menu ul#top-menu .more-wrap ').click(function() {
			if ($(this).hasClass('active')) {
				itemsleft.each(function(i) {
					if ( i >= max_elem ) {
						$(this).slideUp(200);
					}
				});
				$(this).removeClass('active');
				//$(this).children('div').css('display', 'block');
				$('.more-wrap').html('<span class="more-view"><i class="material-icons">&#xE145;</i>More</span>');
			} else {
				itemsleft.each(function(i) {
					if ( i >= max_elem  ) {
						$(this).slideDown(200);
					}
				});
				$(this).addClass('active');
				$('.more-wrap').html('<span class="more-view"><i class="material-icons">&#xE15b;</i>Less</span>');
			}
		});

		itemsleft.each(function(i) {
			if ( i >= max_elem ) { 
				$(this).css('display', 'none');
			}
		});


	

});


// Add/Remove acttive class on menu active in responsive  
	$('#menu-icon').on('click', function() {
		$(this).toggleClass('active');
	});

// Loading image before flex slider load
	$(window).load(function() { 
		$(".loadingdiv").removeClass("spinner"); 
	});

// Flex slider load
	$(window).load(function() {
		if($('.flexslider').length > 0){ 
			$('.flexslider').flexslider({		
				slideshowSpeed: $('.flexslider').data('interval'),
				pauseOnHover: $('.flexslider').data('pause'),
				animation: "fade"
			});
		}
	});		

// Scroll page bottom to top
	$(window).scroll(function() {
		if ($(this).scrollTop() > 500) {
			$('.top_button').fadeIn(500);
		} else {
			$('.top_button').fadeOut(500);
		}
	});							
	$('.top_button').click(function(event) {
		event.preventDefault();		
		$('html, body').animate({scrollTop: 0}, 800);
	});



/*======  Carousel Slider For Feature Product ==== */
	var tmfeature = $("#feature-carousel");
		// var x =  tmfeature.children();
		// for (i = 0; i < x.length+1 ; i += 2) {
		//   	x.slice(i,i+2).wrapAll('<div class="'+ i +'"></div>');

		// }
	
	tmfeature.owlCarousel({
		items : 4, //10 items above 1000px browser width
		itemsDesktop : [1400,3],
		itemsDesktopSmall : [1199,2], 
		itemsTablet: [767,2], 
		itemsMobile : [480,2],
		afterAction: addfl
	}); 


	// Custom Navigation Events
	$(".feature_next").click(function(){
		tmfeature.trigger('owl.next');
	})
	$(".feature_prev").click(function(){
		tmfeature.trigger('owl.prev');
	});



/*======  Carousel Slider For discount Product ==== */
	var tmdiscount = $("#discount-carousel");

	
	tmdiscount.owlCarousel({
		items : 5, //10 items above 1000px browser width
		itemsDesktop : [1199,3], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [767,2], 
		itemsMobile : [480,2],
		afterAction: addfl
	}); 



	// Custom Navigation Events
	$(".discount_next").click(function(){
		tmdiscount.trigger('owl.next');
	})
	$(".discount_prev").click(function(){
		tmdiscount.trigger('owl.prev');
	});


/*======  Carousel Slider For New Product ==== */
	var tmnewproduct = $("#newproduct-carousel");
	// var x =  tmnewproduct.children();
	// 	for (i = 0; i < x.length+1 ; i += 2) {
	// 	  	x.slice(i,i+2).wrapAll('<div class="'+ i +'"></div>');
	// 	}
	

	tmnewproduct.owlCarousel({
		items : 4, //10 items above 1000px browser width
		itemsDesktop : [1400,3],
		itemsDesktopSmall : [1199,2], 
		itemsTablet: [767,2], 
		itemsMobile : [480,2],
		afterAction: addfl 
	});
	// Custom Navigation Events
	$(".newproduct_next").click(function(){
		tmnewproduct.trigger('owl.next');
	})
	$(".newproduct_prev").click(function(){
		tmnewproduct.trigger('owl.prev');
	});



/*======  Carousel Slider For Bestseller Product ==== */

	var tmbestseller = $("#bestseller-carousel");
	// var x =  tmbestseller.children();
	// 	for (i = 0; i < x.length+1 ; i += 2) {
	// 	  	x.slice(i,i+2).wrapAll('<div class="'+ i +'"></div>');
	// 	}
	

	tmbestseller.owlCarousel({
		items : 4, //10 items above 1000px browser width
		itemsDesktop : [1400,3],
		itemsDesktopSmall : [1199,2], 
		itemsTablet: [767,2], 
		itemsMobile : [480,2],
		afterAction: addfl 
	});
	// Custom Navigation Events
	$(".bestseller_next").click(function(){
		tmbestseller.trigger('owl.next');
	})
	$(".bestseller_prev").click(function(){
		tmbestseller.trigger('owl.prev');
	});



/*======  Carousel Slider For Special Product ==== */
	var tmspecial = $("#special-carousel");
	 // var x =  tmspecial.children();
	 // 	for (i = 0; i < x.length+1 ; i += 2) {
	 // 	  	x.slice(i,i+2).wrapAll('<div class="'+ i +'"></div>');
	 // 	}
		

	tmspecial.owlCarousel({
		items : 2, //10 items above 1000px browser width
		itemsDesktop : [1199,2], 
		itemsDesktopSmall : [991,1], 
		itemsTablet: [767,1], 
		itemsMobile : [480,1],
		afterAction: addfl 
	});
	// Custom Navigation Events
	$(".special_next").click(function(){
		tmspecial.trigger('owl.next');
	})
	$(".special_prev").click(function(){
		tmspecial.trigger('owl.prev');
	});


/*======  Carousel Slider For Accessories Product ==== */

	var tmaccessories = $("#accessories-carousel");
	tmaccessories.owlCarousel({
		items : 5, //10 items above 1000px browser width
		itemsDesktop : [1199,3], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [767,2], 
		itemsMobile : [480,2],
		afterAction: addfl 
	});
	// Custom Navigation Events
	$(".accessories_next").click(function(){
		tmaccessories.trigger('owl.next');
	})
	$(".accessories_prev").click(function(){
		tmaccessories.trigger('owl.prev');
	});


/*======  Carousel Slider For Category Product ==== */

	var tmproductscategory = $("#productscategory-carousel");
	tmproductscategory.owlCarousel({
		items : 5, //10 items above 1000px browser width
		itemsDesktop : [1199,3], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [767,2], 
		itemsMobile : [480,2],
		afterAction: addfl 
	});
	// Custom Navigation Events
	$(".productscategory_next").click(function(){
		tmproductscategory.trigger('owl.next');
	})
	$(".productscategory_prev").click(function(){
		tmproductscategory.trigger('owl.prev');
	});


/*======  Carousel Slider For Viewed Product ==== */

	var tmviewed = $("#viewed-carousel");
	tmviewed.owlCarousel({
		items : 5, //10 items above 1000px browser width
		itemsDesktop : [1199,3], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [767,2], 
		itemsMobile : [480,2],
		afterAction: addfl 
	});
	// Custom Navigation Events
	$(".viewed_next").click(function(){
		tmviewed.trigger('owl.next');
	})
	$(".viewed_prev").click(function(){
		tmviewed.trigger('owl.prev');
	});

/*======  Carousel Slider For Crosssell Product ==== */

	var tmcrosssell = $("#crosssell-carousel");
	tmcrosssell.owlCarousel({
		items : 5, //10 items above 1000px browser width
		itemsDesktop : [1199,3], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [767,2], 
		itemsMobile : [480,2],
		afterAction: addfl 
	});
	// Custom Navigation Events
	$(".crosssell_next").click(function(){
		tmcrosssell.trigger('owl.next');
	})
	$(".crosssell_prev").click(function(){
		tmcrosssell.trigger('owl.prev');
	});


/*======  Carousel Slider For categorylist ==== */

		var tmcat = $("#tmcategorylist-carousel");
		// tmcat.owlCarousel({
		// 	items : 7, //10 items above 1000px browser width
		// 	autoPlay : true,
		// 	itemsDesktop : [1199,4], 
		// 	itemsDesktopSmall : [991,3], 
		// 	itemsTablet: [767,2], 
		// 	itemsMobile : [480,1],
		// 	afterAction: addfl
		// });
		/* New Change */
		tmcat.owlCarousel({
			items : 3, //10 items above 1000px browser width
			autoPlay : true,
			itemsDesktop : [1199,3], 
			itemsDesktopSmall : [991,2], 
			itemsTablet: [767,2], 
			itemsMobile : [480,1],
			afterAction: addfl
		});
		// Custom Navigation Events
		$(".cat_next").click(function(){
		tmcat.trigger('owl.next');
		})
		$(".cat_prev").click(function(){
		tmcat.trigger('owl.prev');
		});

/*======  Carousel Slider For blog  ==== */
	
	var tmblog = $("#blog-carousel");
	tmblog.owlCarousel({
		items : 1, //10 items above 1000px browser width
		itemsDesktop : [1199,1], 
		itemsDesktopSmall : [991,1], 
		itemsTablet: [480,1]
	});

	$(".blog_next").click(function(){
		tmblog.trigger('owl.next');
	})
	$(".blog_prev").click(function(){
		tmblog.trigger('owl.prev');
	});

	// ps_blog

      if($(window).width() <= 991 ){
		$('.tmblog-latest .products-section-title').click(function() {
		    $('.tmblog-latest .homeblog-inner').slideToggle("slow");
		    $('.tmblog-latest .products-section-title').toggleClass('active');
		  });
	  }
	
	
	
/*======  curosol For Manufacture ==== */
	 var tmbrand = $("#brand-carousel");
      tmbrand.owlCarousel({
     	 items : 7, //10 items above 1000px browser width
     	 itemsDesktop : [1450,5], 
     	 itemsDesktopSmall : [1199,4],
     	 itemsTablet: [767,2], 
		itemsMobile : [480,1] 
      });
      // Custom Navigation Events
      $(".brand_next").click(function(){
        tmbrand.trigger('owl.next');
      })
      $(".brand_prev").click(function(){
        tmbrand.trigger('owl.prev');
      });
	  



function bindGrid()
{
	var view = $.totalStorage("display");

	if (view && view != 'grid')
		display(view);
	else
		$('.display').find('li#grid').addClass('selected');

	$(document).on('click', '#grid', function(e){
		e.preventDefault();
		display('grid');
	});




	$(document).on('click', '#list', function(e){
		e.preventDefault();
		display('list');		
	});	
}

function display(view)
{
	if (view == 'list')
	{
		$('#products ul.product_list').removeClass('grid').addClass('list');
		$('#products .product_list > li').removeClass('col-xs-12 col-sm-6 col-md-6 col-lg-3').addClass('col-xs-12');
		
		
		$('#products .product_list > li').each(function(index, element) {
			var html = '';
			html = '<div class="product-miniature js-product-miniature" data-id-product="'+ $(element).find('.product-miniature').data('id-product') +'" data-id-product-attribute="'+ $(element).find('.product-miniature').data('id-product-attribute') +'" itemscope itemtype="http://schema.org/Product"><div class="row">';
				html += '<div class="thumbnail-container col-xs-4 col-xs-5 col-md-3">' + $(element).find('.thumbnail-container').html() + '</div>';
				
				html += '<div class="product-description center-block col-xs-4 col-xs-7 col-md-9">';
					html += '<div class="comments_note">'+ $(element).find('.comments_note').html() +'</div>';
					html += '<h3 class="h3 product-title" itemprop="name">'+ $(element).find('h3').html() + '</h3>';
					
					var price = $(element).find('.product-price-and-shipping').html();       // check : catalog mode is enabled
					if (price != null) {
						html += '<div class="product-price-and-shipping">'+ price + '</div>';
					}
					
					html += '<div class="product-detail">'+ $(element).find('.product-detail').html() + '</div>';
					
					var colorList = $(element).find('.highlighted-informations').html();
					if (colorList != null) {
						html += '<div class="highlighted-informations">'+ colorList +'</div>';
					}
					
					html += '<div class="product-actions-main">'+ $(element).find('.product-actions-main').html() +'</div>';
					
				html += '</div>';
			html += '</div></div>';
		$(element).html(html);
		});
		$('.display').find('li#list').addClass('selected');
		$('.display').find('li#grid').removeAttr('class');
		$.totalStorage('display', 'list');
	}
	else
	{
		$('#products ul.product_list').removeClass('list').addClass('grid');
		$('#products .product_list > li').removeClass('col-xs-12').addClass('col-xs-12 col-sm-6 col-md-6 col-lg-3');
		$('#products .product_list > li').each(function(index, element) {
		var html = '';
		html += '<div class="product-miniature js-product-miniature" data-id-product="'+ $(element).find('.product-miniature').data('id-product') +'" data-id-product-attribute="'+ $(element).find('.product-miniature').data('id-product-attribute') +'" itemscope itemtype="http://schema.org/Product">';
			html += '<div class="thumbnail-container">' + $(element).find('.thumbnail-container').html() +'</div>';
			
			html += '<div class="product-description">';
				html += '<div class="comments_note">'+ $(element).find('.comments_note').html() +'</div>';
				html += '<h3 class="h3 product-title" itemprop="name">'+ $(element).find('h3').html() +'</h3>';
			
				var price = $(element).find('.product-price-and-shipping').html();       // check : catalog mode is enabled
				if (price != null) {
					html += '<div class="product-price-and-shipping">'+ price + '</div>';
				}
				
				html += '<div class="product-detail">'+ $(element).find('.product-detail').html() + '</div>';
				
				html += '<div class="product-actions-main">'+ $(element).find('.product-actions-main').html() +'</div>';
				
				var colorList = $(element).find('.highlighted-informations').html();
				if (colorList != null) {
					html += '<div class="highlighted-informations">'+ colorList +'</div>';
				}
				
			html += '</div>';
		html += '</div>';
		$(element).html(html);
		});
		$('.display').find('li#grid').addClass('selected');
		$('.display').find('li#list').removeAttr('class');
		$.totalStorage('display', 'grid');
	}
}


function responsivecolumn(){
	
	if ($(document).width() <= 991){
				
		// ---------------- Fixed header responsive ----------------------
		$(window).bind('scroll', function () {
			if ($(window).scrollTop() > 0) {
				$('.header-nav').addClass('fixed');
			} else {
				$('.header-nav').removeClass('fixed');
			}
		});
	}
	
	
	if ($(document).width() <= 991)
	{
		$('.container #columns_inner #left-column').appendTo('.container #columns_inner');
		
	}
	if ($(document).width() >= 992){

				$('.container #columns_inner #left-column').prependTo('.container #columns_inner');

		// ---------------- Fixed header responsive ----------------------
		$(window).bind('scroll', function () {
			if ($(window).scrollTop() > 210) {
				$('.header-top-main').addClass('fixed');
				
			} else {
				$('.header-top-main').removeClass('fixed');				
			}
		});
		
	}
	else{
		$('.header-top-main').removeClass('fixed');

	}
}
$(document).ready(function(){responsivecolumn();});
$(window).resize(function(){responsivecolumn();});


function searchtoggle() {
 		
	if($(window).width() <= 991 ){
		$('#search_widget').detach().insertAfter('.header-nav #_mobile_user_info');
		$('.search_button').click(function(event){
			$(this).toggleClass('active');
			$('#search_widget').toggleClass('active');
			event.stopPropagation();
			$(".searchtoggle").slideToggle("fast");
			$('.search-widget form input[type="text"]').focus();
		});
		
		$(".searchtoggle").on("click", function (event) {
			event.stopPropagation();
		});
	}else{
		$('.search_button,.searchtoggle').unbind();
		$('#search_widget').unbind();
		$(".searchtoggle").show();
		$('#search_widget').detach().insertAfter('.header-top #_desktop_logo');
	}

}

jQuery(document).ready(function() {searchtoggle();});
$(window).resize(function(){responsivecolumn();});





// JS for calling loadMore
$(document).ready(function () {

	"use strict";							 
  	var size_li_feat = $("#index #featureProduct .featured_grid li.product_item").size();
	var size_li_new = $("#index #newProduct .newproduct_grid li.product_item").size();
	var size_li_best = $("#index #bestseller .bestseller_grid li.product_item").size();
	var size_li_special = $("#index .special-products #special-grid li.product_item").size();
	

	var x= 8;
	var y= 8;
	var z= 8;
	var s= 8;
		
	$('#index #featureProduct .featured_grid li.product_item:lt('+x+')').fadeIn('slow');
	$('#index #newProduct .newproduct_grid li.product_item:lt('+y+')').fadeIn('slow');
	$('#index #bestseller .bestseller_grid li.product_item:lt('+z+')').fadeIn('slow');
	$('#index .special-products #special-grid li.product_item:lt('+s+')').fadeIn('slow');
	    	
    $('.featured_grid .gridcount').click(function () {
	if(x==size_li_feat){									 			
			 $('.featured_grid .gridcount').hide();
			 $('.featured_grid .tm-message').show();
	}else{
		x= (x+4 <= size_li_feat) ? x+4 : size_li_feat;	
        $('#index #featureProduct .featured_grid li.product_item:lt('+x+')').fadeIn(1000);			
	}
    });		
	
	$('.newproduct_grid .gridcount').click(function () {
	if(y==size_li_new){									 
			$('.newproduct_grid .gridcount').hide();
			$('.newproduct_grid .tm-message').show();
	}else{
		y= (y+4 <= size_li_new) ? y+4 : size_li_new;
        $('#index #newProduct .newproduct_grid li.product_item:lt('+y+')').fadeIn('slow');
	}
    });	   
	
	$('.bestseller_grid .gridcount').click(function () {
	if(z==size_li_best){									 
			$('.bestseller_grid .gridcount').hide();
			$('.bestseller_grid .tm-message').show();
	}else{
		z= (z+4 <= size_li_best) ? z+4 : size_li_best;
        $('#index #bestseller .bestseller_grid li.product_item:lt('+z+')').fadeIn('slow');
	}
    });
			
	$('#special-grid .gridcount').click(function () {
	if(s==size_li_special){
	
			$('#special-grid .gridcount').hide();
			$('#special-grid .tm-message').show();
	}else{
		s= (s+4 <= size_li_special) ? s+4 : size_li_special;
        $('#index .special-products #special-grid li.product_item:lt('+s+')').fadeIn('slow');
	}
    });
		
		
});


		

//sign in toggle
$(document).ready(function(){
	
	 $('#_desktop_user_info, #_mobile_user_info').click(function(event){
		  $(this).toggleClass('active');
		  event.stopPropagation();
		  $(".user-info").slideToggle("fast");
		});
		$(".user-info").on("click", function (event) {
		  event.stopPropagation();
		});	
		
});

/**
 * NEW JS CODE
 * @author Francois Mickael Rakotonirina
 */
$(document).ready(function() {
	$('img.svg-image').filter(function() {
        return this.src.match(/.*\.svg$/);
    } ).inlineSvg();
});