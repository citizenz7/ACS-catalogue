<?php
include_once './includes/config.php';
$pagetitle = 'Bienvenue sur le site de catalogue de musique !';
include_once 'header.php';
?>



<!-- 5 derniers articles -->
<div class="container pt-5">
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
      <td><a href="artiste.php?id=<?php echo html($row['id']); ?>"><?php echo html($row['nom']); ?></a></td>
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
</div>
<?php include "footer.php" ?>
