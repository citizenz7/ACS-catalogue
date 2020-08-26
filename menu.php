<?php
    $link = $_SERVER['PHP_SELF'];
    $link_array = explode('/',$link);

$liste_id = $db->query('SELECT slug FROM artiste')->fetchAll();
$id_aleatoire = $liste_id[array_rand($liste_id, 1)]['slug'];

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand d-flex w-50 mr-auto" href="./">ACS Groove</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="navbar-collapse collapse w-100" id="navbarTogglerDemo02">
    <ul class="navbar-nav w-100 justify-content-center">
      <li class="nav-item">
        <a class="nav-link nav-font <?php if($page = end($link_array)=="index.php") echo'active'; ?>" href="index.php">Accueil<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <!-- <a class="nav-link nav-font" href="artiste.php?id=<?php echo $id_aleatoire; ?>">&Agrave découvrir</a> -->
        <a class="nav-link nav-font <?php if($page = end($link_array)=="artiste.php") echo'active'; ?>" href="<?php echo $id_aleatoire; ?>">&Agrave découvrir</a>
      </li>
      <li class="nav-item">
        <a class="nav-link nav-font <?php if($page = end($link_array)=="concert.php") echo'active'; ?>" href="concert.php">Concert</a>
      </li>
      <li class="nav-item">
        <a class="nav-link nav-font <?php if($page = end($link_array)=="contact.php") echo'active'; ?>" href="contact.php">Contact</a>
      </li>
    </li>
    <li class="nav-item">
      <a class="nav-link nav-font <?php if($page = end($link_array)=="admin/index.php") echo'active';?>" href="admin/index.php">Admin</a>
    </li>
    </ul>
    <form class="form-inline ml-auto w-100 justify-content-end" method="post" action="recherche.php">
      <input class="form-control mr-sm-2" type="search" name="requete" placeholder="Rechercher"aria-label="Search">
      <button class="btn my-2 my-sm-0 btn-light" type="submit">OK</button>
    </form>
  </div>
</nav>
