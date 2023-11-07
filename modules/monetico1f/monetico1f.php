<?php 
/*
 Module de paiement Monetico DSP2 pour le CM-CIC Par hosteco.fr 2012-2019. 
*/
use PrestaShop\PrestaShop\Core\Payment\PaymentOption;

define('__Monetico_Root__',(dirname(__FILE__)));

@ini_set('display_errors', 'off');

class Monetico1f extends PaymentModule
{
  protected $_html = '';
  protected $_postErrors = array();
  public  $cmcic_ver = '3.0';
    
  public function __construct(){
    $this->name = 'monetico1f';
    $this->tab = 'payments_gateways';
  	$this->author = 'Hosteco.fr';    
    $this->version = '1.7.0.11';

    parent::__construct();
    $this->page = basename(__FILE__, '.php');
    $this->displayName = $this->l('CB Monetico Payement x1');   
    $this->description = $this->l('Secure payment for Monetico system banks').
    '<br><a href="http://hosteco.fr/host/module_paiement_prestashop.php" target="_blank" title="Cliquez ici pour aller sur le site de l\'Editeur"><i class="icon-search"></i>&nbsp;En savoir plus</a>';   
    
    $this->confirmUninstall = $this->l('Are you sure to delete this module ?');

    $this->ps_versions_compliancy = array('min' => '1.7', 'max' => '1.8');  
//    $this->bootstrap = true;
//    $this->module_key = '';
    $this->is_eu_compatible = 1;
        
 		$this->currencies = true;
//		$this->currencies_mode = 'radio';  
    $this->currencies_mode = 'checkbox';		
		
    $shop_id = $this->context->shop->id;
    $shop_uri = $_SERVER['HTTP_HOST'];
    $shop_ql = "SELECT * FROM "._DB_PREFIX_."shop_url WHERE id_shop ='".$shop_id."'";
    if ($shop = Db::getInstance()->getRow($shop_ql))

$this->http = 'http://';
if(isset($_SERVER["SCRIPT_URI"])){if(substr($_SERVER["SCRIPT_URI"],0,5) == 'https') {$this->http = 'https://';}	else {$this->http = 'http://';}} 
if(isset($_SERVER['REQUEST_SCHEME'])){if(substr($_SERVER["REQUEST_SCHEME"],0,5) == 'https') {$this->http = 'https://';}	else {$this->http = 'http://';}} 

    $sql_e = "SELECT * FROM "._DB_PREFIX_."employee WHERE id_employee ='1'";
    if ($row_e = Db::getInstance()->getRow($sql_e))
    $this->email_admin = $row_e['email'];		

		$_SESSION['Version'] = Configuration::get('CMCIC_VERSION');
		$_SESSION['Cle'] = Configuration::get('CMCIC_CLE');
		$_SESSION['Numero'] = Configuration::get('CMCIC_TPE');
		$_SESSION['UrlPaiement'] = Configuration::get('CMCIC_SERVEUR');
		$_SESSION['CodeSociete'] = Configuration::get('CMCIC_CODESOCIETE');
		$_SESSION['Langue'] = 'FR';

  }

  public function install(){
    $sqlInstall = "ALTER TABLE " . _DB_PREFIX_ . "order_payment CHANGE card_holder card_holder VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL";
    if (!parent::install()
		OR !Configuration::updateValue('CMCIC_ACTIVE', 'on')
    OR !Configuration::updateValue('CMCIC_TPE', '12345678')
    OR !Configuration::updateValue('CMCIC_CLE', '0123456789ABCDEF0123456789ABCDEF01234567')
    OR !Configuration::updateValue('CMCIC_VERSION', $this->cmcic_ver)
    OR !Configuration::updateValue('CMCIC_SERVEUR', 'https://p.monetico-services.com/test/paiement.cgi')
    OR !Configuration::updateValue('CMCIC_CODESOCIETE', 'codesociete')
		OR !Configuration::updateValue('CMCIC_MONTANTMINI', '1.00')
		OR !Configuration::updateValue('CMCIC_EMAIL_NOTIFICATION', $this->email_admin)
		OR !Configuration::updateValue('CMCIC_IP_TEST', $_SERVER["REMOTE_ADDR"])  
		OR !Configuration::updateValue('CMCIC_IP_TEST_ACTIVE', '0')              
		OR !$this->registerHook('PaymentReturn')
		OR !$this->registerHook('paymentOptions')
		OR Db::getInstance()->execute($sqlInstall)
    ){
			return false;
		}
    return true;
  }

  public function uninstall(){
    if (!Configuration::deleteByName('CMCIC_ACTIVE')
		OR !Configuration::deleteByName('CMCIC_TPE')
    OR !Configuration::deleteByName('CMCIC_CLE')
    OR !Configuration::deleteByName('CMCIC_VERSION')
    OR !Configuration::deleteByName('CMCIC_SERVEUR')
    OR !Configuration::deleteByName('CMCIC_CODESOCIETE')
		OR !Configuration::deleteByName('CMCIC_MONTANTMINI')
		OR !Configuration::deleteByName('CMCIC_EMAIL_NOTIFICATION')     
		OR !Configuration::deleteByName('CMCIC_IP_TEST')	
		OR !Configuration::deleteByName('CMCIC_IP_TEST_ACTIVE')    	
    OR !parent::uninstall())
        return false;
    return true;
  }

