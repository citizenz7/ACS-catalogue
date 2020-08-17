<?php
function html($string) {
    //return htmlspecialchars($string, REPLACE_FLAGS, CHARSET);
    return htmlspecialchars($string, ENT_COMPAT, 'UTF-8', true);
}

function date_fr($format, $timestamp=false) {
	if (!$timestamp) $date_en = date($format);
	else $date_en = date($format,$timestamp);

	$texte_en = array(
		"Monday", "Tuesday", "Wednesday", "Thursday",
		"Friday", "Saturday", "Sunday", "January",
		"February", "March", "April", "May",
		"June", "July", "August", "September",
		"October", "November", "December"
	);
	$texte_fr = array(
		"lundi", "mardi", "mercredi", "jeudi",
		"vendredi", "samedi", "dimanche", "janvier",
		"f&eacute;vrier", "mars", "avril", "mai",
		"juin", "juillet", "ao&ucirc;t", "septembre",
		"octobre", "novembre", "d&eacute;cembre"
	);
	$date_fr = str_replace($texte_en, $texte_fr, $date_en);

	$texte_en = array(
		"Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun",
		"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul",
		"Aug", "Sep", "Oct", "Nov", "Dec"
	);
	$texte_fr = array(
		"Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim",
		"Jan", "F&eacute;v", "Mar", "Avr", "Mai", "Jui",
		"Jui", "Ao&ucirc;", "Sep", "Oct", "Nov", "D&eacute;c"
	);
	$date_fr = str_replace($texte_en, $texte_fr, $date_fr);

	return $date_fr;
}


// ---------------------------------------------------------------------
//  Générer un mot de passe aléatoire
// ---------------------------------------------------------------------
function fct_passwd( $chrs = "")
{
   if( $chrs == "" ) $chrs = 10;
   $chaine = "";

   $list = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghkmnpqrstuvwxyz!=$";
   mt_srand((double)microtime()*1000000);
   $newstring="";

   while( strlen( $newstring )< $chrs ) {
   $newstring .= $list[mt_rand(0, strlen($list)-1)];
   }
   return $newstring;
 }

function get_extension($nom) {
    $nom = explode(".", $nom);
    $nb = count($nom);
    return strtolower($nom[$nb-1]);
}
