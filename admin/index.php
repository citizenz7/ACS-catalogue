
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
  <div class="container pt-3 pb-3 mt-5">
    <div class="row">
      <div class="col-sm-12 text-justify">
        <div class="pb-2 mt-3">
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
            <tr style="font-size:14px;">
              <th><a href="index.php?tri=id&ordre=desc"><i class="fas fa-sort-up"></i></a>Id<a href="index.php?tri=id&ordre=asc"><i class="fas fa-sort-down"></i></a></th>
              <th width="40%"><a href="index.php?tri=nom&ordre=desc"><i class="fas fa-sort-up"></i></a>Nom<a href="index.php?tri=nom&ordre=asc"><i class="fas fa-sort-down"></i></a</th>
              <th><a href="index.php?tri=date&ordre=desc"><i class="fas fa-sort-up"></i></a>Date d'ajout<a href="index.php?tri=date&ordre=asc"><i class="fas fa-sort-down"></i></a</th>
              <th><a href="index.php?tri=dateMAJ&ordre=desc"><i class="fas fa-sort-up"></i></a>Date de MAJ<a href="index.php?tri=dateMAJ&ordre=asc"><i class="fas fa-sort-down"></i></a></th>
              <th><a href="index.php?tri=bin&ordre=desc"><i class="fas fa-sort-up"></i></a>Corbeille<a href="index.php?tri=bin&ordre=asc"><i class="fas fa-sort-down"></i></a></th>
              <th class="text-center">Action</th>
	    </tr>
	    </thead>
	    <tbody>
              <?php
              try {
                //Pagination : on instancie la class
                $pages = new Paginator('7','art');

                //on collecte tous les enregistrements de la fonction
                $stmt = $db->query('SELECT id FROM artiste');

                //On détermine le nombre total d'enregistrements
                $pages->set_total($stmt->rowCount());

                // On met en place le tri--------------------------------------------
						    if(isset($_GET['tri'])) {
							     $tri = html($_GET['tri']);
						    }
						    else {
							     $post_tri = 'date';
							     $tri = html($post_tri);
						    }

						    if(isset($_GET['ordre'])) {
							     $ordre = html($_GET['ordre']);
						    }
						    else {
							     $ordre_tri = 'desc';
							     $ordre = html($ordre_tri);
						    }
              // -----------------------------------------------------------------

						   // Protection du tri -----------------------------------------------
						   if (!empty($_GET['tri']) && !in_array($_GET['tri'], array('id','nom', 'genre', 'pays', 'presentation', 'biographie', 'discographie', 'active', 'label', 'site_web', 'date', 'dateMAJ', 'image', 'youtube', 'bin'))) {
							    header('Location: index.php');
							    exit();
						   }
						   if (!empty($_GET['ordre']) && !in_array($_GET['ordre'], array('asc','desc','ASC','DESC'))) {
							    header('Location: index.php');
							    exit();
						   }
						  // -----------------------------------------------------------------

                $stmt = $db->query('SELECT * FROM artiste ORDER BY '.$tri.' '.$ordre.' ' .$pages->get_limit());
                while($row = $stmt->fetch()){

                  echo '<tr>';
                  echo '<td>'.$row['id'].'</td>';
                  echo '<td>'.$row['nom'].'</td>';
                  echo '<td class="small">'.date_fr('d-m-Y à H:i:s', strtotime(($row['date']))).'</td>';

                  if(!empty($row['dateMAJ'])) {
                    echo '<td class="small">'.date_fr('d-m-Y à H:i:s', strtotime(($row['dateMAJ']))).'</td>';
                  }
                  else {
                    echo '<td></td>';
                  }
                  ?>
                  <td class="text-center">
                    <?php
                    if($row['bin'] == 1) {
                      echo 'oui';
                    }
                    else {
                      echo 'non';
                    }
                    ?>
                  </td>
                  <td class="text-center">
                    <a class="btn btn-primary btn-sm tinytext" role="button" aria-pressed="true" title="Editer la fiche" href="edit.php?id=<?php echo $row['id'];?>"><i class="fas fa-edit"></i></a> |

                    <?php
                    if($row['bin'] == 0) {
                    ?>
                      <a class="btn btn-warning btn-sm tinytext" role="button" aria-pressed="true" title="Mettre à la corbeille" href="javascript:desartiste('<?php echo $row['id']; ?>','<?php echo $row['nom']; ?>')"><i class="fas fa-trash"></i></a> |
                    <?php
                    }
                    else {
                    ?>
                      <a class="btn btn-success btn-sm tinytext" role="button" aria-pressed="true" title="Restaurer la fiche" href="javascript:restartiste('<?php echo $row['id']; ?>','<?php echo $row['nom']; ?>')"><i class="fas fa-plus-circle"></i></a> |
                    <?php
                    }
                    ?>

                    <a class="btn btn-danger btn-sm tinytext" role="button" aria-pressed="true" title="Supprimer la fiche" href="javascript:delartiste('<?php echo $row['id'];?>','<?php echo $row['nom'];?>')"><i class="fas fa-skull-crossbones"></i></a>
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

            <?php
            /* Suppression dans SQL */
            if(isset($_GET['delartiste'])) {
              $stmt = $db->prepare('DELETE FROM artiste WHERE id = :id') ;
              $stmt->execute(array(':id' => $_GET['delartiste']));
              header('Location: index.php?action=deleted');
              exit;
            }

            /* Mettre à la corbeille fiche artiste */
            if(isset($_GET['desartiste'])) {
              $stmt = $db->prepare('UPDATE artiste SET bin = 1 WHERE id = :id');
              $stmt->execute(array(':id' => $_GET['desartiste']));
              header('Location: index.php?action=corbeille');
              exit;
            }

            /* Restaurer fiche artiste */
            if(isset($_GET['restartiste'])) {
              $stmt = $db->prepare('UPDATE artiste SET bin = 0 WHERE id = :id');
              $stmt->execute(array(':id' => $_GET['restartiste']));
              header('Location: index.php?action=restaurer');
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

            if(isset($_GET['action']) && $_GET['action'] == "corbeille"){
              echo '
              <div class="alert alert-info alert-dismissible fade show text-center font-weight-bold mt-4" role="alert">
                Fiche mise à la corbeille !
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              ';
            }

            if(isset($_GET['action']) && $_GET['action'] == "restaurer"){
              echo '
              <div class="alert alert-info alert-dismissible fade show text-center font-weight-bold mt-4" role="alert">
                Fiche restaurée !
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
</div>
</div>
<?php include_once 'footer.php'; ?>
