
{if $activecomptant=='on' && $montant_mini<=$montant}

	<form action="{$Serveur}" method="post" class="hidden" id="cmcic_form">
		<input type="hidden" name="MAC"            value="{$Hmac}">
		<input type="hidden" name="TPE"            value="{$tpe}">
		<input type="hidden" name="contexte_commande" value="{$sContexteCommande}">		
		<input type="hidden" name="date"           value="{$date}">
		<input type="hidden" name="dateech1"          value="">
    <input type="hidden" name="dateech2"          value="">
    <input type="hidden" name="dateech3"          value="">
    <input type="hidden" name="dateech4"          value="">
		<input type="hidden" name="montant"        value="{$montant}{$devise}">
		<input type="hidden" name="montantech1"       value="">
    <input type="hidden" name="montantech2"       value="">
    <input type="hidden" name="montantech3"       value="">
    <input type="hidden" name="montantech4"       value="">
    <input type="hidden" name="nbrech"            value="">
		<input type="hidden" name="reference"      value="{$reference}">
		<input type="hidden" name="lgue"           value="{$langue}">
		<input type="hidden" name="mail"		       value="{$mail}">
		<input type="hidden" name="societe"        value="{$codesociete}">
		<input type="hidden" name="texte-libre"    value="{$commentaire}">
		<input type="hidden" name="url_retour_ok"  value="{$urlRetourOK}">
		<input type="hidden" name="url_retour_err" value="{$urlRetourNOK}">
				<input type="hidden" name="version"       value="{$version}">
	</form>

{/if}

