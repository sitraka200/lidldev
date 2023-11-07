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
	$(window).ready(function() {
		$("select[name='COOKIES_PLUS_NOTICE_STYLE']").change(function() {
			console.log($(this).val());
		});
	});
})(jQuery);