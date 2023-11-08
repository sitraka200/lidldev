
{if $attachments}
	<div id="formulaires">
		<div id="formulairesblock">
			<div class="container">
				{foreach from=$attachments item=attachment name=attachment_list}
					<div class="grid col-md-6 {if $smarty.foreach.attachment_list.iteration is odd }odd{/if}">
						<div class="cms-grid-item cms-grid-item-{$smarty.foreach.attachment_list.index} col-xs-12">
							<div class="col-xs-12">
								<div class="sub-title">{$attachment.name}</div>
							</div>

							<div class="col-xs-12">
								<img src="{$urls.base_url}img/cms/formulaire.png" alt="formulaire.png">
							</div>

							<div class="col-xs-12 description">
								<p>{$attachment.description}</p>
							</div>

							<div class="col-xs-12">
								<div class="button"><a href="{$urls.base_url}index.php?controller=attachment&id_attachment={$attachment.id_attachment}" class="btn btn-primary"><i class="material-icons file-download">&#xE2C4;</i>{l s='Download' d='Shop.Theme.Global'}</a></div>
							</div>
						</div>
					</div>

					<hr class="col-xs-12 {if $smarty.foreach.attachment_list.iteration is odd }odd{/if}">
				{/foreach}

			</div>
		</div>
	</div>
{else}
    <div class="no_attachments">{l s='No new attachments' d='Shop.Theme.Global'}</dvi>
{/if}