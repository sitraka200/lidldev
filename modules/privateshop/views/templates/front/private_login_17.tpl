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
		{if isset($js_files) && $js_files}
			{foreach from=$js_files item=js_uri}
				<script type="text/javascript" src="{$js_uri|escape:'htmlall':'UTF-8'}"></script>
			{/foreach}
		{/if}
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
        <link rel="stylesheet" href="{$css_dir|escape:'htmlall':'UTF-8'}theme.css" type="text/css" media="all" charset="utf-8" />
        
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
		.bg_opacity {
			background:rgb(241,241,241,{/literal}{$field_values.bg_opacity|escape:'htmlall':'UTF-8'}{literal}) !important;
		}
		.bg_opacity_white {
			background:rgb(255,255,255,{/literal}{$field_values.bg_opacity/2|escape:'htmlall':'UTF-8'}{literal}) !important;
		}
		#gif_loader { background-color: rgba(255,255,255,0.5);
		position: absolute; left: 0; top: 0; width: 100%; height: 101%; z-index: 9;
		background-image:url("{/literal}{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/img/load.gif"{literal});
		background-repeat: no-repeat;
		background-position: center;
		}
		#new-private-account { position: relative}
        .date-select > label { margin-left: 15px!important;}
        .show_comment { display: inline-block!important; }
        </style><!--/inline css-->
        {/literal}
        <script type="text/javascript">
        //<![CDATA[
			var baseUri = "{$base_uri|escape:'htmlall':'UTF-8'}";
			var token = "{$token|escape:'htmlall':'UTF-8'}";
			var ajax_url = "{$ajax_link|escape:'htmlall':'UTF-8'}";
            {literal}
			// load() event and resize() event are combined
			$(window).ready(responsiveFn).resize(responsiveFn);
			function SignUp()
			{
				$('.alert-danger, .error').hide();
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
                //$('#ps17_errors').html('').hide();
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
			function toggleVis(e) {
				var elm = $(e).closest('.input-group').children('input.js-visible-password');
				if (elm.attr('type') === 'password') {
				  elm.attr('type', 'text');
				  $(e).text($(e).data('textHide'));
				} else {
				  elm.attr('type', 'password');
				  $(e).text($(e).data('textShow'));
				}

			};
			function registerNewUser(el) {
                var gif_loader = $('#gif_loader');
                gif_loader.show();
                var form_data = $('#new-private-account form').serialize();
                $.ajax({
                        type : "POST",
                        cache : false,
                        url : ajax_url,
                        dataType : "json",
                        data : form_data,
                        success: function(jsonData,textStatus,jqXHR) {
                            if (jsonData.errors > 0) {
                                var __html = '<div class="alert alert-danger" id="ps17_errors"><ol><li>'+jsonData.html+'</li></ol></div>';
                                $('#error_holder').html(__html);
                                gif_loader.hide();
                            }
                            else {
                                $('#error_holder').html('');
                                if (jsonData.redirect === true) {
                                    window.location = jsonData.redirect_url;
                                }
                                else {
                                    $('#new-private-account').html(jsonData.message);
                                }
                                gif_loader.hide();
                            }
                            console.log(jsonData.errors);
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            gif_loader.hide();
                        }
                });
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
		{/literal}
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
    </head>
    <body{if $field_values.priv_form_theme == 'mod'} class="private_modern_theme"{/if} {if isset($field_values) AND $field_values.bg_type}{if $field_values.bg_type == "background-image" AND isset($field_values.bg_img)}id="bg-private-image"{elseif $field_values.bg_type == "background-video" AND isset($field_values.bg_video_img)}id="bg-private-image_video"{else if isset($field_values.bg_color) AND $field_values.bg_type == 'background-color'}id="bg-private-color"{/if}{/if}>
    <div id="wrapper"{if isset($field_values.position) AND $field_values.position AND $field_values.position == 'left'} class="bg_opacity"{elseif $field_values.position == 'right'} class="bg_opacity"{/if} style="{if isset($field_values.position) AND $field_values.position AND $field_values.position == 'left'}float: left; margin-left:3%;{elseif $field_values.position == 'right'}float: right; margin-right:3%;{elseif $field_values.position == 'center'}margin:0 auto;{/if}" {if isset($field_values) AND $field_values.position == 'center'}class="center_align bg_opacity"{/if}>
        <div id="privatebox">
            <div class="container bg_opacity_white" id="fmm_ps17">
                <p id="logo_basic"><img src="{if isset($field_values.custom_logo) && $field_values.custom_logo > 0}{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/img/private/tmp/{$field_values.custom_logo_img|escape:'htmlall':'UTF-8'}{else}{$logo_url|escape:'htmlall':'UTF-8'}{/if}" alt="logo" /></p>{if $field_values.show_store_title > 0}<h1 class="pshop_title_shop">{$shop_name|escape:'htmlall':'UTF-8'}</h1>{/if}
                <!-- <h2>{l s='Private Login' mod='privateshop'}</h2> -->
                <div id="center_column" class="private_login">
                    {include file="module:privateshop/views/templates/front/errors.tpl"}
					<div id="error_holder"></div>
                    {if isset($field_values) AND isset($field_values.active_signup) AND $field_values.active_signup == 1}
                    <!-- create form -->
                    <div id="new-private-account" style="display:none;">
                        <form method="post" class="js-customer-form" id="customer-form" action="">
							<section>
							   <input type="hidden" value="" name="id_customer">
                               {if isset($field_values.gender_opt) && $field_values.gender_opt <= 0}
							   <div class="form-group row social_title">
								  <label class="col-md-3 form-control-label">
								  {l s='Social title' mod='privateshop'}
								  </label>
								  <div class="col-md-6 form-control-valign">
									 <label class="radio-inline">
									 <span class="custom-radio">
									 <input type="radio" value="1" name="id_gender">
									 <span></span>
									 </span>
									 {l s='Mr.' mod='privateshop'}
									 </label>
									 <label class="radio-inline">
									 <span class="custom-radio">
									 <input type="radio" value="2" name="id_gender">
									 <span></span>
									 </span>
									 {l s='Mrs.' mod='privateshop'}
									 </label>
								  </div>
								  <div class="col-md-3 form-control-comment">
								  </div>
							   </div>
                               {/if}
							   <div class="form-group row ">
								  <label class="col-md-3 form-control-label required">
								  {l s='First name' mod='privateshop'}
								  </label>
								  <div class="col-md-6">
									 <input type="text" placeholder="{l s='First name' mod='privateshop'}" required="" value="" name="firstname" class="form-control">
								  </div>
								  <div class="col-md-3 form-control-comment">
								  </div>
							   </div>
							   <div class="form-group row ">
								  <label class="col-md-3 form-control-label required">
								  {l s='Last name' mod='privateshop'}
								  </label>
								  <div class="col-md-6">
									 <input type="text" required="" placeholder="{l s='Last name' mod='privateshop'}" value="" name="lastname" class="form-control">
								  </div>
								  <div class="col-md-3 form-control-comment">
								  </div>
							   </div>
							   <div class="form-group row ">
								  <label class="col-md-3 form-control-label required">
								  {l s='Email' mod='privateshop'}
								  </label>
								  <div class="col-md-6">
									 <input type="email" required="" placeholder="{l s='Email' mod='privateshop'}" value="" name="email_account" class="form-control">
								  </div>
								  <div class="col-md-3 form-control-comment">
								  </div>
							   </div>
							   <div class="form-group row ">
								  <label class="col-md-3 form-control-label required">
								  {l s='Password' mod='privateshop'}
								  </label>
								  <div class="col-md-6">
									 <div class="input-group js-parent-focus">
										<input type="password" required="" value="" placeholder="{l s='Password' mod='privateshop'}" name="password" class="form-control js-child-focus js-visible-password">
										<span class="input-group-btn pshop_show_hide">
										<button data-text-hide="{l s='Hide' mod='privateshop'}" onclick="toggleVis(this);" data-text-show="{l s='Show' mod='privateshop'}" data-action="show-password" type="button" class="btn">
										{l s='Show' mod='privateshop'}
										</button>
										</span>
									 </div>
								  </div>
								  <div class="col-md-3 form-control-comment">
								  </div>
							   </div>
                               {if isset($field_values.bday) && $field_values.bday <= 0}
							   <div class="form-group row ">
                                   <div class="birth-date-select">
                                       <label class="col-lg-3">{l s='Birthday' mod='privateshop'}</label>
                                       <div class="col-lg-6">
                                           <div>
                                               <select id="days" name="days" class="form-control">
                                                   <option value="">-</option>
                                                   {foreach from=$days item=day}
                                                       <option value="{$day}" {if ($sl_day == $day)} selected="selected"{/if}>{$day}&nbsp;&nbsp;</option>
                                                   {/foreach}
                                               </select>
                                           </div><br>
                                           <div>
                                               <select id="months" name="months" class="form-control">
                                                   <option value="">-</option>
                                                   {foreach from=$months key=k item=month}
                                                       <option value="{$k}" {if ($sl_month == $k)} selected="selected"{/if}>{l s=$month mod='privateshop' }&nbsp;</option>
                                                   {/foreach}
                                               </select>
                                           </div><br>
                                           <div>
                                               <select id="years" name="years" class="form-control">
                                                   <option value="">-</option>
                                                   {foreach from=$years item=year}
                                                       <option value="{$year}" {if ($sl_year == $year)} selected="selected"{/if}>{$year}&nbsp;&nbsp;</option>
                                                   {/foreach}
                                               </select>
                                           </div><br>
										   <div class="col-md-3 form-control-comment show_comment">
                                               {l s='Optional' mod='privateshop'}
										   </div>
									   </div>
                                   </div>
							   </div>
                               {/if}
                               {if isset($field_values.offers_opt) && $field_values.offers_opt <= 0}
							   <div class="form-group row ">
								  <label class="col-md-3 form-control-label">
								  </label>
								  <div class="col-md-6">
									 <span class="custom-checkbox">
									 <input type="checkbox" value="1" name="optin">
									 <span><i class="material-icons checkbox-checked"></i></span>
									 <label>{l s='Receive offers from our partners' mod='privateshop'}</label>
									 </span>
								  </div>
								  <div class="col-md-3 form-control-comment">
								  </div>
							   </div>
                               {/if}
                               {if isset($field_values.nletter_opt) && $field_values.nletter_opt <= 0}
							   <div class="form-group row ">
								  <label class="col-md-3 form-control-label">
								  </label>
								  <div class="col-md-6">
									 <span class="custom-checkbox">
									 <input type="checkbox" value="1" name="newsletter">
									 <span><i class="material-icons checkbox-checked"></i></span>
									 <label>{l s='Sign up for our newsletter' mod='privateshop'}<br><em></em></label>
									 </span>
								  </div>
								  <div class="col-md-3 form-control-comment">
								  </div>
							   </div>
                               {/if}
							   {$hook_create_account_form nofilter}
							</section>
							<footer class="form-footer clearfix">
							   <input type="hidden" value="1" name="submitCreate">
							   <button type="button" data-link-action="save-customer" onclick="registerNewUser(this);" class="btn btn-primary form-control-submit pull-xs-right">
							   {l s='Save' mod='privateshop'}
							   </button>
                                <a href="javascript:void(0);" onclick="Login();">
                                    <span>{l s='Log in instead!' mod='privateshop'}</span>
                                </a>
							</footer>
						 </form>
                        <div class="clearfix"></div>
						<div id="gif_loader" style="display: none"></div>
                    </div> <!-- /create form ends-->
                    {/if}
                        <!-- login form -->
                    <div id="private-login">
                        <form action="{$link->getPageLink('authentication', true)|escape:'htmlall':'UTF-8'}" method="post" id="login_form" class="box">
                            <h2 class="private-subheading">{if isset($field_values) AND isset($field_values.login_title) AND $field_values.login_title}{$field_values.login_title|escape:'htmlall':'UTF-8'}{else}{l s='Private Login' mod='privateshop'}{/if}</h2>
                            <div class="form_content clearfix">
                            <table class="private_login_table">
                                <tr class="pshop_fields_row">
                                    <div class="form-group">
                                        <td><label for="email">{l s='Email address' mod='privateshop'}</label></td>
                                        <td colspan="3"><input placeholder="{l s='Email address' mod='privateshop'}" class="is_required validate account_input form-control" data-validate="isEmail" type="text" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email|stripslashes|escape:'htmlall':'UTF-8'}{/if}" /></td>
                                    </div>
                                </tr>
                                <tr class="exttra_row"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                <tr class="pshop_fields_row">
                                    <div class="form-group">
                                        <td><label for="passwd">{l s='Password' mod='privateshop'}</label></td>
                                        <td colspan="3"><input placeholder="{l s='Password' mod='privateshop'}" class="is_required validate account_input form-control" type="password" data-validate="isPasswd" id="passwd" name="passwd" value="{if isset($smarty.post.passwd)}{$smarty.post.passwd|stripslashes|escape:'htmlall':'UTF-8'}{/if}" /></td>
                                    </div>
                                </tr>
                                <tr class="exttra_row"><td>&nbsp;</td><td>&nbsp;</td></tr>
                            </table>
							<ul id="pshop_bottom_footer">
                                    <li><p class="lost_password form-group"><a id="lost-password" href="javascript:;" title="{l s='Recover your forgotten password' mod='privateshop'}" rel="nofollow" onclick="forgot_password()">{l s='Forgot your password?' mod='privateshop'}</a></p></li>
                                    <li class="submit">
                                        {if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'htmlall':'UTF-8'}" />{/if}
                                    <div>
                                        {if $version >= 1.6}
                                        &nbsp;<button type="submit" id="SubmitLogin" name="SubmitLogin" class="button btn btn-default button-medium">
                                            <span>
                                                <i class="icon-lock left"></i>
                                                {l s='Sign in' mod='privateshop'}
                                            </span>
                                        </button>
                                        {else}
                                            <input type="submit" id="SubmitLogin" name="SubmitLogin" class="button" value="{l s='Log in' mod='privateshop'}"/>
                                        {/if}
                                    </div>
                                    <div>
                                        {if isset($field_values) AND isset($field_values.active_signup) AND $field_values.active_signup == 1}
                                        &nbsp;<a class="btn btn-default button button-medium exclusive" type="submit" id="register" name="register" onclick="SignUp();">
                                            <span>
                                                {l s='Sign Up' mod='privateshop'}
                                            </span>
                                        </a>
                                        {/if}
                                    </div>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div> <!-- /login form ends -->
                    <div id="private-lost-password" style="display:none;">{include file="module:privateshop/views/templates/front/password_17.tpl"}</div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        </div>
    </body>
</html>
