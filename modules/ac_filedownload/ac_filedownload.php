<?php
/**
* Ac Extra field for customer
*
* Do not edit or add to this file.
* You are not authorized to modify, copy or redistribute this file.
* Permissions are reserved by FME Modules.
*
*  @author    Francois Mickael RAKOTONIRINA
*  @copyright 2019 Avinconcept Modules All right reserved
*  @license   Copyrights Avinconcept
*  @category  Avinconcept
*  @package   Ac_ExtraFieldCustomer
*/

// Vérifie que le module est bien exécuté au sein de Prestashop
// en contrôlant que la constante _PS_VERSION est définie
if (!defined('_PS_VERSION_')) {
    exit;
}
// même nom que le fichier du module en Camel_Case
class Ac_FileDownload extends Module {
 
 	/**
 	 * Constructeur de la classe
 	 */
    public function __construct() {
 
 		// Nom du module / identifiant interne (même nom que le dossier du module)
        $this->name = 'ac_filedownload';
        // Onglet dans lequel afficher le module dans la liste des modules installés
        $this->tab = 'front_office_features';
        // Version du module
        $this->version = '1.0.0';
        // Auteur
        $this->author = 'AvinConcept';
        // Indique s'il faut ou non créé une instance du module lors du chargement
	    // de la liste des modules de Prestashop
        $this->need_instance = 0;
        // Défini avec quelle version de Prestashop le module est compatible
        $this->ps_versions_compliancy = [
            'min' => '1.7.1',
            'max' => _PS_VERSION_
        ];
        // Indique s'il faut utiliser le système de rendu Bootstrap pour ce module
        $this->bootstrap = true;
 
 		// Exécute la méthode __construct de la classe parente 'Module'
        parent::__construct();
 
 		// Nom affiché dans la liste des modules
        $this->displayName = $this->l('Ac File Download');
        // Description affichée dans la liste des modules
        $this->description = $this->l('donwload attachements in front');

        // Texte de confirmation optionnel à la désinstallation
        $this->confirmUninstall = $this->l('Are you sure to uninstall this module?');

        // Permet de vérifier si la variable définie plus tard dans l'administration
        // est définie ou non. Si ce n'est pas le cas, affiche un avertissement
        // if (!Configuration::get('NS_MONMODULE_PAGENAME')) {
        //     $this->warning = $this->l('Aucun nom fourni');
        // }
    }
 
    /**
     * Installation du module
     * @return boolean
     */
    public function install() {

    	// Vérifie si le mode multi-boutique de Prestashop 1.7 est activé
	    if (Shop::isFeatureActive()) {
	    	// Si oui, défini le contexte pour appliquer l’installation à toutes les boutiques	
	        Shop::setContext(Shop::CONTEXT_ALL);
	    }

	    // Lance l'installation qui va :
	    // - Installer le module en exécutant la méthode install de la classe parente
	    // - Exécuter les méthodes d'enregistrement des hooks
	    // - Et ajouter la valeur NS_MONMODULE_PAGENAME à la base de données
	    // Et récupère le résultat de toutes ces actions, si l'une d'entre elles échoue
	    // en renvoyant 'false', cela indique que l'installation a échouée

        if (!parent::install() 
                //Hooks Admin
                || !$this->registerHook('actionAdminCustomersControllerSaveAfter') 
                || !$this->registerHook('actionAdminCustomersFormModifier')
                //Hooks Front        
                || !$this->registerHook('displayAttachementsGridListing')
                //Hooks objects 
                || !$this->registerHook('actionObjectCustomerAddAfter') 
                || !$this->registerHook('actionObjectCustomerUpdateAfter')
                //Hook validation des champs
                || !$this->registerHook('validateCustomerFormFields') 
        ) {
            return false;
        }
 
        return true;
    }
 
    /**
     * Désinstallation du module
     * @return boolean
     */
    public function uninstall() {
        return parent::uninstall();
    }

    public function hookDisplayAttachementsGridListing($params)
    {
        if (!$this->isCached('ac_filedownload.tpl', $this->getCacheId('ac_filedownload'))) {
            $attachments = Attachment::getAllAttachments($this->context->language->id);

            $this->smarty->assign(array(
                'attachments' => $attachments
            ));
        }
        return $this->display(__FILE__, 'ac_filedownload.tpl', $this->getCacheId('ac_filedownload'));
    }

}