{*
* PrivateShop
*
* Do not edit or add to this file.
* You are not authorized to modify, copy or redistribute this file.
* Permissions are reserved by FME Modules.
*
*  @author    FME Modules
*  @copyright 2018 FME Modules All right reserved
*  @license   FME Modules
*  @category  FMM Modules
*  @package   PrivateShop
*}
<div class="bootstrap">
		<div class="alert alert-warning">
			<button type="button" class="close" data-dismiss="alert">×</button>
				<ul class="list-unstyled">
					<li>{l s='Please note that the email notification will be only sent to user if you activate the customer account from below Activate button.' mod='privateshop'}</li>
				</ul>
		</div>
	</div>
<div class="panel col-lg-12">
	<div class="panel-heading">
		<i class="icon-search"></i> {l s='Filter' mod='privateshop'}
	</div>
	<div class="row">
		<div class="col-lg-12 form-group">
			<div class="col-lg-2">
				<label class="col-lg-5 control-label">{l s='Show:' mod='privateshop'}</label>
				<select class="filter col-lg-7" name="n">
					<option value="10"{if $search_result.n == 0 || $search_result.n <= 10} selected="selected"{/if}>10</option>
					<option value="25"{if $search_result.n == 25} selected="selected"{/if}>25</option>
					<option value="50"{if $search_result.n == 50} selected="selected"{/if}>50</option>
					<option value="100"{if $search_result.n == 100} selected="selected"{/if}>100</option>
					<option value="300"{if $search_result.n == 300} selected="selected"{/if}>300</option>
					<option value="500"{if $search_result.n == 500} selected="selected"{/if}>500</option>
					<option value="1000"{if $search_result.n == 1000} selected="selected"{/if}>1000</option>
				</select>
			</div>
			<div class="col-lg-4">
				<label class="col-lg-4 control-label">{l s='Position:' mod='privateshop'}</label>
				<select class="filter col-lg-8" name="filter_select_pos">
					<option value="0"{if $search_result.pos == 0} selected="selected"{/if}>{l s='By ID Asc' mod='privateshop'}</option>
					<option value="1"{if $search_result.pos > 0} selected="selected"{/if}>{l s='By ID Desc' mod='privateshop'}</option>
				</select>
			</div>
			<div class="col-lg-4">
				<label class="col-lg-4 control-label">{l s='Active:' mod='privateshop'}</label>
				<select class="filter col-lg-8" name="filter_select_state">
					<option value="0"{if $search_result.state == 0} selected="selected"{/if}>{l s='--' mod='privateshop'}</option>
					<option value="1"{if $search_result.state == 1} selected="selected"{/if}>{l s='Yes' mod='privateshop'}</option>
					<option value="2"{if $search_result.state == 2} selected="selected"{/if}>{l s='No' mod='privateshop'}</option>
				</select>
			</div>
			<div class="col-lg-2 pull-right">
				<button type="submit" name="search" class="btn btn-default pull-right"><i class="icon-search"></i> {l s='Search' mod='privateshop'}</button>
			</div>
		</div>
		<div class="col-lg-12 form-group" style=" margin-bottom: 5px;">
			<div class="col-lg-10">
				<label class="col-lg-4 control-label">{l s='By Name:' mod='privateshop'}</label>
				<div class="col-lg-8">
					<input type="text" name="search_by_name" value="{if isset($search_result.name) && !empty($search_result.name)}{$search_result.name}{/if}" />
				</div>
			</div>
			<div class="col-lg-2 pull-right">
				<button type="submit" name="searchReset" class="btn btn-warning pull-right"><i class="icon-eraser"></i> {l s='Reset' mod='privateshop'}</button>
			</div>
		</div>
	</div>
