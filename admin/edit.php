<?php
include_once '../includes/config.php';
require_once 'header.php';

//if not logged in redirect to login page
if(!$user->is_logged_in()){
  header('Location: login.php');
}
?>

<div class="container pt-3 pb-5">
  <div class="row">
    <div class="col-sm-12 text-justify">
      <div class="pb-5">

      <?php include_once 'menu.php'; ?>

<?php
$id = html($_GET['id']);

if (isset($_POST['update'])) {
  $stmt = $db->prepare("UPDATE artiste SET nom=:nom,genre=:genre,pays_origine=:pays_origine,biographie=:biographie,discographie=:discographie,active=:active,label=:label,site_web=:site_web,image=:image,youtube=:youtube WHERE id=$id");
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

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="nomartiste">Nom de l'artiste</label>
    <input type="text" class="form-control" name="nom" id="nomartiste" value="<?php echo $row['nom']; ?>">
  </div>
  <div class="form-group">
    <label for="genreartiste">Genre</label>
    <input type="text" class="form-control" name="genre" id="genreartiste" value="<?php echo $row['genre']; ?>">
  </div>
  <div class="form-group">
    <label for="paysartiste">Pays de l'artiste/groupe</label>
    <input type="text" class="form-control" name="pays_origine" id="paysartiste" value="<?php echo $row['pays_origine'] ?>">
  </div>
  <div class="form-group">
    <label for="presartiste">Présentation</label>
    <textarea class="form-control" name="presentation" id="presartiste" rows="8" cols="80"><?php echo $row['presentation'] ?></textarea>
  </div>
  <div class="form-group">
    <label for="bioartiste">Biographie</label>
    <textarea class="form-control" name="biographie" id="bioartiste" rows="8" cols="80"><?php echo $row['biographie'] ?></textarea>
  </div>
  <div class="form-group">
    <label for="discoartiste">Discographie</label>
    <textarea class="form-control" name="discographie" id="discoartiste" rows="8" cols="80"><?php echo $row['discographie'] ?></textarea>
  </div>
  <div class="form-group">
    <label for="actifartiste">Activité</label>
    <input type="text" class="form-control" name="active" id="actifartiste" value="<?php echo $row['active'] ?>">
  </div>
  <div class="form-group">
    <label for="labelartiste">Label</label>
    <input type="text" class="form-control" name="label" id="labelartiste" value="<?php echo $row['label'] ?>">
  </div>
  <div class="form-group">
    <label for="siteartiste">Site web</label>
    <input type="text" class="form-control" name="site_web" id="siteartiste" value="<?php echo $row['site_web'] ?>">
  </div>
  <div class="form-group">
    <label for="imageartiste">Image</label>
    <input type="text" class="form-control" name="image" id="imageartiste" value="<?php echo $row['image'] ?>">
  </div>
  <div class="form-group">
    <label for="youtubeartiste">Lien Youtube</label>
    <input type="text" class="form-control" name="youtube" id="youtubeartiste" value="<?php echo $row['youtube'] ?>"><br>
  </div>

  <div class="text-right pt-5"><button type='submit' class="btn btn-primary" name='update'>Editer la fiche</button></div>
</form>

<?php
  }//while
}//try
catch (\Exception $e) {
  echo $e->getMessage();
}
?>

</div>
</div>
</div>
</div>

<?php
require_once 'header.php';
?>
