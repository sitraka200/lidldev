{*
* PrivateShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
*
*  @author    FMM Modules
*  @copyright 2018 FMM Modules
*  @version   1.4.0
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if $version < 1.6}

	<div class="translatable">
	{foreach from=$languages item=language}
	<div id="welcome_{$language.id_lang|escape:'htmlall':'UTF-8'}" class="lang_{$language.id_lang|escape:'htmlall':'UTF-8'}" style="display: {if $language.id_lang == $id_lang} block {else} none{/if};float: left;">
		<textarea cols="100" rows="10" type="text" id="{$input_name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}" 
			name="{$input_name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}" 
			class="autoload_rte" >{if isset($input_value[$language.id_lang])}{$input_value[$language.id_lang]|htmlentitiesUTF8}{*html content*}{/if}</textarea>
		<span class="hint" name="help_box">{$hint|default:''|escape:'htmlall':'UTF-8'}<span class="hint-pointer">&nbsp;</span></span>
	</div>
	{/foreach}
	{$module->displayFlags($languages, $active_lang, welcome, welcome, false) nofilter}
	</div>
	<script type="text/javascript">
		var iso = '{$iso_tiny_mce|escape:'htmlall':'UTF-8'}';
		var pathCSS = '{$smarty.const._THEME_CSS_DIR_|escape:'htmlall':'UTF-8'}';
		var ad = '{$ad|escape:'htmlall':'UTF-8'}';
		var file_not_found = '';
	</script>
{else}

	{foreach from=$languages item=language}
		{if $languages|count > 1}
			<div class="translatable-field row lang-{$language.id_lang|escape:'htmlall':'UTF-8'}">
				<div class="col-lg-9">
		{/if}
			<textarea id="{$input_name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}" name="{$input_name|escape:'htmlall':'UTF-8'}_{$language.id_lang|escape:'htmlall':'UTF-8'}" class="{if isset($class)}{$class|escape:'htmlall':'UTF-8'}{else}textarea-autosize{/if}"{if isset($maxlength) && $maxlength} maxlength="{$maxlength|intval|escape:'htmlall':'UTF-8'}"{/if}>{if isset($input_value[$language.id_lang])}{$input_value[$language.id_lang]|htmlentitiesUTF8}{*html content*}{/if}</textarea>

		{if $languages|count > 1}
				</div>
				<div class="col-lg-2">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						{$language.iso_code|escape:'htmlall':'UTF-8'}
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						{foreach from=$languages item=language}
						<li><a href="javascript:hideOtherLanguage({$language.id_lang|escape:'htmlall':'UTF-8'});">{$language.name|escape:'htmlall':'UTF-8'}</a></li>
						{/foreach}
					</ul>
				</div>
			</div>
		{/if}
	{/foreach}
	<div class="help-block">{l s='This message will be displayed after registration of restricted customers. You can use HTML tags, images, links etc...' mod='privateshop'}</div>
	<script type="text/javascript">
		$(".textarea-autosize").autosize();
	</script>
{/if}
{literal}
<script type="text/javascript">
var file_not_found = '';
$(document).ready(function ()
{
	$('.displayed_flag .pointer').addClass('btn btn-default');
	$('.language_flags').addClass('well').css('display','inline-block').hide();
	hideOtherLanguage({/literal}{$active_lang|escape:'htmlall':'UTF-8'}{literal});
    setTimeout(function() {
		tinyMCE.init({
                    mode : "textareas",
                    theme : "advanced",
                    plugins : "safari,pagebreak,style,layer,table,advimage,advlink,inlinepopups,media,searchreplace,contextmenu,paste,directionality,fullscreen",
                    theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,,|,forecolor,backcolor",
                    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen",
                    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,pagebreak",
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_toolbar_align : "left",
                    theme_advanced_statusbar_location : "bottom",
                    theme_advanced_resizing : false,
                    content_css : "{/literal}{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}themes/{$smarty.const._THEME_NAME_|escape:'htmlall':'UTF-8'}/css/global.css{literal}",
                    document_base_url : "{/literal}{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}{literal}",
                    width: "600",
                    height: "auto",
                    font_size_style_values : "8pt, 10pt, 12pt, 14pt, 18pt, 24pt, 36pt",
                    template_external_list_url : "lists/template_list.js",
                    external_link_list_url : "lists/link_list.js",
                    external_image_list_url : "lists/image_list.js",
                    media_external_list_url : "lists/media_list.js",
                    elements : "nourlconvert",
                    entity_encoding: "raw",
                    convert_urls : false,
                    language : "{/literal}{$iso_tiny_mce|escape:'htmlall':'UTF-8'}{literal}"
            });
	}, 3000);
    id_language = Number("{/literal}{$active_lang|escape:'htmlall':'UTF-8'}{literal}");
});
function hideOtherLanguage(id)
{
    $('.translatable-field').hide();
    $('.lang-' + id).show();

    var id_old_language = id_language;
    id_language = id;

    if (id_old_language != id)
        changeEmployeeLanguage();

    updateCurrentText();
}

function changeEmployeeLanguage()
{
    if (typeof allowEmployeeFormLang !== 'undefined' && allowEmployeeFormLang)
        $.post("index.php", {
            action: 'formLanguage',
            tab: 'AdminEmployees',
            ajax: 1,
            token: employee_token,
            form_language_id: id_language
        });
}
</script>{/literal}