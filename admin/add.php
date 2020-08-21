<?php
include_once "../includes/config.php";

//if not logged in redirect to login page
if(!$user->is_logged_in()){
  header('Location: login.php');
}

include_once 'header.php';
?>

<div class="container pt-5 pb-5">
  <div class="row">
    <div class="col-sm-12 px-5 text-justify">
      <div class="pb-5">

<?php
if (isset($_POST['create'])) {

  // location where initial upload will be moved to
  $target = $_FILES['image']['name'];
  $path = '../img/artistes/'.$target;

  $_POST = array_map( 'stripslashes', $_POST );

  //collect form data
  extract($_POST);

  //very basic validation
  if($nom ==''){
    $error[] = 'Veuillez entrer un nom.';
  }

  if($presentation ==''){
    $error[] = 'Veuillez entrer un texte de présentation';
  }

  if($biographie ==''){
    $error[] = 'Veuillez entrer un texte de biographie';
  }

  if($discographie ==''){
    $error[] = 'Veuillez entrer un texte de discographie';
  }

  if(isset($_FILES['image'])){
     // find thevtype of image
      switch ($_FILES["image"]["type"]) {
         case $_FILES["image"]["type"] == "image/jpeg":
            move_uploaded_file($_FILES["image"]["tmp_name"], $path);
            break;
         case $_FILES["image"]["type"] == "image/pjpeg":
            move_uploaded_file($_FILES["image"]["tmp_name"], $path);
            break;
         case $_FILES["image"]["type"] == "image/png":
            move_uploaded_file($_FILES["image"]["tmp_name"], $path);
            break;
         case $_FILES["image"]["type"] == "image/x-png":
            move_uploaded_file($_FILES["image"]["tmp_name"], $path);
            break;

         default:
            $error[] = 'Mauvais type d\'image. Seules les JPG et les PNG sont acceptées !.';
     }
   }

  if(!isset($error)){

  try {
  $stmt = $db->prepare("INSERT INTO artiste (nom, genre, pays_origine, presentation, biographie, discographie, active, label, site_web, image, youtube) VALUES (:nom,:genre,:pays_origine,:presentation,:biographie,:discographie,:active,:label,:site_web,:image,:youtube)");
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

  $id = $db->lastInsertId();

  if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
      $stmt = $db->prepare('UPDATE artiste SET image = :image WHERE id = :id') ;
      $stmt->execute(array(
           ':id' => $id,
           ':image' => $target
      ));
  }

  //redirect to index page
  header('Location: index.php?action=added');
  exit;
} // try

 catch (\Exception $e) {
  echo $e->getMessage();
  }
}

if(isset($error)){
  foreach($error as $error){
    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
  }
}

} // if isset create
?>

<?php
include('menu.php');
?>

<div class="pt-3"><h2>Ajouter un artiste/groupe</h2></div>

<!-- <form class="" action="" method="post">
  <p>Nom de l'artiste/groupe :</p>
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
-->

<form action='' method='post' enctype="multipart/form-data">
   <div class="form-group">
     <label for="nomartiste">Nom</label>
     <input type="text" name="nom" class="form-control" id="nomartiste" value='<?php if(isset($error)){ echo $_POST['nom']; } ?>'>
   </div>
   <div class="form-group">
     <label for="genreartiste">Genre</label>
     <input type="text" name="genre" class="form-control" id="genreartiste" value='<?php if(isset($error)){ echo $_POST['genre']; } ?>'>
   </div>
   <div class="form-group">
     <label for="paysartiste">Pays d'origine</label>
     <input type="text" name="pays_origine" class="form-control" id="paysartiste" value='<?php if(isset($error)){ echo $_POST['pays_origine']; } ?>'>
   </div>
   <div class="form-group">
     <label for="presartiste">Présentation</label>
     <textarea name="presentation" class="form-control" id="presartiste" rows="10"><?php if(isset($error)){ echo $_POST['presentation']; } ?></textarea>
   </div>
   <div class="form-group">
     <label for="bioartiste">Biographie</label>
     <textarea name="biographie" class="form-control" id="bioartiste" rows="10"><?php if(isset($error)){ echo $_POST['biographie']; } ?></textarea>
   </div>
   <div class="form-group">
     <label for="discoartiste">Discographie</label>
     <textarea name="discographie" class="form-control" id="discoartiste" rows="10"><?php if(isset($error)){ echo $_POST['discographie']; } ?></textarea>
   </div>
   <div class="form-group">
     <label for="activeartiste">Activité</label>
     <input type="text" name="active" class="form-control" id="activeartiste" value='<?php if(isset($error)){ echo $_POST['active']; } ?>'>
   </div>
   <div class="form-group">
     <label for="labelartiste">Label</label>
     <input type="text" name="label" class="form-control" id="labelartiste" value='<?php if(isset($error)){ echo $_POST['label']; } ?>'>
   </div>
   <div class="form-group">
     <label for="siteartiste">Site web</label>
     <input type="text" name="site_web" class="form-control" id="siteartiste" value='<?php if(isset($error)){ echo $_POST['site_web']; } ?>'>
   </div>
   <div class="form-group">
     <label for="imageartiste">Image <small>(images jpeg ou png seulement)</small></label>
     <input type="file" name="image" class="form-control">
   </div>
   <div class="form-group">
     <label for="youtubeartiste">Youtube</label>
     <input type="text" name="youtube" class="form-control" id="youtubeartiste" value='<?php if(isset($error)){ echo $_POST['youtube']; } ?>'>
   </div>

   <div class="text-right pt-5">
     <button type="reset" class="btn btn-secondary">Annuler</button> <button type="submit" class="btn btn-primary" name="create">Ajouter</button>
   </div>
</form>

</div>
</div>
</div>
</div>
</div>
</div>

<?php include_once 'footer.php'; ?>
