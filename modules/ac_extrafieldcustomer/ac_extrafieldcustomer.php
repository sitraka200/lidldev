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

use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Type;

use Doctrine\DBAL\Query\QueryBuilder;
use PrestaShop\PrestaShop\Core\Search\Filters\CustomerFilters;

// même nom que le fichier du module en Camel_Case
class Ac_ExtraFieldCustomer extends Module {
 
 	/**
 	 * Constructeur de la classe
 	 */
    public function __construct() {
 
 		// Nom du module / identifiant interne (même nom que le dossier du module)
        $this->name = 'ac_extrafieldcustomer';
        // Onglet dans lequel afficher le module dans la liste des modules installés
        $this->tab = 'others';
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
        $this->displayName = $this->l('Ac Extra Field Customer');
        // Description affichée dans la liste des modules
        $this->description = $this->l('Add new fields to customer');

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
               // Install Sql du module
                || !$this->_installSql() 
                //Hooks Admin
                // || !$this->registerHook('actionAdminCustomersFormModifier')
                || !$this->registerHook('actionCustomerGridDefinitionModifier')
                || !$this->registerHook('actionCustomerGridQueryBuilderModifier')
                || !$this->registerHook('actionCustomerFormBuilderModifier')
                || !$this->registerHook('actionAfterUpdateCustomerFormHandler')
                || !$this->registerHook('actionAfterCreateCustomerFormHandler')
                //Hooks Front        
                || !$this->registerHook('actionCustomerAccountAdd')
                //Hooks objects 
                || !$this->registerHook('actionObjectCustomerAddAfter') 
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
        return parent::uninstall() && $this->_unInstallSql();
    }
 
    /**
     * Modifications sql du module
     * @return boolean
     */
    protected function _installSql() {
        /**
         * Check if column already exist
         */
        $sql_column_check = "SELECT column_name FROM information_schema.columns WHERE TABLE_NAME = '" . _DB_PREFIX_ . "customer' and column_name = 'matricule'";
        $sql_column_check2 = "SELECT column_name FROM information_schema.columns WHERE TABLE_NAME = '" . _DB_PREFIX_ . "customer' and column_name = 'cgu'";
        $sql_column_check3 = "SELECT column_name FROM information_schema.columns WHERE TABLE_NAME = '" . _DB_PREFIX_ . "customer' and column_name = 'confidential'";

        $check1 = Db::getInstance()->getValue($sql_column_check);
        $check2 = Db::getInstance()->getValue($sql_column_check2);
        $check3 = Db::getInstance()->getValue($sql_column_check3);

        // $pre = var_export($results, true);

        // file_put_contents('file.txt', $pre);

        // $result = false if column not found else $result = 'matricule'
        $result1 = true;
        if (!$check1) {
            $sqlInstall = "ALTER TABLE " . _DB_PREFIX_ . "customer "
                . "ADD matricule VARCHAR(255) NULL";
     
            $result1 =  Db::getInstance()->execute($sqlInstall);
        }
        $result2 = true;
        if (!$check2) {
            $sqlInstall2 = "ALTER TABLE " . _DB_PREFIX_ . "customer "
                . "ADD cgu tinyint(1) unsigned NOT NULL DEFAULT 0";
     
            $result2 =  Db::getInstance()->execute($sqlInstall2);
        }
        $result3 = true;
        if (!$check3) {
            $sqlInstall3 = "ALTER TABLE " . _DB_PREFIX_ . "customer "
                . "ADD confidential tinyint(1) unsigned NOT NULL DEFAULT 0";
     
            $result3 =  Db::getInstance()->execute($sqlInstall3);
        }

        return $result1 && $result2 && $result3;
    }
 
