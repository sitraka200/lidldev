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
<div class="box">
<h1 class="page-subheading">{l s='Forgot your password?' mod='privateshop'}</h1>

{*include file="$tpl_dir./errors.tpl"*}

{if isset($confirmation) && $confirmation == 1}
<p class="alert alert-success">{l s='Your password has been successfully reset and a confirmation has been sent to your email address:' mod='privateshop'} {if isset($customer_email)}{$customer_email|escape:'htmlall':'UTF-8'|stripslashes}{/if}</p>
{elseif isset($confirmation) && $confirmation == 2}
<p class="alert alert-success">{l s='A confirmation email has been sent to your address:' mod='privateshop'} {if isset($customer_email)}{$customer_email|escape:'htmlall':'UTF-8'|stripslashes}{/if}</p>
{else}
<p>{l s='Please enter the email address you used to register. We will then send you a new password. ' mod='privateshop'}</p>
<form action="{$request_uri|escape:'htmlall':'UTF-8'}" method="post" class="std" id="form_forgotpassword">
	<input type="hidden" name="private_pass_recovery" value="1">
	<fieldset>
		<div class="form-group">
			<label for="email">{l s='Email address' mod='privateshop'}</label>
			<input class="form-control" type="text" placeholder="{l s='Email address' mod='privateshop'}" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email|escape:'htmlall':'UTF-8'|stripslashes}{/if}" />
		</div>
		<p class="submit">
			{if $version < 1.6}
				<input type="submit" class="button" name="forgotpassword" value="{l s='Retrieve Password' mod='privateshop' mod='privateshop'}" />
			{else}
            	<button type="submit" class="btn btn-default button button-medium" name="forgotpassword"><span>{l s='Retrieve Password' mod='privateshop' mod='privateshop'}<i class="icon-chevron-right right"></i></span></button>
            {/if}
		</p>
	</fieldset>
</form>
{/if}
</div>
<ul class="clearfix footer_links">
	<li><a class="btn btn-default button button-small" href="javascript:void(0);" title="{l s='Back to Login' mod='privateshop'}" rel="nofollow" onclick="BackToLogin();"><span><i class="icon-chevron-left"></i>{l s='Back to Login' mod='privateshop'}</span></a></li>
</ul>
