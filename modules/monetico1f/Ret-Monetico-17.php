<?php
/*
 Module de paiement Monetico DSP2 pour le CM-CIC Par hosteco.fr 2012-2019.
*/
if(isset($_REQUEST['hosteco'])) {if($_REQUEST['hosteco'] == 'test') { echo'Test Module Ok !'; exit;}}
if(isset($_REQUEST['vld']) && $_REQUEST['vld'] != '') {
if($_REQUEST['vld'] == 'test') { echo'Test Module Ok !'; exit;}
printf ("version=2\ncdr=0", "0");
}else {
$http = 'http://';
if(isset($_SERVER["SCRIPT_URI"])){if(substr($_SERVER["SCRIPT_URI"],0,5) == 'https') {$http = 'https://';}	else {$http = 'http://';}} 
if(isset($_SERVER['REQUEST_SCHEME'])){if(substr($_SERVER["REQUEST_SCHEME"],0,5) == 'https') {$http = 'https://';}	else {$http = 'http://';}} 
header("Location: ".$http.$_SERVER['HTTP_HOST']."/modules/monetico1f/Ret-Monetico-17.php.");
exit;
}

include_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../app/AppKernel.php');
$env = 'prod';// or you can use _PS_MODE_DEV_ ? 'dev' : 'prod';
$debug = false;// or you can use _PS_MODE_DEV_ ? true : false;
$kernel = new \AppKernel($env, $debug);
$kernel->boot();

include_once(dirname(__FILE__).'/monetico1f.php');
ob_start();

header('Pragma: no-cache');
header('Content-type: text/plain');
ini_set('display_errors', 'off');

$EI_Monetico = new Monetico1f();

//Activation paiement//

$cmcic_active	= (bool)Configuration::get('CMCIC_ACTIVE');

$email_notific = Configuration::get('CMCIC_EMAIL_NOTIFICATION');


//Récupération des paramètres généraux si un mode de paiement est activé//

if( $cmcic_active )
{
	$MyTpe["retourbanque"]= Configuration::get('CMCIC_URLCGI2');
	$MyTpe["retourok"]    = Configuration::get('CMCIC_URLOK');
	$MyTpe["retournok"]   = Configuration::get('CMCIC_URLNOK');
	$MyTpe["version"]	    = Configuration::get('CMCIC_VERSION');
	$MyTpe["serveur"]     = trim(Configuration::get('CMCIC_SERVEUR')); 

		$sVersion		= $MyTpe["version"];
		$sUrlOK			= $MyTpe["retourok"];
		$sUrlKO			= $MyTpe["retournok"];
		$sUrlpaiement = $MyTpe["serveur"];

  define ("MONETICOPAIEMENT_URLSERVER", $sUrlpaiement);	
  define ("MONETICOPAIEMENT_URLOK", $sUrlOK);
  define ("MONETICOPAIEMENT_URLKO", $sUrlKO);

	$MyTpe["tpe"] 		    	= Configuration::get('CMCIC_TPE');
	$MyTpe["codesociete"] 	= Configuration::get('CMCIC_CODESOCIETE');
	$MyTpe["cle"]           = Configuration::get('CMCIC_CLE');

require_once("MoneticoPaiement_Config.php");

// PHP implementation of RFC2104 hmac sha1 ---
require_once("MoneticoPaiement_Ept.inc.php");
  
	
} else {

	exit;
}

//Retour Banque
//------------------------------------------------------------------------------
// Begin Main : Retrieve Variables posted by Monetico Paiement Server
$MoneticoPaiement_bruteVars = getMethode();

// TPE init variables
$oEpt = new MoneticoPaiement_Ept();
$oHmac = new MoneticoPaiement_Hmac($oEpt);

