{*
* PrivateShop
*
* Do not edit or add to this file.
* You are not authorized to modify, copy or redistribute this file.
* Permissions are reserved by FME Modules.
*
*  @author    FME Modules
*  @copyright 2018 FME Modules All right reserved
*  @license   FME Modules
*  @category  FMM Modules
*  @package   PrivateShop
*}
{literal}
<style type="text/css">
.frame_styled { display: inline-block; padding: 1.5% !important; border: 1px solid #C7D6DB; background: #F5F8F9; text-align: center;
 margin-right: 2%; border-radius: 4px; position: relative; cursor: pointer; max-height: 90px; overflow: hidden}
.active_frame { background: #c5f7ca; border-color: #72C279}
.frame_styled input[type="radio"] { height: 90px; left: 0; position: absolute; top: -10px; width: 100%; opacity: 0; z-index: 99;}
.pvt_icon { text-align: center; display: block; clear: both;}
.pvt_icon::before { display: inline-block;
font-family: FontAwesome; color: #2EACCE;
font-size: 32px;
font-size-adjust: none;
font-stretch: normal;
font-style: normal;
font-weight: normal;
line-height: 1;
text-rendering: auto;}
.ac_ico::before {content: "\f1fb";}
.ai_ico::before {content: "\f03e";}
.ayv_ico::before {content: "\f16a";}
.ws_ico::before {content: "\f023";}
.os_ico::before {content: "\f13e";}
.mod_theme_ico::before {content: "\f0d0";}
.def_theme_ico::before {content: "\f0c5";}
.red_flag { color: red;}
</style>{/literal}
<script type="text/javascript">
	var _activate_customer = {$activate_customer};
	var _tab_module = "{$tab_select}";
$(document).ready(function(){
console.log(_tab_module);
	var chk_box = document.getElementsByName('BACKGROUND_TYPE');
	for(var i=0; i<chk_box.length;i++)
	{
		if (chk_box[i].checked)
		{
		  var sel_opt = chk_box[i].value;
		  show_bg_option(sel_opt);
		}
	}
	if (_activate_customer > 0 || _tab_module === 'customers') {
		javascript:displayPrivateTab('customers');
	}
	$('.frame_styled').on('click', function(e) {
			$(this).parent().find('.frame_styled').removeClass('active_frame');
			$(this).addClass('active_frame');
			//$(this).find('input[type="radio"]').trigger('click');
		});
});

function show_bg_option(opt)
{
	$('.bg_options').hide();
	$('#'+opt).show();
	if(opt.toString() == 'background-image')
		$('#background-gallery').show();
}
</script>
<!-- login title -->
<div class="col-lg-12 form-group margin-form">
	<label class="form-group control-label col-lg-3">{l s='Login Title' mod='privateshop'}</label>
	<div class="form-group margin-form">
		<div class="col-lg-6">
			{foreach from=$languages item=lang}
			<div class="lang_{$lang.id_lang}"id="cpara_{$lang.id_lang}"{if $lang.id_lang != $active_lang} style="display:none;"{/if}>
				<input type="text" class="form-control" name="LOGIN_TITLE_{$lang.id_lang}" value="{if isset($field_values) AND isset($field_values.login_title[$lang.id_lang])}{$field_values.login_title[$lang.id_lang]|escape:'htmlall':'UTF-8'}{/if}"/>
			</div>
			{/foreach}
		</div>
		<div class="col-lg-3">{$module->displayFlags($languages, Context::getContext()->language->id, 'cpara&curren;dd', 'cpara', true) nofilter}{*HTML Content*}</div>
	</div>
</div>
<!-- login title -->
<div class="col-lg-12 form-group margin-form">
	<label class="form-group control-label col-lg-3">{l s='Signup Title' mod='privateshop'}</label>
	<div class="form-group margin-form ">
		<div class="col-lg-6">
			{foreach from=$languages item=lang}
			<div class="lang_{$lang.id_lang}"id="cpara2_{$lang.id_lang}"{if $lang.id_lang != $active_lang} style="display:none;"{/if}>
			<input type="text" class="form-control" name="SIGNUP_TITLE_{$lang.id_lang}" value="{if isset($field_values) AND isset($field_values.signup_title[$lang.id_lang])}{$field_values.signup_title[$lang.id_lang]|escape:'htmlall':'UTF-8'}{/if}"/>
			</div>
			{/foreach}
		</div>
		<div class="col-lg-3">{$module->displayFlags($languages, Context::getContext()->language->id, 'cpara2&curren;dd', 'cpara2', true) nofilter}{*HTML Content*}</div>
	</div>
</div>
<!-- form position -->
<div class="col-lg-12 form-group margin-form">
<label class="control-label col-lg-3">{l s='Form Position' mod='privateshop'}</label>					
	<div class="col-lg-2 frame_styled{if isset($field_values) AND isset($field_values.position) AND $field_values.position == 'left'} active_frame{/if}">
		<span>
			<input type="radio" name="FORM_POSITION" id="FORM_POSITION_1" value="left" {if isset($field_values) AND isset($field_values.position) AND $field_values.position == 'left'}checked="checked"{/if}/>
		</span>
		<div>
			<label class="t" for="FORM_POSITION_1">
				<div><center>{l s='Left' mod='privateshop'}</center></div>
				<div><img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/privateshop/views/img/l.png"/></div>
			</label>
		</div>
	</div>
	
	<div class="col-lg-2 frame_styled{if isset($field_values) AND isset($field_values.position) AND $field_values.position == 'center'} active_frame{/if}">
		<span>
			<input type="radio" name="FORM_POSITION" id="FORM_POSITION_2" value="center" {if isset($field_values) AND isset($field_values.position) AND $field_values.position == 'center'}checked="checked"{/if}/>
		</span>
		<div>
			<label class="t" for="FORM_POSITION_2">
				<div><center>{l s='Center' mod='privateshop'}</center></div>
				<div><img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/privateshop/views/img/c.png"/></div>
			</label>
		</div>
	</div>
	<div class="col-lg-2 frame_styled{if isset($field_values) AND isset($field_values.position) AND $field_values.position == 'right'} active_frame{/if}">
		<span>
			<input type="radio" name="FORM_POSITION" id="FORM_POSITION_3" value="right" {if isset($field_values) AND isset($field_values.position) AND $field_values.position == 'right'}checked="checked"{/if}/>
		</span>
		<div>
			<label class="t" for="FORM_POSITION_3">
				<div><center>{l s='Right' mod='privateshop'}</center></div>
				<div><img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/privateshop/views/img/r.png"/></div>
			</label>
		</div>
	</div>
</div>
<div class="clearfix"></div>

<!-- Form Theme selection -->
<div class="col-lg-12 form-group margin-form">
	<label class="control-label col-lg-3">{l s='Form Theme' mod='privateshop'}</label>
	<div class="col-lg-9">
	<div class="col-lg-3 margin-form frame_styled{if isset($field_values) AND isset($field_values.priv_form_theme) AND $field_values.priv_form_theme == 'mod'} active_frame{/if}">
		<input type="radio" name="PRIVATE_FORM_THEME" id="PRIVATE_FORM_THEME_mod" value="mod" {if isset($field_values) AND isset($field_values.priv_form_theme) AND $field_values.priv_form_theme == 'mod'}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_FORM_THEME_mod">{l s='Modern Theme' mod='privateshop'}</label>
		<i class="pvt_icon mod_theme_ico"></i>
	</div>
	
	<div class="col-lg-3 margin-form frame_styled{if isset($field_values) AND isset($field_values.priv_form_theme) AND $field_values.priv_form_theme == 'def'} active_frame{/if}">
		<input type="radio" name="PRIVATE_FORM_THEME" id="PRIVATE_FORM_THEME_def" value="def" {if isset($field_values) AND isset($field_values.priv_form_theme) AND $field_values.priv_form_theme == 'def'}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_FORM_THEME_def">{l s='Default Theme' mod='privateshop'}</label>
		<i class="pvt_icon def_theme_ico"></i>
	</div>
	<div style="display: block; clear: both" class="help-block">{l s='Default theme will use your store theme stylesheet.' mod='privateshop'}</div>
	</div>
</div>

<!-- opacity option -->
<div class="col-lg-12 form-group margin-form">
	<label class="form-group control-label col-lg-3">{l s='Form Background Opacity' mod='privateshop'}</label>
	<div class="form-group margin-form ">
		<div class="col-lg-6">
			<input type="text" name="BG_OPACITY" value="{if isset($field_values) AND isset($field_values.bg_opacity)}{$field_values.bg_opacity|escape:'htmlall':'UTF-8'}{/if}" />
			<div class="help-block">{l s='Use values between 0 and 1 for example 0.6 or 0.85' mod='privateshop'}</div>
		</div>
	</div>
</div>
<!-- signup -->
<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Enable Signup' mod='privateshop'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="PRIVATE_SIGNUP" id="PRIVATE_SIGNUP_on" value="1" {if isset($field_values) AND isset($field_values.active_signup) AND $field_values.active_signup == 1}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_SIGNUP_on">{if $version < 1.6}<img src="../img/admin/enabled.gif" alt="Enabled" title="Enabled" />{else}{l s='Yes' mod='privateshop'}{/if}</label>
			<input type="radio" name="PRIVATE_SIGNUP" id="PRIVATE_SIGNUP_off" value="0" {if isset($field_values) AND isset($field_values.active_signup) AND $field_values.active_signup == 0}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_SIGNUP_off">{if $version < 1.6}<img src="../img/admin/disabled.gif" alt="Disabled" title="Disabled" />{else}{l s='No' mod='privateshop'}{/if}</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>
</div>

<!-- birthday menu -->
<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Disable Birthday in Signup' mod='privateshop'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="PRIVATE_BDAY" id="PRIVATE_BDAY_on" value="1" {if isset($field_values) AND isset($field_values.bday) AND $field_values.bday == 1}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_BDAY_on">{if $version < 1.6}<img src="../img/admin/enabled.gif" alt="Enabled" title="Enabled" />{else}{l s='Yes' mod='privateshop'}{/if}</label>
			<input type="radio" name="PRIVATE_BDAY" id="PRIVATE_BDAY_off" value="0" {if isset($field_values) AND isset($field_values.bday) AND $field_values.bday == 0}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_BDAY_off">{if $version < 1.6}<img src="../img/admin/disabled.gif" alt="Disabled" title="Disabled" />{else}{l s='No' mod='privateshop'}{/if}</label>
			<a class="slide-button btn"></a>
		</span>
  <div class="help-block">{l s='Only for PrestaShop 1.7.x versions.' mod='privateshop'}</div>
	</div>
</div>
</div>

<!-- gender options -->
<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Disable Gender in Signup' mod='privateshop'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="PRIVATE_GENDER_OPT" id="PRIVATE_GENDER_OPT_on" value="1" {if isset($field_values) AND isset($field_values.gender_opt) AND $field_values.gender_opt == 1}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_GENDER_OPT_on">{if $version < 1.6}<img src="../img/admin/enabled.gif" alt="Enabled" title="Enabled" />{else}{l s='Yes' mod='privateshop'}{/if}</label>
			<input type="radio" name="PRIVATE_GENDER_OPT" id="PRIVATE_GENDER_OPT_off" value="0" {if isset($field_values) AND isset($field_values.gender_opt) AND $field_values.gender_opt == 0}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_GENDER_OPT_off">{if $version < 1.6}<img src="../img/admin/disabled.gif" alt="Disabled" title="Disabled" />{else}{l s='No' mod='privateshop'}{/if}</label>
			<a class="slide-button btn"></a>
		</span>
  <div class="help-block">{l s='Only for PrestaShop 1.7.x versions.' mod='privateshop'}</div>
	</div>
</div>
</div>

<!-- newsletter box -->
<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Disable Newsletter Signup' mod='privateshop'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="PRIVATE_NLETTER_OPT" id="PRIVATE_NLETTER_OPT_on" value="1" {if isset($field_values) AND isset($field_values.nletter_opt) AND $field_values.nletter_opt == 1}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_NLETTER_OPT_on">{if $version < 1.6}<img src="../img/admin/enabled.gif" alt="Enabled" title="Enabled" />{else}{l s='Yes' mod='privateshop'}{/if}</label>
			<input type="radio" name="PRIVATE_NLETTER_OPT" id="PRIVATE_NLETTER_OPT_off" value="0" {if isset($field_values) AND isset($field_values.nletter_opt) AND $field_values.nletter_opt == 0}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_NLETTER_OPT_off">{if $version < 1.6}<img src="../img/admin/disabled.gif" alt="Disabled" title="Disabled" />{else}{l s='No' mod='privateshop'}{/if}</label>
			<a class="slide-button btn"></a>
		</span>
  <div class="help-block">{l s='Only for PrestaShop 1.7.x versions.' mod='privateshop'}</div>
	</div>
</div>
</div>

<!-- Offers box -->
<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Disable Offers Signup' mod='privateshop'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="PRIVATE_OFFERS_OPT" id="PRIVATE_OFFERS_OPT_on" value="1" {if isset($field_values) AND isset($field_values.offers_opt) AND $field_values.offers_opt == 1}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_OFFERS_OPT_on">{if $version < 1.6}<img src="../img/admin/enabled.gif" alt="Enabled" title="Enabled" />{else}{l s='Yes' mod='privateshop'}{/if}</label>
			<input type="radio" name="PRIVATE_OFFERS_OPT" id="PRIVATE_OFFERS_OPT_off" value="0" {if isset($field_values) AND isset($field_values.offers_opt) AND $field_values.offers_opt == 0}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_OFFERS_OPT_off">{if $version < 1.6}<img src="../img/admin/disabled.gif" alt="Disabled" title="Disabled" />{else}{l s='No' mod='privateshop'}{/if}</label>
			<a class="slide-button btn"></a>
		</span>
  <div class="help-block">{l s='Only for PrestaShop 1.7.x versions.' mod='privateshop'}</div>
	</div>
</div>
</div>
<!-- restricted signup -->
<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Restrict New Accounts?' mod='privateshop'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="PRIVATE_SIGNUP_RESTRICT" id="PRIVATE_SIGNUP_RESTRICT_on" value="1" {if isset($field_values) AND isset($field_values.active_signup_restrict) AND $field_values.active_signup_restrict == 1}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_SIGNUP_RESTRICT_on">{if $version < 1.6}<img src="../img/admin/enabled.gif" alt="Enabled" title="Enabled" />{else}{l s='Yes' mod='privateshop'}{/if}</label>
			<input type="radio" name="PRIVATE_SIGNUP_RESTRICT" id="PRIVATE_SIGNUP_RESTRICT_off" value="0" {if isset($field_values) AND isset($field_values.active_signup_restrict) AND $field_values.active_signup_restrict == 0}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_SIGNUP_RESTRICT_off">{if $version < 1.6}<img src="../img/admin/disabled.gif" alt="Disabled" title="Disabled" />{else}{l s='No' mod='privateshop'}{/if}</label>
			<a class="slide-button btn"></a>
		</span>
		<div class="help-block">{l s='Do you want to validate new accounts OR all new accounts have access to webstore.' mod='privateshop'}</div>
	</div>
</div>
</div>

<!-- show store title heading -->
<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Show store title?' mod='privateshop'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="PRIVATE_SHOW_STORE_TITLE" id="PRIVATE_SHOW_STORE_TITLE_on" value="1" {if isset($field_values) AND isset($field_values.show_store_title) AND $field_values.show_store_title == 1}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_SHOW_STORE_TITLE_on">{if $version < 1.6}<img src="../img/admin/enabled.gif" alt="Enabled" title="Enabled" />{else}{l s='Yes' mod='privateshop'}{/if}</label>
			<input type="radio" name="PRIVATE_SHOW_STORE_TITLE" id="PRIVATE_SHOW_STORE_TITLE_off" value="0" {if isset($field_values) AND isset($field_values.show_store_title) AND $field_values.show_store_title == 0}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_SHOW_STORE_TITLE_off">{if $version < 1.6}<img src="../img/admin/disabled.gif" alt="Disabled" title="Disabled" />{else}{l s='No' mod='privateshop'}{/if}</label>
			<a class="slide-button btn"></a>
		</span>
		<div class="help-block">{l s='Do you want to show store title right after logo on form?' mod='privateshop'}</div>
	</div>
</div>
</div>

<!-- Offers box -->
<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='Use Custom Logo' mod='privateshop'}</label>
<div class="form-group margin-form ">
	<div class="col-lg-9">
		<span class="switch prestashop-switch fixed-width-lg">
			<input type="radio" name="PRIVATE_CUSTOM_LOGO" id="PRIVATE_CUSTOM_LOGO_on" value="1" {if isset($field_values) AND isset($field_values.custom_logo) AND $field_values.custom_logo == 1}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_CUSTOM_LOGO_on">{if $version < 1.6}<img src="../img/admin/enabled.gif" alt="Enabled" title="Enabled" />{else}{l s='Yes' mod='privateshop'}{/if}</label>
			<input type="radio" name="PRIVATE_CUSTOM_LOGO" id="PRIVATE_CUSTOM_LOGO_off" value="0" {if isset($field_values) AND isset($field_values.custom_logo) AND $field_values.custom_logo == 0}checked="checked"{/if}/>
		<label class="t" for="PRIVATE_CUSTOM_LOGO_off">{if $version < 1.6}<img src="../img/admin/disabled.gif" alt="Disabled" title="Disabled" />{else}{l s='No' mod='privateshop'}{/if}</label>
			<a class="slide-button btn"></a>
		</span>
	</div>
