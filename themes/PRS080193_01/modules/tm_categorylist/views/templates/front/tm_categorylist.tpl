{*
* 2007-2016 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2016 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div class="col-md-6 no-padding-left">
	<div class="row">
		<div class="Bannercombo1 col-md-12">
			<div class="Bannerlist">
				{hook h='displayCatBanner'}
			</div>

			<div  class="tmcategorylist">
				<div class="tmcategory-container container hb-animate-element left-to-right">
					<div class="row">
						<h2 class="h1 products-section-title ">{l s='Tickets by category' d='Shop.Theme.Global'}</h2>
						<div class="menu-title"></div>
						{if isset($tmcategoryinfos) && $tmcategoryinfos}
							{assign var='sliderFor' value=4}
							{assign var='productCount' value=count($tmcategoryinfos)}
							{$categorycount=0}
							{if $productCount >= $sliderFor}
								<div class="customNavigation">
									<a class="btn prev cat_prev">&nbsp;</a>
									<a class="btn next cat_next">&nbsp;</a>
								</div>
							{/if}

							{if $productCount >= $sliderFor}
								<ul id="tmcategorylist-carousel" class="tm-carousel product_list product_slider_grid">
							{else}
								<ul id="tmcategorylist" class="product_list grid row gridcount product_slider_grid">
							{/if}
									{foreach from=$tmcategoryinfos item=tmcategoryinfo}
										{assign var=tmimglink value=$link->getCatImageLink($tmcategoryinfo.category->link_rewrite, $tmcategoryinfo.category->id)}
										<li>
											<div class="categoryblock{$categorycount} categoryblock item">
												<div class="block_content">
													{if tmimglink}
														<a href="{$tmimglink}">
															<div class="categoryimage_bg">
																<div class="categoryimage">
																	<img src="{$tmimglink}" alt="" class="img-responsive"/>
																</div>
															</div>
														</a>
													{/if}
													<div class="categorylist">
														<div class="cate-heading">
															<a href="{$link->getCategoryLink($tmcategoryinfo.category->id_category, $tmcategoryinfo.category->link_rewrite)}">{$tmcategoryinfo.name}</a>
														</div>
														<ul class="subcategory">
															{$categorychildcount = 1}
															{foreach $tmcategoryinfo.child_cate item=child}
															{if $categorychildcount <=3}
															<li>
																<a href="{$link->getCategoryLink({$child.id_category},{$child.link_rewrite})}">{$child.name}</a>,
															</li>
															{/if}
															{$categorychildcount = $categorychildcount + 1}
															{/foreach}
															<li>
																<a href="{$link->getCategoryLink($tmcategoryinfo.category->id_category, $tmcategoryinfo.category->link_rewrite)}">
																{l s='View all' mod='tmcategorylist'}</a>
															</li>
														</ul>
													</div>
													<div class="cate-description">
														{$tmcategoryinfo.description|truncate:130:'...' nofilter}
													</div>
												</div>

											</div>
										</li>

										{$categorycount = $categorycount + 1}
									{/foreach}
								</ul>
						{else}
							<div class="alert alert-info">{l s='No Category is Selected.' d='Shop.Theme.Global'}</div>
						{/if}
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>