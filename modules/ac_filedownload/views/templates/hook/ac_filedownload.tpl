{$attachments|var_dump}
{* {if $attachments}
    <ul class="bullet">
        {foreach from=$attachments item=attachment name=attachment_list}
            <li><a href="{$link->getAttachmentLink($attachment.id_attachment, $attachment.name)|escape:'html'}" title="{l s='More about %s' sprintf=[$attachment.name] mod='blockattachment'}">{$attachment.name|escape:'html':'UTF-8'}</a></li>
        {/foreach}
    </ul>
{else}
    <p>{l s='No new attachments' mod='blockattachment'}</p>
{/if} *}