  public function getContent()
  {
       	
	$this->display_entete();
	
	if (Tools::isSubmit('submitCmCic')){
	
		//Paiement en une fois début//
		
		if(Tools::getValue('CMCIC_ACTIVE')=='1'){
			if (!Tools::getValue('CMCIC_TPE')){
				$this->_postErrors[] = $this->l('TPE number is required');
			} else {
				Configuration::updateValue('CMCIC_TPE', Tools::getValue('CMCIC_TPE'));
			}
			if (!Tools::getValue('CMCIC_CLE')){
				$this->_postErrors[] = $this->l('HMAC key is required');
			} else {
				Configuration::updateValue('CMCIC_CLE', Tools::getValue('CMCIC_CLE'));
			}
			if (!Tools::getValue('CMCIC_CODESOCIETE')){
				$this->_postErrors[] = $this->l('Company code is required');
			} else {
				Configuration::updateValue('CMCIC_CODESOCIETE', Tools::getValue('CMCIC_CODESOCIETE'));
			}
		} else {
			Configuration::updateValue('CMCIC_TPE', Tools::getValue('CMCIC_TPE'));
			Configuration::updateValue('CMCIC_CLE', Tools::getValue('CMCIC_CLE'));
			Configuration::updateValue('CMCIC_CODESOCIETE', Tools::getValue('CMCIC_CODESOCIETE'));
		}
		
		//Paiement en une fois fin//

		//Autres paramètres de configuration//
		
		Configuration::updateValue('CMCIC_ACTIVE', Tools::getValue('CMCIC_ACTIVE'));
		Configuration::updateValue('CMCIC_SERVEUR', Tools::getValue('CMCIC_SERVEUR'));
		Configuration::updateValue('CMCIC_VERSION', Tools::getValue('CMCIC_VERSION'));
		Configuration::updateValue('CMCIC_MONTANTMINI', Tools::getValue('CMCIC_MONTANTMINI'));		
		Configuration::updateValue('CMCIC_EMAIL_NOTIFICATION', Tools::getValue('CMCIC_EMAIL_NOTIFICATION'));
		Configuration::updateValue('CMCIC_IP_TEST', Tools::getValue('CMCIC_IP_TEST'));
		Configuration::updateValue('CMCIC_IP_TEST_ACTIVE', Tools::getValue('CMCIC_IP_TEST_ACTIVE'));    			
        
		if($this->_postErrors){
			$this->displayErrors();
		} else {
			$this->displayConf();
		}


	}
	
    $this->_displayForm();
    return $this->_html;
 }
  
  public function displayConf()
  {
    $this->_html .= '
    <div class="conf confirm">
      <img src="../img/admin/ok.gif" alt="Confirmation" />
      '.$this->l('Settings Saved').'<br /><br />
    </div>';
  }
  
  public function displayErrors()
  {
    $nbErrors = sizeof($this->_postErrors);
    $this->_html .= '
    <div class="alert error">
      <h3>'.($nbErrors > 1 ? $this->l('There are') : $this->l('There is')).' '.$nbErrors.' '.($nbErrors > 1 ? $this->l('errors') : $this->l('error')).'</h3>
      <ol>';
    foreach ($this->_postErrors AS $error)
      $this->_html .= '<li>'.$error.'</li>';
    $this->_html .= '
      </ol><br /><br />
    </div>';
  }
  
  public function display_entete()
  {
    $this->_html .= '
	  <a style="float:right; margin-right:80px; margin-top:20px;" href="http://hosteco.fr/host/module_paiement_prestashop.php" target="_blank" title="Cliquez ici pour aller sur le site de l\'&eacute;diteur">
    <img src="../modules/monetico1f/img/HostEco_MHSE.png" height="60" /></a>      
    <img src="../modules/monetico1f/img/monetico-paiement.png" style="float:left; margin-right:15px;" />
    <img src="../modules/monetico1f/img/Compatible-1-7-Version.png" style="float:right; margin-right:50px;" />   

    <b><br /><br /><br /><br /><br />
    '.$this->l('This module allow you to accept payment with Monetico.').'<big>DSP2</big></b> (3D Secure v2 -3DSV2)<br />
  	'.$this->l('Banks available : CIC, Crédit Mutuel, OBC and Desjardins').'<br /><br />
    <br />
    ';
  }