</div>
</div>

<!-- Offers box -->
<div class="col-lg-12 form-group margin-form">
  <label class="form-group control-label col-lg-3">{l s='Custom Logo' mod='privateshop'}</label>
  <div class="form-group margin-form">
   <div class="col-lg-9">
     {if isset($field_values) AND isset($field_values.custom_logo_img) AND !empty($field_values.custom_logo_img)}<img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/privateshop/views/img/private/tmp/{$field_values.custom_logo_img|escape:'htmlall':'UTF-8'}" width="100" style="padding: 1px; border: 1px solid #ccc; margin-bottom: 8px" />{/if}
     <input class="btn btn-default" type="file" name="custom_logo_img"/>
     <div class="help-block">{l s='It will be used as logo if custom logo option is turned ON.' mod='privateshop'}</div>
   </div>
  </div>
</div>

<!-- restricted signup message MCE -->
<div class="col-lg-12 form-group margin-form">
<label class="form-group control-label col-lg-3">{l s='New Accounts Message' mod='privateshop'}</label>
	<div class="form-group margin-form ">
		<div class="col-lg-9">
			{include file='./textarea_lang.tpl'
			languages=$languages
			input_name='restrict_message'
			class="autoload_rte"
			input_value=$field_values.restrict_message}
		</div>
	</div>
