<?php
include_once '../includes/config.php';

//if not logged in redirect to login page
if(!$user->is_logged_in()){
	header('Location: login.php');
}

include_once 'header.php';

//Si on supprime l'image du article...
		if(isset($_GET['delimageconcert'])) {
			$delimageconcert = $_GET['delimageconcert'];
			//on supprime le fichier image
			$stmt = $db->prepare('SELECT imageconcert FROM concert WHERE idconcert = :idconcert');
			$stmt->execute(array(
				':idconcert' => $delimageconcert
			));
			$sup = $stmt->fetch();
			$file = "../img/concerts/" . $sup['imageconcert'];
			if (file_exists($file)) {
				unlink($file);
			}
			//puis on supprime l'image dans la base
			$stmt = $db->prepare('UPDATE concert SET imageconcert = NULL WHERE idconcert = :idconcert');
			$stmt->execute(array(
        			':idconcert' => $delimageconcert
      		));
		header('Location: editconcert.php?idconcert='.$delimageconcert);
		}
?>

  <div class="container mt-5">
    <div class="row">
      <div class="col-sm-12 px-3 mt-5 text-justify">
        <div class="pb-5">


	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		//collect form data
    extract($_POST);

    // location where initial upload will be moved to
   	$target = $idconcert . '-' . $_FILES['imageconcert']['name'];
		$path = '../img/concerts/'.$target;

		$_POST = array_map( 'stripslashes', $_POST );

		//very basic validation
		if($idconcert ==''){
			$error[] = 'Probleme. Votre fiche n\'a pas d\'ID ?!!';
		}

		if($nomconcert ==''){
			$error[] = 'Veuillez entrer un nom de concert';
		}

		if($presentationconcert ==''){
			$error[] = 'Veuillez entrer une présentation';
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

        $slug = slug($nom);

				//insert into database
				$stmt = $db->prepare('UPDATE concert SET nomconcert = :nomconcert, lieuconcert = :lieuconcert, dateconcert = :dateconcert, imageconcert = :imageconcert, presentationconcert = :presentationconcert, descriptionconcert = :descriptionconcert WHERE idconcert = :idconcert');
				$stmt->execute(array(
					':nomconcert' => $nomconcert,
					':lieuconcert' => $lieuconcert,
          				':dateconcert' => $dateconcert,
          				':imageconcert' => $imageconcert,
          				':presentationconcert' => $presentationconcert,
          				':descriptionconcert' => $descriptionconcert,
          				':idconcert' => $idconcert
				));

        if(isset($_FILES['imageconcert']['name']) && !empty($_FILES['imageconcert']['name'])) {
	         $stmt = $db->prepare('UPDATE concert SET imageconcert = :imageconcert WHERE idconcert = :idconcert');
            $stmt->execute(array(
              ':imageconcert' => $target,
              ':idconcert' => $idconcert
             ));
        }

				//redirect to index page
				header('Location: indexconcert.php?action=updated');
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

			$stmt = $db->prepare('SELECT * FROM concert WHERE idconcert = :idconcert') ;
			$stmt->execute(array(':idconcert' => $_GET['idconcert']));
			$row = $stmt->fetch();

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<div class="text-center mt-5 mb-4 alert alert-primary" role="alert">Bienvenue <b><?php echo $_SESSION['username']; ?></b> ! Vous êtes connecté.</div>

  <?php
  include('menu.php');
  ?>

  <div class="pt-3"><h3>Editer la fiche du concert : "<?php echo $row['nomconcert']; ?>"</h3></div>

  <form action="" method="post" enctype="multipart/form-data">
    <input type='hidden' name='idconcert' value='<?php echo $row['idconcert'];?>'>
     <div class="form-group">
       <label for="nomconcert">Nom</label>
       <input type="text" name="nomconcert" class="form-control" id="nomconcert" value="<?php echo html($row['nomconcert']); ?>">
     </div>
     <div class="form-group">
       <label for="lieuconcert">Lieu</label>
       <input type="text" name="lieuconcert" class="form-control" id="lieuconcert" value="<?php echo html($row['lieuconcert']); ?>">
     </div>
     <div class="form-group">
       <label for="dateconcert">Date</label>
       <input type="text" name="dateconcert" class="form-control" id="dateconcert" value="<?php echo html($row['dateconcert']); ?>">
     </div>
     <div class="form-group">
       <label for="descconcert">Description</label>
       <textarea name="descriptionconcert" class="form-control" id="descconcert" rows="10"><?php echo html($row['descriptionconcert']); ?></textarea>
     </div>
     <div class="form-group">
       <label for="Presconcert">Presentation</label>
       <textarea name="presentationconcert" class="form-control" id="presconcert" rows="10"><?php echo html($row['presentationconcert']); ?></textarea>
     </div>
     <div class="form-group">
       <label for="image">Image <small>(images jpeg ou png seulement)</small></label><br>
       <?php
       if(!empty($row['imageconcert']) && file_exists("../img/concerts/" . $row['imageconcert'])) {
         echo '<img class="img-thumbnail" style="max-width: 150px;" src="../img/concerts/'.html($row['imageconcert']).'" alt="Image de présentation de '.html($row['nomconcert']).'" />';
			 }
			 else {
				 echo 'Pas d\'image pour <i><b>'.html($row['nomconcert']) . '</b></i>';
			 }
			 ?>
			 <a href="javascript:delimageconcert('<?php echo html($row['idconcert']);?>','<?php echo html($row['imageconcert']);?>')">Supprimer l'image</a>
        <br>
        <input type="file" name="imageconcert" class="form-control">
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