  public function _displayForm(){   

	$conf = Configuration::getMultiple(array('CMCIC_ACTIVE', 'CMCIC_TPE', 'CMCIC_CLE', 'CMCIC_VERSION', 'CMCIC_SERVEUR', 
  'CMCIC_CODESOCIETE', 'CMCIC_MONTANTMINI','CMCIC_EMAIL_NOTIFICATION', 'CMCIC_IP_TEST', 'CMCIC_IP_TEST_ACTIVE'));

	$CMCIC_TPE = $conf['CMCIC_TPE'];
	$CMCIC_CODESOCIETE = $conf['CMCIC_CODESOCIETE'];

  	$urlmonettest = 'https://p.monetico-services.com/test/paiement.cgi';
    $urlmonetprod = 'https://p.monetico-services.com/paiement.cgi';
  	$urlcictest = 'https://ssl.paiement.cic-banques.fr/test/paiement.cgi';
    $urlcicprod = 'https://ssl.paiement.cic-banques.fr/paiement.cgi';
    $urlobctest = 'https://ssl.paiement.banque-obc.fr/test/paiement.cgi';
    $urlobcprod = 'https://ssl.paiement.banque-obc.fr/paiement.cgi';
    $urlcmtest  = 'https://paiement.creditmutuel.fr/test/paiement.cgi';
    $urlcmprod  = 'https://paiement.creditmutuel.fr/paiement.cgi';
    
    $file_instal = __Monetico_Root__."/aide_instal.php"; 
    $file_ccom4 = __Monetico_Root__."/cour_ccom4.php"; 

	$this->_html .= '
	
	<style type="text/css">  
	<!-- 
	
		ul.tabs {
			margin: 0;
			padding: 0;
			float: left;
			list-style: none;
			height: 32px; 
			border-bottom: 1px solid #999;
			border-left: 1px solid #999;
			width: 100%;			
		}
		ul.tabs li {
			float: left;
			margin: 0;
			padding: 0;
			width: 250px;
			height: 31px; 
			line-height: 31px; 
			border: 1px solid #999;
			border-left: none;
			margin-bottom: -1px; 
			overflow: hidden;
			position: relative;
			background: #eaeaf0;
		}
		ul.tabs li a {
			text-decoration: none;
			color: #0072aa;
			display: block;
			font-size: 1.4em;
			text-align: center;
			outline: none;	
		}
		ul.tabs li a:hover {
			background: #fffa67;
		}
		html ul.tabs li.active, html ul.tabs li.active a:hover  {
			background: #ffffee;
			border-bottom: 1px solid #fff; 
		}
	
	--> 
	</style> 
	
	<script type="text/javascript">
	
			$(document).ready(function() {
			
			$(".tab_content").hide();
			$("ul.tabs li:first").addClass("active").show();
			$(".tab_content:first").show();

			$("ul.tabs li").click(function() {

				$("ul.tabs li").removeClass("active");
				$(this).addClass("active");
				$(".tab_content").hide();

				var activeTab = $(this).find("a").attr("href");
				$(activeTab).fadeIn();
				return false;
			});

		});
	
	</script>
	
	
	<fieldset>
		<legend style="background: #d8f5a5"><img src="../img/admin/contact.gif" />'.$this->l('Settings and Parameters').'</legend>
		<form action="'.$_SERVER['REQUEST_URI'].'" method="Post">
		
		<ul class="tabs">
			<li>
				<a href="#TabConf_01">'.$this->l('Adjustment Payment in one time').'</a>
			</li>
           ';
			
    if(file_exists($file_instal)) {      
  	$this->_html .= '
			<li>
				<a href="#TabConf_03">'.$this->l('Help installation').'</a>
			</li>';
     }

    if(file_exists($file_ccom4)) {      
  	$this->_html .= '
			<li>
				<a href="#TabConf_04">'.$this->l('Email to Centrecom').'</a>
			</li>';
     }
     
	$this->_html .= '</ul>			
		<div style="border: 1px solid #999;border-top: none;overflow: hidden;clear: both;float: left; width: 100%;background: #ffffee;">

		<div id="TabConf_01" class="tab_content">
			<br /><br />
        <label>'.$this->l('Monetico version :').'</label>
			  <div class="margin-form">
			  <input type="hidden" name="CMCIC_VERSION" value="'.$this->cmcic_ver.'" />V '.$this->cmcic_ver.'
			  </div>
			  <br />			
			  <label>'.$this->l('Enable one time payment :').'</label>
			  <div class="margin-form">
			  <input type="checkbox" name="CMCIC_ACTIVE" value="on" '.((Tools::getValue('CMCIC_ACTIVE') or $conf['CMCIC_ACTIVE']) ? 'checked' : '').' />
			  </div>
			  <br />
			  <label>'.$this->l('TPE number :').'</label>
			  <div class="margin-form">
			  <input type="text" name="CMCIC_TPE" size=10 maxlength=8 value="'.((!Tools::getValue('CMCIC_TPE')) ? $conf['CMCIC_TPE'] : Tools::getValue('CMCIC_TPE')).'" />
			  <span>'.$this->l('Seven or eight carracters.').'</span>
			  </div>
			  <br />
			  <label>'.$this->l('Your Company code :').'</label>
			  <div class="margin-form">
			  <input type="text" name="CMCIC_CODESOCIETE" size=20 maxlength=42 value="'.((!Tools::getValue('CMCIC_CODESOCIETE')) ? $conf['CMCIC_CODESOCIETE'] : Tools::getValue('CMCIC_CODESOCIETE')).'" />
			  <span>'.$this->l('Has been given by CMCIC.').'</span>
			  </div>
			  <br />
			  <label>'.$this->l('Key control :').'</label>
			  <div class="margin-form">
			  <input type="text" name="CMCIC_CLE" size=60 maxlength=50 value="'.((!Tools::getValue('CMCIC_CLE')) ? $conf['CMCIC_CLE'] : Tools::getValue('CMCIC_CLE')).'" />
			  <span>'.$this->l('HMAC Key has been given by CMCIC.').'</span>
			  </div>
			  <br />
			  <label>'.$this->l('Minimum purchase :').'</label>
			  <div class="margin-form">
			  <input type="text" name="CMCIC_MONTANTMINI" size=10 maxlength=42 value="'.((!Tools::getValue('CMCIC_MONTANTMINI')) ? $conf['CMCIC_MONTANTMINI'] : Tools::getValue('CMCIC_MONTANTMINI') ).'" />
			  <span>'.$this->l('Total amnount for the customer.').'</span>
			  </div>
			  <br />			  
			  <label>'.$this->l('Your Bank agency :').'</label>
			  <div class="margin-form">
			  <input type="radio" name="CMCIC_SERVEUR" value="'.htmlentities($urlmonetprod).'" '.((Tools::getValue('CMCIC_SERVEUR')==htmlentities($urlmonetprod) or $conf['CMCIC_SERVEUR']==htmlentities($urlmonetprod)) ? ' checked' : '' ).'/> Monetico Production&nbsp;
			  <input type="radio" name="CMCIC_SERVEUR" value="'.htmlentities($urlmonettest).'" '.((Tools::getValue('CMCIC_SERVEUR')==htmlentities($urlmonettest) or $conf['CMCIC_SERVEUR']==htmlentities($urlmonettest)) ? ' checked' : '' ).'/> Monetico Test
			  </div>			  
			  <div class="margin-form">
			  <input type="radio" name="CMCIC_SERVEUR" value="'.htmlentities($urlcicprod).'" '.((Tools::getValue('CMCIC_SERVEUR')==htmlentities($urlcicprod) or $conf['CMCIC_SERVEUR']==htmlentities($urlcicprod)) ? ' checked' : '' ).'/> CIC Production&nbsp;
			  <input type="radio" name="CMCIC_SERVEUR" value="'.htmlentities($urlcictest).'" '.((Tools::getValue('CMCIC_SERVEUR')==htmlentities($urlcictest) or $conf['CMCIC_SERVEUR']==htmlentities($urlcictest)) ? ' checked' : '' ).'/> CIC Test
			  </div>
			  <div class="margin-form">
			  <input type="radio" name="CMCIC_SERVEUR" value="'.htmlentities($urlcmprod).'" '.((Tools::getValue('CMCIC_SERVEUR')==htmlentities($urlcmprod) or $conf['CMCIC_SERVEUR']==htmlentities($urlcmprod)) ? ' checked' : '' ).'/> Cr&eacute;dit Mutuel Production&nbsp;
			  <input type="radio" name="CMCIC_SERVEUR" value="'.htmlentities($urlcmtest).'" '.((Tools::getValue('CMCIC_SERVEUR')==htmlentities($urlcmtest) or $conf['CMCIC_SERVEUR']==htmlentities($urlcmtest)) ? ' checked' : '' ).'/> Cr&eacute;dit Mutuel Test
			  </div>
			  <div class="margin-form">
			  <input type="radio" name="CMCIC_SERVEUR" value="'.htmlentities($urlobcprod).'" '.((Tools::getValue('CMCIC_SERVEUR')==htmlentities($urlobcprod) or $conf['CMCIC_SERVEUR']==htmlentities($urlobcprod)) ? ' checked' : '' ).'/> OBC Production&nbsp;
			  <input type="radio" name="CMCIC_SERVEUR" value="'.htmlentities($urlobctest).'" '.((Tools::getValue('CMCIC_SERVEUR')==htmlentities($urlobctest) or $conf['CMCIC_SERVEUR']==htmlentities($urlobctest)) ? ' checked' : '' ).'/> OBC Test
			  </div>
        <br />
			  <label>'.$this->l('Your Email Notification :').'</label>
			  <div class="margin-form">
			  <input type="text" name="CMCIC_EMAIL_NOTIFICATION" size=20 maxlength=42 value="'.((!Tools::getValue('CMCIC_EMAIL_NOTIFICATION')) ? $conf['CMCIC_EMAIL_NOTIFICATION'] : Tools::getValue('CMCIC_EMAIL_NOTIFICATION')).'" />
			  </div>	
			  <br />
			  <label>'.$this->l('Management Test Mode :').'</label>
			  <div class="margin-form">
			  <input type="radio" name="CMCIC_IP_TEST_ACTIVE" value="0"'.((Tools::getValue('CMCIC_IP_TEST_ACTIVE')=="0" or $conf['CMCIC_IP_TEST_ACTIVE']=="0") ? ' checked' : '' ).'/>&nbsp;'.$this->l(' still Visible').'&nbsp;
			  <input type="radio" name="CMCIC_IP_TEST_ACTIVE" value="1"'.((Tools::getValue('CMCIC_IP_TEST_ACTIVE')=="1" or $conf['CMCIC_IP_TEST_ACTIVE']=="1") ? ' checked' : '' ).'/>&nbsp;'.$this->l(' Hidden (Visible with the IP below)').'
			  </div>
			  <br />
			  <label>'.$this->l('IP address for the Test Mode :').'</label>
			  <div class="margin-form">
			  <input type="text" name="CMCIC_IP_TEST" size=20 maxlength=42 value="'.((!Tools::getValue('CMCIC_IP_TEST')) ? $conf['CMCIC_IP_TEST'] : Tools::getValue('CMCIC_IP_TEST')).'" />
			  </div>	
			  <br />					  
  	</div>';
		
    if(file_exists($file_instal)) { include(_PS_MODULE_DIR_.$this->name.'/aide_instal.php'); }
    if(file_exists($file_ccom4)) {include(_PS_MODULE_DIR_.$this->name.'/cour_ccom4.php'); }		

	$this->_html .= '
			  <label>'.$this->l('Access Administration').'</label>
        <div class="margin-form">         
        <a href="https://www.monetico-services.com/fr/identification/login.cgi" target="_blank" title="'.$this->l('Click here to go to the back office').' Monetico"><b>'.$this->l('Merchant Dashboard').' Monetico</b></a>  
         &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
        <a href="https://www.cmcicpaiement.fr/fr/identification/identification.html" target="_blank" title="'.$this->l('Click here to go to the back office').' CM-CIC P@iement"><b>'.$this->l('Merchant Dashboard').' CM-CIC P@iement</b></a>  
        <br /><br />
			  </div>
			  <label><a href="http://hosteco.fr/host/module_paiement_prestashop.php" target="_blank">&copy; Hosteco.fr</a></label>&nbsp;&nbsp;&nbsp;&nbsp;
	      <small>'.$this->l('Payments for other modules you can contact').' : <a href="http://hosteco.fr/host/module_paiement_prestashop.php" target="_blank"  title="'.$this->l('Click here to go on the site of the editor').'"><b>hosteco.fr</b></a></small>
        <br /><br />';

	$this->_html .= '
 			  </div>
			<br />'.$this->l('Payment module').' Monetico - <i>'.$this->l('You must create first your ecommerce account with your bank. ').'</i>
		<center><input type="submit" name="submitCmCic" value="'.$this->l('Save').'" class="button" /></center>

		</div>
		
	</fieldset>
	</form>';

  }

