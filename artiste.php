<?php
include_once './includes/config.php';
$id = html($_GET['id']);

try {
  $stmt = $db->prepare('SELECT nom,bin FROM artiste WHERE id = :id') ;
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch();
}
catch(PDOException $e) {
    echo $e->getMessage();
}

/* Si la fiche est désactivée (bin == 1), on n'affiche rien et on renvoie vers la page index.php */
if($row['bin'] == 1) {
  header('Location: index.php');
}

else {

$pagetitle = 'Artiste : ' . $row['nom'];
include_once 'header.php';
?>

<div class="container pt-5 mt-5 mb-5">

<?php
try {
  $stmt = $db->query("SELECT * FROM artiste WHERE bin = 0 AND id = $id");
  while($row = $stmt->fetch()) {
    echo '<div class="border px-3">';

      echo '<p class="text-justify display-4 font-weight-bold">' . $row['nom'] . '</p>';

        echo '<ul class="list-group list-group-horizontal-sm text-muted my-3 text-center" style="font-size: 12px;">';
          echo '<li class="list-group-item"><b>Genre(s)</b><br>' . $row['genre'] . '</li>';
          echo '<li class="list-group-item"><b>Pays d\'origine</b><br>' . $row['pays_origine'] . '</li>';

          if (!empty($row['active'])) {
            echo '<li class="list-group-item"><b>Années d\'activité</b><br>' . $row['active'] . '</li>';
          }

          if (!empty($row['label'])) {
            echo '<li class="list-group-item"><b>Label</b><br>' . $row['label'] . '</li>';
          }

          if (!empty($row['site_web'])) {
            echo '<li class="list-group-item"><a href="' . $row['site_web'] . '"><i class="fas fa-link fa-3x"></i></a></li>';
          }

          if (!empty($row['youtube'])) {
            echo '<li class="list-group-item"><a href="' . $row['youtube'] . '"><i class="fab fa-youtube fa-3x"></i></a></li>';
          }

          echo '<li class="list-group-item"><b>Fiche postée le</b><br>' . date_fr('d-m-Y à H:i:s', strtotime(($row['date']))) . '</li>';

          if(!empty($row['dateMAJ'])) {
            echo '<li class="list-group-item"><b>Fiche mise à jour le</b><br>' . date_fr('d-m-Y à H:i:s', strtotime(($row['dateMAJ']))) . '</li>';
          }
        echo '</ul>';

        if (empty($row['image'])) {
          echo '<p class="text-justify"><img class="img-fluid float-left mr-3 mb-3" src="./img/nophoto.png" alt="' . $row['nom'] . '">' . $row['presentation'] . '</p>';
        }
        else {
          echo '<p class="text-justify"><img class="img-fluid float-left mr-3 mb-3" src="./img/artistes/' . $row['image'] . '" alt="' . $row['nom'] . '">' . $row['presentation'] . '</p>';
        }

        echo '<p class="text-justify">' . $row['biographie'] . '</p>';
        echo '<p class="text-justify">' . $row['discographie'] . '</p>';

    echo '</div>';

  } //while
} // try
catch (\Exception $e) {
  echo $e->getMessage();
}

?>

</div>

<?php include 'footer.php'; ?>

<?php } //else ?>
