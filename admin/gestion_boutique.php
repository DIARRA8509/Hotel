<?php
require_once('../inc/init.inc.php');  // on va dans le dossier parent "../" puis on descend dans le dossier inc/

//------------- TRAITEMENT -----------------------
// 1- Vérification ADMIN :
if (!internauteEstConnecteEtEstAdmin()) {
    header('location:../connexion.php');
    exit();
}

// Ici code à venir


// 4- Enregistrement du produit :
if ($_POST) { // si formulaire soumis
    $photo_bdd = '';  // contient l'url de la photo uploadée
    
    // ici code à venir
    
    // 5 - PHOTO :
    if (!empty($_FILES['photo']['name'])) {
      //debug($_FILES);
      
      // Déterminer le nom de la photo :
      $nom_photo = $_POST['reference'] . '_' . $_FILES['photo']['name'];
      
      $photo_bdd = RACINE_SITE . 'photo/' . $nom_photo; // chemin de la photo enregistré en BDD
      
      $photo_dossier = $_SERVER['DOCUMENT_ROOT'].$photo_bdd; // on ajoute la racine serveur au chemin de la photo pour avoir un chemin absolu complet lors de la copie du fichier photo
      
      copy($_FILES['photo']['tmp_name'], $photo_dossier);
      // enregistrement de la photo temporairement stockée dans 'tmp_name' dans le répertoire $photo_dossier      
    }
    
    
    // 4 suite - enregistrement du produit en base :
    foreach ($_POST as $indice => $valeur) {
      $_POST[$indice] = htmlentities($valeur, ENT_QUOTES);
    }
    
    $mysqli->query("REPLACE INTO produit (id_produit, reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES('$_POST[id_produit]', '$_POST[reference]', '$_POST[categorie]', '$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', '$_POST[public]', '$photo_bdd', '$_POST[prix]', '$_POST[stock]')");
    
    $contenu .= '<div class="bg-success">Le produit a été enregistré</div>';
    
    $_GET['action'] = 'affichage'; // pour déclencher l'affichage des produits (cf 6)
  
} // fin du if ($_POST)
  


// 2- Liens AFFICHAGE et AJOUT :
$contenu .= '<ul class="nav nav-tabs">';
    $contenu .= '<li><a href="?action=affichage">Affichage des produits</a></li>';
    $contenu .= '<li><a href="?action=ajout">Ajout d\'un produit</a></li>';
 
$contenu .= '</ul>';


// 6- Affichage des produits sous forme de table HTML :
if (isset($_GET['action']) && $_GET['action'] == 'affichage') {
  
  $resultat = $mysqli->query("SELECT * FROM produit");
  
  $contenu .= '<h3>Affichage des produits</h3>';
  $contenu .= 'Nombre de produit(s) dans la boutique : ' . $resultat->num_rows;
  
  $contenu .= '<table class="table">';
  
    // Affichage des entêtes de la table :
    $contenu .= '<tr>';
      while($colonne = $resultat->fetch_field()) {
       // debug($colonne);
        $contenu .= '<th>'. $colonne->name .'</th>';
      }
    
    $contenu .= '<th>Action</th>';
    $contenu .= '</tr>';
  
    // Affichage des lignes de la table :
      while($ligne = $resultat->fetch_assoc()) {
        $contenu .= '<tr>';
          foreach($ligne as $indice=>$valeur) {
             
             if ($indice == 'photo') {
               $valeur = '<img src="'. $valeur .'" width=70 height=70>';
             }
             $contenu .= '<td>'. $valeur .'</td>';
          }
        
        $contenu .= '<td>';
          
          $contenu .= '<a href="?action=modification&id_produit='. $ligne['id_produit'] .'">modifier</a> / <a href="?action=suppression&id_produit='. $ligne['id_produit'] .'" onclick="return(confirm(\'Etes-vous sûr de vouloir supprimer ce produit \'));" >supprimer</a>';
        
        $contenu .= '</td>';
        $contenu .= '</tr>';
      }
    
  $contenu .= '</table>';
}









//------------- AFFICHAGE -----------------------
require_once('../inc/haut.inc.php');
echo $contenu;

// 3- Formulaire HTML :
if (isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')) : // affichage du formulaire quand on est en ajout ou modif. Attention : endif en bas du fichier !

?>
<h3>Formulaire d'ajout ou de modification de produit</h3>

<form method="post" action="" enctype="multipart/form-data">
<!-- multipart/form-data permet d'uploader un fichier et de générer une superglobale $_FILES -->

  <input type="hidden" name="id_produit" value="0">
  <!-- champ caché pour pouvoir passer dans $_POST l'id du produit à modifier -->
  
  <label for="reference">Référence</label><br>
  <input type="text" id="reference" name="reference" value=""><br>

  <label for="categorie">Catégorie</label><br>
  <input type="text" id="categorie" name="categorie" value=""><br>

  <label for="titre">Titre</label><br>
  <input type="text" id="titre" name="titre" value=""><br>

  <label for="description">Description</label><br>
  <textarea id="description" name="description" ></textarea><br>
  
  <label for="couleur">Couleur</label><br>
  <input type="text" id="couleur" name="couleur" value=""><br>
  
  <label>Taille</label><br>
  <select name="taille">
      <option value="S">S</option>
      <option value="M">M</option>
      <option value="L">L</option>
      <option value="XL">XL</option>
  </select><br>
  
  <label>Public</label><br>
  <input type="radio" name="public" value="m" checked>Homme
  <input type="radio" name="public" value="f" >Femme
  <input type="radio" name="public" value="mixte" >Mixte
  <br>
  
  <label for="photo">Photo</label><br>
  <input type="file" id="photo" name="photo"><br> <!-- le type file est dépendant de l'attribut enctype = "multipart/form-data". Ils permettent de remplir la supergolable $_FILES lorsqu'une photo est uploadée -->
  
  <label for="prix">Prix</label><br>
  <input type="text" id="prix" name="prix" value="0"><br>
  
  <label for="stock">Stock</label><br>
  <input type="text" id="stock" name="stock" value="0"><br>
  
  <input type="submit" value="valider" class="btn">
</form>
<?php
endif;
require_once('../inc/bas.inc.php');





