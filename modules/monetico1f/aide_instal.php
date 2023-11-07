<?php
/*
 Module de paiement Monetico pour le CM-CIC Par hosteco.fr 2012-2017. 
*/
function filtre($chaine) {

$chaine = str_replace(" ","%20",$chaine);
$chaine = str_replace("<br>","%0D%0A",$chaine);
$chaine = str_replace("<br%20/>","%0D%0A",$chaine);
$chaine = str_replace("<b>","",$chaine);
$chaine = str_replace("</b>","",$chaine);

return $chaine;

}

$id_shop = $this->context->shop->id;
$shop_uri = $_SERVER['HTTP_HOST'];
$shop_ql = "SELECT * FROM "._DB_PREFIX_."shop_url WHERE main='1' and id_shop ='".$id_shop."'";
if ($rs_shop = Db::getInstance()->getRow($shop_ql))
$domain = $rs_shop['domain'];   
$domain_ssl = $rs_shop['domain_ssl'];
$boutique = str_replace("www.","",$rs_shop['domain']); 
 
$domain_uri = $domain;
if ($rs_shop['physical_uri'] == '/') {$physical_uri = '';} else  {$physical_uri = $rs_shop['physical_uri'];}

$virtual_uri = str_replace('/','',$rs_shop['virtual_uri']);
$virtual_uri = '/'.$virtual_uri ;
if ($virtual_uri == '/') {$virtual_uri = '';} 
$shop_uri = $domain_uri . $physical_uri . $virtual_uri;

$titres = 'URLS pour le TPE '. $CMCIC_TPE.' / '. $CMCIC_CODESOCIETE.' --> '. $shop_uri .' - CMS : Prestashop';

$emails = '
Bonjour, <br />
<br />
Vous trouverez ci-dessous les adresses d\'annulation, de  succès et l\'adresse de retour<br />
 ----------------------------------------------------------------------------------------------<br />
TPE: <b>'.$CMCIC_TPE.'</b> / code société: <b>'.$CMCIC_CODESOCIETE.'</b><br /> 
<br />
Adresse annulation:<br /><b>
'.htmlspecialchars($this->http.$shop_uri.__PS_BASE_URI__.'order.php', ENT_COMPAT, 'UTF-8').'<br />
<br /></b>
Adresse Succès:<br /><b>
'.htmlspecialchars($this->http.$shop_uri.__PS_BASE_URI__.'order-confirmation.php', ENT_COMPAT, 'UTF-8').'<br />
<br /></b>
Adresse Retour (test et Prod):<br /><b>
'.$this->http.htmlspecialchars($shop_uri.__PS_BASE_URI__, ENT_COMPAT, 'UTF-8').'modules/monetico1f/Ret-Monetico-17.php<br />
</b>
------------------------------------------------------------------------------------------------<br />
<br />
Cordialement<br />
<br />';
$emailsf = filtre($emails);

$titresp = 'Demande de mise en production pour le TPE '.$CMCIC_TPE.' / '.$CMCIC_CODESOCIETE.' --> '.$shop_uri;

$emailsp = '
Bonjour, 
<br /><br />
Demande de mise en production pour le TPE '.$CMCIC_TPE.' / '.$CMCIC_CODESOCIETE.' --> '.$shop_uri.' - CMS : Prestashop
<br /><br />
Cordialement .
<br /><br />';
$emailspf = filtre($emailsp);


$this->_html .= '
		<div id="TabConf_03" class="tab_content" style="margin-left:30px; font-size:15px; font-weight:normal;">
			
