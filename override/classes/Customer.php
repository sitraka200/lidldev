<?php 
class Customer extends CustomerCore { 
    /**
     * Add New Fields attribute to the Customer 
     */ 
    /*
    * module: ac_extrafieldcustomer
    * date: 2019-09-19 19:30:38
    * version: 1.0.0
    */
    public $matricule;
    /*
    * module: ac_extrafieldcustomer
    * date: 2019-09-19 19:30:38
    * version: 1.0.0
    */
    public $cgu;
    /*
    * module: ac_extrafieldcustomer
    * date: 2019-09-19 19:30:38
    * version: 1.0.0
    */
    public $confidential;
     
    /*
    * module: ac_extrafieldcustomer
    * date: 2019-09-19 19:30:38
    * version: 1.0.0
    */
    public function __construct($id = null) { 
        /**
         * Definition of the new field
         */ 
        self::$definition['fields']['matricule'] = [ 'type' => self::TYPE_STRING,
            'required' => false, 'size' => 255
        ];
        self::$definition['fields']['cgu'] = ['type' => self::TYPE_BOOL, 'validate' => 'isBool'];
        self::$definition['fields']['confidential'] = ['type' => self::TYPE_BOOL, 'validate' => 'isBool'];
        
        parent::__construct($id);
    }
}