{*
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
*}
<script type="text/javascript" src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/privateshop/views/js/jquery.autocomplete.js"></script>

<script type="text/javascript">
var img = '';
{if $version < 1.6}
	img = '<img src="../img/admin/delete.gif" />';
{/if}

{literal}
var version = "{/literal}{$version|escape:'htmlall':'UTF-8'}{literal}";
var search_link = htmlEncode("{/literal}{$search_link|escape:'htmlall':'UTF-8'}{literal}");
$(document).ready(function()
{
	var p_sh = document.getElementsByName('PRIVATIZE_SHOP');
	for(var i=0; i < p_sh.length; i++)
	{
		if (p_sh[i].value == 'whole-shop' && p_sh[i].checked)
			disable_all();
		else if (p_sh[i].value == 'selected-parts' && p_sh[i].checked)
			enable_all();
	}

	var link = "{/literal}{$link->getPageLink('search')|escape:'htmlall':'UTF-8'}{literal}";
	var lang = jQuery('#lang_spy').val();
	$("#product_autocomplete_input")
		.autocomplete(search_link, {
				minChars: 3,
				max: 10,
				width: 500,
				selectFirst: false,
				scroll: false,
				dataType: "json",
				formatItem: function(data, i, max, value, term) {
					return value;
				},
				parse: function(data)
				{
					var mytab = new Array();
					for (var i = 0; i < data.length; i++)
						mytab[mytab.length] = { data: data[i], value: data[i].id_product + ' - ' + data[i].pname };
					return mytab;
				},
				extraParams: {
					ajaxSearch: 1,
					id_lang: lang
				}
			}
		)
		.result(function(event, data, formatted)
		{
			var $divAccessories = $('#addProducts');
			if ( data.id_product.length > 0 && data.pname.length > 0 )
			{
				var exclude = [];
				var selected = $('.private_products');
				for(var i=0; i < selected.length; i++)
					exclude.push(selected[i].value);
				var ps_div = '';				

				if($.inArray(data.id_product, exclude) == -1)
				{
					ps_div = '<div id="selected_product_' + data.id_product + '" class="form-control-static margin-form"><input type="hidden" name="private_products[]" value="' + data.id_product + '" class="private_products"/><button type="button" class="btn btn-default remove-product" name="' + data.id_product + '" onclick="deleteProduct('+ data.id_product +')">'+ img +'<i class="icon-remove text-danger"></i></button>&nbsp;'+ data.pname +'</div>';

					
					$divAccessories.show().html($divAccessories.html() + ps_div);
				}

			}
		})

});

function addRemoteAddr()
{
	var length = $('input[name=ACCESS_GRANTED_IP]').attr('value').length;
	if (length > 0)
		$('input[name=ACCESS_GRANTED_IP]').attr('value',$('input[name=ACCESS_GRANTED_IP]').attr('value') +",{/literal}{$cur_ip|escape:'htmlall':'UTF-8'}{literal}");
	else
		$('input[name=ACCESS_GRANTED_IP]').attr("value","{/literal}{$cur_ip|escape:'htmlall':'UTF-8'}{literal}");
}

function deleteProduct(id)
{
	$("#selected_product_"+id).remove();
}

function disable_all()
{
	$('#product_autocomplete_input').attr('disabled','disabled');
	$('#check-all-associated-categories-tree').attr('disabled','disabled');
	$('#uncheck-all-associated-categories-tree').attr('disabled','disabled');
	$('#checkme').attr('disabled','disabled');
	$('#search_cat').attr('disabled','disabled');
	$('#associated-categories-tree-categories-search').attr('disabled','disabled');
	$('.remove-product').attr('disabled','disabled')
	$('.cms_pages').attr('disabled','disabled');
	var cat = document.getElementsByName('categoryBox[]');
	for(var i=0; i < cat.length; i++)
	{
		cat[i].disabled = true;
	}
	
}

function enable_all()
{
	$('#product_autocomplete_input').removeAttr('disabled');
	$('#check-all-associated-categories-tree').removeAttr('disabled');
	$('#uncheck-all-associated-categories-tree').removeAttr('disabled');
	$('#checkme').removeAttr('disabled');
	$('#search_cat').removeAttr('disabled');
	$('#associated-categories-tree-categories-search').removeAttr('disabled');
	$('.remove-product').removeAttr('disabled');
	$('.cms_pages').removeAttr('disabled');
	var cat = document.getElementsByName('categoryBox[]');
	for(var i=0; i < cat.length; i++)
	{
		cat[i].disabled = false;
	}
	
}

