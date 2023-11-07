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
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="{$language_code|escape:'htmlall':'UTF-8'}"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7" lang="{$language_code|escape:'htmlall':'UTF-8'}"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8" lang="{$language_code|escape:'htmlall':'UTF-8'}"><![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9" lang="{$language_code|escape:'htmlall':'UTF-8'}"><![endif]-->
<html lang="{$language_code|escape:'htmlall':'UTF-8'}">
    <head>
        <meta charset="utf-8" />
        <title>{$meta_title|escape:'htmlall':'UTF-8'}</title>
{if isset($meta_description)}
		<meta name="description" content="{$meta_description|escape:'htmlall':'UTF-8'}" />
{/if}
{if isset($meta_keywords)}
		<meta name="keywords" content="{$meta_keywords|escape:'htmlall':'UTF-8'}" />
{/if}
        <meta name="generator" content="PrestaShop" />
        <meta name="robots" content="{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow" />
        <meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url|escape:'htmlall':'UTF-8'}?{$img_update_time|escape:'htmlall':'UTF-8'}" />
        <link rel="shortcut icon" type="image/x-icon" href="{$favicon_url|escape:'htmlall':'UTF-8'}?{$img_update_time|escape:'htmlall':'UTF-8'}" />
		<!-- Js defination vars -->
		{$js_def}
{if isset($js_files) && $js_files}
    {foreach from=$js_files item=js_uri}
        <script type="text/javascript" src="{$js_uri|escape:'htmlall':'UTF-8'}"></script>
    {/foreach}
{/if}
		<script type="text/javascript" src="{$js_dir|escape:'htmlall':'UTF-8'}/global.js"></script>
		<script type="text/javascript" src="{if $force_ssl}{$base_dir_ssl|escape:'htmlall':'UTF-8'}{else}{$base_dir|escape:'htmlall':'UTF-8'}{/if}js/tools.js"></script>
		<script type="text/javascript" src="{$js_dir|escape:'htmlall':'UTF-8'}autoload/15-jquery.total-storage.min.js"></script>
		<script type="text/javascript" src="{$js_dir|escape:'htmlall':'UTF-8'}autoload/15-jquery.uniform-modified.js"></script>
		<script type="text/javascript" src="{$js_dir|escape:'htmlall':'UTF-8'}tools/statesManagement.js"></script>
        <script type="text/javascript" src="{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/js/validate.js"></script>
{if $version >= 1.6}        
        <script type="text/javascript" src="{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/js/authentication16.js"></script>
        <link rel="stylesheet" href="{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/css/authentication16.css" type="text/css" media="all" charset="utf-8" />
{else}
        <script type="text/javascript" src="{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/js/authentication15.js"></script>
        <link rel="stylesheet" href="{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/css/authentication15.css" type="text/css" media="all" charset="utf-8" />
{/if}
{if isset($field_values) AND $field_values.bg_type}
	{if $field_values.bg_type == "background-video" AND isset($field_values.bg_video)}
		<script type="text/javascript" src="{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/js/jquery.tubular.1.0.js"></script>
	{/if}
{/if}
		<link rel="shortcut icon" href="{$favicon_url|escape:'htmlall':'UTF-8'}" />
        <link rel="stylesheet" href="{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/css/private.css" type="text/css" charset="utf-8" />
        <link rel="stylesheet" href="{$css_dir|escape:'htmlall':'UTF-8'}global.css" type="text/css" media="all" charset="utf-8" />
        
        {literal}
        <!-- inline css -->
         <style type="text/css">
        body
        {
            height: 100% !important;
            margin: 0;
            background: rgba(77,117,219,1);
            background: -moz-linear-gradient(left, rgba(77,117,219,1) 0%, rgba(120,155,227,1) 55%, rgba(120,155,227,1) 100%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba(77,117,219,1)), color-stop(55%, rgba(120,155,227,1)), color-stop(100%, rgba(120,155,227,1)));
            background: -webkit-linear-gradient(left, rgba(77,117,219,1) 0%, rgba(120,155,227,1) 55%, rgba(120,155,227,1) 100%);
            background: -o-linear-gradient(left, rgba(77,117,219,1) 0%, rgba(120,155,227,1) 55%, rgba(120,155,227,1) 100%);
            background: -ms-linear-gradient(left, rgba(77,117,219,1) 0%, rgba(120,155,227,1) 55%, rgba(120,155,227,1) 100%);
            background: linear-gradient(to right, rgba(77,117,219,1) 0%, rgba(120,155,227,1) 55%, rgba(120,155,227,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4d75db', endColorstr='#789be3', GradientType=1 );
        }
        #bg-private-image{
            background:url("{/literal}{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/img/private/{$field_values.bg_img|escape:'htmlall':'UTF-8'}{literal}") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            width: 100%;
        }

		#bg-private-image_video{
            background:url("{/literal}{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/img/private/tmp/{$field_values.bg_video_img|escape:'htmlall':'UTF-8'}{literal}") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            width: 100%;
        }
		
        body#bg-private-color{
            height: 100%;
            margin: 0;
            width: 100%;
            background: {/literal}{$field_values.bg_color|escape:'htmlall':'UTF-8'}{literal};
        }
		.bg_opacity
        {
			background:rgb(241,241,241,{/literal}{$field_values.bg_opacity|escape:'htmlall':'UTF-8'}{literal}) !important;
		}
		.bg_opacity_white
        {
			background:rgb(255,255,255,{/literal}{$field_values.bg_opacity/2|escape:'htmlall':'UTF-8'}{literal}) !important;
		}
        </style><!--/inline css-->
        {/literal}
        <script type="text/javascript">
        //<![CDATA[
            var baseUri = "{$base_uri|escape:'htmlall':'UTF-8'}";
            var token = "{$token|escape:'htmlall':'UTF-8'}";
            var ajax_url = "{$ajax_link|escape:'htmlall':'UTF-8'}";
            // load() event and resize() event are combined
            $(window).ready(responsiveFn).resize(responsiveFn);
            function SignUp()
            {
                $('#error_holder').html('');
                $('#private-login').hide();
                $('#new-private-account').show();
                $('.alert').addClass('private_error_resp');
            }
            
            function Login()
            {
                $('.alert-danger, .error').hide();
                $('#private-login').show();
                $('#new-private-account').hide();
                $('.alert').addClass('private_error_resp');
            }

            function forgot_password()
            {
                $('#error_holder').html('');
                $('#private-login').hide();
                $('#private-lost-password').show();
                $('.alert').addClass('private_error_resp');
            }
            function BackToLogin()
            {
                $('.private_error_resp').html('').hide();
                $('#private-lost-password').hide();
                $('#private-login').fadeIn('slow');
            }

            function responsiveFn()
            {
                width = $( window ).width();
                height = $( window ).height();

                if(width <= 320) {
                    $('#login_form').removeClass('box');
                }
                else {
                    $('#login_form').addClass('box');
                }
            }

            $(document).on('click', '#SubmitLogin', function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                //var gif_loader = $('#gif_loader');
                //gif_loader.show();
                var jsonData = {
                    type : "POST",
                    cache : false,
                    url : ajax_url,
                    dataType : "json",
                    data : {
                        action : 'privateLogin',
                        ajax : true,
                        email : $.trim($('input[name=email]').val()),
                        passwd : $.trim($('input[name=passwd]').val())
                    },
                    success: function(response) {
                        if (response.errors > 0) {
                            var __html = '<div class="alert alert-danger" id="ps17_errors"><ol><li>'+response.html+'</li></ol></div>';
                            $('#error_holder').html(__html);
                            //gif_loader.hide();
                        } else if (response.success) {
                            $('#error_holder').html('');
                            //gif_loader.hide();
                            window.location.reload();
                        }
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(textStatus + '<br>' + errorThrown);
                        //gif_loader.hide();
                    }
                };
                $.ajax(jsonData);
            });
        //]]>
        </script>
	{if isset($field_values) AND $field_values.bg_type}
		{if $field_values.bg_type == "background-video" AND isset($field_values.bg_video)}
		  <script type="text/javascript">{literal}
			$(document).ready(function() {
				$('#wrapper').tubular({videoId: {/literal}'{$field_values.bg_video}'{literal}});
				});{/literal}
		  </script>
		{/if}
	{/if}
	{if $persist == 1 AND isset($persist)}
		  <script type="text/javascript">{literal}
			$(document).ready(function() {
				forgot_password();
				});{/literal}
		  </script>
	{/if}
	{if $persist == 2 AND isset($persist)}
		  <script type="text/javascript">{literal}
			$(document).ready(function() {
				SignUp();
				});{/literal}
		  </script>
	{/if}
    </head>
    <body{if $field_values.priv_form_theme == 'mod'} class="private_modern_theme"{/if} {if isset($field_values) AND $field_values.bg_type}{if $field_values.bg_type == "background-image" AND isset($field_values.bg_img)}id="bg-private-image"{elseif $field_values.bg_type == "background-video" AND isset($field_values.bg_video_img)}id="bg-private-image_video"{else if isset($field_values.bg_color) AND $field_values.bg_type == 'background-color'}id="bg-private-color"{/if}{/if}>
    <div id="wrapper"{if isset($field_values.position) AND $field_values.position AND $field_values.position == 'left'} class="bg_opacity"{elseif $field_values.position == 'right'} class="bg_opacity"{/if} style="{if isset($field_values.position) AND $field_values.position AND $field_values.position == 'left'}float: left; margin-left:3%;{elseif $field_values.position == 'right'}float: right; margin-right:3%;{elseif $field_values.position == 'center'}margin:0 auto;{/if}" {if isset($field_values) AND $field_values.position == 'center'}class="center_align bg_opacity"{/if}>
        <div id="privatebox" class="privateshop_ps_lower">
            <div class="container bg_opacity_white">
                <p id="logo_basic"><img src="{$logo_url|escape:'htmlall':'UTF-8'}" alt="logo" /></p>{if $field_values.show_store_title > 0}<h1>{$shop_name|escape:'htmlall':'UTF-8'}</h1>{/if}
                <!-- <h2>{l s='Private Login' mod='privateshop'}</h2> -->
                <div id="center_column" class="private_login">
                    {include file="$tpl_dir./errors.tpl"}
                    <div id="error_holder"></div>
                    {if isset($field_values) AND isset($field_values.active_signup) AND $field_values.active_signup == 1}
                    <!-- create form -->
                    <div id="new-private-account" style="display:none;">
                        <form action="{$link->getPageLink('authentication', true)|escape:'htmlall':'UTF-8'}" method="post" id="create-account_form" class="box" style="width:100%">
                            <h2 class="private-subheading">{if isset($field_values) AND isset($field_values.signup_title) AND $field_values.signup_title}{$field_values.signup_title|escape:'htmlall':'UTF-8'}{else}{l s='Create a private account' mod='privateshop'}{/if}</h2>
                            <div class="form_content clearfix">
                            <div class="private_signup_table">
                                <p>{l s='Please enter your email address to create an account.' mod='privateshop'}</p>
								{if isset($persist_restricted) && $persist_restricted > 0}
									{if empty($restrict_message)}
										<div class="alert alert-success">{l s='Your Account is created but pending validation for Email address:' mod='privateshop'} {if isset($smarty.post.email)}{$smarty.post.email}{/if}</div>
									{else}
										<div class="alert alert-success">{l s='Email address:' mod='privateshop'} {if isset($smarty.post.email)}{$smarty.post.email}{/if}<br />{$restrict_message}</div>
									{/if}
								{/if}
                                <div class="alert alert-danger error private_error_resp" id="create_account_error" style="display:none"></div>
                                    <div class="form-group">
                                        <label for="email_create" class="pshop_fields_row_hide">{l s='Email address' mod='privateshop'}</label>
                                        <input type="text" placeholder="{l s='Email address' mod='privateshop'}" class="is_required validate account_input form-control form-group" data-validate="isEmail" id="email_create" name="email_create" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}" /></td>
                                    </div>
                                    <div class="submit">
                                        {if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'htmlall':'UTF-8'}" />{/if}
                                        {if $version >= 1.6}
                                        <button class="btn btn-default button button-medium exclusive" type="submit" id="SubmitCreate" name="SubmitCreate">
                                            <span>
                                                {l s='Create account' mod='privateshop'}
                                            </span>
                                        </button>
                                        {else}
                                            <input type="button" id="SubmitCreate" name="SubmitCreate" class="button_large" value="{l s='Create your account' mod='privateshop'}" />
                                        {/if}
                                        <input type="hidden" class="hidden" name="SubmitCreate" value="{l s='Create an account' mod='privateshop'}" />&nbsp;
                                        
                                            <button class="btn btn-default button button-medium pull-right" type="button" rel="nofollow" title="{l s='Already registered?' mod='privateshop'}" href="javascript:;" onclick="Login();" style="{if $version >= 1.6}color:#fff;{else}color:#555;{/if}">
                                               <span>{l s='Already registered?' mod='privateshop'}</span>
                                            </button>
                                        
                                    </div>
                            </div>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                    </div> <!-- /create form ends-->
                    {/if}
                        <!-- login form -->
                    <div id="private-login">
                        <form action="{$link->getPageLink('authentication', true)|escape:'htmlall':'UTF-8'}" method="post" id="login_form" class="box">
                            <h2 class="private-subheading">{if isset($field_values) AND isset($field_values.login_title) AND $field_values.login_title}{$field_values.login_title|escape:'htmlall':'UTF-8'}{else}{l s='Private Login' mod='privateshop'}{/if}</h2>
                            <div class="form_content clearfix">
                            <table class="private_login_table">
                                <tr>
                                    <div class="form-group">
                                        <td class="pshop_fields_row_hide"><label for="email">{l s='Email address' mod='privateshop'}</label></td>
                                        <td colspan="3"><input placeholder="{l s='Email address' mod='privateshop'}" class="is_required validate account_input form-control form-group" data-validate="isEmail" type="text" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email|stripslashes|escape:'htmlall':'UTF-8'}{/if}" /></td>
                                    </div>
                                </tr>
                                <tr class="exttra_row"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                <tr>
                                    <div class="form-group">
                                        <td class="pshop_fields_row_hide"><label for="passwd">{l s='Password' mod='privateshop'}</label></td>
                                        <td colspan="3"><input placeholder="{l s='Password' mod='privateshop'}" class="is_required validate account_input form-control form-group" type="password" data-validate="isPasswd" id="passwd" name="passwd" value="{if isset($smarty.post.passwd)}{$smarty.post.passwd|stripslashes|escape:'htmlall':'UTF-8'}{/if}" /></td>
                                    </div>
                                </tr>
                                <tr class="exttra_row"><td>&nbsp;</td><td>&nbsp;</td></tr>
                            </table>
							<ul id="pshop_bottom_footer">
                                    <li><p class="lost_password form-group"><a id="lost-password" href="javascript:;" title="{l s='Recover your forgotten password' mod='privateshop'}" rel="nofollow" onclick="forgot_password()">{l s='Forgot your password?' mod='privateshop'}</a></p></li>
                                        {if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'htmlall':'UTF-8'}" />{/if}
                                    <li class="submit">
                                        {if $version >= 1.6}
                                        &nbsp;<button type="submit" id="SubmitLogin" name="SubmitLogin" class="button btn btn-default button-medium">
                                            <span>
                                                {l s='Sign in' mod='privateshop'}
                                            </span>
                                        </button>
                                        {else}
                                            <input type="submit" id="SubmitLogin" name="SubmitLogin" class="button" value="{l s='Log in' mod='privateshop'}" />
                                        {/if}
                                        {if isset($field_values) AND isset($field_values.active_signup) AND $field_values.active_signup == 1}
                                        &nbsp;<a class="btn btn-default button button-medium exclusive" type="submit" id="register" name="register" onclick="SignUp();">
                                            <span>
                                                {l s='Sign Up' mod='privateshop'}
                                            </span>
                                        </a>
                                        {/if}
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div> <!-- /login form ends -->
                    <div id="private-lost-password" style="display:none;">{include file="./password.tpl"}</div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        </div>
    </body>
