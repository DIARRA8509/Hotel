<?php
function debug($var, $mode = 1) {
  echo '<div style="background: orange; padding: 5px;">';
    if ($mode == 1) {
      echo '<pre>'; print_r($var); echo '</pre>';
    } else {
      echo '<pre>'; var_dump($var); echo '</pre>';
    }
  echo '</div>';
}

//-------------------------------
function internauteEstConnecte() {
  if (isset($_SESSION['membre'])) {
    return true;
  } else {
    return false;
  }
}

//--------------------------------
function internauteEstConnecteEtEstAdmin() {
  if (internauteEstConnecte() && $_SESSION['membre']['statut'] == 1) { // statut = 1 correspond à un admin
    return true;
  } else {
    return false;
  }
}

//---------------------------------








