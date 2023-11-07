{*
* PrivateShop
*
* Do not edit or add to this file.
* You are not authorized to modify, copy or redistribute this file.
* Permissions are reserved by FME Modules.
*
*  @author    FME Modules
*  @copyright 2019 FME Modules All right reserved
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
		{if isset($field_values) AND $field_values.bg_type}
		{if $field_values.bg_type == "background-video" AND isset($field_values.bg_video)}
		<script type="text/javascript" src="{$base_uri|escape:'htmlall':'UTF-8'}js/jquery/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/js/jquery.tubular.1.0.js"></script>
		{/if}
		{/if}
		<link rel="shortcut icon" href="{$favicon_url|escape:'htmlall':'UTF-8'}" />
        <link rel="stylesheet" href="{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/css/private.css" type="text/css" charset="utf-8" />
		{if $version > 0}
		<link rel="stylesheet" href="{$css_dir|escape:'htmlall':'UTF-8'}custom.css" type="text/css" media="all" charset="utf-8" />
		<link rel="stylesheet" href="{$css_dir|escape:'htmlall':'UTF-8'}theme.css" type="text/css" media="all" charset="utf-8" />
        {/if}
        {literal}
        <!-- inline css -->
        <style type="text/css">
		html { padding: 0px;}
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
        </style><!--/inline css-->
        {/literal}
	{if isset($field_values) AND $field_values.bg_type}
		{if $field_values.bg_type == "background-video" AND isset($field_values.bg_video)}
		  <script type="text/javascript">{literal}
			$(document).ready(function() {
				$('#wrapper').tubular({videoId: {/literal}'{$field_values.bg_video}'{literal}});
				});{/literal}
		  </script>
		{/if}
	{/if}
    </head>
    <body {if isset($field_values) AND $field_values.bg_type}{if $field_values.bg_type == "background-image" AND isset($field_values.bg_img)}id="bg-private-image"{elseif $field_values.bg_type == "background-video" AND isset($field_values.bg_video_img)}id="bg-private-image_video"{else if isset($field_values.bg_color) AND $field_values.bg_type == 'background-color'}id="bg-private-color"{/if}{/if}>
    <div id="wrapper"{if isset($field_values.position) AND $field_values.position AND $field_values.position == 'left'} class="bg_opacity"{elseif $field_values.position == 'right'} class="bg_opacity"{/if} style="{if isset($field_values.position) AND $field_values.position AND $field_values.position == 'left'}float: left; margin-left:3%;{elseif $field_values.position == 'right'}float: right; margin-right:3%;{elseif $field_values.position == 'center'}margin:0 auto;{/if}" {if isset($field_values) AND $field_values.position == 'center'}class="center_align bg_opacity"{/if}>
        <div id="privatebox">
            <div class="container bg_opacity_white" id="fmm_ps17">
				<p style="text-align:center;"><img src="{if isset($field_values.custom_logo) && $field_values.custom_logo > 0}{$modules_dir|escape:'htmlall':'UTF-8'}privateshop/views/img/private/tmp/{$field_values.custom_logo_img|escape:'htmlall':'UTF-8'}{else}{$logo_url|escape:'htmlall':'UTF-8'}{/if}" alt="logo" /></p>
				{if isset($field_values.restrict_message) AND empty($field_values.restrict_message)}
					<div id="restricted">
						<h1>{l s='You do not have permission to view this page.' mod='privateshop'}</h1>
					</div>
				{else}
					{$field_values.restrict_message nofilter}{*HTML Content*}
				{/if}
            </div>
        </div>
        <div class="clearfix"></div>
        </div>
    </body>
</html>
