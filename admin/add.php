<?php
include_once "../includes/config.php";
include_once 'header.php';
?>

<?php

if (isset($_POST['create'])) {
  try {

  $stmt = $db->prepare("INSERT INTO artiste (nom, genre, pays_origine, presentation, biographie, discographie, active, label, site_web, image, youtube) VALUES (:nom ,:genre ,:pays_origine ,:presentation ,:biographie ,:discographie ,:active ,:label ,:site_web ,:image ,:image)");
  $stmt->execute(array(
    ':nom' => $_POST['nom'],
    ':genre' => $_POST['genre'],
    ':pays_origine' => $_POST['pays_origine'],
    ':presentation' => $_POST['presentation'],
    'biographie' => $_POST['biographie'],
    'discographie' => $_POST['discographie'],
    'active' => $_POST['active'],
    'label' => $_POST['label'],
    'site_web' => $_POST['site_web'],
    'image' => $_POST['image'],
    'youtube' => $_POST['youtube']
  ));
  header('Location: index.php');
}
 catch (\Exception $e) {
  echo $e->getMessage();
}
}
?>

<form class="" action="" method="post">
  <p>Nom de l'artiste :</p>
  <input type="text" name="nom" value="" required>
  <p>Genre :</p>
  <input type="text" name="genre" value="" required>
  <p>Pays d'origine :</p>
  <input type="text" name="pays_origine" value="">
  <p>Présentation</p>
  <textarea name="presentation" rows="8" cols="80" required></textarea>
  <p>Biographie :</p>
  <textarea name="biographie" rows="8" cols="80" required></textarea>
  <p>Discographie :</p>
  <textarea name="discographie" rows="8" cols="80" required></textarea>
  <p>Actif :</p>
  <input type="text" name="active" value="" required>
  <p>Label :</p>
  <input type="text" name="label" value="" required>
  <p>Site web :</p>
  <input type="text" name="site_web" value="">
  <p>Image :</p>
  <input type="text" name="image" value="">
  <p>Lien YouTube :</p>
  <input type="text" name="youtube" value=""><br>
  <input type="submit" name="create" value="Create">
</form>
