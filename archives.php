<?php
$pagetitle = 'Archives par date : ' . $_GET['month'] . '/' . $_GET['year'];
include_once 'header.php';
?>

<?php
try {
//collect month and year data
$month = $_GET['month'];
$year = $_GET['year'];

$monthName = date_fr("F", mktime(0, 0, 0, html($_GET['month']), 10));
$yearNumber = date_fr(html($_GET['year']));

//set from and to dates
$from = date_fr('Y-m-01 00:00:00', strtotime("$year-$month"));
$to = date_fr('Y-m-31 23:59:59', strtotime("$year-$month"));

$pages = new Paginator('3','p');

$stmt = $db->prepare('SELECT id FROM artiste WHERE date >= :from AND date <= :to');
$stmt->execute(array(
		':from' => $from,
		':to' => $to
));

//pass number of records to
$pages->set_total($stmt->rowCount());

$stmt = $db->prepare('SELECT * FROM artiste WHERE date >= :from AND date <= :to ORDER BY id DESC ' .$pages->get_limit());
$stmt->execute(array(
    ':from' => $from,
    ':to' => $to
));
?>

<div class="container pt-3 pb-5">
  <div class="row">
    <div class="col-sm-12 px-3 py-3">

    <h2 class="pt-3 pb-4">Archives mois de <?php echo $monthName; ?> <?php echo $yearNumber; ?></h2>
		<?php
		while($row = $stmt->fetch()){
			echo '<div class="border my-3">';
			   echo '<h3 class="px-3 py-3"><a href="artiste.php?id='.html($row['id']).'">'.html($row['nom']).'</a></h3>';
			   echo '<p class="muted smalltext px-3">publié le '.date_fr('d-m-Y H:i:s', strtotime(html($row['date']))).' dans <em>' . html($row['genre']) . '</em></p>';

				 $max = 1000;
         $chaine = $row['presentation'];
         if (strlen($chaine) >= $max) {
	       	 $chaine = substr($chaine, 0, $max);
	       	 $espace = strrpos($chaine, " ");
	       	 $chaine = substr($chaine, 0, $espace).'... <span class="pl-1 font-weight-bold"><a href="artiste.php?id=' . html($row['id']) . '">Lire la suite</a></span>';
         }
         echo '<div class="px-3 text-justify">' . nl2br($chaine) . '</div>';

			   //echo '<div class="px-3 text-justify">' . nl2br($row['presentation']) . '</div>';
			   //echo '<p class="px-3"><a href="artiste.php?id=' . html($row['id']) . '">Lire la suite</a></p>';
			echo '</div>';
		}

		//echo '<div class="text-center">' . $pages->page_links("archives.php?month=$month&year=$year&") . '</div>';
		?>
		<div class="row justify-content-center">
      <div class="col-4">
        <?php echo $pages->page_links("archives.php?month=$month&year=$year&"); ?>
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
