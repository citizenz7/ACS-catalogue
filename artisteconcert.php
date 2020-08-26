<?php
include_once './includes/config.php';

$idconcert = html($_GET['idconcert']);

try {
  $stmt = $db->prepare('SELECT nomconcert,binconcert FROM concert WHERE idconcert = :idconcert') ;
  $stmt->execute(array(':idconcert' => $idconcert));
  $row = $stmt->fetch();
}
catch(PDOException $e) {
    echo $e->getMessage();
}
//
/* Si la fiche est désactivée (bin == 1), on n'affiche rien et on renvoie vers la page index.php */
if($row['binconcert'] == 1) {
  header('Location: index.php');
}
else {
$pagetitle = 'Concert : ' . $row['nomconcert'];
include_once 'header.php';
?>

<div class="container pt-5 mt-5 mb-5">

<?php
try {
  $stmt = $db->prepare("SELECT * FROM concert WHERE idconcert = :idconcert");
  $stmt->execute(array(':idconcert' => $idconcert));
  while($row = $stmt->fetch()) {
    echo '<div class="border px-3 mt-4">';

      echo '<p class="text-justify display-4 font-weight-bold">' . $row['nomconcert'];
        //si c'est un admin connecté...
        if($user->is_logged_in()){
          echo '<a class="btn btn-info btn-sm tinytext mx-3 px-2" role="button" aria-pressed="true" title="Editer la fiche" href="./admin/editconcert.php?idconcert=' . $row['idconcert'] . '"><i class="fas fa-edit"></i></a>';
        }
      echo '</p>';

        echo '<ul class="list-group list-group-horizontal-sm text-muted my-3 text-center" style="font-size: 12px;">';
          echo '<li class="list-group-item"><b>Lieu</b><br>' . $row['lieuconcert'] . '</li>';

          echo '<li class="list-group-item"><b>Concert le</b><br>' . date_fr('d-m-Y à H:i:s', strtotime(($row['dateconcert']))) . '</li>';

        echo '</ul>';

        if (empty($row['imageconcert'])) {
          echo '<p class="text-justify"><img class="img-fluid float-left mr-3 mb-3" src="./img/nophoto.png" alt="' . $row['nomconcert'] . '">' . $row['nomconcert'] . '</p>';
        }
        else {
          echo '<p class="text-justify"><img style="max-width:150px;" class="img-fluid float-left mr-3 mb-3" src="./img/concerts/' . $row['imageconcert'] . '" alt="' . $row['nomconcert'] . '">' . $row['descriptionconcert'] . '</p>';
        }
        echo '<p class="text-justify">' . $row['presentationconcert'] . '</p>';
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
