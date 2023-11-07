<?php
/**
 * Project : everpspopup
 * @author Team Ever
 * @copyright Team Ever
 * @license   Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 * @link https://www.team-ever.com
 */

class EverPsPopupClass extends ObjectModel
{
    public $id_everpspopup;
    public $id_shop;
    public $unlogged;
    public $newsletter;
    public $bgcolor;
    public $controller_array;
    public $categories;
    public $name;
    public $content;
    public $link;
    public $cookie_time;
    public $adult_mode;
    public $delay;
    public $date_start;
    public $date_end;
    public $active;
    public $id_lang;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'everpspopup',
        'primary' => 'id_everpspopup',
        'multilang' => true,
        'fields' => array(
            'id_shop' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isunsignedInt',
                'required' => true
            ),
            'unlogged' => array(
                'type' => self::TYPE_INT,
                'lang' => false,
                'validate' => 'isBool',
                'required' => false
            ),
            'newsletter' => array(
                'type' => self::TYPE_INT,
                'lang' => false,
                'validate' => 'isBool',
                'required' => false
            ),
            'bgcolor' => array(
                'type' => self::TYPE_STRING,
                'lang' => false,
                'validate' => 'isColor',
                'required' => false
            ),
            'controller_array' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isunsignedInt',
                'required' => false
            ),
            'categories' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isJson',
                'required' => false
            ),
            'name' => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isGenericName'
            ),
            'link' => array(
                'type' => self::TYPE_STRING,
                'lang' => true,
                'validate' => 'isUrl'
            ),
            'cookie_time' => array(
                'type' => self::TYPE_INT,
                'lang' => false,
                'validate' => 'isUnsignedId',
                'required' => true
            ),
            'adult_mode' => array(
                'type' => self::TYPE_INT,
                'lang' => false,
                'validate' => 'isBool',
                'required' => false
            ),
            'delay' => array(
                'type' => self::TYPE_INT,
                'lang' => false,
                'validate' => 'isUnsignedId',
                'required' => false
            ),
            'date_start' => array(
                'type' => self::TYPE_DATE,
                'lang' => false,
                'validate' => 'isDateFormat',
                'required' => false
            ),
            'date_end' => array(
                'type' => self::TYPE_DATE,
                'lang' => false,
                'validate' => 'isDateFormat',
                'required' => false
            ),
            'active' => array(
                'type' => self::TYPE_INT,
                'lang' => false,
                'validate' =>'isBool',
                'required' => false
            ),
            // lang fields
            'content' => array(
                'type' => self::TYPE_HTML,
                'lang' => true,
                'validate' => 'isCleanHtml'
            ),
        )
    );

    public function getPopup($id_shop, $id_lang)
    {
        if (!(int)$id_shop) {
            $id_shop = (int)$this->context->shop->id;
        }
        $sql = new DbQuery;
        $sql->select('*');
        $sql->from('everpspopup', 'ep');
        $sql->leftJoin(
            'everpspopup_lang',
            'epl',
            'ep.id_everpspopup = epl.id_everpspopup'
        );
        $sql->where('ep.active = 1');
        $sql->where('epl.id_lang = '.(int)$id_lang);

        return new self(
            (int)Db::getInstance()->getValue($sql),
            (int)$id_lang,
            (int)$id_shop
        );
    }
}