function htmlEncode(input)
{
    return String(input)
        .replace(/&amp;/g, '&');
}
</script>
{/literal}
<!-- Privatize selection -->
<div class="col-lg-12 form-group margin-form">
	<label class="control-label col-lg-3">
		<span data-html="true" data-original-title="{l s='Restrict the access of whole shop or restrict specific parts of the shop(categories,products,pages etc).' mod='privateshop'}" class="label-tooltip" data-toggle="tooltip" title="">{l s='Privatize' mod='privateshop'}</span>
	</label>
	<div class="col-lg-2 margin-form frame_styled{if isset($field_values) AND isset($field_values.PRIVATIZE_SHOP) AND $field_values.PRIVATIZE_SHOP == 'whole-shop'} active_frame{/if}">
		<input type="radio" name="PRIVATIZE_SHOP" id="PRIVATIZE_SHOP_shop" value="whole-shop" onclick="disable_all()" {if isset($field_values) AND isset($field_values.PRIVATIZE_SHOP) AND $field_values.PRIVATIZE_SHOP == 'whole-shop'}checked="checked"{/if}/>
		<label class="t" for="PRIVATIZE_SHOP_shop">{l s='Whole Shop' mod='privateshop'}</label>
		<i class="pvt_icon ws_ico"></i>
	</div>
	
	<div class="col-lg-2 margin-form frame_styled{if isset($field_values) AND isset($field_values.PRIVATIZE_SHOP) AND $field_values.PRIVATIZE_SHOP == 'selected-parts'} active_frame{/if}">
		<input type="radio" name="PRIVATIZE_SHOP" id="PRIVATIZE_SHOP_selected" value="selected-parts" onclick="enable_all()" {if isset($field_values) AND isset($field_values.PRIVATIZE_SHOP) AND $field_values.PRIVATIZE_SHOP == 'selected-parts'}checked="checked"{/if}/>
		<label class="t" for="PRIVATIZE_SHOP_selected">{l s='Only Selected' mod='privateshop'}</label>
		<i class="pvt_icon os_ico"></i>
	</div>
</div>
<!-- Whitelist ip's -->
<div class="form-group margin-form">
	<div id="conf_id_ACCESS_GRANTED_IP">
		<label class="control-label col-lg-3">
			<span data-html="true" data-original-title="{l s='Listed IP addresses allowed to access the Front Office even if private shop is enabled. Please use a comma to separate them (e.g. 42.24.4.2,127.0.0.1,99.98.97.96)' mod='privateshop'}" class="label-tooltip" data-toggle="tooltip" title="">
				{l s='Allowed IP(s)' mod='privateshop'}
			</span>
		</label>
		<div class="col-lg-7">
			<input type="text" value="{if isset($field_values) AND isset($field_values.allowed_ip)}{$field_values.allowed_ip|escape:'htmlall':'UTF-8'}{/if}" name="ACCESS_GRANTED_IP">
		</div>
		<div class="col-lg-1 margin-form">
			<button onclick="addRemoteAddr();" class="btn btn-default" type="button"><i class="icon-plus"></i> {l s='Add my IP' mod='privateshop'}</button>
		</div>
	</div>
</div>
<div class="clearfix"></div><br>
<!-- restrict products -->
<div class="form-group margin-form">
	<label class="control-label col-lg-3" for="product_autocomplete_input">
		<span class="label-tooltip" data-toggle="tooltip" title="{l s='Select products to make them private.' mod='privateshop'}">{l s='Private Products' mod='privateshop'}</span>
	</label>
	<div class="col-lg-7">
		<div id="ajax_choose_product">
			<div class="input-group">
				<input id="product_autocomplete_input" name="" type="text" class="text ac_input" value=""/>
				<input id="lang_spy" type="hidden" value="1" />
				<span class="input-group-addon"><i class="icon-search"></i></span>
			</div>
			<p class="preference_description help-block margin-form">({l s='Start by typing the first letters of the product\'s name, then select the product from the drop-down list.' mod='privateshop'})</p>
		</div>
		<!-- <table id="addProducts" style="display:block;">
		</table> -->
		<div id="addProducts" style="{if isset($products)}display:block;{else}display:none;{/if}">
		{if isset($products) AND $products}
			{foreach $products as $pid}
			<div id="selected_product_{$pid|escape:'htmlall':'UTF-8'}" class="form-control-static margin-form">
				<input type="hidden" name="private_products[]" value="{$pid|escape:'htmlall':'UTF-8'}" class="private_products"/>
				<button type="button" class="btn btn-default remove-product" name="{$pid|escape:'htmlall':'UTF-8'}" onclick="deleteProduct({$pid|escape:'htmlall':'UTF-8'})">
					<i class="icon-remove text-danger"></i>
					{if $version < 1.6}
						<img src="../img/admin/delete.gif" />
					{/if}
				</button>&nbsp;{Product::getProductName({$pid|escape:'htmlall':'UTF-8'})|escape:'htmlall':'UTF-8'}
			</div>
			{/foreach}
		{/if}
		</div>
	</div>
