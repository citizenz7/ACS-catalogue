<?php
$pagetitle = 'Bienvenue sur le site !';
include_once 'header.php';
?>

<?php include_once 'sidebar.php'; ?>

<!-- 5 derniers articles -->
<table class="table">
  <thead>
    <tr>
      <th scope="col">Artiste</th>
      <th scope="col">Genre</th>
      <th scope="col">Pays d'origine</th>
      <th scope="col">Lien</th>
    </tr>
  </thead>
  <tbody>
<?php
  try {
		$stmt = $db->query('SELECT * FROM artiste ORDER BY id DESC LIMIT 5');
    while($row = $stmt->fetch()) {
?>
    <tr>
      <th scope="row"><a href="artiste.php?id=<?php echo html($row['id']); ?>"><?php echo html($row['nom']); ?></a></th>
      <td><?php echo html($row['genre']); ?></td>
      <td><?php echo html($row['pays_origine']); ?></td>
      <td><a href="<?php echo html($row['site_web']); ?>">Site web</a></td>
    </tr>
  <?php
    } //while
  } // try
  catch(PDOException $e) {
    echo $e->getMessage();
  }
  ?>
</tbody>
</table>
<?php include "footer.php" ?>
