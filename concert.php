<?php
include_once './includes/config.php';
$pagetitle = 'Les concerts';
include_once 'header.php';
?>

<div class="container">

  <div class="row">
    <div class="col-sm-12">
      <h4 class="py-3 px-3"><i class="fas fa-headphones"></i> Les derniers concerts :</h4><hr>
    </div>
  </div>


<!-- 5 derniers articles -->
<div id="back2" class="row px-3 py-5">

  <?php
    try {
      //pagination
      $pages = new Paginator('3','conc');

      //on collecte tous les enregistrements de la fonction
      $stmt = $db->query('SELECT idconcert FROM concert');

      //On détermine le nombre total d'enregistrements
      $pages->set_total($stmt->rowCount());

      $stmt = $db->query('SELECT * FROM concert WHERE binconcert = 0 ORDER BY idconcert DESC ' . $pages->get_limit());
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
          <div class="profile-name"><a class="text-decoration-none text-white" target="_blank" href="artisteconcert.php?idconcert=<?php echo html($row['idconcert']); ?>"><?php echo html($row['nomconcert']); ?></a></div>
	        <div class="profile-position text-white font-weight-bold" style="font-size: 13px;">Date : <?php echo date_fr('d-m-Y', strtotime(($row['dateconcert']))); ?>, à <?php echo $row['heureconcert']; ?></div>
	        <div class="profile-overview text-white font-weight-bold" style="font-size: 13px; padding-left: 30px;">Lieu : <?php echo $row['lieuconcert']; ?></div>

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

<?php include "footer.php" ?>