</div>
<div class="clearfix"></div><br/>
<!-- restrict categories -->
<div class="col-lg-12 form-group margin-form">
	<label class="form-group control-label col-lg-3">
		<span class="label-tooltip" data-toggle="tooltip" title="{l s='Select categories to make them private.' mod='privateshop'}">{l s='Private Category' mod='privateshop'}</span>
	</label>
	<div class="form-group margin-form ">
		<div class="col-lg-9">
			{$categories}{*html code, cannot be escaped*}
		</div>
	</div>
</div><br><br/>
<div class="clearfix"></div><br/>
<!-- Private CMS Pages -->
<div class="form-group margin-form">
	<label class="control-label col-lg-3" for="product_autocomplete_input">
		<span class="label-tooltip" data-toggle="tooltip" title="{l s='Select page(s) to make them private.' mod='privateshop'}">{l s='Private Pages' mod='privateshop'}</span>
	</label>
	<div class="col-lg-9">
		<div id="productArrayTable">
	      <table cellspacing="0" cellpadding="0" class="table std table-bordered" style="overflow-y: auto;{if $version < 1.6}width:500px;{/if}">
	        <tr>
	          <th> <input type="checkbox" name="checkme" id="checkme" class="noborder" onclick="checkDelBoxes(this.form, 'cms_pages[]', this.checked)"/>
	          </th>
	          <th>{l s='ID' mod='privateshop'}</th>
	          <th>{l s='Page Name' mod='privateshop'}</th>
	        </tr>
	        <tr><td colspan="3" style="border-bottom:1px solid #e1e1e1;"></td></tr>
	        {foreach from=$cms_pages item=page}
		        <tr>
		          <td>
		          	<input type="checkbox" class="cms_pages" name="cms_pages[]" id="{$page.id_cms|escape:'htmlall':'UTF-8'}" value="{$page.id_cms|escape:'htmlall':'UTF-8'}" {if isset($pages) AND $pages AND in_array($page.id_cms, $pages)}checked="checked"{/if}/>
		          </td>
		          <td>
		          	{$page.id_cms|escape:'htmlall':'UTF-8'}
		          </td>
		          <td>
		          	<span for="{$page.id_cms|escape:'htmlall':'UTF-8'}" class="t">
		          		{$page.meta_title|escape:'htmlall':'UTF-8'}
		          	</span>
		          </td>
		        </tr>
	        {/foreach}
	      </table>
	    </div>
	</div>
</div>
<div class="clearfix"></div>

<!-- restricted signup -->
<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Allow Google to crawl?' mod='privateshop'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="PRIVATE_RESTRICT_GOOGLE" id="PRIVATE_RESTRICT_GOOGLE_on" value="1" {if isset($field_values) AND isset($field_values.active_google) AND $field_values.active_google == 1}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_RESTRICT_GOOGLE_on">{if $version < 1.6}<img src="../img/admin/enabled.gif" alt="Enabled" title="Enabled" />{else}{l s='Yes' mod='privateshop'}{/if}</label>
			<input type="radio" name="PRIVATE_RESTRICT_GOOGLE" id="PRIVATE_RESTRICT_GOOGLE_off" value="0" {if isset($field_values) AND isset($field_values.active_google) AND $field_values.active_google == 0}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_RESTRICT_GOOGLE_off">{if $version < 1.6}<img src="../img/admin/disabled.gif" alt="Disabled" title="Disabled" />{else}{l s='No' mod='privateshop'}{/if}</label>
			<a class="slide-button btn"></a>
		</span>
		<div class="help-block">{l s='Do you want Google searchbot to access the webstore for SEO?' mod='privateshop'}</div>
	</div>
</div>
</div>