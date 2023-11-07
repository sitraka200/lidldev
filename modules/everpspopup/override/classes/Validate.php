<?php
/**
 * Project : everpsproductnotification
 * @author Team Ever
 * @copyright Team Ever
 * @license   Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 * @link https://www.team-ever.com
 */

class Validate extends ValidateCore
{

    /**
     * Check if $string is a valid JSON string
     *
     * @param string $string JSON string to validate
     * @return bool Validity is ok or not
     */
    public static function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
