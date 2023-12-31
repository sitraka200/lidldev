{**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author    PrestaShop SA <contact@prestashop.com>
* @copyright 2007-2017 PrestaShop SA
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* International Registred Trademark & Property of PrestaShop SA
*}

<div id="blog-localengine">
		<h3>{l s='Comments' d='Shop.Theme.Global'}</h3>
		
		<div class="comments">
			{foreach from=$comments item=comment name=comment} {$default=''}
			<div class="comment-item" id="comment{$comment.id_comment|escape:'html':'UTF-8'}">
				<img src="http://www.gravatar.com/avatar/{md5(strtolower(trim($comment.email|escape:'html':'UTF-8')))}?d={urlencode($default|escape:'html':'UTF-8')}&s=60" align="left"/>
				<div class="comment-wrap">
					<div class="comment-meta">
						<span class="comment-created">{l s='Created On' d='Shop.Theme.Global'}<span> {strtotime($comment.date_add)|date_format:"%A, %B %e, %Y"|escape:'html':'UTF-8'}</span></span>
						<span class="comment-postedby">{l s='Posted By' d='Shop.Theme.Global'}<span> {$comment.user|escape:'html':'UTF-8'}</span></span>
						<span class="comment-link"><a href="{$blog_link|escape:'html':'UTF-8'}#comment{$comment.id_comment|intval}">{l s='Comment Link' d='Shop.Theme.Global'}</a></span>
					</div>

					<div class="comment-content">
						{$comment.comment|nl2br nofilter}{* HTML form , no escape necessary *}
					</div>
				</div>
			</div>
			{/foreach}
			{if $blog_count_comment}
			<div class="ps_sortPagiBar clearfix bottom-line">
				{include file="module:psblog/views/templates/front/default/_pagination.tpl"}
	        </div>
	        {/if}
		</div>

		<h3>{l s='Leave your comment' d='Shop.Theme.Global'}</h3>
		<form class="form-horizontal" method="post" id="comment-form" action="{$blog_link|escape:'html':'UTF-8'}" onsubmit="return false;">
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="inputFullName">{l s='Full Name' d='Shop.Theme.Global'}</label>
				<div class="col-lg-9">
					<input type="text" name="user" placeholder="{l s='Enter your full name' d='Shop.Theme.Global'}" id="inputFullName" class="form-control">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="inputEmail">{l s='Email' d='Shop.Theme.Global'}</label>
				<div class="col-lg-9">
					<input type="text" name="email"  placeholder="{l s='Enter your email' d='Shop.Theme.Global'}" id="inputEmail" class="form-control">
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-lg-3 col-form-label" for="inputComment">{l s='Comment' d='Shop.Theme.Global'}</label>
				<div class="col-lg-9">
					<textarea type="text" name="comment" rows="6"  placeholder="{l s='Enter your comment' d='Shop.Theme.Global'}" id="inputComment" class="form-control"></textarea>
				</div>
			</div>
			 <div class="form-group row">
			 	<label class="col-lg-3 col-form-label" for="inputEmail">{l s='Captcha' d='Shop.Theme.Global'}</label>
			 	<div class="col-lg-8 col-md-8 ipts-captcha">
			 		 <img src="{$captcha_image|escape:'html':'UTF-8'}" class="comment-capcha-image" align="left"/>
				 	<input class="form-control" type="text" name="captcha" value="" size="10"  />
				</div>
			 </div>
			 <input type="hidden" name="id_psblog_blog" value="{$id_psblog_blog|intval}">
			<div class="form-group row">
				<div class="col-lg-9 offset-md-3"><button class="btn btn-default btn-primary" name="submitcomment" type="submit">{l s='Submit' d='Shop.Theme.Global'}</button></div>
			</div>
		</form>
</div>