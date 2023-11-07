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

<div id="blog-dashboard">

	<div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <a href="http://www.prestabrain.com/support/prestashop-16x-guides.html">{l s='Click Here to see Module Guide' d='Modules.PsBlog.Admin'}</a>
                    </div>
                </div>
		<div class="col-md-6">
			
			<div class="panel panel-default">
				<div class="panel-heading">{l s='Global Config' d='Modules.PsBlog.Admin'}</div>
				
				<div class="panel-content" id="bloggeneralsetting">
					<ul class="nav nav-tabs psblog-globalconfig" role="tablist">
						<li class="nav-item{if $default_tab == '#fieldset_0'} active{/if}">
							<a class="nav-link" href="#fieldset_0" role="tab" data-toggle="tab">{l s='General Setting' d='Modules.PsBlog.Admin'}</a>
						</li>
						<li class="nav-item{if $default_tab == '#fieldset_1_1'} active{/if}">
							<a class="nav-link" href="#fieldset_1_1" role="tab" data-toggle="tab">{l s='Listing Blog Setting' d='Modules.PsBlog.Admin'}</a>
						</li>
						<li class="nav-item{if $default_tab == '#fieldset_2_2'} active{/if}">
							<a class="nav-link" href="#fieldset_2_2" role="tab" data-toggle="tab">{l s='Item Blog Setting' d='Modules.PsBlog.Admin'}</a>
						</li>
					</ul>
					<div class="tab-content">
						{$globalform}{* HTML form , no escape necessary *}
					</div>
				</div>	

			</div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">{l s='Quick Tools' d='Modules.PsBlog.Admin'}</div>
				<div class="panel-content">
					
					<div id="quicktools" class="row">
						{foreach from=$quicktools item=tool}
						<div class="col-xs-3 col-lg-3 active">
						<a href="{$tool.href|escape:'html':'UTF-8'}" class="{$tool.class|escape:'html':'UTF-8'}">
							<i class="icon icon-3x {$tool.icon|escape:'html':'UTF-8'}"></i> 
							<p>{$tool.title|escape:'html':'UTF-8'}</p>
						</a>
						</div>
						{/foreach} 
						
					</div>
				</div>	
			</div>


			<div class="panel panel-default">
				<div class="panel-heading">{l s='Statistics' d='Modules.PsBlog.Admin'}</div>
				<div class="panel-content" id="dashtrends">
						
						<div class="row" id="dashtrends_toolbar">
							<dl   class="col-xs-4 col-lg-4 active">
								<dt>{l s='Blogs' d='Modules.PsBlog.Admin'}</dt>
								<dd class="data_value size_l"><span id="sales_score">{$count_blogs|intval}</span></dd>
								 
							</dl>
							<dl   class="col-xs-4 col-lg-4">
								<dt>{l s='Categories' d='Modules.PsBlog.Admin'}</dt>
								<dd class="data_value size_l"><span id="orders_score">{$count_cats|intval}</span></dd>
							 
							</dl>
							<dl  class="col-xs-4 col-lg-4">
								<dt>{l s='Comments' d='Modules.PsBlog.Admin'}</dt>
								<dd class="data_value size_l"><span id="cart_value_score">{$count_comments|intval}</span></dd>
							 
							</dl>
							 
						</div>


				</div>

			</div>	

			<div class="panel panel-default">
				<div class="panel-heading">{l s='Modules' d='Modules.PsBlog.Admin'}</div>
				<div class="panel-content">
					
					<section>
							<nav>
								<ul class="nav nav-tabs">
									<li class="">
										<a data-toggle="tab" href="#dash_latest_comment">
											<i class="icon-fire"></i> {l s='Lastest Comments' d='Modules.PsBlog.Admin'}
										</a>
									</li>
									<li class="active">
										<a data-toggle="tab" href="#dash_most_viewed">
											<i class="icon-trophy"></i> {l s='Most Viewed' d='Modules.PsBlog.Admin'}
										</a>
									</li>
								
								 
								</ul>
							</nav>
							<div class="tab-content panel">
								<div id="dash_latest_comment" class="tab-pane">
									
									<div>
										<ul>
										{foreach from=$latest_comments item=comment}
										<li><a href="{$comment_link|escape:'html':'UTF-8'}&id_comment={$comment.id_comment|intval}&updatepsblog_comment">
												{$comment.comment|strip_tags|truncate:65:'...'} </a/> {l s='Date' d='Modules.PsBlog.Admin'}({$comment.date_add|escape:'html':'UTF-8'}) - {l s='User :' d='Modules.PsBlog.Admin'} {$comment.user|escape:'html':'UTF-8'}</li>
										{/foreach}
										</ul>
									</div> 
								</div>
								<div id="dash_most_viewed" class="tab-pane active">
									 <div>
										<ul>
										{foreach from=$blogs item=blog}
										<li><a href="{$blog_link|escape:'html':'UTF-8'}&id_psblog_blog={$blog.id_psblog_blog|intval}&updatepsblog_blog">{$blog.meta_title|escape:'html':'UTF-8'}</a/> - <i>{l s='Hits' d='Modules.PsBlog.Admin'}: {$blog.hits|intval}</i> </li>
										{/foreach}
										</ul>
									</div> 
								</div>
							</div>
						</section>
				</div>	
			</div>	
		</div>
	</div>
</div>