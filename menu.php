<?php
$liste_id = $db->query('SELECT id FROM artiste')->fetchAll();
$id_aleatoire = $liste_id[array_rand($liste_id, 1)]['id'];

?>
<div id="navbar" class="sticky">
  <div class="col-md-4">
  </div>
  <div class="col-md-4 mid-element">
    <ul class="nav">
      <li>
        <a class="nav-link active" href="./">Home</a>
      </li>
      <li>
        <a class="nav-link" href="./artiste.php?id=<?php echo $id_aleatoire; ?>">&Agrave découvrir</a>
      </li>
      <li>
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
      <li>
        <a class="nav-link" href="./admin">Admin</a>
      </li>
    </ul>
  </div>
      <div id="search-bar" class="nl-auto nav-item col-md-4 right-element">
<form class="form-inline navform" method="Post" action="recherche.php">
      <input class="form-control mr-sm-2" type="search" name="requete" placeholder="Rechercher" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
    </form>
    </div>
</div>
