/*
*
* PrivateShop
*
* Do not edit or add to this file.
* You are not authorized to modify, copy or redistribute this file.
* Permissions are reserved by FME Modules.
*
*  @author    FME Modules
*  @copyright 2017 FME Modules All right reserved
*  @license   FME Modules
*  @category  FMM Modules
*  @package   PrivateShop
*/

/**
 * Handles loading of product tabs
 */
function ProductTabsManager(){
	var self = this;
	this.product_tabs = [];
	this.current_request;
	this.stack_error = [];
	this.page_reloading = false;
	this.has_error_loading_tabs = false;

	/**
	* Show / Hide languages semaphore
	*/
	this.allow_hide_other_languages = true;

	this.setTabs = function(tabs){
		this.product_tabs = tabs;
	}

	/**
	 * Schedule execution of onReady() function for each tab and bind events
	 */
	this.init = function()
	{
		for (var tab_name in this.product_tabs) {
			if (this.product_tabs[tab_name].onReady !== undefined)
				this.onLoad(tab_name, this.product_tabs[tab_name].onReady);
		}

		$('.shopList.chzn-done').on('change', function(){
			if (self.current_request)
			{
				self.page_reloading = true;
				self.current_request.abort();
			}
		});

		$(window).on('beforeunload', function() {
			self.page_reloading = true;
		});
	}

	/**
	 * Execute a callback function when a specific tab has finished loading or right now if the tab has already loaded
	 *
	 * @param tab_name name of the tab that is checked for loading
	 * @param callback_function function to call
	 */
	this.onLoad = function (tab_name, callback)
	{
		var container = $('#product-tab-content-' + tab_name);
		// Some containers are not loaded depending on the shop configuration
		if (container.length === 0)
			return;

		// onReady() is always called after the dom has been created for the tab (similar to $(document).ready())
		if (container.hasClass('not-loaded'))
			container.bind('loaded', callback);
		else
			callback();
	}

	/**
	 * Get a single tab or recursively get tabs in stack then display them
	 *
	 * @param string tab_name name of the tab
	 * @param boolean selected is the tab selected
	 */
	this.display = function (tab_name, selected)
	{
		/*In order to prevent mod_evasive DOSPageInterval (Default 1s)*/
		if (mod_evasive)
			sleep(1000);

		var tab_selector = $("#product-tab-content-" + tab_name);

		// Is the tab already being loaded?
		if (tab_selector.hasClass('not-loaded') && !tab_selector.hasClass('loading'))
		{
			// Mark the tab as being currently loading
			tab_selector.addClass('loading');

			if (selected)
				$('#product-tab-content-wait').show();

			// send $_POST array with the request to be able to retrieve posted data if there was an error while saving product
			var data;
			var send_type = 'GET';
			if (save_error)
			{
				send_type = 'POST';
				data = post_data;
				// set key_tab so that the ajax call returns the display for the current tab
				data.key_tab = tab_name;
			}

			return $.ajax({
				url : $('#privateshop_'+tab_name).attr("href")+"&ajax=1" + '&rand=' + new Date().getTime(),
				async : true,
				cache: false, // cache needs to be set to false or IE will cache the page with outdated product values
				type: send_type,
				headers: { "cache-control": "no-cache" },
				data: data,
				timeout: 30000,
				success : function(data)
				{
					tab_selector.html(data).find('.dropdown-toggle').dropdown();
					tab_selector.removeClass('not-loaded');

					if (selected)
					{
						$("#privateshop_"+tab_name).addClass('selected');
						tab_selector.show();
					}
					tab_selector.trigger('loaded');
				},
				complete : function(data)
				{
					tab_selector.removeClass('loading');
					if (selected)
					{
						$('#product-tab-content-wait').hide();
						tab_selector.trigger('displayed');
					}
				},
				beforeSend : function(data)
				{
					// don't display the loading notification bar
					if (typeof(ajax_running_timeout) !== 'undefined')
						clearTimeout(ajax_running_timeout);
				}
			});
		}
	}
var product_tabs = [];
product_tabs['Associations'] = new function(){
	var self = this;
	this.initAccessoriesAutocomplete = function (){
		$('#product_autocomplete_input')
			.autocomplete('ajax_products_list.php', {
				minChars: 1,
				autoFill: true,
				max:20,
				matchContains: true,
				mustMatch:false,
				scroll:false,
				cacheLength:0,
				formatItem: function(item) {
					return item[1]+' - '+item[0];
				}
			}).result(self.addAccessory);

		$('#product_autocomplete_input').setOptions({
			extraParams: {
				excludeIds : self.getAccessoriesIds()
			}
		});
	};

	this.getAccessoriesIds = function()
	{
		if ($('#inputAccessories').val() === undefined)
			return id_product;
		return id_product + ',' + $('#inputAccessories').val().replace(/\-/g,',');
	}

	this.addAccessory = function(event, data, formatted)
	{
		if (data == null)
			return false;
		var productId = data[1];
		var productName = data[0];

		var $divAccessories = $('#divAccessories');
		var $inputAccessories = $('#inputAccessories');
		var $nameAccessories = $('#nameAccessories');

		/* delete product from select + add product line to the div, input_name, input_ids elements */
		$divAccessories.html($divAccessories.html() + '<div class="form-control-static"><button type="button" class="delAccessory btn btn-default" name="' + productId + '"><i class="icon-remove text-danger"></i></button>&nbsp;'+ productName +'</div>');
		$nameAccessories.val($nameAccessories.val() + productName + '¤');
		$inputAccessories.val($inputAccessories.val() + productId + '-');
		$('#product_autocomplete_input').val('');
		$('#product_autocomplete_input').setOptions({
			extraParams: {excludeIds : self.getAccessoriesIds()}
		});
	};

	this.delAccessory = function(id)
	{
		var div = getE('divAccessories');
		var input = getE('inputAccessories');
		var name = getE('nameAccessories');

		// Cut hidden fields in array
		var inputCut = input.value.split('-');
		var nameCut = name.value.split('¤');

		if (inputCut.length != nameCut.length)
			return jAlert('Bad size');

		// Reset all hidden fields
		input.value = '';
		name.value = '';
		div.innerHTML = '';
		for (i in inputCut)
		{
			// If empty, error, next
			if (!inputCut[i] || !nameCut[i])
				continue ;

			// Add to hidden fields no selected products OR add to select field selected product
			if (inputCut[i] != id)
			{
				input.value += inputCut[i] + '-';
				name.value += nameCut[i] + '¤';
				div.innerHTML += '<div class="form-control-static"><button type="button" class="delAccessory btn btn-default" name="' + inputCut[i] +'"><i class="icon-remove text-danger"></i></button>&nbsp;' + nameCut[i] + '</div>';
			}
			else
				$('#selectAccessories').append('<option selected="selected" value="' + inputCut[i] + '-' + nameCut[i] + '">' + inputCut[i] + ' - ' + nameCut[i] + '</option>');
		}

		$('#product_autocomplete_input').setOptions({
			extraParams: {excludeIds : self.getAccessoriesIds()}
		});
	};

	this.onReady = function(){
		self.initAccessoriesAutocomplete();
		self.getManufacturers();
		$('#divAccessories').delegate('.delAccessory', 'click', function(){
			self.delAccessory($(this).attr('name'));
		});
		if (display_multishop_checkboxes)
			ProductMultishop.checkAllAssociations();
	};
}


	this.checkAllAssociations = function()
	{
		ProductMultishop.checkField($('input[name=\'multishop_check[id_category_default]\']').prop('checked'), 'id_category_default');
		ProductMultishop.checkField($('input[name=\'multishop_check[id_category_default]\']').prop('checked'), 'associated-categories-tree', 'category_box');
	};

};

var tabs_manager = new ProductTabsManager();
tabs_manager.setTabs(product_tabs);

$(document).ready(function() {
	// The manager schedules the onReady() methods of each tab to be called when the tab is loaded
	tabs_manager.init();
	updateCurrentText();
	$("#name_" + id_lang_default + ",#link_rewrite_" + id_lang_default)
		.on("change", function(e) {
			$(this).trigger("handleSaveButtons");
		});
	// bind that custom event
	$("#name_" + id_lang_default + ",#link_rewrite_" + id_lang_default)
		.on("handleSaveButtons", function(e) {
			handleSaveButtons()
		});

	// Pressing enter in an input field should not submit the form
	$('#product_form').delegate('input', 'keypress', function(e) {
			var code = null;
		code = (e.keyCode ? e.keyCode : e.which);
		return (code == 13) ? false : true;
	});

	$('#product_form').submit(function(e) {
		$('#selectedCarriers option').attr('selected', 'selected');
		$('#selectAttachment1 option').attr('selected', 'selected');
		return true;
	});
});