</div>
<div class="table-responsive">
	<table class="table table-filter-templates" style="width:100%;">
		<thead>
			<tr>
				<th class="center"><span class="title_box"><strong>{l s='ID' mod='privateshop'}</strong></span></th>
				<th class="center"><span class="title_box"><strong>{l s='Title' mod='privateshop'}</strong></span></th>
				<th><span class="title_box"><strong>{l s='Name' mod='privateshop'}</strong></span></th>
				<th><span class="title_box"><strong>{l s='Email' mod='privateshop'}</strong></span></th>
				<th class="center"><span class="title_box"><strong>{l s='Status' mod='privateshop'}</strong></span></th>
				<th class="center"><span class="title_box"><strong>{l s='Newsletter' mod='privateshop'}</strong></span></th>
				<th class="center"><span class="title_box"><strong>{l s='Signup Date' mod='privateshop'}</strong></span></th>
				<th class="center"><span class="title_box"><strong>{l s='Last Visit' mod='privateshop'}</strong></span></th>
				<th class="center"><span class="title_box text-right"><strong>{l s='Action' mod='privateshop'}</strong></span></th>
			</tr>
		</thead>
		<tbody>
		{if isset($customers) AND $customers}
			{foreach from=$customers item=customer}
			<tr>
				<td class="center" style="padding:10px;width:50px;">{$customer.id_customer|escape:'htmlall':'UTF-8'}</td>
				<td class="center" style="padding:10px;width:50px;">{$customer.title|escape:'htmlall':'UTF-8'}</td>
				<td {if $version >= 1.6}style="width:100%"{/if}>{$customer.customer|escape:'htmlall':'UTF-8'}</td>
				<td>{$customer.email|escape:'htmlall':'UTF-8'}</td>
				<td class="center">
				{if $customer.active == 1}
					<label class="t list-action-enable action-enabled" for="active_on">
						<i class="icon-check"></i>
						{if $version < 1.6}
							<img src="../img/admin/enabled.gif" alt="Enabled" title="Enabled" />
						{/if}
					</label>
				{else}
					<label class="t list-action-enable action-disabled" for="active_off">
						<i class="icon-remove"></i>
						{if $version < 1.6}
							<img src="../img/admin/disabled.gif" alt="Disabled" title="Disabled" />
						{/if}
					</label>
				{/if}
				</td>
				<td class="center">
				{if $customer.newsletter == 1}
					<label class="t list-action-enable action-enabled" for="active_on">
						<i class="icon-check"></i>
						{if $version < 1.6}
							<img src="../img/admin/enabled.gif" alt="Enabled" title="Enabled" />
						{/if}
					</label>
				{else}
					<label class="t list-action-enable action-disabled" for="active_off">
						<i class="icon-remove"></i>
						{if $version < 1.6}
							<img src="../img/admin/disabled.gif" alt="Disabled" title="Disabled" />
						{/if}
					</label>
				{/if}
				</td>
				<td class="center">{$customer.date_add|escape:'htmlall':'UTF-8'}</td>
				<td class="center">{$customer.connect|escape:'htmlall':'UTF-8'}</td>
				<td class="text-right">
					<div class="btn-group-action">
						<div class="btn-group pull-right">
							{if $customer.active <= 0}
								<a onclick="document.location='{$activate_index|escape:'htmlall':'UTF-8'}&id_customer={$customer.id_customer|escape:'htmlall':'UTF-8'}'" class="btn btn-default" title="{l s='Activate' mod='privateshop'}" href="javascript:void(0);">
								{if $version >= 1.6}
									<i class="icon-search-plus"></i> {l s='Activate' mod='privateshop'}
								{else}
									<img src="../img/admin/details.gif"/>
								{/if}
								</a>
							{else}
								<a onclick="document.location='{$cIndex|escape:'htmlall':'UTF-8'}&id_customer={$customer.id_customer|escape:'htmlall':'UTF-8'}&viewcustomer&token={$ctoken|escape:'htmlall':'UTF-8'}'" class="edit btn btn-default" title="{l s='Edit' mod='privateshop'}" href="javascript:void(0);">
								{if $version >= 1.6}
									<i class="icon-search-plus"></i> {l s='View' mod='privateshop'}
								{else}
									<img src="../img/admin/details.gif"/>
								{/if}
								</a>
							{/if}
							{if $version >= 1.6}
								<button data-toggle="dropdown" class="btn btn-default dropdown-toggle">
									<i class="icon-caret-down"></i>&nbsp;
								</button>
							{/if}
							<ul class="dropdown-menu">
								<li>
									<a onclick="document.location='{$cIndex|escape:'htmlall':'UTF-8'}&id_customer={$customer.id_customer|escape:'htmlall':'UTF-8'}&deletecustomer&token={$ctoken|escape:'htmlall':'UTF-8'}'" class="delete" title="{l s='Delete' mod='privateshop'}" href="javascript:void(0);">
									{if $version >= 1.6}
										<i class="icon-trash"></i> {l s='Delete' mod='privateshop'}
									{else}
										<img src="../img/admin/delete.gif"/>
									{/if}
									</a>
								</li>
							</ul>
						</div>
					</div>
				</td>
			</tr>
			{/foreach}
		{/if}
		</tbody>
	</table>
</div>
