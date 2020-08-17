<?php
include_once './includes/config.php';
$pagetitle = 'Bienvenue sur le site de catalogue de musique !';
include_once 'header.php';
?>

<?php include_once 'sidebar.php'; ?>

<!-- 5 derniers articles -->
<?php
  try {
		$stmt = $db->query('SELECT * FROM artiste ORDER BY id DESC LIMIT 5');
    while($row = $stmt->fetch()) {
?>

  <?php
    echo html($row['nom']) . '<br>';
    echo html($row['genre']) . '<br>';
    echo html($row['pays_origine']) . '<br>';
    echo html($row['biographie']) . '<br>';
    echo html($row['discographie']) . '<br>';
    echo html($row['active']) . '<br>';
    echo html($row['label']) . '<br>';
    echo html($row['site_web']) . '<br>';
    echo html($row['image']) . '<br>';
    echo html($row['youtube']);
  ?>

  <?php
    } //while

  } // try

  catch(PDOException $e) {
    echo $e->getMessage();
  }
  ?>

<?php include "footer.php" ?>
