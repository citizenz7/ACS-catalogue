<?php
include_once "../includes/config.php";

//if not logged in redirect to login page
if(!$user->is_logged_in()){
  header('Location: login.php');
}

include_once 'header.php';
?>

<div class="container mt-5">
  <div class="row">
    <div class="col-sm-12 px-3 mt-5 text-justify">
      <div class="pb-5">
        <div class="text-center mt-5 mb-4 alert alert-primary" role="alert">Bienvenue <b><?php echo $_SESSION['username']; ?></b> ! Vous êtes connecté.</div>

<?php
if (isset($_POST['createconcert'])) {

  //collect form data
  extract($_POST);

  $req = $db->query("SHOW TABLE STATUS FROM acscatalogue LIKE 'concert' ");
  $donnees = $req->fetch();
  $idimageconcert = $donnees['Auto_increment'];


  // location where initial upload will be moved to
  $target = $idimageconcert . '-' . $_FILES['imageconcert']['name'];
  $path = '../img/concerts/'.$target;

  $_POST = array_map( 'stripslashes', $_POST );

  //very basic validation
  if($nomconcert ==''){
    $error[] = 'Veuillez entrer un nom.';
  }

  if($presentationconcert ==''){
    $error[] = 'Veuillez entrer un texte de présentation';
  }

  if($lieuconcert ==''){
    $error[] = 'Veuillez entrer un lieu ';
  }

  if($dateconcert ==''){
    $error[] = 'Veuillez entrer une date';
  }

  if(isset($_FILES['imageconcert'])){
     // find thevtype of image
      switch ($_FILES["imageconcert"]["type"]) {
         case $_FILES["imageconcert"]["type"] == "image/jpeg":
            move_uploaded_file($_FILES["imageconcert"]["tmp_name"], $path);
            break;
         case $_FILES["imageconcert"]["type"] == "image/pjpeg":
            move_uploaded_file($_FILES["imageconcert"]["tmp_name"], $path);
            break;
         case $_FILES["imageconcert"]["type"] == "image/png":
            move_uploaded_file($_FILES["imageconcert"]["tmp_name"], $path);
            break;
         case $_FILES["imageconcert"]["type"] == "image/x-png":
            move_uploaded_file($_FILES["imageconcert"]["tmp_name"], $path);
            break;

         default:
            $error[] = 'Mauvais type d\'image. Seules les JPG et les PNG sont acceptées !.';
     }
   }

  if(!isset($error)){

  try {

  $stmt = $db->prepare("INSERT INTO concert (nomconcert,lieuconcert,dateconcert,heureconcert,presentationconcert,descriptionconcert) VALUES (:nomconcert,:lieuconcert,:dateconcert,:heureconcert,:presentationconcert,:descriptionconcert)");
  $stmt->execute(array(
    ':nomconcert' => $_POST['nomconcert'],
    ':lieuconcert' => $_POST['lieuconcert'],
    ':dateconcert' => $_POST['dateconcert'],
    ':heureconcert' => $_POST['heureconcert'],
    ':presentationconcert' => $_POST["presentationconcert"],
    ':descriptionconcert' => $_POST["descriptionconcert"]
  ));

  $idconcert = $db->lastInsertId();

  if(isset($_FILES['imageconcert']['name']) && !empty($_FILES['imageconcert']['name'])) {
      $stmt = $db->prepare('UPDATE concert SET imageconcert = :imageconcert WHERE idconcert = :idconcert') ;
      $stmt->execute(array(
           ':idconcert' => $idconcert,
           ':imageconcert' =>$target
      ));
  }

  //redirect to index page
  header('Location: indexconcert.php?action=added');
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

<div class="pt-3"><h2>Ajouter un concert</h2></div>

<form action='' method='post' enctype="multipart/form-data">
   <div class="form-group">
     <label for="nomconcert">Nom</label>
     <input type="text" name="nomconcert" class="form-control" id="nomconcert" value='<?php if(isset($error)){ echo $_POST['nomconcert']; } ?>' required>
   </div>
   <div class="form-group">
     <label for="lieuconcert">lieu</label>
     <input type="text" name="lieuconcert" class="form-control" id="lieuconcert" value='<?php if(isset($error)){ echo $_POST['lieuconcert']; } ?>' required>
   </div>
   <div class="form-group">
     <label for="dateconcert">date</label>
     <input type="date" name="dateconcert" class="form-control" id="dateconcert" value='<?php if(isset($error)){ echo $_POST['dateconcert']; } ?>' required>
   </div>
   <div class="form-group">
     <label for="heureconcert">Heure</label>
     <input type="text" name="heureconcert" class="form-control" id="heureconcert" placeholder="00:00" value='<?php if(isset($error)){ echo $_POST['heureconcert']; } ?>' required>
   </div>
   <div class="form-group">
     <label for="presartiste">description</label>
     <textarea name="descriptionconcert" class="form-control" id="presartiste" rows="10"><?php if(isset($error)){ echo $_POST['descriptionconcert']; } ?></textarea>
   </div>
   <div class="form-group">
     <label for="presentationconcert">presentation</label>
     <textarea name="presentationconcert" class="form-control" id="bioartiste" rows="10"><?php if(isset($error)){ echo $_POST['presentationconcert']; } ?></textarea>
   </div>
   <div class="form-group">
     <label for="imageconcert">Image <small>(images jpeg ou png seulement)</small></label>
     <input type="file" name="imageconcert" class="form-control">
   </div>
   <div class="text-right pt-5">
     <button type="reset" class="btn btn-secondary">Annuler</button> <button type="submit" class="btn btn-primary" name="createconcert">Ajouter</button>
   </div>
</form>

</div>
</div>
</div>
</div>
</div>
</div>

<?php include_once 'footer.php'; ?>
