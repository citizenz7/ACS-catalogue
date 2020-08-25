<?php include_once './includes/config.php';
$pagetitle = 'Nous contacter';
include_once 'header.php'; ?>



<div class="container">

  <div class="row">
    <div class="col-sm-12">
      <h4 class="py-3 px-3"><i class="fas fa-headphones"></i> Les dernières fiches :</h4><hr>
    </div>
  </div>


<!-- 5 derniers articles -->
<div id="back2" class="row px-3 py-5">

  <?php
    try {
      //pagination
      $pages = new Paginator('9','art');

      //on collecte tous les enregistrements de la fonction
      $stmt = $db->query('SELECT idconcert FROM concert');

      //On détermine le nombre total d'enregistrements
      $pages->set_total($stmt->rowCount());

		  $stmt = $db->query('SELECT * FROM concert ORDER BY idconcert DESC ' . $pages->get_limit());
      while($row = $stmt->fetch()) {
      ?>

      <div class="col-md-4">
        <div class="profile-card-6 border">
          <?php
          if(!empty($row['imageconcert'])) {
          ?>
          <img src="./img/concerts/<?php echo $row['imageconcert']; ?>" class="img-fluid">
          <?php }
          else {
          ?>
            <img src="./img/nophoto.png" class="img-fluid">
          <?php
          }
          ?>
          <!-- <div class="profile-name"><a class="text-decoration-none text-white" target="_blank" href="artiste.php?id=<?php echo html($row['id']); ?>"><?php echo html($row['nom']); ?></a></div> -->
          <div class="profile-name"><a class="text-decoration-none text-white" target="_blank" href="artisteconcert.php?idconcert=<?php echo $row["idconcert"]; ?>"><?php echo html($row['nomconcert']); ?></a></div>
          <div class="profile-position"><?php echo $row['lieuconcert']; ?></div>
          <div class="profile-overview">
            <div class="profile-overview">
              <div class="row text-card">
                <div class="col-xs-4">
                  <?php echo $row['dateconcert']; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
      } //while
    } // try
    catch(PDOException $e) {
      echo $e->getMessage();
    }
    ?>
</div>

<!-- Pagination -->
<div class="row justify-content-center">
  <div class="col-12 text-center mt-4 mb-3 pt-1 border">
	   <?php
	     echo $pages->page_links();
	   ?>
  </div>
</div>


</div>














<?php
include_once 'footer.php';
?>