<h2>Procédure d\'installation sur '.$boutique.' ('.$this->context->shop->id.')</h2>
<b><big>A - Paiement simple (en 1 fois)</big></b>
  <br /><br />
  <b>1) - </b>Entrez les valeurs : Numéro de TPE, Code société, et la Clé de Sécurité SHA1,
  <br /> Choisir Monetico ou la banque et le mode test, Entrez la valeur de seuil mini d\'activation, et Activé le module.
  <br /><br />   
  <b>Information sur le code soci&eacute;t&eacute; :<br /></b>
  <br />  
  Le code soci&eacute;t&eacute; vous est fournis par email de <b>centrecom@e-i.com</b>, il comporte g&eacute;n&eacute;ralement 7 &agrave; 8 caract&egrave;res reprenant le nom de votre soci&eacute;t&eacute;, 
  <br />&agrave; ne pas confondre avec l\'identifiant Monetico Paiement qui lui comprend 16 caract&egrave;res.
  <br /><br />   
  <b>Exemple de fichier Clef (numéro tpe.key) :<br /></b>
  <br />
  <div style="background:#dedede;padding: 5px 15px 5px 15px;margin-right:500px;">
  VERSION 1 <b><font color="blue">8E787049376D31DA39C40555C8CA21E62C92030A</font></b><br />
  HMAC-SHA1<br />
  #<br />
  f2857627adbf02c1d91963af085c39de32378cd8<br />
  </div>
  <b>Vous devez recopier la clef en bleu dans le champ Clé de Sécurité SHA1.</b><br />  
  <br /><b>Si vous n\'avez pas de fichier Clef, vous trouverez la clef dans l\'admin Test Monetico de votre  compte VAD</b><br />
  <i>toutes les informations n&eacute;cessaires sont dans les  3 emails que centrecom vous a envoy&eacute;.</i>
  <br /><br />
  <b>Vous devez recopier la clef en bleu dans le champ Clé de Sécurité SHA1.</b><br />
  <br />
  <b>2) - </b>Email à envoyer pour le paiement <b>simple</b> à <a href="mailto:centrecom@e-i.com?subject='. $titres.'&body='.$emailsf.'" title="Cliquez ici pour créer l\'email"><b>centrecom@e-i.com</b></a> ci-dessous:<br />
  <i>(Cet email doit être envoyé avec l\'adresse email fourni à centrecom lors de la signature du VAD avec votre banque)</i><br />
  <b>Pour le Canada contactez le support technique en <a href="https://assistance.monetico.ca/support-technique" target="_blank">cliquant ici</a></b><br /><br />
  <div style="background:#eee;padding: 5px 15px 5px 15px;margin-right:270px;">    
  TITRE : &nbsp; 
  <b>'. $titres.'</b> 
</div>

*************************************************************************************************************
  <div style="background:#eee;padding: 5px 15px 5px 15px;margin-right:270px;">  
'.$emails.'
</div>
***************************************************************************************************************		
<br /><br />	
<i>En faite à ce stade le paiement est effectué en mode test, mais la BDD n\'est pas mise à jour donc la commande n&#39;apparait pas.</i>
<br />
  <b>3) - </b>  D&egrave;s que vous avez le retour de centrecom, vous devez effectuer les 3 essais de paiement accept&eacute; demand&eacute;s par centrecom.<br />
  <b>Vous pouvez suivre vos tests dans l\'admin de test </b><a href="https://www.monetico-services.com/fr/test/identification/login.cgi" target="blank" title="Cliquez ici pour ouvrir le vad en mode test"><b>Monetico Paiement</b></a>
<br /><br />	
  <b>4) - </b>  Une fois que les 3 essais sont concluants, pouvez faire la demande de mise en production à <a href="mailto:centrecom@e-i.com?subject='. $titresp.'&body='.$emailspf.'" title="Cliquez ici pour créer l\'email"><b>centrecom@e-i.com</b></a> ci-dessous:<br />
  <i>(Cet email doit être envoyé avec l\'adresse email fourni à centrecom lors de la signature du VAD avec votre banque)</i><br />
  <b>Pour le Canada contactez le support technique en <a href="https://assistance.monetico.ca/support-technique" target="_blank">cliquant ici</a></b><br /><br />  
  <div style="background:#eee;padding: 5px 15px 5px 15px;margin-right:270px;">  
  TITRE : &nbsp;
  <b>'.$titresp.'</b> 
</div>
*************************************************************************************************************
  <div style="background:#eee;padding: 5px 15px 5px 15px;margin-right:270px;">
'.$emailsp.'
</div>
**************************************************************************************************************
<br /><br />
  <b>5) - </b>  Dès que vous avez le retour de centrecom, retirer le mode test en choisissant Monetico Production. 
  <br /><b>(votre module accepte maintenant les paiements r&eacute;els)</b>
<br /><br />
<b><font color="blue">L\'installation du paiement simple est terminée.</font></b>
<br /><br /><br />
</div>

';

/*
 Module de paiement Monetico pour le CM-CIC Par hosteco.fr 2012-2017. 
*/
?>
