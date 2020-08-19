<?php
include_once './includes/config.php';
$id = $_GET['id'];


$pagetitle = 'Artiste : ';
include_once 'header.php';
?>

<?php
try {
  $stmt = $db->query("SELECT * FROM artiste WHERE id=$id");
  while($row = $stmt->fetch()) {
    echo '<div class="border rounded px-3">';
      echo '<p class="text-justify display-4 font-weight-bold">' . $row['nom'] . '</p>';

      echo '<p class="text-justify text-muted"><i class="fas fa-music"></i> Genre(s) : ' . $row['genre'] . '<br>';
      echo '<i class="fas fa-flag"></i> Pays d\'origine : ' . $row['pays_origine'] . '</p>';

      if (empty($row['image'])) {
        echo '<p class="text-justify"><img class="img-fluid float-left mr-3 mb-3" src="./img/nophoto.png" alt="' . $row['nom'] . '">' . $row['presentation'] . '</p>';
      }
      else {
        echo '<p class="text-justify"><img class="img-fluid float-left mr-3 mb-3" src="./img/artistes/' . $row['image'] . '" alt="' . $row['nom'] . '">' . $row['presentation'] . '</p>';
      }
      echo '<p class="text-justify">' . $row['biographie'] . '</p>';

      echo '<p class="text-justify">' . $row['discographie'] . '</p>';
    echo '</div>';

    echo '<div class="row pt-3 px-3">';
      echo '<div class="col-sm-12 text-justify text-center alert alert-primary" role="alert">';
        echo '<i class="fas fa-table"></i> Années d\'activité : ' . $row['active'] . ' | ';
        echo '<i class="fas fa-tag"></i> Label : ' . $row['label'] . ' | ';

        if (empty($row['site_web'])) {
          echo '<i class="fas fa-link"></i> Site web | ';
        }
        else {
          echo '<i class="fas fa-link"></i> <a href="' . $row['site_web'] . '">Site web</a> | ';
        }


        echo '<i class="fab fa-youtube"></i> <a href="' . $row['youtube'] . '">Youtube</a>';
      echo '</div>';
    echo '</div>';
  } //while
} // try
catch (\Exception $e) {
  echo $e->getMessage();
}
?>

<?php include 'footer.php'; ?>
