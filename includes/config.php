<?php
//Sessions
ob_start();
session_start();

//-----------------------------------------------------
//SQL
//-----------------------------------------------------
require_once 'sql.php';
require_once 'functions.php';

//-----------------------------------------------------
//Paramètres du site
//-----------------------------------------------------
$SITENAME = 'ACS Groove';
$SITENAMELONG = 'monsupersitedemusique.fr';
$SITESLOGAN = 'La musique, c\'est magique !';
$SITEDESCRIPTION = 'Catalogue de musique...';
$SITEKEYWORD = 'musique,acs,catalogue,partage,échange,licence,license,medias,libre,free,opensource,gnu,téléchargement,download,upload,php,mysql,picture,video,mp3,mkv,avi,mpeg,gpl,creativecommons,cc,mit,apache,cecill,artlibre';

//-----------------------------------------------------
//MAIL
//-----------------------------------------------------
/*
define('SITEMAIL','contact@example.com');
define('SITEMAILPASSWORD','xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
define('SMTPHOST','mail.example.com');
define('SMTPPORT','587');
define('SITEOWNORNAME','John Doe');
define('SITEAUTOR','jdoe777');
define('SITEOWNORADDRESS','xxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
*/

$SITEAUTHORS = 'citizenz7, AuseQ, ya58';
$SITEVERSIONn = '1.0.0';
$SITEDATE = '17/08/20';
$COPYDATE = '2020';
$CHARSET = 'UTF-8';

//-----------------------------------------------------
//Website Settings
//-----------------------------------------------------

//Chemin complet pour le répertoire des images
//$REP_IMAGES = '/var/www/'.SITENAMELONG.'/web/images/';

//Paramètres pour le fichier torrent (upload.php)
//define('MAX_FILE_SIZE', 1048576); //Taille maxi en octets du fichier .torrent
$WIDTH_MAX = 500; //Largeur max de l'image en pixels
$HEIGHT_MAX = 500; //Hauteur max de l'image en pixels

//Paramètres pour l'icone de présentation du torrent (index.php, edit-post.php, ...)
$WIDTH_MAX_ICON = 150; //largeur maxi de l'icone de présentation dut orrent
$HEIGHT_MAX_ICON = 150; //Hauteur maxi de l'icone de présentation du torrent
$MAX_SIZE_ICON = 30725; //Taille max en octet de l'icone de présentation du torrent (30 Ko)

//Paramètres pour l'avatar membre (profile.php, edit-profil.php, ...)
$MAX_SIZE_AVATAR = 51200; //Taille max en octets du fichier (50 Ko)
$WIDTH_MAX_AVATAR = 200; //Largeur max de l'image en pixels
$HEIGHT_MAX_AVATAR = 200; //Hauteur max de l'image en pixels
$EXTENSIONS_VALIDES = array( 'jpg' , 'png' ); //extensions d'images valides
//$REP_IMAGES_AVATARS = '/var/www/'.SITENAMELONG.'/web/images/avatars/'; //Répertoires des images avatar des membres
?>
