<?php
include_once '../includes/config.php';

//if not logged in redirect to login page
if(!$user->is_logged_in()){
  header('Location: login.php');
}

include_once 'header.php';

//Si on supprime l'image du article...
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

  <div class="container pt-5 pb-5">
    <div class="row">
      <div class="col-sm-12 px-5 text-justify">
        <div class="pb-5">

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

    // location where initial upload will be moved to
    $target = $_FILES['image']['name'];
    $path = '../img/artistes/'.$target;

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($id ==''){
			$error[] = 'Probleme. Votre fiche n\'a pas d\'ID ?!!';
		}

		if($nom ==''){
			$error[] = 'Veuillez entrer un nom de d\'artiste ou de groupe';
		}

		if($presentation ==''){
			$error[] = 'Veuillez entrer une présentation';
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

				//insert into database
				$stmt = $db->prepare('UPDATE artiste SET nom = :nom, genre = :genre, pays_origine = :pays_origine, presentation = :presentation, biographie = :biographie, discographie = :discographie, active = :active, label = :label, site_web = :site_web, date = :date, youtube = :youtube
          WHERE id = :id');
				$stmt->execute(array(
					':nom' => $nom,
					':genre' => $genre,
          ':pays_origine' => $pays_origine,
          ':presentation' => $presentation,
          ':biographie' => $biographie,
          ':discographie' => $discographie,
          ':active' => $active,
          ':label' => $label,
          ':site_web' => $site_web,
          ':date' => date('Y-m-d H:i:s'),
          ':youtube' => $youtube,
          ':id' => $id
				));

        if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
	         $stmt = $db->prepare('UPDATE artiste SET image = :image WHERE id = :id');
            $stmt->execute(array(
              ':image' => $target,
              ':id' => $id
             ));
        }

				//redirect to index page
				header('Location: index.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	?>


	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
		}
	}

		try {

			$stmt = $db->prepare('SELECT * FROM artiste WHERE id = :id') ;
			$stmt->execute(array(':id' => $_GET['id']));
			$row = $stmt->fetch();

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

  <?php
  include('menu.php');
  ?>

  <div class="pt-3"><h3>Editer la fiche de l'artiste/groupe : "<?php echo $row['nom']; ?>"</h3></div>

  <form action="" method="post" enctype="multipart/form-data">
    <input type='hidden' name='id' value='<?php echo $row['id'];?>'>
     <div class="form-group">
       <label for="artistenom">Nom</label>
       <input type="text" name="nom" class="form-control" id="artistenom" value="<?php echo html($row['nom']); ?>">
     </div>
     <div class="form-group">
       <label for="artistegenre">Genre</label>
       <input type="text" name="genre" class="form-control" id="artistegenre" value="<?php echo html($row['genre']); ?>">
     </div>
     <div class="form-group">
       <label for="artistepays">Pays d'origine</label>
       <input type="text" name="pays_origine" class="form-control" id="artistepays" value="<?php echo html($row['pays_origine']); ?>">
     </div>
     <div class="form-group">
       <label for="artistepres">Description</label>
       <textarea name="presentation" class="form-control" id="artistepres" rows="10"><?php echo html($row['presentation']); ?></textarea>
     </div>
     <div class="form-group">
       <label for="artistebio">Biographie</label>
       <textarea name="biographie" class="form-control" id="artistebio" rows="10"><?php echo html($row['biographie']); ?></textarea>
     </div>
     <div class="form-group">
       <label for="artistedisco">Discographie</label>
       <textarea name="discographie" class="form-control" id="artistedisco" rows="10"><?php echo html($row['discographie']); ?></textarea>
     </div>
     <div class="form-group">
       <label for="artisteactive">Années d'activité</label>
       <input type="text" name="active" class="form-control" id="artisteactive" value="<?php echo html($row['active']); ?>">
     </div>
     <div class="form-group">
       <label for="artistelabel">Label</label>
       <input type="text" name="label" class="form-control" id="artistelabel" value="<?php echo html($row['label']); ?>">
     </div>
     <div class="form-group">
       <label for="artistesite">Site web</label>
       <input type="text" name="site_web" class="form-control" id="artistesite" value="<?php echo html($row['site_web']); ?>">
     </div>
     <div class="form-group">
       <label for="image">Image <small>(images jpeg ou png seulement)</small></label><br>
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
        <input type="file" name="image" class="form-control">
      </div>
      <div class="form-group">
        <label for="artisteyoutube">Youtube</label>
        <input type="text" name="youtube" class="form-control" id="artisteyoutube" value="<?php echo html($row['youtube']); ?>">
      </div>
      <div class="text-right pt-5"><button type='submit' class="btn btn-primary" name='submit'>Editer l'article</button></div>
  </form>

</div>
</div>
</div>
</div>
</div>
</div>

<?php include_once 'footer.php'; ?>
