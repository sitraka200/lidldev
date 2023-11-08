{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}

{block name='product_miniature_item'}
<div class="product-miniature1 js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
    <div class="image-block_slider">
        {assign var=imagesCount value=$product.images|count}
        <aside id="thumbnails" class="thumbnails js-thumbnails text-xs-center">
            {block name='product_images'}
            <div class="js-modal-mask mask {if $imagesCount <= 5} nomargin {/if}">
                <ul class="product-images js-modal-product-images">
                    {foreach from=$product.images item=image}
                    <li class="thumb-container">
                        <img data-image-large-src="{$image.large.url}" class="thumb js-modal-thumb" src="{$image.medium.url}" alt="{$image.legend}" title="{$image.legend}" width="{$image.medium.width}" itemprop="image">
                    </li>
                    {/foreach}
                </ul>
            </div>
            {/block}
            
            {if $imagesCount > 5}
            <div class="arrows js-modal-arrows">
                <i class="material-icons arrow-up js-modal-arrow-up">&#xE5C7;</i>
                <i class="material-icons arrow-down js-modal-arrow-down">&#xE5C5;</i>
            </div>
            {/if}
        </aside>
    </div>

    <div class="thumbnail-container col-sm-12 col-md-5">
        <div class="special_block">
            <div class="image-block">
                {block name='product_thumbnail'}
                <a href="{$product.url}" class="thumbnail product-thumbnail">
                    <img
                        class = "primary-image js-modal-product-cover product-cover-modal"
                        src = "{$product.cover.bySize.home_default.url}"
                        alt = "{$product.cover.legend}"
                        data-full-size-image-url = "{$product.cover.large.url}"
                        title="{$product.cover.legend}" 
                        >
                </a>
                {/block} 
            </div>

            {block name='product_flags'}
            <ul class="product-flags">
               {foreach from=$product.flags item=flag}
               <li class="{$flag.type}">{$flag.label}</li>
               {/foreach}
           </ul>
           {/block}

            {if $product.has_discount}
            {hook h='displayProductPriceBlock' product=$product type="old_price"}
            {if $product.discount_type === 'percentage'}
            <div class="discount_type_flag">
                <span class="discount-percentage">{$product.discount_percentage}</span>
            </div>
            {* ADD NEW CHANGE *}
            {else}
            <div class="discount_type_flag">
                <span class="discount-percentage">-{math equation="(( a * 100)/b)" format="%.2f" a=$product.discount_amount|intval b=$product.price_without_reduction|intval}%</span>
            </div>
            {/if}
            {/if}
        </div>

        <div class="product-description col-sm-12 col-md-7">
            {block name='product_reviews'}
            {hook h='displayProductListReviews' product=$product}
            {/block}

            {block name='product_name'}
            <span class="h3 product-title" itemprop="name"><a href="{$product.url}" title="{$product.name}">{$product.name}</a></span>
            {/block}

            {block name='product_description_short'}
            {if $product.description}
            {/if}
            {/block}  

            {block name='product_price_and_shipping'}
            {if $product.show_price}
            <div class="product-price-and-shipping">
                <span itemprop="price" class="price">{$product.price}</span>
                {if $product.has_discount}
                {hook h='displayProductPriceBlock' product=$product type="old_price"}               
                <span class="sr-only">{l s='Regular price' d='Shop.Theme.Catalog'}</span>
                <span class="regular-price">{$product.regular_price}</span>
                {/if}
                {* {hook h='displayProductPriceBlock' product=$product type="before_price"}            *}
                {* {hook h='displayProductPriceBlock' product=$product type='unit_price'} *}
                {* {hook h='displayProductPriceBlock' product=$product type='weight'} *}
            </div>
            {/if}
            {/block}

            {block name='product_description_short'}
            <div class="product-detail" itemprop="description">{$product.description_short|truncate:150:'...' nofilter}</div>
            {/block}

            <!-- <div id="product-description-offer">{l s='Hurry Up! Offer Ends in:' d='Shop.Theme.Global'}</div> -->
            {hook h='PSProductCountdown' id_product=$product.id_product} 

            {block name='product_buy'}
            {if !$configuration.is_catalog}       
            <div class="product-actions-main">
                <form action="{$urls.pages.cart}" method="post" class="add-to-cart-or-refresh">
                    <input type="hidden" name="token" value="{$static_token}">
                    <input type="hidden" name="id_product" value="{$product.id}" class="product_page_product_id">
                    <input type="hidden" name="id_customization" value="0" class="product_customization_id">
                    <button class="btn btn-primary add-to-cart" data-button-action="add-to-cart" type="submit" {if $product.availability == 'unavailable'}disabled{/if} title="{l s='Add to cart' d='Shop.Theme.Global'}">           
                        {l s='Add to cart' d='Shop.Theme.Global'}
                    </button>
                </form> 
                
                {block name='quick_view'}
                <a href="#" class="quick-view" data-link-action="quickview">
                    <!-- <i class="material-icons search">&#xE417;</i> --> <!-- {l s='Quick view' d='Shop.Theme.Actions'} -->
                </a>
                {/block} 
            </div>
            {/if}
            {/block}
        </div>
    </div>
</div>
{/block}