<?php
include_once "../includes/config.php";
include_once 'header.php'; 
?>

<?php

$id = $_GET['id'];

if (isset($_POST['update'])) {
  $id = $_GET['id'];
  $stmt = $db->prepare("UPDATE artiste SET nom=:nom ,genre=:genre ,pays_origine=:pays_origine ,biographie=:biographie ,discographie=:discographie ,active=:active ,label=:label ,site_web=:site_web ,image=:image ,youtube=:image WHERE id=$id");
  $stmt->execute(array(
    ':nom' => $_POST['nom'],
    ':genre' => $_POST['genre'],
    ':pays_origine' => $_POST['pays_origine'],
    'biographie' => $_POST['biographie'],
    'discographie' => $_POST['discographie'],
    'active' => $_POST['active'],
    'label' => $_POST['label'],
    'site_web' => $_POST['site_web'],
    'image' => $_POST['image'],
    'youtube' => $_POST['youtube']
  ));

}
?>

<?php

try {
  $stmt = $db->query("SELECT * FROM artiste WHERE id=$id");
  while ($row = $stmt->fetch()) {
?>

<form class="" action="" method="post">
  <p>Nom de l'artiste :</p>
  <input type="text" name="nom" value="<?php echo $row['nom']; ?>">
  <p>Genre :</p>
  <input type="text" name="genre" value="<?php echo $row['genre']; ?>">
  <p>Pays d'origine :</p>
  <input type="text" name="pays_origine" value="<?php echo $row['pays_origine'] ?>">
  <p>Biographie :</p>
  <textarea name="biographie" rows="8" cols="80"><?php echo $row['biographie'] ?></textarea>
  <p>Discographie :</p>
  <textarea name="discographie" rows="8" cols="80"><?php echo $row['discographie'] ?></textarea>
  <p>Actif :</p>
  <input type="text" name="active" value="<?php echo $row['active'] ?>">
  <p>Label :</p>
  <input type="text" name="label" value="<?php echo $row['label'] ?>">
  <p>Site web :</p>
  <input type="text" name="site_web" value="<?php echo $row['site_web'] ?>">
  <p>Image :</p>
  <input type="text" name="image" value="<?php echo $row['image'] ?>">
  <p>Lien YouTube :</p>
  <input type="text" name="youtube" value="<?php echo $row['youtube'] ?>"><br>
  <input type="submit" name="update" value="Update">
</form>

<?php
  }//while
}//try
catch (\Exception $e) {
  echo $e->getMessage();
}
?>
