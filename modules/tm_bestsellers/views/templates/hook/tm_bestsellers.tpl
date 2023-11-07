{*
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2017 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<section class="bestseller-products">
	<div class="side-banner">
		
			<h2 class="h1 products-section-title text-uppercase">
					{l s='best selleing product' d='Shop.Theme.Global'}
			</h2>

			<div class="side-para">{l s='Mi vitae magnis Fusce laoreet nibh felis porttitor laoreet Vestibulum faucibus.' d='Shop.Theme.Global'}</div>

			<div class="side-button">
			<a class="all-product-link pull-xs-left pull-md-right h4" href="{$allBestSellers}">
			{l s='view more' d='Shop.Theme.Global'}
			</a>
			</div>

	</div>
	{assign var='sliderFor' value=5} <!-- Define Number of product for SLIDER -->
	<div class="hb-animate-element left-to-right">
	<div id="spe_res">
	<div class="products">	
		
		{if $slider == 1 && $no_prod >= $sliderFor}
			<ul id="bestseller-carousel" class="tm-carousel product_list">
		{else}
			<ul id="bestseller-grid" class="bestseller_grid product_list grid row gridcount">
		{/if}
		
		{foreach from=$products item="product"}
			<li class="{if $slider == 1 && $no_prod >= $sliderFor}item{else}product_item col-xs-12 col-sm-6 col-md-4 col-lg-4{/if}">
				{include file="catalog/_partials/miniatures/product.tpl" product=$product}
			</li>
		{/foreach}

		{if $slider == 0}
			<li class="loadmore">
				<!-- <div class="tm-message"><i class="material-icons">&#xE811;</i>{l s='No more products found!' d='Shop.Theme.Global'}</div> -->
				<!-- <button class="btn btn-default gridcount btn-primary">{l s='view more products' d='Shop.Theme.Global'}</button> -->

			</li>
		{/if}
		</ul>
	</div>
	</div>
		{if $slider == 1 && $no_prod >= $sliderFor}
			<div class="customNavigation">
				<a class="btn prev bestseller_prev"></a>
				<a class="btn next bestseller_next"></a>
			</div>
		{/if}
</div>

</section>