    /**
     * Suppression des modification sql du module
     * @return boolean
     */
    protected function _unInstallSql() {
        /**
         * Check if column exist
         */
        // $sql_column_check = "SELECT column_name FROM information_schema.columns WHERE TABLE_NAME = '" . _DB_PREFIX_ . "customer' and column_name = 'matricule'";

        // $result = Db::getInstance()->getValue($sql_column_check);

        // if ($result) {
        //     $sqlUnInstall = "ALTER TABLE " . _DB_PREFIX_ . "customer "
        //         . "DROP matricule";
 
        //     return Db::getInstance()->execute($sqlUnInstall);
        // }

        return true;
    }
 
    /**
     * Modification du formulaire d'édition d'un client en BO
     * @param type $params
     */
    // public function hookActionAdminCustomersFormModifier($params) {
 
    //     $params['fields'][0]['form']['input'][] = [
    //         'type' => 'text',
    //         'label' => $this->l('Matricule Number'),
    //         'name' => 'matricule',
    //         'class' => 'input fixed-width-xxl',
    //         'hint' => $this->l('Matricule number')
    //     ];
 
    //     //Définition de la valeur du champ supplémentaire
    //     $params['fields_value']['matricule'] = $params['object']->matricule;
    // }

    public function hookActionCustomerAccountAdd($params)
    {
        // création via admin dia tsy midéclenche
        $new_customer = $params['newCustomer'];

        // Check if property exist 
      //   if (property_exists($new_customer, 'matricule')) {
	    	// $num0 = time();
	     //    $num1 = mt_rand(100000,999999);
	     //    $random_matricule = $num0 . $num1;

	     //    // Save random matricule
	     //    $new_customer->matricule = $random_matricule;
	     //    $new_customer->update();
      //   }
    }

    /**
     * Enregistrement du matricule à la création du compte
     * @param type $params
     */
    public function hookActionObjectCustomerAddAfter($params) {
        // $pre = var_export($params, true);

        // file_put_contents('file.txt', $pre);

        // $ssss = $this->context->controller->php_self . ' - ';

        // file_put_contents('file.txt', $ssss, FILE_APPEND);

        // $ssss = get_class($this->context->controller) . ' - ';

        // file_put_contents('file.txt', $ssss, FILE_APPEND);

        if (
                $this->context->controller->php_self == 'authentication'
                || $this->context->controller instanceof AdminCustomersController
            ) {

            $num0 = time();
            $num1 = mt_rand(100000,999999); 
            
            $random_matricule = $num0 . ' ' .  $num1;

            $params['object']->matricule = $random_matricule;
            try {
                $params['object']->save();
            } catch (Exception $ex) {
                PrestaShopLogger::addLog($this->l('Error in customer in module ' . $this->name));
            }
        }
    }

    public function hookActionAdminCustomersListingFieldsModifier($params)
    {
        $pre = var_export($params, true);

        file_put_contents('file.txt', $pre);

        $ssss = $this->context->controller->php_self . ' - ';

        file_put_contents('file.txt', $ssss, FILE_APPEND);

        $ssss = get_class($this->context->controller) . ' - ';

        file_put_contents('file.txt', $ssss, FILE_APPEND);

        if (isset($params['select'])) {
            //get data
            $params['select'] .= ', a.matricule as matricule';
            //add new column in list
            $params['fields']['matricule'] = array(
                'title' => $this->trans('Matricule', array(), 'Admin.Global'),
                'align' => 'text-center',
                'class' => 'fixed-width-xs',
                'search' => true,
                'havingFilter' => true,
                'filter_key' => 'a!matricule'
            );
        }

        //Suppression des champs "Titre"
        unset($params['fields']['title']);
    }

