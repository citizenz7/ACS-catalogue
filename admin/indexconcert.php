

<?php
include_once '../includes/config.php';

//if not logged in redirect to login page
if(!$user->is_logged_in()){
  header('Location: login.php');
}

include_once 'header.php';
echo $page = end($link_array);
//Si on supprime l'image du projet...
		if(isset($_GET['delconcert'])) {
			$delimage = $_GET['delconcert'];
			//on supprime le fichier image
			$stmt = $db->prepare('SELECT imageconcert FROM concert WHERE idconcert = :idconcert');
			$stmt->execute(array(
				':idconcert' => $delimage
			));
			$sup = $stmt->fetch();
			$file = "../img/concerts/" . $sup['imageconcert'];
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
          <div class="text-center mt-5 mb-4 alert alert-primary" role="alert">Bienvenue <b><?php echo $_SESSION['username']; ?></b> ! Vous êtes connecté.</div>

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
                <td><span id="projets" class="lead font-weight-bold">Concerts</span></td>
                <td class="text-right"><a href="addconcert.php" class="mx-auto"><button type="button" class="btn btn-success btn-sm">Ajouter un concert</button></a></td>
              </tr>
            </table>

	  <table class="table table-sm table-hover table-responsive-sm">
	    <thead class="thead-light">
            <tr style="font-size:14px;">
              <th><a href="indexconcert.php?tri=idconcert&ordre=desc"><i class="fas fa-sort-up"></i></a>Id<a href="indexconcert.php?tri=idconcert&ordre=asc"><i class="fas fa-sort-down"></i></a></th>
              <th width="40%"><a href="indexconcert.php?tri=nomconcert&ordre=desc"><i class="fas fa-sort-up"></i></a>Nom<a href="indexconcert.php?tri=nomconcert&ordre=asc"><i class="fas fa-sort-down"></i></a</th>
              <th><a href="indexconcert.php?tri=lieuconcert&ordre=desc"><i class="fas fa-sort-up"></i></a>Lieu du concert<a href="indexconcert.php?tri=lieuconcert&ordre=asc"><i class="fas fa-sort-down"></i></a</th>
              <th><a href="indexconcert.php?tri=dateconcert&ordre=desc"><i class="fas fa-sort-up"></i></a>Date du concert<a href="indexconcert.php?tri=dateconcert&ordre=asc"><i class="fas fa-sort-down"></i></a</th>
              <th><a href="indexconcert.php?tri=binconcert&ordre=desc"><i class="fas fa-sort-up"></i></a>Corbeille<a href="indexconcert.php?tri=binconcert&ordre=asc"><i class="fas fa-sort-down"></i></a></th>
              <th class="text-center">Action</th>
	    </tr>
	    </thead>
	    <tbody>
              <?php
              try {
                //Pagination : on instancie la class
                $pages = new Paginator('7','conc');

                //on collecte tous les enregistrements de la fonction
                $stmt = $db->query('SELECT * FROM concert');

                //On détermine le nombre total d'enregistrements
                $pages->set_total($stmt->rowCount());
              }
              catch(PDOException $e) {
                echo $e->getMessage();
              }
                //On met en place le tri--------------------------------------------
						    if(isset($_GET['tri'])) {
							     $tri = html($_GET['tri']);
						    }
						    else {
							     $post_tri = 'dateconcert';
							     $tri = html($post_tri);
						    }

						    if(isset($_GET['ordre'])) {
							     $ordre = html($_GET['ordre']);
						    }
						    else {
							     $ordre_tri = 'desc';
							     $ordre = html($ordre_tri);
						    }
              //-----------------------------------------------------------------

						   // Protection du tri -----------------------------------------------
						   if (!empty($_GET['tri']) && !in_array($_GET['tri'], array('idconcert','nomconcert', 'presentationconcert', 'descriptionconcert', 'dateconcert', 'imageconcert', 'binconcert'))) {
							    header('Location: index.php');
							    exit();
						   }
						   if (!empty($_GET['ordre']) && !in_array($_GET['ordre'], array('asc','desc','ASC','DESC'))) {
							    header('Location: index.php');
							    exit();
						   }
						  // -----------------------------------------------------------------
              $stmt = $db->query('SELECT * FROM concert');
              while($row = $stmt->fetch()){
                echo '<tr>';
                echo '<td>'.$row['idconcert'].'</td>';
                echo '<td>'.$row['nomconcert'].'</td>';
                echo '<td>'.$row['lieuconcert'].'</td>';
                echo '<td>'.$row['dateconcert'].'</td>';
                ?>
                <td class="text-center">
                  <?php
                  if($row['binconcert'] == 1) {
                    echo 'oui';
                  }
                  else {
                    echo 'non';
                  }
                  ?>
                </td>
                <td class="text-center">
                  <a class="btn btn-primary btn-sm tinytext" role="button" aria-pressed="true" title="Editer la fiche" href="editconcert.php?idconcert=<?php echo $row['idconcert'];?>"><i class="fas fa-edit"></i></a> |

                  <?php
                  if($row['binconcert'] == 0) {
                  ?>
                    <a class="btn btn-warning btn-sm tinytext" role="button" aria-pressed="true" title="Mettre à la corbeille" href="javascript:desconcert('<?php echo $row['idconcert']; ?>','<?php echo $row['nomconcert']; ?>')"><i class="fas fa-trash"></i></a> |
                  <?php
                  }
                  else {
                  ?>
                    <a class="btn btn-success btn-sm tinytext" role="button" aria-pressed="true" title="Restaurer la fiche" href="javascript:restconcert('<?php echo $row['idconcert']; ?>','<?php echo $row['nomconcert']; ?>')"><i class="fas fa-plus-circle"></i></a> |
                  <?php
                  }
                  ?>

                  <a class="btn btn-danger btn-sm tinytext" role="button" aria-pressed="true" title="Supprimer la fiche" href="javascript:delconcert('<?php echo $row['idconcert'];?>','<?php echo $row['nomconcert'];?>')"><i class="fas fa-skull-crossbones"></i></a>
                </td>
                <?php

              }
            //----------------------------------------------------------
	      ?>
	    </tbody>
            </table>

            <?php
            /* Suppression dans SQL */
            if(isset($_GET['delconcert'])) {
              $stmt = $db->prepare('DELETE FROM concert WHERE idconcert = :idconcert') ;
              $stmt->execute(array(':idconcert' => $_GET['delconcert']));
              header('Location: indexconcert.php?action=deleted');
              exit;
            }

            /* Mettre à la corbeille fiche artiste */
            if(isset($_GET['desconcert'])) {
              $stmt = $db->prepare('UPDATE concert SET binconcert = 1 WHERE idconcert = :idconcert');
              $stmt->execute(array(':idconcert' => $_GET['desconcert']));
              header('Location: indexconcert.php?action=corbeille');
              exit;
            }

            /* Restaurer fiche artiste */
            if(isset($_GET['restconcert'])) {
              $stmt = $db->prepare('UPDATE concert SET binconcert = 0 WHERE idconcert = :idconcert');
              $stmt->execute(array(':idconcert' => $_GET['restconcert']));
              header('Location: indexconcert*.php?action=restaurer');
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
          <?php
           // echo $pages->page_links();
           ?>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<?php include_once 'footer.php'; ?>