</div>
<!-- background selection -->
<div class="col-lg-12 form-group margin-form">
	<label class="control-label col-lg-3">{l s='Background' mod='privateshop'}</label>
	<div class="col-lg-2 margin-form frame_styled{if isset($field_values) AND isset($field_values.bg_type) AND $field_values.bg_type == 'background-color'} active_frame{/if}">
		<input type="radio" name="BACKGROUND_TYPE" id="BACKGROUND_TYPE_color" value="background-color" onclick="show_bg_option($(this).val());" {if isset($field_values) AND isset($field_values.bg_type) AND $field_values.bg_type == 'background-color'}checked="checked"{/if}/>
		<label class="t" for="BACKGROUND_TYPE_color">{l s='Apply Color' mod='privateshop'}</label>
		<i class="pvt_icon ac_ico"></i>
	</div>
	
	<div class="col-lg-2 margin-form frame_styled{if isset($field_values) AND isset($field_values.bg_type) AND $field_values.bg_type == 'background-image'} active_frame{/if}">
		<input type="radio" name="BACKGROUND_TYPE" id="BACKGROUND_TYPE_image" value="background-image" onclick="show_bg_option($(this).val());" {if isset($field_values) AND isset($field_values.bg_type) AND $field_values.bg_type == 'background-image'}checked="checked"{/if}/>
		<label class="t" for="BACKGROUND_TYPE_image">{l s='Apply Image' mod='privateshop'}</label>
		<i class="pvt_icon ai_ico"></i>
	</div>
	
	<div class="col-lg-4 margin-form frame_styled{if isset($field_values) AND isset($field_values.bg_type) AND $field_values.bg_type == 'background-video'} active_frame{/if}">
		<input type="radio" name="BACKGROUND_TYPE" id="BACKGROUND_TYPE_video" value="background-video" onclick="show_bg_option($(this).val());" {if isset($field_values) AND isset($field_values.bg_type) AND $field_values.bg_type == 'background-video'}checked="checked"{/if}/>
		<label class="t" for="BACKGROUND_TYPE_video">{l s='Apply YouTube Video' mod='privateshop'}</label>
		<i class="pvt_icon ayv_ico"></i>
	</div>
