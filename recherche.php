<?php
include_once './includes/config.php';
$pagetitle = 'Recherche';
include_once 'header.php';
?>

<div class="container pt-5 pb-5">
  <div class="row">
    <div class="col-sm-12 px-3 py-3 text-justify border">

<?php
if(isset($_POST['requete']) && $_POST['requete'] != NULL) {
  $requete = html($_POST['requete']);
  $req = $db->prepare('SELECT * FROM artiste WHERE nom LIKE :requete ORDER BY date DESC');
  $req->execute(array('requete' => '%'.$requete.'%'));

  $nb_resultats = $req->rowCount();

  if($nb_resultats != 0) {
?>

<h4>Résultats de votre recherche</h4>
<p>Nous avons trouvé
  <?php
  echo $nb_resultats;
  if($nb_resultats > 1) {
    echo ' résultats :';
  }
  else {
    echo ' résultat :';
  }
  ?>
</p>

<table class="table table-hover">
  <thead class="thead-dark">
    <th>Nom de l'artiste/groupe</th>
  </thead>
  <tbody>
    <?php
    while($rech = $req->fetch()) {
    ?>
      <tr>
        <td><i class="fas fa-file-upload"></i> <a href="artiste.php?id=<?php echo html($rech['id']); ?>"><?php echo html($rech['nom']); ?></a></td>
      </tr>
      <?php
    } // fin de la boucle while
		?>
		</tbody>
  </table>

  <div class="pt-5">
    <p class="text-center lead font-weight-bold"><i class="fas fa-search"></i> Faire une <a href="recherche.php">nouvelle recherche</a></p>
    <p class="text-center font-weight-bold"><i class="fas fa-home"></i> Retourner sur <a href="index.php">l'accueil</a></p>
  </div>

	<?php
} // Fin d'affichage des résultats if

else {
?>
  <h4>Aucun résultat ! ;(</h4>
  <p>Nous n'avons trouvé aucun résultat pour votre requête "<?php echo html($_POST['requete']); ?>".</p>

  <div class="pt-5">
    <p class="text-center lead font-weight-bold"><i class="fas fa-search"></i> Faire une <a href="recherche.php">nouvelle recherche</a></p>
    <p class="text-center font-weight-bold"><i class="fas fa-home"></i> Retourner sur <a href="index.php">l'accueil</a></p>
  </div>

<?php
}// fin de l'affichage aucun résulat

$req->closeCursor(); // on ferme mysql

} // if isset $_POST['requete']

else { // formulaire html
?>

  <h2>Rechercher un artiste/groupe :</h2>
  <p class="pt-4">Veuillez entrer un ou plusieurs mots pour réaliser une recherche.<br>La recherche s'effectuera sur <b>le nom</b> de l'artiste ou du groupe.</p>
  <form class="form-group" action="" method="Post">
    <input type="text" class="form-control" placeholder="Veuillez entrer un ou plusieurs mots pour votre recherche" name="requete" size="40">
    <p class="text-right mt-2">
      <button type="reset" class="btn btn-secondary btn-sm">Annuler</button>
      <button type="submit" class="btn btn-primary btn-sm">Rechercher</button>
    </p>
  </form>

<?php
} // fin else
?>


</div>
</div>
</div>

<?php include_once 'footer.php'; ?>