  public function hookPaymentReturn($params) 
	{
		global $smarty;
		    		       
//print_r($params) ; 

$currency = new Currency($params['order']->id_currency);

//$total_to_pay = $params['order']->getOrdersTotalPaid();
//echo $params['order']->total_paid_real;

$shop_id = $params['order']->id_shop;
$shop = new Shop($shop_id);
$shop_name = $shop->name;

$lg_fact='';
$lang = $this->context->language;
//$lien_contact = 'contact-form.php';
if(strstr($_SERVER["REQUEST_URI"], '/fr/')) {$lien_contact = 'fr/nous-contacter';$lg_fact='fr/';}
if(strstr($_SERVER["REQUEST_URI"], '/en/')) {$lien_contact = 'en/contact-us';$lg_fact='en/';}
if(strstr($_SERVER["REQUEST_URI"], '/confirmation-commande?')) {$lien_contact = 'nous-contacter';}
if(strstr($_SERVER["REQUEST_URI"], '/order-confirmation?')) {$lien_contact = 'contact-us';}
/*if($lang->iso_code =='fr') {$lien_contact = 'fr/nous-contacter';$lg_fact='fr/';}
else {$lien_contact = 'en/contact-us';$lg_fact='en/';}
*/
$order_contact = $this->http.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.$lien_contact;

$lien_facture_pdf = $this->http.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.$lg_fact.'index.php?controller=pdf-invoice?id_order='.$params['order']->id;
$lien_img_pdf = $this->http.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/monetico1f/img/pdf.gif';

$order_total =  number_format($params['order']->total_paid_real, 2,',', '')." ".$currency->sign;
$order_payment = $params['order']->payment;
$order_ref = $params['order']->reference;
$order_id = $params['order']->id;

                $smarty->assign(array(
                   'lien_facture_pdf'  => $lien_facture_pdf,
                   'lien_img_pdf'  => $lien_img_pdf,
                   'shop_name'     => $shop_name,
                   'order_contact' => $order_contact,
                   'order_payment' => $order_payment,
                   'order_total'   => $order_total, 
                   'order_ref'     => $order_ref,                                    
                   'order_id'      => $order_id
                   	)); 

		return $smarty->fetch('module:'.$this->name.'/payment_return.tpl');
	}    

