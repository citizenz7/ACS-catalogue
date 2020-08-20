<?php
include_once './includes/config.php';
$id = $_GET['id'];

try {

  $stmt = $db->prepare('SELECT nom FROM artiste WHERE id = :id') ;
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch();

} catch(PDOException $e) {
    echo $e->getMessage();
}

$pagetitle = 'Artiste : ' . $row['nom'];
include_once 'header.php';
?>

<div class="container pt-5 mt-5 mb-5">

<?php
try {
  $stmt = $db->query("SELECT * FROM artiste WHERE id=$id");
  while($row = $stmt->fetch()) {
    echo '<div class="border px-3">';

      echo '<p class="text-justify display-4 font-weight-bold">' . $row['nom'] . '</p>';

        echo '<ul class="list-group list-group-horizontal-sm text-muted my-3 text-center" style="font-size: 14px;">';
          echo '<li class="list-group-item"><b>Genre(s)</b><br>' . $row['genre'] . '</li>';
          echo '<li class="list-group-item"><b>Pays d\'origine</b><br>' . $row['pays_origine'] . '</li>';
          echo '<li class="list-group-item"><b>Années d\'activité</b><br>' . $row['active'] . '</li>';
          echo '<li class="list-group-item"><b>Label</b><br>' . $row['label'] . '</li>';

          if (empty($row['site_web'])) {
            echo '<li class="list-group-item"><i class="fas fa-link"></i> Site web</li>';
          }
          else {
            echo '<li class="list-group-item"><a href="' . $row['site_web'] . '"><i class="fas fa-link fa-2x"></i></a></li>';
          }
          echo '<li class="list-group-item"><a href="' . $row['youtube'] . '"><i class="fab fa-youtube fa-2x"></i></a></li>';
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

    // echo '<div class="row pt-3 px-3">';
    //   echo '<div class="col-sm-12 text-justify text-center alert alert-primary" role="alert">';
    //     echo '<i class="fas fa-table"></i> Années d\'activité : ' . $row['active'] . ' | ';
    //     echo '<i class="fas fa-tag"></i> Label : ' . $row['label'] . ' | ';
    //
    //     if (empty($row['site_web'])) {
    //       echo '<i class="fas fa-link"></i> Site web | ';
    //     }
    //     else {
    //       echo '<i class="fas fa-link"></i> <a href="' . $row['site_web'] . '">Site web</a> | ';
    //     }
    //
    //
    //     echo '<i class="fab fa-youtube"></i> <a href="' . $row['youtube'] . '">Youtube</a>';
    //   echo '</div>';
    // echo '</div>';

  } //while
} // try
catch (\Exception $e) {
  echo $e->getMessage();
}

?>

</div>

<?php include 'footer.php'; ?>
