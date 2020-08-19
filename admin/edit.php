<?php
include_once "../includes/config.php";
include_once 'header.php';

//if not logged in redirect to login page
if(!$user->is_logged_in()){
  header('Location: login.php');
}

//Si on supprime l'image du projet...
		if(isset($_GET['delimage'])) {
			$delimage = $_GET['delimage'];
			//on supprime le fichier image
			$stmt = $db->prepare('SELECT image FROM artiste WHERE id = :id');
			$stmt->execute(array(
				':id' => $delimage
			));
			$sup = $stmt->fetch();
			$file = "../img/artistes/" . $sup['image'];
			if (file_exists($file)) {
				unlink($file);
			}
			//puis on supprime l'image dans la base
			$stmt = $db->prepare('UPDATE artiste SET image = NULL WHERE id = :id');
			$stmt->execute(array(
        ':id' => $delimage
      ));
			header('Location: edit.php?id='.$delimage);
		}

?>

<div class="container pt-3 pb-5">
  <div class="row">
    <div class="col-sm-12 text-justify">
      <div class="pb-5">

<?php
$id = html($_GET['id']);

if (isset($_POST['update'])) {

  $target = "img/artistes/" . $_FILES['image']['name'];
  $path = '../'.$target;

  $_POST = array_map( 'stripslashes', $_POST );

  //collect form data
  extract($_POST);

  //very basic validation
  if($id ==''){
    $error[] = 'Problème : pas d\id dans votre URL ?!!';
  }

  if($nom ==''){
    $error[] = 'Veuillez entrer un nom';
  }

  if($presentation ==''){
    $error[] = 'Veuillez entrer une présentation';
  }

  if($biographie ==''){
    $error[] = 'Veuillez entrer une biographie';
  }

  if($discographie ==''){
    $error[] = 'Veuillez entrer une discographie';
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

   if(!isset($error)) {
     try {
       $stmt = $db->prepare("UPDATE artiste SET nom=:nom,genre=:genre,pays_origine=:pays_origine,presentation=:presentation,biographie=:biographie,discographie=:discographie,active=:active,label=:label,site_web=:site_web,image=:image,youtube=:youtube WHERE id=$id");
       $stmt->execute(array(
         ':nom' => $_POST['nom'],
         ':genre' => $_POST['genre'],
         ':pays_origine' => $_POST['pays_origine'],
         'presentation' => $_POST['presentation'],
         'biographie' => $_POST['biographie'],
         'discographie' => $_POST['discographie'],
         'active' => $_POST['active'],
         'label' => $_POST['label'],
         'site_web' => $_POST['site_web'],
         'image' => $_POST['image'],
         'youtube' => $_POST['youtube']
       ));

       //redirect to index page
       header('Location: index.php?action=updated');
       exit;
     }

     catch(PDOException $e) {
       echo $e->getMessage();
     }

   } // if !isset error

 } // if isset POST update

 //check for any errors
 if(isset($error)){
   foreach($error as $error){
     echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
   }
 }
?>

<?php
try {
  $stmt = $db->prepare("SELECT * FROM artiste WHERE id=:id");
  $stmt->execute(array(':id' => $id));
  $row = $stmt->fetch();
}
catch(PDOException $e) {
  echo $e->getMessage();
}
?>

<?php include_once 'menu.php'; ?>

<div class="pt-3"><h3>Editer la fichede l'artiste/groupe : "<?php echo $row['nom']; ?>"</h3></div>

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
    <input type="text" class="form-control" name="pays_origine" id="paysartiste" value="<?php echo $row['pays_origine']; ?>">
  </div>
  <div class="form-group">
    <label for="presartiste">Présentation</label>
    <textarea class="form-control" name="presentation" id="presartiste" rows="8" cols="80"><?php echo $row['presentation']; ?></textarea>
  </div>
  <div class="form-group">
    <label for="bioartiste">Biographie</label>
    <textarea class="form-control" name="biographie" id="bioartiste" rows="8" cols="80"><?php echo $row['biographie']; ?></textarea>
  </div>
  <div class="form-group">
    <label for="discoartiste">Discographie</label>
    <textarea class="form-control" name="discographie" id="discoartiste" rows="8" cols="80"><?php echo $row['discographie']; ?></textarea>
  </div>
  <div class="form-group">
    <label for="actifartiste">Activité</label>
    <input type="text" class="form-control" name="active" id="actifartiste" value="<?php echo $row['active']; ?>">
  </div>
  <div class="form-group">
    <label for="labelartiste">Label</label>
    <input type="text" class="form-control" name="label" id="labelartiste" value="<?php echo $row['label']; ?>">
  </div>
  <div class="form-group">
    <label for="siteartiste">Site web</label>
    <input type="text" class="form-control" name="site_web" id="siteartiste" value="<?php echo $row['site_web']; ?>">
  </div>
  <div class="form-group">
    <label for="imageartiste">Image <small>(images jpeg ou png seulement)</small></label><br>
    <?php
    if(!empty($row['image']) && file_exists("../img/artistes/" . $row['image'])) {
      echo '<img class="img-thumbnail" style="max-width: 150px;" src="../img/artistes/'.html($row['image']).'" alt="Image de présentation de '.html($row['nom']).'" />';
    ?>
    <a href="javascript:delimage('<?php echo html($row['id']);?>','<?php echo html($row['image']);?>')">Supprimer l'image</a>
    <?php
     }
     else {
       echo 'Pas d\'image pour <i><b>'.html($row['nom']) . '</b></i>';
     }
     ?>
     <br>
     <input type="file" name="image" id="imageartiste" class="form-control">
  </div>
  <div class="form-group">
    <label for="youtubeartiste">Lien Youtube</label>
    <input type="text" class="form-control" name="youtube" id="youtubeartiste" value="<?php echo $row['youtube'] ?>"><br>
  </div>

  <div class="text-right pt-5"><button type='submit' class="btn btn-primary" name='update'>Editer la fiche</button></div>
</form>



</div>
</div>
</div>
</div>

<?php
require_once 'header.php';
?>