	//Gestion des dates d'échéances//
	
	public function gestion_dates($nb)
	{
		$date_next = array();
		$actual_month = (int)date("m");
//		$actual_month =  10;
		
		//Vérification date voulue//		
		$date_next['day'] 	= (int)date("d");		
		$date_next['month']	= $actual_month + $nb;
		$date_next['year']	= (int)date("Y");
		
		//Correction pour le changement d'année (mois > 12)// 				
		if( $date_next['month'] > 12 ){
			$date_next['month'] = $date_next['month'] - 12;
      $date_next['year'] = $date_next['year']+1;
		}   
      $date_next['day'] = sprintf("%'.02d", $date_next['day']);
      $date_next['month'] = sprintf("%'.02d", $date_next['month']);      
    
		//Vérification de la date//		
		if( checkdate($date_next['month'],$date_next['day'],$date_next['year']) == false )
			while( checkdate($date_next['month'],$date_next['day'],$date_next['year']) == false )
			{
				$date_next['day']--;
			}
		//Formatage//		
		return $date_next['day'].'/'.$date_next['month'].'/'.$date_next['year'];
	}

  public function Save_Order($idcartrecup, $state, $montant, $display_Name, $message, $info_tr, $cart_id_currency, $dont_touch_amount, $cart_secure_key, $shop){
  
parent::validateOrder(//			$this->validateOrder(
      $idcartrecup, 
      $state, 
      $montant, 
      $this->displayName,
      $message,  //vide pour v1.7   
      $info_tr,
      $cart_id_currency,
      $dont_touch_amount,
      $cart_secure_key,
      $shop
      );  
  
  }

