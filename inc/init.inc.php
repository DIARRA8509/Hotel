<?php
/*
Ce fichier sera inclus dans TOUS les scripts du site (hors les fichiers inc eux-m�mes) pour initialiser les �l�ments suivants :
- connexion � la BDD
- cr�ation ou ouverture de session
- d�finir le chemin (url) du site comme dans les CMS
- et inclure le fichier fonction.inc.php syst�matiquement dans tous les scripts
*/

// Connexion � la BDD :
$mysqli = new Mysqli('localhost', 'root', '', 'diw36_entreprise');
if ($mysqli->connect_error) die('Un probl�me est survenu lors de la tentative de connexion � la BDD : ' . $mysqli->connect_error);

$mysqli->set_charset("utf8");  // force les transactions avec la BDD en utf-8


// Session :
session_start();

// Chemin du site :
define('RACINE_SITE', '/11-site/'); // on d�finit le chemin de la racine du site pour pouvoir �tablir des url de fichiers en chemin absolu que l'on soit dans un template admin ou front

// D�claration de variables d'affichage de contenus :
$contenu = '';
$contenu_gauche = '';
$contenu_droite = '';

// Autre inclusion n�cessaire � tous les scripts :
require_once('fonction.inc.php');























