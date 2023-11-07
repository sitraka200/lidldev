{*
 * Cookies Plus
 *
 * NOTICE OF LICENSE
 *
 * This product is licensed for one customer to use on one installation (test stores and multishop included).
 * Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
 * whole or in part. Any other use of this module constitues a violation of the user agreement.
 *
 * DISCLAIMER
 *
 * NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
 * ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
 * WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
 * PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
 * IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
 *
 *  @author    idnovate.com <info@idnovate.com>
 *  @copyright 2017 idnovate.com
 *  @license   See above
*}

<style>
	.col-xs-6 {
	    width: 50%;
	    float: left;
	    position: relative;
	    min-height: 1px;
	    padding-left: 5px;
	    padding-right: 5px;
	    box-sizing: border-box;
	}

	/*  Bootstrap Clearfix */
	/*  Tablet  */
	@media (min-width:767px){
	  /* Column clear fix */
	  .col-lg-1:nth-child(12n+1),
	  .col-lg-2:nth-child(6n+1),
	  .col-lg-3:nth-child(4n+1),
	  .col-lg-4:nth-child(3n+1),
	  .col-lg-6:nth-child(2n+1),
	  .col-md-1:nth-child(12n+1),
	  .col-md-2:nth-child(6n+1),
	  .col-md-3:nth-child(4n+1),
	  .col-md-4:nth-child(3n+1),
	  .col-md-6:nth-child(2n+1){
	    clear: none;
	  }
	  .col-sm-1:nth-child(12n+1),
	  .col-sm-2:nth-child(6n+1),
	  .col-sm-3:nth-child(4n+1),
	  .col-sm-4:nth-child(3n+1),
	  .col-sm-6:nth-child(2n+1){
	    clear: left;
	  }
	}

	/*  Medium Desktop  */
	@media (min-width:992px){
	  /* Column clear fix */
	  .col-lg-1:nth-child(12n+1),
	  .col-lg-2:nth-child(6n+1),
	  .col-lg-3:nth-child(4n+1),
	  .col-lg-4:nth-child(3n+1),
	  .col-lg-6:nth-child(2n+1),
	  .col-sm-1:nth-child(12n+1),
	  .col-sm-2:nth-child(6n+1),
	  .col-sm-3:nth-child(4n+1),
	  .col-sm-4:nth-child(3n+1),
	  .col-sm-6:nth-child(2n+1){
	    clear: none;
	  }
	  .col-md-1:nth-child(12n+1),
	  .col-md-2:nth-child(6n+1),
	  .col-md-3:nth-child(4n+1),
	  .col-md-4:nth-child(3n+1),
	  .col-md-6:nth-child(2n+1){
	    clear: left;
	  }
	}

	/*  Large Desktop  */
	@media (min-width:1200px){
	  /* Column clear fix */
	  .col-md-1:nth-child(12n+1),
	  .col-md-2:nth-child(6n+1),
	  .col-md-3:nth-child(4n+1),
	  .col-md-4:nth-child(3n+1),
	  .col-md-6:nth-child(2n+1),
	  .col-sm-1:nth-child(12n+1),
	  .col-sm-2:nth-child(6n+1),
	  .col-sm-3:nth-child(4n+1),
	  .col-sm-4:nth-child(3n+1),
	  .col-sm-6:nth-child(2n+1){
	    clear: none;
	  }
	  .col-lg-1:nth-child(12n+1),
	  .col-lg-2:nth-child(6n+1),
	  .col-lg-3:nth-child(4n+1),
	  .col-lg-4:nth-child(3n+1),
	  .col-lg-6:nth-child(2n+1){
	    clear: left;
	  }
	}
	.module-list { overflow: hidden;}
	.module-list label { display: inline; }
	.module-list img { vertical-align: top; }
	.module-list div { margin-bottom: 10px;	}
</style>

<div class="module-list">
	{foreach from=$allModules item=module}
	<div class="col-xs-6">
		<img src="../modules/{$module->name|escape:'htmlall':'UTF-8'}/logo.png" alt="{$module->displayName|escape:'htmlall':'UTF-8'}" width="16" height="16" />
		<input type="checkbox" name="C_P_MODULES_VALUES[]" value="{$module->id|escape:'htmlall':'UTF-8'}" {if isset($module->checked) && $module->checked}checked=checked{/if} />
		<label>{$module->displayName|escape:'htmlall':'UTF-8'}</label> ({$module->name|escape:'htmlall':'UTF-8'})
	</div>
	{/foreach}
</div>