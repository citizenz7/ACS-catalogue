<?php
include_once './includes/config.php';
$pagetitle = 'Archives par nom : ' . $_GET['nom'];
include_once 'header.php';
?>

<?php
try {
//collect month and year data
$nom = $_GET['nom'];

$pages = new Paginator('3','p');

$stmt = $db->prepare('SELECT * FROM artiste WHERE nom = :nom');
$stmt->execute(array(
		':nom' => $nom
));

//pass number of records to
$pages->set_total($stmt->rowCount());

$stmt = $db->prepare('SELECT * FROM artiste WHERE nom = :nom ORDER BY id DESC ' .$pages->get_limit());
$stmt->execute(array(
    ':nom' => $nom
));
?>

<div class="container mt-5 pb-5">
  <div class="row">
    <div class="col-sm-12 px-3 py-3">

          <h2 class="pt-5 pb-4">Archives pour le nom : <?php echo html($nom); ?></h2>
		<?php
		while($row = $stmt->fetch()){
			echo '<div class="border my-3">';
			   echo '<h3 class="px-3 py-3"><a href="' . html($row['slug']) . '">' . html($row['nom']) . '</a></h3>';
			   echo '<p class="muted smalltext px-3">publié le ' . date_fr('d-m-Y H:i:s', strtotime(html($row['date']))) . ' dans <em>' . html($row['nom']) . '</em></p>';

				 $max = 1000;
         $chaine = $row['presentation'];
         if (strlen($chaine) >= $max) {
	       	 $chaine = substr($chaine, 0, $max);
	       	 $espace = strrpos($chaine, " ");
	       	 $chaine = substr($chaine, 0, $espace).'<span class="pl-1 font-weight-bold"><a class="text-danger" href="artiste.php?id=' . html($row['id']) . '">... [ Lire la suite ]</a></span>';
         }
         echo '<div class="px-3 py-3 text-justify">' . nl2br($chaine) . '</div>';

				 // echo '<div class="px-3 text-justify">' . nl2br($row['presentation']) . '</div>';
			   //echo '<p class="px-3"><a href="artiste.php?id=' . html($row['id']) . '">Lire la suite</a></p>';
			echo '</div>';
		}

		//echo '<div class="text-center">' . $pages->page_links("archives.php?month=$month&year=$year&") . '</div>';
		?>
		<div class="row justify-content-center">
          		<div class="col-4">
            			<?php echo $pages->page_links("archives.php?nom=$nom&"); ?>
          		</div>
        	</div>
		<?php
}

catch(PDOException $e) {
	echo $e->getMessage();
}
?>

</div>
</div>
</div>

<?php include_once 'footer.php'; ?>
