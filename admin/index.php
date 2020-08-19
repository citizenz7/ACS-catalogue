
<?php
include_once '../includes/config.php';

//if not logged in redirect to login page
if(!$user->is_logged_in()){
  header('Location: login.php');
}

include_once 'header.php';

//Si on supprime l'image du projet...
		if(isset($_GET['delartiste'])) {
			$delimage = $_GET['delartiste'];
			//on supprime le fichier image
			$stmt = $db->prepare('SELECT image FROM artiste WHERE id = :id');
			$stmt->execute(array(
				':id' => $delimage
			));
			$sup = $stmt->fetch();
			$file = "../img/" . $sup['image'];
			if (file_exists($file)) {
				unlink($file);
			}
			//puis on supprime l'image dans la base
			// $stmt = $db->prepare('UPDATE projets SET projetImage = NULL WHERE projetID = :projetID');
			// $stmt->execute(array(
      //   ':projetID' => $delimage
      // ));
			// header('Location: edit-projet.php?id='.$delimage);
		}

?>

<!-- Projets -->
  <div class="container pt-3 pb-3">
    <div class="row">
      <div class="col-sm-12 text-justify">
        <div class="pb-2">
          <div class="text-center mb-4 alert alert-primary" role="alert">Bienvenue <b><?php echo $_SESSION['username']; ?></b> ! Vous êtes connecté.</div>

	  <?php
	  if(isset($_GET['action']) && $_GET['action'] == "updated"){
              echo '
              <div class="alert alert-success alert-dismissible fade show text-center font-weight-bold mt-4" role="alert">
                Fiche mise à jour !
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              ';
            }
	  ?>

          <?php include('menu.php');?>

            <table class="table table-responsive-sm">
              <tr>
                <td><span id="projets" class="lead font-weight-bold">Artistes</span></td>
                <td class="text-right"><a href="add.php" class="mx-auto"><button type="button" class="btn btn-success btn-sm">Ajouter un artiste/groupe</button></a></td>
              </tr>
            </table>

	  <table class="table table-sm table-hover table-responsive-sm">
	    <thead class="thead-light">
            <tr>
              <th>ID</th>
              <th width="70%">Nom</th>
              <th>Date d'ajout</th>
              <th class="text-center">Action</th>
	    </tr>
	    </thead>
	    <tbody>
              <?php
              try {
                //Pagination : on instancie la class
                $pages = new Paginator('5','art');

                //on collecte tous les enregistrements de la fonction
                $stmt = $db->query('SELECT id FROM artiste');

                //On détermine le nombre total d'enregistrements
                $pages->set_total($stmt->rowCount());

                $stmt = $db->query('SELECT * FROM artiste ORDER BY id DESC ' .$pages->get_limit());
                while($row = $stmt->fetch()){

                  echo '<tr>';
                  echo '<td>'.$row['id'].'</td>';
                  echo '<td>'.$row['nom'].'</td>';
                  echo '<td class="small">'.date_fr('d-m-Y à H:i:s', strtotime(($row['date']))).'</td>';
                  ?>
                  <td class="text-center">
                    <a class="btn btn-primary btn-sm tinytext" role="button" aria-pressed="true" title="Editer la fiche" href="edit.php?id=<?php echo $row['id'];?>">Editer</a> |
                    <a class="btn btn-danger btn-sm tinytext" role="button" aria-pressed="true" title="Supprimer la fiche" href="javascript:delartiste('<?php echo $row['id'];?>','<?php echo $row['nom'];?>')">Suppr.</a>
                  </td>
                  <?php
                  echo '</tr>';
                }

              }
              catch(PDOException $e) {
                echo $e->getMessage();
              }
	      ?>
	    </tbody>
            </table>

            <!-- Delete in SQL -->
            <?php
            if(isset($_GET['delartiste'])) {
              $stmt = $db->prepare('DELETE FROM artiste WHERE id = :id') ;
              $stmt->execute(array(':id' => $_GET['delartiste']));

              header('Location: index.php?action=deleted');
              exit;
            }

            if(isset($_GET['action']) && $_GET['action'] == "deleted"){
              echo '
              <div class="alert alert-info alert-dismissible fade show text-center font-weight-bold mt-4" role="alert">
                Fiche supprimée !
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              ';
            }
            ?>

      </div>
      <!-- Pagination -->
      <div class="row justify-content-center">
        <div class="col-4">
          <?php echo $pages->page_links(); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once 'footer.php'; ?>
