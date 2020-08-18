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
      echo '<p class="text-justify display-4 font-weight-bold">' . html($row['nom']) . '</p>';

      echo '<p class="text-justify text-muted"><i class="fas fa-music"></i> Genre(s) : ' . html($row['genre']) . '<br>';
      echo '<i class="fas fa-flag"></i> Pays d\'origine : ' . html($row['pays_origine']) . '</p>';

      if (empty($row['image'])) {
        echo '<p class="text-justify"><img class="img-fluid float-left" style="max-height: 275px; margin-right: 10px;" src="./img/nophoto.png" alt="' . html($row['nom']) . '">' . html($row['presentation']) . '</p>';
      }
      else {
        echo '<p class="text-justify"><img class="img-fluid float-left" style="max-height: 275px; margin-right: 10px;" src="./img/' . html($row['image']) . '" alt="' . html($row['nom']) . '">' . html($row['presentation']) . '</p>';
      }
      echo '<p class="text-justify">' . html($row['biographie']) . '</p>';

      echo '<p class="text-justify">' . html($row['discographie']) . '</p>';
    echo '</div>';

    echo '<div class="row pt-3 px-3">';
      echo '<div class="col-sm-12 text-justify text-center alert alert-primary" role="alert">';
        echo '<i class="fas fa-table"></i> Années d\'activité : ' . html($row['active']) . ' | ';
        echo '<i class="fas fa-tag"></i> Label : ' . html($row['label']) . ' | ';
        echo '<i class="fas fa-link"></i> <a href="' . html($row['site_web']) . '">Site web</a> | ';
        echo '<i class="fab fa-youtube"></i> <a href="' . html($row['youtube']) . '">Youtube</a>';
      echo '</div>';
    echo '</div>';
  } //while
} // try
catch (\Exception $e) {
  echo $e->getMessage();
}
?>

<?php include 'footer.php'; ?>
