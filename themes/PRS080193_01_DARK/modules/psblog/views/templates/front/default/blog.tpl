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
{extends file=$layout}

{block name='content'}

	{if isset($error)}
			<div id="blogpage">
				<div class="blog-detail">
					<div class="alert alert-warning">{l s='Sorry, We are updating data, please come back later!!!!' d='Shop.Theme.Global'}</div>
				</div>
			</div>
		{else}
		<div class="content">
			<div id="blogpage" class="col-xs-12 col-lg-9">
				<article class="blog-detail">
					{if $is_active}
					
					

					{if $blog->preview_url && $config->get('item_show_image','1')}
						<div class="blog-image">
							<img src="{$blog->preview_url|escape:'html':'UTF-8'}" title="{$blog->meta_title|escape:'html':'UTF-8'}" class="img-fluid" />
							
						</div>
					{/if}
					<h1 class="blog-title">{$blog->meta_title|escape:'html':'UTF-8'}</h1>
	                 <div class="blog-meta">
						{if $config->get('item_show_author','1')}
						<span class="blog-author">
							<span> {l s='Posted By' d='Shop.Theme.Global'}: </span>
							<a href="{$blog->author_link|escape:'html':'UTF-8'}" class="fa fa-user" title="{$blog->author|escape:'html':'UTF-8'}"> {$blog->author|escape:'html':'UTF-8'}</a>
						</span>
						{/if}

						{if $config->get('item_show_category','1')}
						<span class="blog-cat"> 
							<i class="fa fa-list"></i>{l s='In' d='Shop.Theme.Global'}: 
							<a href="{$blog->category_link|escape:'html':'UTF-8'}" title="{$blog->category_title|escape:'html':'UTF-8'}">{$blog->category_title|escape:'html':'UTF-8'}</a>
						</span>
						{/if}

						{if $config->get('item_show_created','1')}
						<span class="blog-created">
							<i class="fa fa-calendar"></i> {l s='On' d='Shop.Theme.Global'}:
							<time class="date" datetime="{strtotime($blog->date_add)|date_format:"%Y"|escape:'html':'UTF-8'}">
								{l s=strtotime($blog->date_add)|date_format:"%A"|escape:'html':'UTF-8' d='Module.PsBlog'},	<!-- day of week -->
								{l s=strtotime($blog->date_add)|date_format:"%B"|escape:'html':'UTF-8' d='Module.PsBlog'}		<!-- month-->
								{l s=strtotime($blog->date_add)|date_format:"%e"|escape:'html':'UTF-8' d='Module.PsBlog'},	<!-- day of month -->
								{l s=strtotime($blog->date_add)|date_format:"%Y"|escape:'html':'UTF-8' d='Module.PsBlog'}		<!-- year -->
							</time>
						</span>
						{/if}
						
						{* {if isset($blog_count_comment)&&$config->get('item_show_counter','1')}
						<span class="blog-ctncomment">
							<i class="fa fa-comments-o"></i>{l s='Comment' d='Shop.Theme.Global'}: 
							{$blog_count_comment|intval}
						</span>
						{/if} *}
						{if isset($blog->hits)&&$config->get('item_show_hit','1')}
						<span class="blog-hit">
							<i class="fa fa-heart"></i>{l s='Hit' d='Shop.Theme.Global'}:
							{$blog->hits|intval}
						</span>
						{/if}
					</div>
					<div class="blog-description">
						{if $config->get('item_show_description',1)}
							{$blog->description nofilter}{* HTML form , no escape necessary *}
						{/if}
						{$blog->content nofilter}{* HTML form , no escape necessary *}
					</div>
					
					

					{if trim($blog->video_code)}
					<div class="blog-video-code">
						<div class="inner ">
							{$blog->video_code nofilter}{* HTML form , no escape necessary *}
						</div>
					</div>
					{/if}

					<div class="social-share">
						 {include file="module:psblog/views/templates/front/default/_social.tpl"}
					</div>
					{if $tags}
					<div class="blog-tags">
						<span>{l s='Tags:' d='Shop.Theme.Global'}</span>
					 
						{foreach from=$tags item=tag name=tag}
							 <a href="{$tag.link|escape:'html':'UTF-8'}" title="{$tag.tag|escape:'html':'UTF-8'}"><span>{$tag.tag|escape:'html':'UTF-8'}</span></a>
						{/foreach}
						 
					</div>
					{/if}

					{if !empty($samecats)||!empty($tagrelated)}
					<div class="extra-blogs row">
					{if !empty($samecats)}
						<div class="col-lg-6 col-md-6 col-xs-12">
							<h4>{l s='In Same Category' d='Shop.Theme.Global'}</h4>
							<ul>
							{foreach from=$samecats item=cblog name=cblog}
								<li><a href="{$cblog.link|escape:'html':'UTF-8'}">{$cblog.meta_title|escape:'html':'UTF-8'}</a></li>
							{/foreach}
							</ul>
						</div>
						<div class="col-lg-6 col-md-6 col-xs-12">
							<h4>{l s='Related by Tags' d='Shop.Theme.Global'}</h4>
							<ul>
							{foreach from=$tagrelated item=cblog name=cblog}
								<li><a href="{$cblog.link|escape:'html':'UTF-8'}">{$cblog.meta_title|escape:'html':'UTF-8'}</a></li>
							{/foreach}
							</ul>
						</div>
					{/if}
					</div>
					{/if}

					{if $productrelated}

					{/if}
					{* <div class="blog-comment-block">
					{if $config->get('item_comment_engine','local')=='facebook'}
						{include file="module:psblog/views/templates/front/default/_facebook_comment.tpl"}
					{elseif $config->get('item_comment_engine','local')=='diquis'}
						{include file="module:psblog/views/templates/front/default/_diquis_comment.tpl"}
					
					{else}
						{include file="module:psblog/views/templates/front/default/_local_comment.tpl"}
					{/if}
					</div> *}	
					{else}
					<div class="alert alert-warning">{l s='Sorry, This blog is not avariable. May be this was unpublished or deleted.' d='Shop.Theme.Global'}</div>
					{/if}

				</article>
			</div>
			
			<div class="col-xs-12 col-lg-3">
				<div id="tmsmartblog_block">
					<div id="tmcmsbannerblock">
						<div class="container">
							<div class="subbanner">
								<div class="cms-banner-item col-xs-6 col-sm-5 col-md-4 col-lg-12">
									<div class="col-xs-12">
										<div class="sub-title">Formulaires</div>
									</div>
									
									<div class="col-xs-12 cms_image">
										<img src="https://cse-lidlentzheim.com/img/cms/formulaire.png" alt="formulaire.png">
									</div>
									
									<div class="col-xs-12">
										<div class="button"><a href="https://cse-lidlentzheim.com/content/6-formulaires" class="btn btn-primary">Y accéder</a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		{/if}

	<!---
		Translation Day of Week - NOT REMOVE
		{l s='Sunday' d='Modules.PsBlog.Shop'}
		{l s='Monday' d='Modules.PsBlog.Shop'}
		{l s='Tuesday' d='Modules.PsBlog.Shop'}
		{l s='Wednesday' d='Modules.PsBlog.Shop'}
		{l s='Thursday' d='Modules.PsBlog.Shop'}
		{l s='Friday' d='Modules.PsBlog.Shop'}
		{l s='Saturday' d='Modules.PsBlog.Shop'}
	-->
	<!---
		Translation Month - NOT REMOVE
			{l s='January' d='Modules.PsBlog.Shop'}
			{l s='February' d='Modules.PsBlog.Shop'}
			{l s='March' d='Modules.PsBlog.Shop'}
			{l s='April' d='Modules.PsBlog.Shop'}
			{l s='May' d='Modules.PsBlog.Shop'}
			{l s='June' d='Modules.PsBlog.Shop'}
			{l s='July' d='Modules.PsBlog.Shop'}
			{l s='August' d='Modules.PsBlog.Shop'}
			{l s='September' d='Modules.PsBlog.Shop'}
			{l s='October' d='Modules.PsBlog.Shop'}
			{l s='November' d='Modules.PsBlog.Shop'}
			{l s='December' d='Modules.PsBlog.Shop'}
	-->
{/block}