function computeHmacSource($source, $oEpt)
{
  $anomalies = null;
  if( array_key_exists('TPE', $source) )
    $anomalies = $source["TPE"] != $oEpt->sNumero ? ":TPE" : null;
  if( array_key_exists('version', $source) )
    $anomalies .= $source["version"] == $oEpt->sVersion ? ":version" : null;

  // sole field to exclude from the MAC computation
  if( array_key_exists('MAC', $source) )
    unset($source['MAC']);
  else
    $anomalies .= ":MAC";

  if($anomalies != null)
    return "anomaly_detected" . $anomalies;

  // order by key is mandatory
  ksort($source);
  // map entries to "key=value" to match the target format
  array_walk($source, function(&$a, $b) { $a = "$b=$a"; });
  // join all entries using asterisk as separator
  return implode( '*', $source);
}

// Message Authentication
$MAC_source = computeHmacSource($MoneticoPaiement_bruteVars, $oEpt);
$computed_MAC = $oHmac->computeHmac($MAC_source);
$congruent_MAC = array_key_exists('MAC', $MoneticoPaiement_bruteVars) &&
  $computed_MAC == strtolower($MoneticoPaiement_bruteVars['MAC']);

if ($congruent_MAC) { 

//------------------------------------------------------------------------------

//Référence Panier Client//

function DecodePanier($ref){
	return (int)substr($ref,0,-7);
}

if( $MoneticoPaiement_bruteVars )
{$CMCIC_bruteVars = $MoneticoPaiement_bruteVars; }

$idcartrecup = DecodePanier($CMCIC_bruteVars['reference']);
$cart = new Cart($idcartrecup);

$MyTpe["langue"] = strtoupper(Language::getIsoById($cart->id_lang));

$sVersion		= $MyTpe["version"];
$sNumero		= $MyTpe["tpe"];	
$sCodeSociete	= $MyTpe["codesociete"];
$sLangue		= $MyTpe["langue"];
$sUrlOK			= $MyTpe["retourok"];
$sUrlKO			= $MyTpe["retournok"];
$sUrlpaiement	= $MyTpe["serveur"];

if( !isset($CMCIC_bruteVars['modepaiement']) )
	$CMCIC_bruteVars['modepaiement'] = '';
if( !isset($CMCIC_bruteVars['motifrefus']) )
	$CMCIC_bruteVars['motifrefus'] = '';
if( !isset($CMCIC_bruteVars['originecb']) )
	$CMCIC_bruteVars['originecb'] = '';
if( !isset($CMCIC_bruteVars['bincb']) )
	$CMCIC_bruteVars['bincb'] = '';
if( !isset($CMCIC_bruteVars['hpancb']) )
	$CMCIC_bruteVars['hpancb'] = '';
if( !isset($CMCIC_bruteVars['ipclient']) )
	$CMCIC_bruteVars['ipclient'] = '';
if( !isset($CMCIC_bruteVars['originetr']) )
	$CMCIC_bruteVars['originetr'] = '';
if( !isset($CMCIC_bruteVars['veres']) )
	$CMCIC_bruteVars['veres'] = '';
if( !isset($CMCIC_bruteVars['pares']) )
	$CMCIC_bruteVars['pares'] = '';
if( !isset($CMCIC_bruteVars['bincb']) )
	$CMCIC_bruteVars['bincb'] = '';
if( !isset($CMCIC_bruteVars['montantech']) )
	$CMCIC_bruteVars['montantech'] = '';
if( !isset($CMCIC_bruteVars['texte-libre']) )
	$CMCIC_bruteVars['texte-libre'] = '';
	
//------------------------------------------------------------------------------
                       
$code_retour = $CMCIC_bruteVars['code-retour'];
$texte_libre = $CMCIC_bruteVars['texte-libre'];
$ip_client = $CMCIC_bruteVars['ipclient'];
$transaction_id = $CMCIC_bruteVars['numauto'];

switch($CMCIC_bruteVars['brand']) {
case "AM" :
$brand = "American Express"; break ;
case "CB" : 
$brand = "Groupement CB"; break ;
case "MC" : 
$brand = "Mastercard"; break ;
case "VI" : 
$brand = "Visa"; break ;
case "na" : 
$brand = "Non disponible"; break ;
}

$_3ds_64 = base64_decode($CMCIC_bruteVars['authentification']);
$_3ds = json_decode($_3ds_64, true);
$status3ds = '';

switch($_3ds['status']) {
case "not_enrolled" :
$status3ds = "La transaction a été faite hors protocole 3DSecure \n\r"; $EI_Monetico->displayName = $EI_Monetico->displayName." (Non-3DS)"; break ;
case "authenticated" :
$status3ds = "La transaction a été faite selon le protocole 3DSecure v2 (DSP2). \n\r"; $EI_Monetico->displayName = $EI_Monetico->displayName." [3DSecure-V2]"; break ;
}

//    $id_cart = DecodePanier($CMCIC_bruteVars['reference']);
//    $cart = new Cart($id_cart);

$lgt = strlen($CMCIC_bruteVars['montant']);
$total = substr($CMCIC_bruteVars['montant'],'0',$lgt-3);
//$total_cart = $cart->getOrderTotal(true, 3); 
//echo $total_cart;

$transaction_id = $CMCIC_bruteVars['numauto'];
$validitee = substr($CMCIC_bruteVars['vld'],0,2)."-20".substr($CMCIC_bruteVars['vld'],2,2);
$validite = substr($CMCIC_bruteVars['vld'],0,2)." / 20".substr($CMCIC_bruteVars['vld'],2,2);
$date_trans = str_replace("_"," ",$CMCIC_bruteVars['date']);
$texte_libre = str_replace("_"," ",$texte_libre);
$pos_ip_client = strrpos($texte_libre,'-');
$ip_client = substr($texte_libre,$pos_ip_client + 1, '16');

$result = 
	"Montant = ".$total." Euro 
	 \n\rNo de TPE = ". $sNumero.
  "\n\rNo de transaction = ". $CMCIC_bruteVars['numauto'].
	"\n\rType de Carte = ". $brand .
	"\n\rMode Paiement = " .$CMCIC_bruteVars['modepaiement']	.	
	"\n\rDate transmission = ". $date_trans.
	"\n\rCode Retour = ".	$code_retour.
	"\n\rCryptogramme = " .$CMCIC_bruteVars['cvx'].
	"\n\rValidité = " .$validite.
	"\n\rNo de Panier = " .$CMCIC_bruteVars['reference'] .
	"\n\rPost: " . strtolower($computed_MAC).
	"\n\rRet. : " . $oHmac->computeHmac($MAC_source) . 
	"\n\rInfos : " .substr($texte_libre,'0',$pos_ip_client - 1).
	"\n\rIP Client : " .$ip_client.
	"\n\r" .	$status3ds ;

    $headers  = "Content-Transfer-Encoding: 8bit\r\n";
	  $headers .= "MIME-Version: 1.0\r\n";
//	  $headers .= "X-Mailer: Copyright (c) 2010 Hosteco.fr Agency\r\n"; 
 	  $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    $headers .= "From: Transaction Monetico Paiement<paiement@monetico.net>"; 	
    
    $sit = Configuration::get('PS_SHOP_NAME');
    $site = htmlentities($sit, NULL, 'utf-8');

      $id_cart = $idcartrecup;       	

			$test_ok = strstr(Configuration::get('CMCIC_SERVEUR'),"test");

      $resulte = "Transaction Monetico Paiement effectuée avec succès.\n\r".$result;	
      $resultb = '<br><br><b>Informations:</b><br>'.str_replace("\n\r","<br>",$resulte);	
      $results = str_replace("\n\r","<br>",$result);		
      
$sqlc = "SELECT * FROM "._DB_PREFIX_."cart WHERE id_cart ='".$id_cart."'";
if ($row = Db::getInstance()->getRow($sqlc))
$customer_id = $row['id_customer'];
$shop_id = $row['id_shop'];

$shop = new Shop($shop_id);

$cql = "SELECT email FROM "._DB_PREFIX_."customer WHERE id_customer ='".$customer_id."'";
if ($rowc = Db::getInstance()->getRow($cql))
$customer_email = $rowc['email'];   
$results .= "<br />Email Client = ".$customer_email;


	switch($CMCIC_bruteVars['code-retour']) {
		case "Annulation" :
			
			//Paiement refusé,pas de commande et retour panier//	
      		
          $mes_err =	"<font color=red><b><i>Le panier no $id_cart ($order_ref)est Refusé par le système Monetico Paiement sur <br></font>$site</i></b><p><small>$results</p>";
          mail("$email_notific","Transaction Refusée du Panier no $id_cart - ($order_ref) par Monetico Paiement sur $sit","$mes_err","$headers");	         
			break;

		case "payetest":	
    //Paiement accepté,en mode test//	
      if($test_ok){ 
      $result .= "\n\rMode TEST Activé";
      $mode_test = "<br><br><big><b>Transaction en Mode TEST</b></big>";
			//Paiement accepté en mode test,commande				
				
			$montant = number_format(floatval($CMCIC_bruteVars['montant']), 2, '.', '');

      $EI_Monetico->validateOrder(
      $idcartrecup, 
      '2', 
      $montant, 
      $EI_Monetico->displayName,
      '',
      '',
      (int)$cart->id_currency,
      false,
      $cart->secure_key,
      $shop
      );    
      
$sqlc = "SELECT * FROM "._DB_PREFIX_."orders WHERE id_cart ='".$id_cart."'";
if ($row = Db::getInstance()->getRow($sqlc)){
$order_id = $row['id_order'];     
$order_ref = $row['reference']; 
}

$sqlp = "UPDATE "._DB_PREFIX_."order_payment SET 
transaction_id = 'MODE TEST',
card_expiration = '".$validitee."',
card_brand = '".$brand."',
card_holder = '".$mode_test.$resultb."' 
WHERE order_reference ='".$order_ref."'";
Db::getInstance()->execute($sqlp);

          $mess_ok =	"<font color=green><b><i>La Commande no $order_id  ($order_ref) est validé par le système Monetico Paiement sur </font><br>$site</i><font color=red><br>En Mode Test</font></b><p><small>$results</p>";
          mail("$email_notific","Validation de la Commande no $order_id - ($order_ref) par Monetico Paiement sur $sit en mode Test","$mess_ok","$headers");	
	    }
			break;

		case "paiement":			
			//Paiement accepté, commande réel//
				
			$montant = number_format(floatval($CMCIC_bruteVars['montant']), 2, '.', '');

			$EI_Monetico->validateOrder(
      $idcartrecup, 
      '2',
      $montant, 
      $EI_Monetico->displayName,
      '',      
      '',
      (int)$cart->id_currency,
      false,
      $cart->secure_key,
      $shop
      );
      
$sqlc = "SELECT * FROM "._DB_PREFIX_."orders WHERE id_cart ='".$id_cart."'";
if ($row = Db::getInstance()->getRow($sqlc)){
$order_id = $row['id_order'];     
$order_ref = $row['reference']; 
}

$sqlp = "UPDATE "._DB_PREFIX_."order_payment SET 
transaction_id = '".$transaction_id."',
card_expiration = '".$validitee."',
card_brand = '".$brand."',
card_holder = '".$resultb."' 
WHERE order_reference ='".$order_ref."'";
Db::getInstance()->execute($sqlp);

          $mess_ok =	"<font color=green><b><i>La Commande no $order_id ($order_ref) est validé par le système Monetico Paiement sur </font><br>$site</i></b><p><small>$results</p>";
          mail("$email_notific","Validation de la Commande no $order_id - ($order_ref) par Monetico Paiement sur $sit","$mess_ok","$headers");	      
			break;		
	}
            //printf ("version=2\ncdr=0", "0");
          	//$receipt = CMCIC_CGI2_MACOK;
            $MACConfirmed ='O';  
}
else
{
	//La clé de sécurité est mauvaise//
	        //printf("version=2\ncdr=1", "1\n");
         	//$receipt = CMCIC_CGI2_MACNOTOK.$cgi2_fields;
          $MACConfirmed ='N';          
}

          //printf (CMCIC_CGI2_RECEIPT, $receipt);

/*
 Module de paiement Monetico DSP2 pour le CM-CIC Par hosteco.fr 2012-2019. 
*/

ob_end_clean();

?>
