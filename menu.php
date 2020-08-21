<?php
$liste_id = $db->query('SELECT id FROM artiste')->fetchAll();
$id_aleatoire = $liste_id[array_rand($liste_id, 1)]['id'];

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="nav navbar-nav abs-center-x">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="artiste.php?id=<?php echo $id_aleatoire; ?>">&Agrave découvrir</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="admin/index.php">Admin</a>
    </li>
    </ul>
    <form class="form-inline ml-auto" method="post" action="recherche.php">
      <input class="form-control mr-sm-2" type="search" name="requete" placeholder="Rechercher"aria-label="Search">
      <button class="btn my-2 my-sm-0 btn-light" type="submit">Search</button>
    </form>
  </div>
</nav>