  public function Payment_Monetico($params){

	global $smarty, $cookie, $cart;
	    
    $sit = Configuration::get('PS_SHOP_NAME');
    $site = htmlentities($sit, NULL, 'utf-8');

	//Variables générales//
	
  	$address 		= new Address((int)$cart->id_address_invoice);
    $customer 		= new Customer((int)$cart->id_customer);
    $id_currency 	= (int)$cart->id_currency;
    $currency 		= new Currency((int)$id_currency);
	
  	$cmcic_active	= (bool)Configuration::get('CMCIC_ACTIVE');
  	
$civilite_clt = '';
if($customer->id_gender =='1') $civilite_clt = 'MR';
if($customer->id_gender =='2') $civilite_clt = 'MME';

    $invoice = $address ;	
    $delivery = new Address((int)$cart->id_address_delivery);
  	//print_r($delivery);
  	
  	$id_billing_country = $invoice->id_country;
$sql_bc = "SELECT * FROM "._DB_PREFIX_."country WHERE id_country ='".$id_billing_country."'";
if ($row_bc = Db::getInstance()->getRow($sql_bc))
$billing_country = $row_bc['iso_code'];
$sql_sbc = "SELECT * FROM "._DB_PREFIX_."state WHERE id_state ='".$invoice->id_state."'";
if ($row_sbc = Db::getInstance()->getRow($sql_sbc)){
$billing_state = $row_sbc['name']; 
$billing_state = '"stateOrProvince" : "'.$billing_state.'",';}else{ $billing_state = '';}
  	
  	$id_shipping_country = $delivery->id_country;
$sql_sc = "SELECT * FROM "._DB_PREFIX_."country WHERE id_country ='".$id_shipping_country."'";
if ($row_sc = Db::getInstance()->getRow($sql_sc))
$shipping_country = $row_sc['iso_code'];
$sql_ssc = "SELECT * FROM "._DB_PREFIX_."state WHERE id_state ='".$delivery->id_state."'";
if ($row_ssc = Db::getInstance()->getRow($sql_ssc)){
$shipping_state = $row_ssc['name'];
$shipping_state = '"stateOrProvince" : "'.$shipping_state.'",';}else{ $shipping_state = '';}
  	
	function No_Accent($text) {
		$text = str_replace(
			array(
				'à','â','ä','á','ã','å', 'î','ï','ì','í', 'ô','ö','ò','ó','õ','ø', 'ù','û','ü','ú', 'é','è','ê','ë', 'ç', 'ÿ', 'ñ',
				'À','Â','Ä','Á','Ã','Å', 'Î','Ï','Ì','Í',	'Ô','Ö','Ò','Ó','Õ','Ø', 'Ù','Û','Ü','Ú', 'É','È','Ê','Ë', 'Ç', 'Ÿ', 'Ñ'),
			array(
				'a','a','a','a','a','a', 'i','i','i','i', 'o','o','o','o','o','o', 'u','u','u','u', 'e','e','e','e', 'c', 'y', 'n', 
				'A','A','A','A','A','A', 'I','I','I','I', 'O','O','O','O','O','O', 'U','U','U','U', 'E','E','E','E',	'C', 'Y', 'N'	),$text);
		return $text;
	}

  function Clean_string($chaine){ 
  $depart = '`!#$&%()*+,./:;<>=?@[]\_{}§£|~';
  $replac = '______________________________'; 
  $mt_propre = strtr($chaine,$depart,$replac);
  $mt_propre = str_replace('"', '',$mt_propre);
  $mt_propre = No_Accent($mt_propre);
  return $mt_propre;
  }  
  
  function Clean_Tel($num_tel) {
  if(!empty($num_tel)){ 
  $num_tel = str_replace(" ","", $num_tel);
  if(strstr(substr($num_tel,0,1),'+')) {
  if(strstr(substr($num_tel,3,1),'-')) {
  $tel_propre = $num_tel;
  }else{
  $tel_propre = '+'.substr($num_tel,1,2).'-'.substr($num_tel,3,14);
  }
  }else{
  $tel_propre = '+33-'.substr($num_tel,1,14);
  }}else{$tel_propre = '';} 
  return $tel_propre;
  }

$rawContexteCommand = '  	
{ "billing" : { 
"firstName" : "'.Clean_string($invoice->firstname).'", 
"lastName" : "'.Clean_string($invoice->lastname).'", 
"phone" : "'.Clean_Tel($invoice->phone).'", 
"mobilePhone" : "'.Clean_Tel($invoice->phone_mobile).'",
"addressLine1" : "'.Clean_string($invoice->address1).'",
"addressLine2" : "'.Clean_string($invoice->address2).'", 
"city" : "'.Clean_string($invoice->city).'", 
"postalCode" : "'.$invoice->postcode.'", 
'.$billing_state.'
"country" : "'.$billing_country.'" }, 

"shipping" : { 
"firstName" : "'.Clean_string($delivery->firstname).'", 
"lastName" : "'.Clean_string($delivery->lastname).'", 
"addressLine1" : "'.Clean_string($delivery->address1).'", 
"addressLine2" : "'.Clean_string($delivery->address2).'", 
"city" : "'.Clean_string($delivery->city).'", 
"postalCode" : "'.$delivery->postcode.'", 
'.$shipping_state.'
"country" : "'.$shipping_country.'", 
"email" : "'.$customer->email.'", 
"phone" : "'.Clean_Tel($delivery->phone).'",
"shipIndicator" : "other", 
"deliveryTimeframe" : "two_day", 
"firstUseDate" : "'.substr($delivery->date_upd,0,10).'", 
"matchBillingAddress" : true }, 

"client" : { 
"firstName" : "'.Clean_string($customer->firstname).'", 
"lastName" : "'.Clean_string($customer->lastname).'", 
"email" : "'.$customer->email.'" } 
} ';  	

//echo $rawContexteCommand;

$utf8ContexteCommande = utf8_encode( $rawContexteCommand );
$sContexteCommande = base64_encode( $utf8ContexteCommande );

	//Variables paiement une fois//
	
	if( $cmcic_active )
	{
		$MyTpe["tpe"]          = trim(Configuration::get('CMCIC_TPE'));
		$MyTpe["codesociete"]  = trim(Configuration::get('CMCIC_CODESOCIETE'));
		$MyTpe["cle"]          = trim(Configuration::get('CMCIC_CLE'));
		$MyTpe["serveur"]      = trim(Configuration::get('CMCIC_SERVEUR'));
		
		$MyTpe["tpe4X"]		    	= trim(Configuration::get('CMCIC4X_TPE'));
		$MyTpe["codesociete4X"] = trim(Configuration::get('CMCIC4X_CODESOCIETE'));
		$MyTpe["cle4X"]         = trim(Configuration::get('CMCIC4X_CLE'));
		$MyTpe["serveur4X"]	    = trim(Configuration::get('CMCIC4X_SERVEUR'));
		
		$sCodeSociete = $MyTpe["codesociete"];
		$sUrlpaiement = $MyTpe["serveur"];
		
		$test_ok = strstr($MyTpe["serveur"],"test");
    $nb_paiement = 'Simple';
    if($test_ok){
		$MyTpe["commentaire"] = "Hosteco_Test - Paiement ".$nb_paiement." - du Panier No ".$cart->id." sur ".$site." par ".$customer->email." - ".$_SERVER["REMOTE_ADDR"];
    } else {
		$MyTpe["commentaire"]  = "Paiement ".$nb_paiement." - du Panier No ".$cart->id." sur ".$site." par ".$customer->email." - ".$_SERVER["REMOTE_ADDR"];
       		}      
	}
	
    $MyTpe["commentaire"] = str_replace(" ","_",$MyTpe["commentaire"]);	  	

if (version_compare(_PS_VERSION_, '1.5', '>')) {   	
    $cart_details = $cart->getSummaryDetails(null, true);
    $monant_btq = $cart_details['total_price'];
} else {
    $monant_btq = Tools::convertPrice($params['cart']->getOrderTotal(true, 3), $currency);
}

    $lang_iso = Language::getIsoById(intval($cookie->id_lang));
    $lang_monetico = substr(strtoupper(Language::getLanguageCodeByIso($lang_iso)),0,2);
//    echo $lang_iso.'-'.$lang_monetico;

$lien_confirm = 'index.php?controller=order-confirmation';
if(strstr($_SERVER["REQUEST_URI"], '/fr/')) {$lien_confirm = 'fr/confirmation-commande';}
if(strstr($_SERVER["REQUEST_URI"], '/en/')) {$lien_confirm = 'en/order-confirmation';}
if($_SERVER["REQUEST_URI"]  == '/commande') {$lien_confirm = 'confirmation-commande';}
if($_SERVER["REQUEST_URI"] == '/order') {$lien_confirm = 'order-confirmation';}
if(__PS_BASE_URI__ != '/') {$lien_order = str_replace(__PS_BASE_URI__,'',$_SERVER["REQUEST_URI"]);}
else {$lien_order = substr($_SERVER["REQUEST_URI"],1,30);} 
/*
echo $lien_order;
echo '<br>';
echo __PS_BASE_URI__;
*/
	//Paramètres généraux si un des deux type de paiement est activé//
	if( $cmcic_active )
	{
		$MyTpe["retourok"]     = $this->http.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.$lien_confirm.'?id_cart='.$cart->id.'&id_module='.$this->id.'&key='.$customer->secure_key;
		$MyTpe["retournok"]    = $this->http.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.$lien_order;
		$MyTpe["reference"]    = $cart->id." - ".date("si");
		$MyTpe["devise"]       = strtoupper($currency->iso_code);

		$MyTpe["langue"]     = $lang_monetico;//strtoupper(Language::getIsoById(intval($cookie->id_lang)));
		$MyTpe["version"]	   = Configuration::get('CMCIC_VERSION');	
		$MyTpe["montant"]    = number_format($monant_btq, 2, '.', '');
		$MyTpe["submit"]	   = $this->l('Secure payment by credit card');
		$MyTpe["date"]		   = date("d/m/Y:H:i:s");
		$MyTpe["email"]		   = $customer->email;
		
		$sLangue		= $MyTpe["langue"];
		$sVersion		= $MyTpe["version"];
		$sUrlOK			= $MyTpe["retourok"];
		$sUrlKO			= $MyTpe["retournok"];
		$montant		= $MyTpe["montant"];
		$sDate      = $MyTpe["date"];
		$sEmail     = $MyTpe["email"];
		$sMontant   = $MyTpe["montant"];
		$sDevise    = $MyTpe["devise"];
		$sReference = $MyTpe["reference"];
		
    }
	  
	if( $cmcic_active )
	{
		//Clé paiement en une fois début//

define ("MONETICOPAIEMENT_URLSERVER", $sUrlpaiement);	
define ("MONETICOPAIEMENT_URLOK", $sUrlOK);
define ("MONETICOPAIEMENT_URLKO", $sUrlKO);
require_once("MoneticoPaiement_Config.php");

// PHP implementation of RFC2104 hmac sha1 ---
require_once("MoneticoPaiement_Ept.inc.php");

    	
$oEpt = new MoneticoPaiement_Ept($sLangue);
$oHmac = new MoneticoPaiement_Hmac($oEpt);

$sTexteLibre = HtmlEncode($MyTpe["commentaire"]);

$CtlHmac = sprintf(MONETICOPAIEMENT_CTLHMAC, MONETICOPAIEMENT_VERSION, $oEpt->sVersion, $oEpt->sNumero, $oHmac->computeHmac(sprintf(MONETICOPAIEMENT_CTLHMACSTR, $oEpt->sVersion, $oEpt->sNumero)));

// Data to certify
$Go_fields = implode(
  '*',
  [
    "TPE={$oEpt->sNumero}",
    "contexte_commande=$sContexteCommande",
    "date=$sDate",
    "dateech1=",
    "dateech2=",
    "dateech3=",
    "dateech4=",
    "lgue=$sLangue",
    "mail=$sEmail",
    "montant=$sMontant{$sDevise}",
    "montantech1=",
    "montantech2=",
    "montantech3=",
    "montantech4=",
    "nbrech=",
    "reference=$sReference",
    "societe={$oEpt->sCodeSociete}",
    "texte-libre=$sTexteLibre",
    "url_retour_err=$oEpt->sUrlKO",
    "url_retour_ok=$oEpt->sUrlOK",
    "version={$oEpt->sVersion}"
  ]
);

// MAC computation
$sMAC = $oHmac->computeHmac($Go_fields);			
	}
	
	if( $cmcic_active )
	{
		$smarty->assign('version',$sVersion);
		$smarty->assign('date',$MyTpe["date"]);
		$smarty->assign('devise',$MyTpe["devise"]);
		$smarty->assign('montant',$MyTpe["montant"]);
		$smarty->assign('reference',$MyTpe["reference"]);
		$smarty->assign('urlRetourNOK',$MyTpe["retournok"]);
		$smarty->assign('urlRetourOK',$MyTpe["retourok"]);
		$smarty->assign('langue',$MyTpe["langue"]);
		$smarty->assign('mail',$MyTpe["email"]);
	}
	
	$smarty->assign('activecomptant','off');
	//Paiement en une fois si activé//
		
	if( $cmcic_active )
	{
		$smarty->assign('activecomptant',Configuration::get('CMCIC_ACTIVE'));
		$smarty->assign('montant_mini',Configuration::get('CMCIC_MONTANTMINI'));		
		$smarty->assign('Serveur',$sUrlpaiement);
		$smarty->assign('tpe',$oEpt->sNumero);
		$smarty->assign('codesociete',$MyTpe["codesociete"]);
		$smarty->assign('Hmac',$sMAC);
		$smarty->assign('commentaire',$sTexteLibre);		
		$smarty->assign('sContexteCommande',$sContexteCommande);
	}
	
    $Monetico_tpl = $smarty->fetch('module:'.$this->name.'/monetico1f.tpl');

    return $Monetico_tpl;
}
//----------------------------------------------------------