    /**
     * MODERN PAGE HOOK FOR CUSTOMER ADMIN PAGE
     * Hooks allows to modify Customer grid definition.
     * This hook is a right place to add/remove columns or actions (bulk, grid).
     *
     * @param array $params
     */
    public function hookActionCustomerGridDefinitionModifier(array $params)
    {
        /** @var GridDefinitionInterface $definition */
        $definition = $params['definition'];

        /** @var ColumnCollection */
        $columns = $definition->getColumns();

        /**
         * All column matricule to grid
         */
        $columns
            ->addBefore(
                'actions',
                (new DataColumn('matricule'))
                ->setName($this->trans('Matricule number', [], 'Admin.Global'))
                ->setOptions([
                    'field' => 'matricule',
                ])
            );

        /** @var FilterCollection $filters */
        $filters = $definition->getFilters();

        /**
         * Filter by matricule
         */
        $filters
            ->add(
                (new Filter('matricule', TextType::class))
                ->setTypeOptions([
                    'attr' => [
                        'placeholder' => $this->trans('Search matricule', [], 'Admin.Actions'),
                    ],
                    'required' => false,
                ])
                ->setAssociatedColumn('matricule')
            );
    }

    /**
     * Hook allows to modify Customers query builder and add custom sql statements.
     *
     * @param array $params
     */
    public function hookActionCustomerGridQueryBuilderModifier(array $params)
    {
        /** @var QueryBuilder $searchQueryBuilder */
        $searchQueryBuilder = $params['search_query_builder'];

        /** @var CustomerFilters $searchCriteria */
        $searchCriteria = $params['search_criteria'];

        $searchQueryBuilder->addSelect('c.matricule');

        if ('matricule' === $searchCriteria->getOrderBy()) {
            $searchQueryBuilder->orderBy('c.matricule', $searchCriteria->getOrderWay());
        }

        foreach ($searchCriteria->getFilters() as $filterName => $filterValue) {
            if ('matricule' === $filterName) {
                $searchQueryBuilder->andWhere('c.matricule = :filterValue');
                $searchQueryBuilder->setParameter('filterValue', $filterValue);

                if (!$filterValue) {
                    $searchQueryBuilder->orWhere('c.matricule IS NULL');
                }
            }
        }
    }

    /**
     * Hook adding new form field to customer form

     * @param array $params
     */
    public function hookActionCustomerFormBuilderModifier(array $params)
    {
        // $ssss = $this->context->controller->php_self . ' - ';

        // file_put_contents('file.txt', $ssss);

        // $ssss = get_class($this->context->controller) . ' - ';

        // file_put_contents('file.txt', $ssss, FILE_APPEND);

        /** @var FormBuilderInterface $formBuilder */
        $formBuilder = $params['form_builder'];
        $formBuilder
            ->add('matricule', TextType::class, [
                'label' => $this->getTranslator()->trans('Matricule number', [], 'Modules.Ac_ExtraFieldCustomer'),
                'required' => true,
                'constraints' => [
                    new Type([
                        'type' => 'alnum',
                        'message' => $this->trans('This field is invalid', [], 'Admin.Notifications.Error'),
                    ]),
                ],
            ]);

        $customerId = $params['id'];

        $customer = new Customer((int)$customerId);

        /**
         * Use validate in case of edit action not new action thus $customer is null when creating
         */
        if (Validate::isLoadedObject($customer)) {
            $params['data']['matricule'] = $customer->matricule;
            // Enregistrer les données du formulaire dans formBuilder pour pouvoir les afficher dans l'interface
            $formBuilder->setData($params['data']);
        }

    }

    public function hookActionAfterUpdateCustomerFormHandler(array $params)
    {
        $this->updateCustomerMatricule($params);
    }

    public function hookActionAfterCreateCustomerFormHandler(array $params)
    {
        $this->updateCustomerMatricule($params);
    }

    private function updateCustomerMatricule(array $params)
    {
        $customerId = $params['id'];
        /** @var array $customerFormData */
        $customerFormData = $params['form_data'];
        $matricule = $customerFormData['matricule'];
        
        $customer = new Customer((int)$customerId);

        if (Validate::isLoadedObject($customer)) {
            $customer->matricule = $matricule;
            $customer->update();
        }
    }
}
