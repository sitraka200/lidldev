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

<div id="tmpaymentcmsblock" class="links hb-animate-element right-to-left">
<div class="title h3 block_title hidden-md-down">
<h3 class="h3">{l s='payment' d='Shop.Theme.Global'}</h3>
  {$tmpaymentcmsblockinfos.text nofilter}
  </div>
  <div class="title h3 block_title hidden-lg-up" data-target="#footer_payment" data-toggle="collapse">
	<span class="h3">payment options</span>
<!-- 	<span class="pull-xs-right">
	  <span class="navbar-toggler collapse-icons">
		<i class="material-icons add">&#xE313;</i>
		<i class="material-icons remove">&#xE316;</i>
	  </span>
	</span> -->
	 <ul class="" id="footer_payment">
     {$tmpaymentcmsblockinfos.text nofilter}
    </ul>
  </div>
 
</div>
