<?php

if(!isset($MyTpe["cle"])) $MyTpe["cle"] = '';
if(!isset($MyTpe["cle4X"])) $MyTpe["cle4X"] = '';
if(!isset($MyTpe["tpe"])) $MyTpe["tpe"] = '';
if(!isset($MyTpe["tpe4X"])) $MyTpe["tpe4X"] = '';
if(!isset($MyTpe["version"])) $MyTpe["version"] = '';
if(!isset($MyTpe["serveur"])) $MyTpe["serveur"] = '';
if(!isset($MyTpe["serveur4X"])) $MyTpe["serveur4X"] = '';
if(!isset($MyTpe["codesociete"])) $MyTpe["codesociete"] = '';
if(!isset($MyTpe["codesociete4X"])) $MyTpe["codesociete4X"] = '';
if(!isset($MyTpe["retourok"])) $MyTpe["retourok"] = '';
if(!isset($MyTpe["retournok"])) $MyTpe["retournok"] = '';

define ("MONETICOPAIEMENT_KEY", $MyTpe["cle"]);
define ("MONETICOPAIEMENT_KEY_4x", $MyTpe["cle4X"]);
define ("MONETICOPAIEMENT_EPTNUMBER", $MyTpe["tpe"]);
define ("MONETICOPAIEMENT_EPTNUMBER_4x", $MyTpe["tpe4X"]);
define ("MONETICOPAIEMENT_VERSION", $MyTpe["version"]);
define ("MONETICOPAIEMENT_COMPANYCODE", $MyTpe["codesociete"]);
define ("MONETICOPAIEMENT_COMPANYCODE_4x", $MyTpe["codesociete4X"]);
define ("MONETICOPAIEMENT_URLSERVER_4x", $MyTpe["serveur4X"]);	

define ("MONETICOPAIEMENT_CTLHMAC", "V%s.sha1.php--[CtlHmac%s%s]-%s");
define ("MONETICOPAIEMENT_CTLHMACSTR", "CtlHmac%s%s");
define ("MONETICOPAIEMENT_PHASE2BACK_RECEIPT","version=2\ncdr=%s");
define ("MONETICOPAIEMENT_PHASE2BACK_MACOK","0");
define ("MONETICOPAIEMENT_PHASE2BACK_MACNOTOK","1\n");
define ("MONETICOPAIEMENT_URLPAYMENT", "paiement.cgi");

?>
