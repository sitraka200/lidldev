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
<html lang="{$language_code|escape:'htmlall':'UTF-8'}" style="padding: 0;">
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
        <!-- NEW CHANGE -->
        <link rel="stylesheet" href="{$css_dir|escape:'htmlall':'UTF-8'}custom.css" type="text/css" media="all" charset="utf-8" />
        <!-- Add new custom google fonts -->
		<link href="https://fonts.googleapis.com/css?family=Work+Sans:400,500,600,700,800,900|Montserrat:400,500,600,700,800,900&display=swap" rel="stylesheet">
        
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

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 3% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 60%; /* Could be more or less, depending on screen size */
            -webkit-transform: translateY(-100%);
            transform: translateY(-100%);
            transition: transform 0.5s linear;
        }
        @media (max-width: 768px) {
            .modal-content {
                width: 75%;
            }
        }
        @media (max-width: 543px) {
            .modal-content {
                width: 90%;
            }
        }

        .modal-content.open {
            -webkit-transform: translateY(0%);
            transform: translateY(0%);
            transition: transform 0.5s linear;
        }

        /* The Close Button */
        .close {
          color: #aaa;
          float: right;
          font-size: 28px;
          font-weight: bold;
        }

        .close:hover,
        .close:focus {
          color: black;
          text-decoration: none;
          cursor: pointer;
        }

        /* Recaptcha */
        .form-group.recaptcha{
            margin-top: 1rem;
        }
        .form-group.recaptcha .col-md-12 {
            padding: 0;
        }
        .g-recaptcha {
            display: flex;
            justify-content: center;
        }

        /* Popup */
        .pp-content {
            background: linear-gradient(360deg, rgba(0,72,153,1) 0%, rgba(0,110,184,1) 100%);
            font-family: 'Work Sans', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .text-yellow {
            color: #ffed00 !important;
        }
        .img-top-container {
            display: flex;
            justify-content: center;
        }
        .img-col {
            -ms-flex: 0 0 66.666667%;
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }
        @media (min-width: 576px) {
            .img-col {
                -ms-flex: 0 0 50%;
                flex: 0 0 50%;
                max-width: 50%;
            }
        }
        @media (min-width: 768px) {
            .img-col {
                -ms-flex: 0 0 33.333333%;
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
            }
        }
        .fluid {
            max-width: 100%;
            height: auto;
            vertical-align: middle;
            border-style: none;
        }
        .text-tombola {
            margin-bottom: 1rem!important;
        }
        .text-container {
            display: -ms-flexbox !important;
            display: flex !important;
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }
        .text-container .text {
            -ms-flex: 0 0 83.333333%;
            flex: 0 0 83.333333%;
            max-width: 83.333333%;
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }
        .text-white {
            color: #fff !important;
        }
        .text-center {
            text-align: center !important;
        }
        .text-left {
            text-align: left !important;
        }
        ol.gagnants li {
            color: #ffed00 !important;
            text-align: left !important;
        }
        .clearfix::after {
            display: block;
            clear: both;
            content: "";
        }
        .fafter {
            display: inline-block;
            margin-top: 1rem;
            margin-bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            line-height: 1rem;
            font-weight: 400;
        }
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
                var checkbox = $('input[name="psgdpr_consent_checkbox"]');
                if (!checkbox.prop('checked')) {
                    var __html = '<div class="alert alert-danger" id="ps17_errors"><ol><li>Veuillez accepter les conditions générales d\'utilisation et la politique de confidentialité</li></ol></div>';
                    $('#error_holder').html(__html);
                } else {
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
    {if $field_values.show_store_title > 0}<h1 class="pshop_title_shop">Bienvenue sur le site {$shop_name|escape:'htmlall':'UTF-8'}</h1>{/if}
    <div id="wrapper"{if isset($field_values.position) AND $field_values.position AND $field_values.position == 'left'} class="bg_opacity"{elseif $field_values.position == 'right'} class="bg_opacity"{/if} style="{if isset($field_values.position) AND $field_values.position AND $field_values.position == 'left'}float: left; margin-left:3%;{elseif $field_values.position == 'right'}float: right; margin-right:3%;{elseif $field_values.position == 'center'}margin:0 auto;{/if}" {if isset($field_values) AND $field_values.position == 'center'}class="center_align bg_opacity"{/if}>
        <div id="privatebox">
            <div class="container bg_opacity_white" id="fmm_ps17">
                <p id="logo_basic"><img src="{if isset($field_values.custom_logo) && $field_values.custom_logo > 0}{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/img/private/tmp/{$field_values.custom_logo_img|escape:'htmlall':'UTF-8'}{else}{$logo_url|escape:'htmlall':'UTF-8'}{/if}" alt="logo" /></p>
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
								  <label class="col-sm-3 col-md-3 form-control-label">
								  {* {l s='Social title' mod='privateshop'} *}
								  </label>
								  <div class="col-md-12 form-control-valign">
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
								  {l s='First name' mod='privateshop'}*
								  </label>
								  <div class="col-md-6">
									 <input type="text" {* placeholder="{l s='First name' mod='privateshop'}" *} required="" value="" name="firstname" class="form-control">
								  </div>
								  <div class="col-md-3 form-control-comment">
								  </div>
							   </div>
							   <div class="form-group row ">
								  <label class="col-md-3 form-control-label required">
								  {l s='Last name' mod='privateshop'}*
								  </label>
								  <div class="col-md-6">
									 <input type="text" required="" {* placeholder="{l s='Last name' mod='privateshop'}" *} value="" name="lastname" class="form-control">
								  </div>
								  <div class="col-md-3 form-control-comment">
								  </div>
							   </div>
							   <div class="form-group row ">
								  <label class="col-md-3 form-control-label required">
								  {l s='Email' mod='privateshop'}*
								  </label>
								  <div class="col-md-6">
									 <input type="email" required="" {* placeholder="{l s='Email' mod='privateshop'}" *} value="" name="email_account" class="form-control">
								  </div>
								  <div class="col-md-3 form-control-comment">
								  </div>
							   </div>
							   <div class="form-group row ">
								  <label class="col-md-3 form-control-label required">
								  {l s='Password' mod='privateshop'}*
								  </label>
								  <div class="col-md-6 password-container">
									 <div class="input-group js-parent-focus">
										<input type="password" required="" value="" {* placeholder="{l s='Password' mod='privateshop'}" *} name="password" class="form-control js-child-focus js-visible-password">
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
                                       <label>{l s='Birthday' mod='privateshop'}</label>
                                       <div class="birth-date-row">
                                           <div class="col-xs-12 col-sm-4 col-md-12 col-xl-4 column">
                                               <select id="days" name="days" class="form-control" required>
                                                   <option value="">-</option>
                                                   {foreach from=$days item=day}
                                                       <option value="{$day}" {if ($sl_day == $day)} selected="selected"{/if}>{$day}&nbsp;&nbsp;</option>
                                                   {/foreach}
                                               </select>
                                           </div>
                                           <div class="col-xs-12 col-sm-4 col-md-12 col-xl-4 column">
                                               <select id="months" name="months" class="form-control" required>
                                                   <option value="">-</option>
                                                   {foreach from=$months key=k item=month}
                                                       <option value="{$k}" {if ($sl_month == $k)} selected="selected"{/if}>{l s=$month mod='privateshop' }&nbsp;</option>
                                                   {/foreach}
                                               </select>
                                           </div>
                                           <div class="col-xs-12 col-sm-4 col-md-12 col-xl-4 column">
                                               <select id="years" name="years" class="form-control" required>
                                                   <option value="">-</option>
                                                   {foreach from=$years item=year}
                                                       <option value="{$year}" {if ($sl_year == $year)} selected="selected"{/if}>{$year}&nbsp;&nbsp;</option>
                                                   {/foreach}
                                               </select>
                                           </div><br>
										   <div class="col-md-3 form-control-comment show_comment">
                                               {* {l s='Optional' mod='privateshop'} *}
										   </div>
									   </div>
                                   </div>
							   </div>
                               {/if}

                                {* NEW CHANGE *}
                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        {l s='Matricule number' mod='privateshop'}*
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" required value="" name="matricule" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-control-comment">
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        {l s='Address' mod='privateshop'}*
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" required value="" name="address" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-control-comment">
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        {l s='Zip/Postal Code' mod='privateshop'}*
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" required value="" name="postcode" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-control-comment">
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        {l s='City' mod='privateshop'}*
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" required value="" name="city" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-control-comment">
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        {l s='Phone number' mod='privateshop'}*
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" required value="" name="phone" class="form-control">
                                    </div>
                                    <div class="col-md-3 form-control-comment">
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                    </label>
                                    <div class="col-md-6">
                                        {hook h='displayGDPRConsentBlock'}
                                    </div>
                                    <div class="col-md-3 form-control-comment">
                                    </div>
                                </div>

                                {* END NEW CHANGE *}

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

                               <div class="form-group row recaptcha">
                                    <div class="col-md-12">
                                        <div class="g-recaptcha" data-sitekey="6LfDebwUAAAAAE7Qu8Tssisv_6dbjk3YESghqhty" data-size="compact"></div>
                                    </div>
                                </div>

							</section>
							<footer class="form-footer clearfix">
							   <input type="hidden" value="1" name="submitCreate">
							   <button type="button" data-link-action="save-customer" onclick="registerNewUser(this);" class="btn btn-primary form-control-submit pull-xs-right">
							   {l s='Save' mod='privateshop'}
							   </button>
                                <a href="javascript:void(0);" onclick="Login();" class="login_instead">
                                    <span>{l s='Log in instead!' mod='privateshop'}</span>
                                </a>
                                <p class="fafter">
                                  <a href="https://avinconcept.fr" target="_blank">
                                    {l s='© CSE LIDL Entzheim - Designed by AvinConcept' d='Shop.Theme.Global'}
                                  </a>
                                </p>
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
                                        <td colspan="3"><label for="email">{l s='Email address' mod='privateshop'}*</label></td>
                                    </div>
                                </tr>
                                <tr class="pshop_fields_row">
                                    <div class="form-group">
                                        <td colspan="3"><input {* placeholder="{l s='Email address' mod='privateshop'}" *} class="is_required validate account_input form-control" data-validate="isEmail" type="text" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email|stripslashes|escape:'htmlall':'UTF-8'}{/if}" /></td>
                                    </div>
                                </tr>
                                <tr class="exttra_row"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                                <tr class="pshop_fields_row">
                                    <div class="form-group">
                                        <td colspan="3"><label for="passwd">{l s='Password' mod='privateshop'}*</label></td>
                                    </div>
                                </tr>
                                <tr class="pshop_fields_row">
                                    <div class="form-group">
                                        <td colspan="3"><input {* placeholder="{l s='Password' mod='privateshop'}" *} class="is_required validate account_input form-control" type="password" data-validate="isPasswd" id="passwd" name="passwd" value="{if isset($smarty.post.passwd)}{$smarty.post.passwd|stripslashes|escape:'htmlall':'UTF-8'}{/if}" /></td>
                                    </div>
                                </tr>
                                <tr class="exttra_row"><td>&nbsp;</td><td>&nbsp;</td></tr>
                                <tr class="last_row">
                                    <div class="form-group">
                                        <td colspan="3"><p>* Champs obligatoires</p></td>
                                    </div>
                                </tr>
                            </table>
							<ul id="pshop_bottom_footer">
                                    <li><p class="lost_password form-group"><a id="lost-password" href="javascript:;" title="{l s='Recover your forgotten password' mod='privateshop'}" rel="nofollow" onclick="forgot_password()">{l s='Forgot your password?' mod='privateshop'}</a></p></li>
                                    <li class="submit">
                                        {if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'htmlall':'UTF-8'}" />{/if}
                                    <div class="button-container">
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
                                    <div class="button-container">
                                        {if isset($field_values) AND isset($field_values.active_signup) AND $field_values.active_signup == 1}
                                        <button class="btn btn-default button button-medium exclusive" type="button" id="register" name="register" onclick="SignUp();"><span>{l s='Sign Up' mod='privateshop'}</span></button>
                                        {/if}
                                    </div>
                                    </li>
                                    <li class="restriction_message">
                                        <div>
                                            <p>Accès <b>réservé</b> aux employés de LIDL de la direction Régionale d’Entzheim</p>
                                            {* {if isset($field_values) AND isset($field_values.active_signup) AND $field_values.active_signup == 1}
                                            <p>Pour obtenir votre matricule, veuiller renseigner <a onclick="SignUp();"><b>le formulaire d'inscription</b></a></p>
                                            {/if} *}
                                            <p>Pour toute information supplémentaire, veuillez <b>contacter le sécrétariat du Comité</b></p>
                                            <p>
                                              <a href="https://avinconcept.fr" target="_blank">
                                                {l s='© CSE LIDL Entzheim - Designed by AvinConcept' d='Shop.Theme.Global'}
                                              </a>
                                            </p>
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

        <!-- The Modal -->
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div>
                    <span class="close">&times;</span>
                </div>
                <div class="clearfix"></div>
                {* <p><img src="https://cse-lidlentzheim.com/img/cms/IMG_4819.jpg" ></p> *}
                {* <p><img src="https://cse-lidlentzheim.com/img/cms/Entzheim-01.jpg" ></p> *}
                
                <div class="pp-content">
                    <div class="grand-tombola">
                        <div class="img-top-container">
                            <div class="img-col">
                                <img src="https://cse-lidlentzheim.com/img/cms/tombola_lidl-01.png" class="fluid">
                            </div>
                        </div>
                    </div>

                    <div class="text-tombola mb-3">
                        <div class="text-container d-flex justify-content-center">
                            <div class="text">
                                {* <div class="text-center">
                                    <span class="text-white">Le CSE de LIDL Entzheim (DR 2) lance une grande tombola du 01 au 14 Octobre 2019 à l'occasion du lancement officiel des activités des ses activités.</span><br>
                                    <span class="text-yellow">Vous avez la possibilité de gagner trois gros lots et plusieurs petits lots:</span><br><br>
                                </div> *}
                                <div class="text-left text-white">
                                    <span>Cher(es) Collègues,</span><br><br>
                                    <span>Voici la liste des heureux gagnants de notre première tombola :</span>
                                </div>
                                <ol class="gagnants">
                                    <li>Martine JOKERS, magasin 3076 ( Écran TV + Pack Facile offert par la Société Prépa Pour Tous )</li>
                                    <li>BOUDJADJA Leila, magasin 2733 ( Ordinateur Portable )</li>
                                    <li>BOUKRIA Moussa, Enteprot ( Tablette )</li>
                                    <li>Rémy LOÏC, Entrepôt ( Chèque Cadeaux 50 euros )</li>
                                    <li>PICARD Stéphanie, magasin 226, ( Chèque Cadeaux 50 euros )</li>
                                    <li>BURSA Sukuru, Entrepot ( Chèque Cadeaux 50 euros )</li>
                                    <li>GOUAIDIA Hazdin, Entrepot ( Chèque Cadeaux 50 euros )</li>
                                    <li>Albert Aurelie, magasin 234 ( Chèque Cadeaux 50 euros )</li>
                                    <li>MONS Georges, magasin 259 ( Chèque Cadeaux 50 euros )</li>
                                    <li>FISCHER Delphine, magasin 1631 ( Chèque Cadeaux 50 euros )</li>
                                    <li>FALK Yannick, magasin 2806, ( Chèque Cadeaux 50 euros )</li>
                                    <li>François Mylène, magasin 247 ( Chèque Cadeaux 50 euros )</li>
                                    <li>PERROTEY Julie , magasin 3470, ( Chèque Cadeaux 50 euros ) .</li>
                                </ol>
                                <br>
                                <div class="text-left">
                                    <span class="text-white">Félicitations aux heureux gagnants. Le CSE prendra contact avec vous pour organiser la remise des lots , il n’y a aucune autre formalité à accomplir  et grand merci à l’ensemble des salariés de la direction régionale pour votre disponibilité.</span><br>
                                    <span class="text-white">À bientôt pour d’autres aventures.</span>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                
                {* <div class="button" style="text-align: center;">
                    <a href="https://cse-lidlentzheim.com/img/cms/Entzheim-01.jpg" class="btn btn-primary" download><i class="material-icons file-download">&#xE2C4;</i>Télécharger le formulaire</a>
                </div> *}
            </div>
        </div>
        {* <button id="myBtn" style="display: none;">Open Modal</button> *}

        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script>
            $(document).ready(function(){
                // Get the modal
                // var modal = document.getElementById("myModal");

                // // Get the button that opens the modal
                // var btn = document.getElementById("myBtn");

                // // Get the <span> element that closes the modal
                // var span = document.getElementsByClassName("close")[0];

                // setTimeout(function(){
                //     btn.click();
                //     // modal.style.display = "block";
                // }, 4000);

                // btn.onclick = function() {
                //     // modal.style.display = "block";
                //     $('#myModal').show();
                //     setTimeout(function(){
                //         $('.modal-content').addClass('open');
                //     }, 50);
                // }

                // // When the user clicks on <span> (x), close the modal
                // span.onclick = function() {
                //     $('.modal-content').removeClass('open');
                //     setTimeout(function(){
                //         $('#myModal').hide();
                //     }, 600);
                //     // modal.style.display = "none";
                // }

                // // When the user clicks anywhere outside of the modal, close it
                // window.onclick = function(event) {
                //     if (event.target == modal) {
                //         $('.modal-content').removeClass('open');
                //         // modal.style.display = "none";
                //         setTimeout(function(){
                //             $('#myModal').hide();
                //         }, 600);
                //     }
                // }
            });
        </script>
    </body>
</html>
