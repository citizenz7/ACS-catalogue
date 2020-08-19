<?php
include_once './includes/config.php';
$pagetitle = 'Archives par genre';
include_once 'header.php';
?>

<?php
try {
//collect month and year data
$genre = $_GET['genre'];

$pages = new Paginator('3','p');

$stmt = $db->prepare('SELECT * FROM artiste WHERE genre = :genre');
$stmt->execute(array(
		':genre' => $genre
));

//pass number of records to
$pages->set_total($stmt->rowCount());

$stmt = $db->prepare('SELECT * FROM artiste WHERE genre = :genre ORDER BY id DESC ' .$pages->get_limit());
$stmt->execute(array(
    ':genre' => $genre
));
?>

<div class="container pt-3 pb-5">
  <div class="row">
    <div class="col-sm-12 px-3 py-3">

          <h2 class="pt-3 pb-4">Archives pour le genre : <?php echo html($genre); ?></h2>
		<?php
		while($row = $stmt->fetch()){
			echo '<div class="border my-3">';
			   echo '<h3 class="px-3 py-3"><a href="artiste.php?id='.html($row['id']).'">'.html($row['nom']).'</a></h3>';
			   echo '<p class="muted smalltext px-3">publié le '.date_fr('d-m-Y H:i:s', strtotime(html($row['date']))).' dans <em>' . html($row['genre']) . '</em></p>';
			   echo '<div class="px-3 text-justify">' . nl2br($row['presentation']) . '</div>';
			   echo '<p class="px-3"><a href="artiste.php?id=' . html($row['id']) . '">Lire la suite</a></p>';
			echo '</div>';
		}

		//echo '<div class="text-center">' . $pages->page_links("archives.php?month=$month&year=$year&") . '</div>';
		?>
		<div class="row justify-content-center">
          		<div class="col-4">
            			<?php echo $pages->page_links("archives.php?genre=$genre&"); ?>
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