    public function hookPaymentOptions($params){
  	global $cart; 
/*

        if (!$this->checkCurrency($params['cart'])) {
            return;
        }
*/

  $payment_options = '';
  
    $id_currency 	= (int)$cart->id_currency;
    $currency 		= new Currency((int)$id_currency);  
  
	$cmcic_active = (bool)Configuration::get('CMCIC_ACTIVE');
	$montant_mini = Configuration::get('CMCIC_MONTANTMINI');
  $montant = number_format(Tools::convertPrice($params['cart']->getOrderTotal(true, 3), $currency), 2, '.', '');

$active_ip = Configuration::get('CMCIC_IP_TEST_ACTIVE');
$monetico_ip = Configuration::get('CMCIC_IP_TEST'); 
$test_1f = strstr(Configuration::get('CMCIC_SERVEUR'),'test');
/*
echo $_SERVER["REMOTE_ADDR"].' - '.$cmcic_active.' - '.$active_ip.' - ';
echo $monetico_ip.' - '; echo $test_1f;
*/

if(
( $cmcic_active == 'on' && $active_ip == '1' && $monetico_ip == $_SERVER["REMOTE_ADDR"] && $test_1f != '' )
OR ( $cmcic_active == 'on' && $active_ip == '0' && $test_1f != '' )
OR ( $cmcic_active == 'on' && $test_1f == '' )
 )

{ 
if ($cmcic_active && $montant_mini<=$montant)  { 

$serveur_bank = Configuration::get('CMCIC_SERVEUR');

		if(strstr($serveur_bank,'cic')){
			$logo_Bank = "logocic.jpg";
		} elseif(strstr($serveur_bank,'creditmutuel')){
			$logo_Bank = "logocm.jpg";
		} elseif(strstr($serveur_bank,'obc')){
			$logo_Bank = "logoobc.jpg";
		} elseif(strstr($serveur_bank,'monetico')){
			$logo_Bank = "logomonetico.jpg";
		}	

        $newOption = new PaymentOption();
        $newOption->setModuleName($this->name)
          ->setLogo(Media::getMediaPath(_PS_MODULE_DIR_.$this->name.'/img/'.$logo_Bank))
          ->setCallToActionText($this->l('Pay by credit card '))
          ->setForm($this->Payment_Monetico($params))
          ->setAdditionalInformation($this->l('Pay by credit card (CB, VISA, MASTERCARD, ...)'))
                ;   
 $payment_options = [ $newOption ]; 
 
   } else { $payment_options1 = ''; } 
               
   return $payment_options;    
    }   
    
	}

}
/*
 Module de paiement Monetico pour le CM-CIC Par hosteco.fr 2012-2019. 
*/
?>
