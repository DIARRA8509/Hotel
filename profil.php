<?php
require_once('inc/init.inc.php');

//--------------------- TRAITEMENT -------------------
// Redirection si visiteur non connecté :
if (!internauteEstConnecte()) {
  header('location:connexion.php'); // nous invitons l'internaute non connecté à se connecter
  exit(); // pour sortir du script
}

// Préparation de l'affichage du profil :
debug($_SESSION);

$contenu .= '<h2>Bonjour '. $_SESSION['membre']['pseudo'] .'</h2>';

if (internauteEstConnecteEtEstAdmin()) {
  $contenu .= '<p>Vous êtes un administrateur.</p>';
} else {
  $contenu .= '<p>Vous êtes un membre.</p>';
}

$contenu .= '<div><h3>Voici vos informations de profil</h3>';
    $contenu .= '<p> Votre email : ' . $_SESSION['membre']['email'] . '</p>';
    $contenu .= '<p> Votre adresse : ' . $_SESSION['membre']['adresse'] . '</p>';
    $contenu .= '<p> Votre code postal : ' . $_SESSION['membre']['code_postal'] . '</p>';
    $contenu .= '<p> Votre ville : ' . $_SESSION['membre']['ville'] . '</p>';
$contenu .= '</div>';


// ---------------------- AFFICHAGE --------------------
require_once('inc/haut.inc.php');
echo $contenu;
require_once('inc/bas.inc.php');