</html>
{strip}
{if isset($smarty.post.id_state) && $smarty.post.id_state}
	{addJsDef idSelectedState=$smarty.post.id_state|intval}
{elseif isset($address->id_state) && $address->id_state}
	{addJsDef idSelectedState=$address->id_state|intval}
{else}
	{addJsDef idSelectedState=false}
{/if}
{if isset($smarty.post.id_state_invoice) && isset($smarty.post.id_state_invoice) && $smarty.post.id_state_invoice}
	{addJsDef idSelectedStateInvoice=$smarty.post.id_state_invoice|intval}
{else}
	{addJsDef idSelectedStateInvoice=false}
{/if}
{if isset($smarty.post.id_country) && $smarty.post.id_country}
	{addJsDef idSelectedCountry=$smarty.post.id_country|intval}
{elseif isset($address->id_country) && $address->id_country}
	{addJsDef idSelectedCountry=$address->id_country|intval}
{else}
	{addJsDef idSelectedCountry=false}
{/if}
{if isset($smarty.post.id_country_invoice) && isset($smarty.post.id_country_invoice) && $smarty.post.id_country_invoice}
	{addJsDef idSelectedCountryInvoice=$smarty.post.id_country_invoice|intval}
{else}
	{addJsDef idSelectedCountryInvoice=false}
{/if}
{if isset($countries)}
	{addJsDef countries=$countries}
{/if}
{if isset($vatnumber_ajax_call) && $vatnumber_ajax_call}
	{addJsDef vatnumber_ajax_call=$vatnumber_ajax_call}
{/if}
{if isset($email_create) && $email_create}
	{addJsDef email_create=$email_create|boolval}
{else}
	{addJsDef email_create=false}
{/if}
{/strip}
{strip}
{addJsDef isMobile=$mobile_device}
{addJsDef baseDir=$content_dir}
{addJsDef baseUri=$base_uri}
{addJsDef static_token=$static_token}
{addJsDef token=$token|htmlentities:$smarty.const.ENT_QUOTES}
{addJsDef priceDisplayPrecision=$priceDisplayPrecision*$currency->decimals}
{addJsDef priceDisplayMethod=$priceDisplay}
{addJsDef roundMode=$roundMode}
{addJsDef currency=$currency}
{addJsDef currencyRate=$currencyRate|floatval}
{addJsDef currencySign=$currency->sign|html_entity_decode:2:"UTF-8"}
{addJsDef currencyFormat=$currency->format|intval}
{addJsDef currencyBlank=$currency->blank|intval}
{addJsDef isLogged=$is_logged|intval}
{addJsDef isGuest=$is_guest|intval}
{addJsDef page_name=$page_name|escape:'html':'UTF-8'}
{addJsDef contentOnly=$content_only|boolval}
{if isset($cookie->id_lang)}
	{addJsDef id_lang=$cookie->id_lang|intval}
{/if}
{addJsDefL name=FancyboxI18nClose}{l s='Close' mod='privateshop'}{/addJsDefL}
{addJsDefL name=FancyboxI18nNext}{l s='Next' mod='privateshop'}{/addJsDefL}
{addJsDefL name=FancyboxI18nPrev}{l s='Previous' mod='privateshop'}{/addJsDefL}
{addJsDef usingSecureMode=Tools::usingSecureMode()|boolval}
{addJsDef ajaxsearch=Configuration::get('PS_SEARCH_AJAX')|boolval}
{addJsDef instantsearch=Configuration::get('PS_INSTANT_SEARCH')|boolval}
{addJsDef quickView=$quick_view|boolval}
{addJsDef displayList=Configuration::get('PS_GRID_PRODUCT')|boolval}
{addJsDef highDPI=Configuration::get('PS_HIGHT_DPI')|boolval}
{/strip}