<?php include 'header.php'; ?>

<?php $id = $_GET['id'];

try {
  $stmt = $db->query("SELECT * FROM artiste WHERE id=$id");
  while($row = $stmt->fetch()) {
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
  } //while
} // try
catch (\Exception $e) {
  echo $e->getMessage();
}


?>

<?php include 'footer.php'; ?>
