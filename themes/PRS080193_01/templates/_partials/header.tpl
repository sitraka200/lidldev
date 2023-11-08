{**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
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
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{block name='header_banner'}
  <div class="header-banner">
    {hook h='displayBanner'}
  </div>
{/block}

{block name='header_nav'}
<nav class="header-nav">
	<div class="container">

		<div class="hidden-md-down">
			<div class="left-nav">
				{hook h='displayNav1'}
			</div>
			
			<div class="right-nav">
				{hook h='displayNav2'}
			</div>
		</div>
		
			<div class="hidden-lg-up text-xs-center mobile">
				<div class="text-xs-left mobile hidden-lg-up mobile-menu">
			  <div class="menu-container">
			    <div class="menu-icon">
			     <div class="cat-title"> <i class="material-icons menu-open">&#xE5D2;</i></div>
			    </div>

			</div>
			<div class="top-logo" id="_mobile_logo"></div>
			<div class="pull-xs-right" id="_mobile_cart"></div>
			<div class="pull-xs-right" id="_mobile_user_info"></div>
			
			<div class="right-nav">
				{hook h='displayNav2'}
			</div>
			<div class="clearfix"></div>
		</div>
        
	</div>
</nav>
{/block}

{block name='header_top'}
	<div class="header-top">
		<div class="header-div">
		<div class="container">
		        	<div class="header_logo hidden-md-down" id="_desktop_logo">
 {if $page.page_name == 'index'}
				<a href="{$urls.base_url}">
				<img class="logo img-responsive" src="{$shop.logo}" alt="{$shop.name}">
				</a>
  {else}
                <a href="{$urls.base_url}">
                  <img class="logo img-responsive" src="{$shop.logo}" alt="{$shop.name}">
                </a>
            {/if}
			</div>
		
			{hook h='displayTop'}
			<div id="mobile_top_menu_wrapper" class="row hidden-lg-up">
			      <div class="mobile-menu-inner">
			        <div class="menu-icon">
			       <div class="cat-title title2">   <i class="material-icons menu-close">&#xE5CD;</i> </div>
			        </div>
			        <div class="js-top-menu mobile" id="_mobile_top_menu"></div>
						<div id="_mobile_currency_selector"></div>
						<div id="_mobile_language_selector"></div>
						<div id="_mobile_contact_link"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="header-top-main bg_main">
			<div class="container">
			 {hook h='displayTopAbove'}
			</div>
		</div>
		</div>
	</div>
  {hook h='displayNavFullWidth'}
{/block}
