<?php 
class Customer extends CustomerCore { 
    /**
     * Add New Fields attribute to the Customer 
     */ 
    public $matricule;

    public $cgu;

    public $confidential;
     
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