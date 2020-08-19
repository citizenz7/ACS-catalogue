<?php include_once './includes/config.php'; ?>

<?php
$liste_id = $db->query('SELECT id FROM artiste')->fetchAll();
$id_aleatoire = $liste_id[array_rand($liste_id, 1)]['id'];

?>

<nav class="navbar navbar-expand-lg navbar-light my-3" style="background-color: #cce5ff;">
  <a class="navbar-brand" href="./"><?php echo $SITENAME; ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="./">Accueil <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="artiste.php?id=<?php echo $id_aleatoire; ?>">&Agrave découvrir<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Artistes/Groupes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Tri par genre</a>
          <a class="dropdown-item" href="#">Tri par pays origine</a>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="./admin">Admin</a>
        </div>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" href="./admin">Admin</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" method="Post" action="recherche.php">
      <input class="form-control mr-sm-2" type="search" name="requete" placeholder="Rechercher" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
    </form>
  </div>
</nav>
