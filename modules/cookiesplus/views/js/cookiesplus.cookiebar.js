/*
 * Copyright (C) 2012 PrimeBox (info@primebox.co.uk)
 *
 * This work is licensed under the Creative Commons
 * Attribution 3.0 Unported License. To view a copy
 * of this license, visit
 * http://creativecommons.org/licenses/by/3.0/.
 *
 * Documentation available at:
 * http://www.primebox.co.uk/projects/cookie-bar/
 *
 * When using this software you use it at your own risk. We hold
 * no responsibility for any damage caused by using this plugin
 * or the documentation provided.
 */
(function($){
	$.cookieBar = function(options,val){
		if(options=='cookies'){
			var doReturn = 'cookies';
		}else if(options=='set'){
			var doReturn = 'set';
		}else{
			var doReturn = false;
		}
		var defaults = {
			message: CK_message, //Message displayed on bar
			acceptButton: CK_accept_button, //Set to true to show accept/enable button
			acceptText: CK_accept_button_text, //Text on accept/enable button
			acceptFunction: function(cookieValue){if(cookieValue!='enabled' && cookieValue!='accepted' && CK_mode == 2) window.location = window.location.href;}, //Function to run after accept
			//acceptFunction: function(cookieValue){if(cookieValue!='accepted') window.location = window.location.href;}, //Function to run after accept
			declineButton: CK_decline_button, //Set to true to show decline/disable button
			declineText: CK_decline_button_text, //Text on decline/disable button
			declineURL: CK_decline_button_url,
			declineFunction: function(cookieValue){window.location = window.location.href;}, //Function to run after decline
			policyButton: CK_policy_button, //Set to true to show Privacy Policy button
			policyText: CK_policy_button_text, //Text on Privacy Policy button
			policyURL: CK_cms_page, //URL of Privacy Policy
			autoEnable: true, //Set to true for cookies to be accepted automatically. Banner still shows
			acceptOnContinue: CK_accept_move, //Set to true to accept cookies when visitor moves to another page
			acceptOnScroll: CK_accept_scroll, //Set to true to accept cookies when visitor scrolls X pixels up or down
			acceptAnyClick: CK_accept_click, //Set to true to accept cookies when visitor clicks anywhere on the page
			acceptTimeout: CK_accept_timeout,
			acceptTimeoutSeconds: CK_accept_timeout_s,
			expire: CK_cookie_expiry, //Number of days for cookieBar cookie to be stored for
			renewOnVisit: true, //Renew the cookie upon revisit to website
			forceShow: false, //Force cookieBar to show regardless of user cookie preference
			effect: CK_notice_effect, //Options: slide, fade, hide
			element: 'body', //Element to append/prepend cookieBar to. Remember "." for class or "#" for id.
			append: CK_notice_position, //Set to true for cookieBar HTML to be placed at base of website. Actual position may change according to CSS
			fixed: CK_notice_fixed, //Set to true to add the class "fixed" to the cookie bar. Default CSS should fix the position
			bottom: CK_notice_fixed_bottom, //Force CSS when fixed, so bar appears at bottom of website
			domain: String(window.location.hostname), //Location of privacy policy
			referrer: String(document.referrer) //Where visitor has come from
		};
		var options = $.extend(defaults,options);

		//Sets expiration date for cookie
		var expireDate = new Date();
		expireDate.setTime(expireDate.getTime()+(options.expire*86400000));
		expireDate = expireDate.toGMTString();

		var cookieEntry = CK_name+'={value}; expires='+expireDate+'; path=/';

		//Retrieves current cookie preference
		var i,cookieValue='',aCookie,aCookies=document.cookie.split('; ');
		for (i=0;i<aCookies.length;i++){
			aCookie = aCookies[i].split('=');
			if(aCookie[0]==CK_name){
    			cookieValue = aCookie[1];
			}
		}
		//Sets up default cookie preference if not already set
		/*if(cookieValue=='' && doReturn!='cookies' && options.autoEnable){
			cookieValue = 'enabled';
			document.cookie = cookieEntry.replace('{value}','enabled');
		}else*/ if((cookieValue=='accepted' || cookieValue=='declined') && doReturn!='cookies' && options.renewOnVisit){
			document.cookie = cookieEntry.replace('{value}',cookieValue);
		}
		if(options.acceptOnContinue && CK_exception == 0){
			if(options.referrer.indexOf(options.domain)>=0 && String(window.location.href).indexOf(options.policyURL)==-1 && doReturn!='cookies' && doReturn!='set' && cookieValue!='accepted' && cookieValue!='declined'){
				doReturn = 'set';
				val = 'accepted';
			}
		}
		if(doReturn=='cookies'){
			//Returns true if cookies are enabled, false otherwise
			if(cookieValue=='enabled' || cookieValue=='accepted'){
				return true;
			}else{
				return false;
			}
		}else if(doReturn=='set' && (val=='accepted' || val=='declined')){
			//Sets value of cookie to 'accepted' or 'declined'
			document.cookie = cookieEntry.replace('{value}',val);
			if(val=='accepted'){
				return true;
			}else{
				return false;
			}
		}else{
			//Sets up enable/accept button if required
			var message = options.message.replace('{policy_url}',options.policyURL);

			if(options.acceptButton){
				var acceptButton = '<a href="'+window.location.href+'" class="cb-button cb-enable">'+options.acceptText+'</a>';
			}else{
				var acceptButton = '';
			}
			//Sets up disable/decline button if required
			if(options.declineButton){
				var declineButton = '<a href="'+options.declineURL+'" class="cb-button cb-disable">'+options.declineText+'</a>';
			}else{
				var declineButton = '';
			}
			//Sets up privacy policy button if required
			if(options.policyButton){
				var policyButton = '<a href="'+options.policyURL+'" target="_blank" class="cb-button cb-policy">'+options.policyText+'</a>';
			}else{
				var policyButton = '';
			}
			//Whether to add "fixed" class to cookie bar
			if(options.fixed){
				if(options.bottom){
					var fixed = ' class="fixed bottom"';
				}else{
					var fixed = ' class="fixed"';
				}
			}else{
				var fixed = '';
			}

			//Displays the cookie bar if arguments met
			if(options.forceShow || cookieValue=='enabled' || cookieValue=='declined' || cookieValue==''){
				if(options.append){
					$(options.element).append('<div id="cookie-bar"'+fixed+'><p>'+message+acceptButton+declineButton+policyButton+'</p></div>');
				}else{
					$(options.element).prepend('<div id="cookie-bar"'+fixed+'><p>'+message+acceptButton+declineButton+policyButton+'</p></div>');
				}
			}

			var removeBar = function(func){
				if(options.acceptOnScroll) $(document).off('scroll');
				if(typeof(func)==='function') func(cookieValue);
				if(options.effect=='slide'){
					$('#cookie-bar').slideUp(300,function(){$('#cookie-bar').remove();});
				}else if(options.effect=='fade'){
					$('#cookie-bar').fadeOut(300,function(){$('#cookie-bar').remove();});
				}else{
					$('#cookie-bar').hide(0,function(){$('#cookie-bar').remove();});
				}
				$(document).unbind('click',anyClick);
			};
			var cookieAccept = function(){
				document.cookie = cookieEntry.replace('{value}','accepted');
				removeBar(options.acceptFunction);
			};
			var cookieDecline = function(){
				var deleteDate = new Date();
				deleteDate.setTime(deleteDate.getTime()-(864000000));
				deleteDate = deleteDate.toGMTString();
				aCookies=document.cookie.split('; ');
				for (i=0;i<aCookies.length;i++){
					aCookie = aCookies[i].split('=');
					if(aCookie[0].indexOf('_')>=0){
						document.cookie = aCookie[0]+'=0; expires='+deleteDate+'; domain='+options.domain.replace('www','')+'; path=/';
					}else{
						document.cookie = aCookie[0]+'=0; expires='+deleteDate+'; path=/';
					}
				}
				document.cookie = cookieEntry.replace('{value}','declined');
				removeBar(options.declineFunction);
			};
			var anyClick = function(e){
				if(!$(e.target).hasClass('cb-policy')) cookieAccept();
			};

			$('#cookie-bar .cb-enable').click(function(){cookieAccept();return false;});
			$('#cookie-bar .cb-disable').click(function(){cookieDecline();return true;});
			if(options.acceptOnScroll && CK_exception == 0){
				var scrollStart = $(document).scrollTop(),scrollNew,scrollDiff;
				$(document).on('scroll',function(){
					scrollNew = $(document).scrollTop();
					if(scrollNew>scrollStart){
						scrollDiff = scrollNew - scrollStart;
					}else{
						scrollDiff = scrollStart - scrollNew;
					}
					if(scrollDiff>=Math.round(options.acceptOnScroll)) cookieAccept();
				});
			}
			if(options.acceptAnyClick){
				$(document).bind('click',anyClick);
			}
			if(options.acceptTimeout && options.acceptTimeoutSeconds > 0){
				window.setTimeout(function(){ cookieAccept() }, (options.acceptTimeoutSeconds*1000));
			}
		}
	};
})(jQuery);

$(document).ready(function() {
    $.cookieBar();
});