</div>
<!-- background color -->
<div id="background-color" class="bg_options col-lg-12 form-group margin-form" style="display:none;">
	<label class="control-label col-lg-3">{l s='Background Color' mod='privateshop'}</label>
	<div class="form-group margin-form ">
		<div class="col-lg-8">
			<div class="input-group col-lg-6">
				<input type="text" class="mColorPicker" id="color_0" value="{if isset($field_values) AND isset($field_values.bg_color)}{$field_values.bg_color|escape:'htmlall':'UTF-8'}{/if}" name="BACKGROUND_COLOR" data-hex="true" />
				<span id="icp_color_0" class="input-group-addon mColorPickerTrigger" data-mcolorpicker="true"><img src="../img/admin/color.png" /></span>
			</div>
		</div>
	</div>
</div>
<!-- background Video -->
<div id="background-video" class="bg_options col-lg-12 form-group margin-form" style="display:none;">
	<label class="control-label col-lg-3">{l s='Background Youtube Video' mod='privateshop'}</label>
	<div class="form-group margin-form ">
		<div class="col-lg-8">
			<div class="input-group col-lg-6">
				<input type="text" class="form-control" value="{if isset($field_values) AND isset($field_values.bg_video)}{$field_values.bg_video|escape:'htmlall':'UTF-8'}{/if}" name="BACKGROUND_VIDEO" />
				<div class="help-block">{l s='Please use embed link from YouTube like https://www.youtube.com/embed/RdGVz104b3E' mod='privateshop'}</div>
			</div>
		</div>
	</div>
	<label class="control-label col-lg-3">{l s='Temporary Background Image' mod='privateshop'}</label>
	<div class="form-group margin-form ">
		<div class="col-lg-8">
			{if isset($field_values) AND isset($field_values.bg_video_img) AND !empty($field_values.bg_video_img)}<img src="{$smarty.const.__PS_BASE_URI__|escape:'htmlall':'UTF-8'}modules/privateshop/views/img/private/tmp/{$field_values.bg_video_img|escape:'htmlall':'UTF-8'}" width="100" style="padding: 1px; border: 1px solid #ccc; margin-bottom: 8px" />{/if}
			<input class="btn btn-default" type="file" name="bg_video_img"/>
			<div class="help-block">{l s='It will be used as background image till the video loads.' mod='privateshop'}</div>
		</div>
	</div>
</div>
<!-- background image -->
<div id="background-image" class="bg_options col-lg-12 form-group margin-form" style="display:none;">
	<label class="control-label col-lg-3">{l s='Background Image' mod='privateshop'}</label>
	<div class="form-group margin-form ">
		<div class="col-lg-8">
			<input class="btn btn-default" type="file" name="bg_image"/>
		</div>
	</div>
</div>
<div id="background-gallery" class="bg_options form-group margin-form" {if isset($field_values) AND isset($field_values.bg_type) AND $field_values.bg_type == 'background-image'}style="display:block;"{/if}>
	<label class="control-label col-lg-3">{l s='Select from gallery' mod='privateshop'}</label>
	<div class="col-lg-6">
		<select name="bg_image_selected">
			{foreach from=$images item=image}
			<option value="{$image|escape:'htmlall':'UTF-8'}" {if isset($field_values) AND isset($field_values.bg_type) AND $field_values.bg_type == 'background-image' AND $field_values.bg_img == $image}selected="selected"{/if}>
				{$image|escape:'htmlall':'UTF-8'}<img src="../admin/delete.png">
			</option>
			{/foreach}
		</select>
	</div>
</div>
<div class="clearfix"></div>
