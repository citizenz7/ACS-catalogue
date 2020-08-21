<?php
$pagetitle = 'Bienvenue sur le site de catalogue de musique de l\'ACS Nevers !';
include_once 'header.php';
?>

<div id="intro" class="container-fluid">
  <div class="col-sm-12 pl-4 py-5 text-center text-white">
    <p class="text-center py-5">
      <img class="img-fluid" src="./img/logo.png" alt="logo ACS GROOVE" style="max-height: 350px;">
    </p>
    <!-- <i class="fas fa-microphone fa-5x pr-5"></i><i class="fas fa-music fa-5x pr-5"></i><i class="fas fa-headphones fa-5x"></i> -->
    <br>
    <h2 class="font-weight-bold pt-3">ACS Groove</h2>
    <h3>Le site qu'il est vachement bien !</h3>
    <h3>Musicalement parlant !</h3>
  </div>
</div>

<div class="container">

  <div class="row">
    <div class="col-sm-12">
      <h4 class="py-3 px-3"><i class="fas fa-headphones"></i> Les dernières fiches :</h4><hr>
    </div>
  </div>


<!-- 5 derniers articles -->
<div class="row">

<!--<div class="col-sm-12 pl-4 pb-3 ml-3 text-center">
      <h3 class="font-weight-bold">ACS Groove : le site qu'il est vachement bien ! ... Musicalement parlant !</h3>
      <h4><i class="fas fa-headphones"></i> Les dernières fiches :</h4>
    </div> -->

  <?php
    try {
      //pagination
      $pages = new Paginator('9','art');

      //on collecte tous les enregistrements de la fonction
      $stmt = $db->query('SELECT id FROM artiste');

      //On détermine le nombre total d'enregistrements
      $pages->set_total($stmt->rowCount());

		  $stmt = $db->query('SELECT * FROM artiste ORDER BY id DESC ' . $pages->get_limit());
      while($row = $stmt->fetch()) {
      ?>

      <div class="col-md-4">
        <div class="profile-card-6">
          <img src="./img/artistes/<?php echo $row['image']; ?>" class="img-fluid">
          <div class="profile-name"><a class="text-decoration-none text-white" target="_blank" href="artiste.php?id=<?php echo html($row['id']); ?>"><?php echo html($row['nom']); ?></a></div>
          <div class="profile-position"><?php echo $row['genre']; ?></div>
          <div class="profile-overview">
            <div class="profile-overview">
              <div class="row text-card">
                <div class="col-xs-4">
                  <?php echo $row['pays_origine']; ?>
                </div>
                <div class="col-xs-4">
                  <a href="<?php echo $row['youtube'] ?>">
                    <img src="./img/icons/youtube.png" alt="youtube">
                  </a>
                </div>
                <div class="col-xs-4">
                  <a href="<?php echo $row['site_web'] ?>">
                    <img src="./img/icons/www.png" alt="site web">
                  </a>
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
<div class="row justify-content-center mb-3">
  <div class="mx-auto py-2">
	   <?php
	   echo $pages->page_links();
	   ?>
  </div>
</div>

<div class="row pb-5">

  <div class="col-sm-6 mt-3">
    <div class="card">
      <div class="card-body text-center">
        <h5 class="card-title">Archives par date</h5>
        <p class="card-text">
          Vous trouverez ci-dessous les archives classées par mois et années
          <select onchange="document.location.href = this.value" class="custom-select custom-select-sm smalltext mt-4">
            <option selected>Mois - années</option>
            <?php
            $stmt = $db->query("SELECT Month(date) as Month, Year(date) as Year FROM artiste GROUP BY Month(date), Year(date) ORDER BY date DESC");
            while($row = $stmt->fetch()){
              $monthName = date_fr("F", mktime(0, 0, 0, $row['Month'], 10));
              $year = date_fr($row['Year']);
              echo "<option value='archives.php?month=" . $row['Month'] . "&year=" . $row['Year'] . "'>" . $monthName . "-" . $row['Year'] . "</option>";
            }
            ?>
          </select>
        </p>
      </div>
    </div>
  </div>

  <div class="col-sm-6 mt-3">
    <div class="card">
      <div class="card-body text-center">
        <h5 class="card-title">Archives par genre</h5>
        <p class="card-text">
          Vous trouverez ci-dessous les archives classées par genre musical
          <select onchange="document.location.href = this.value" class="custom-select custom-select-sm smalltext mt-4">
            <option selected>Genre</option>
            <?php
            $stmt = $db->query("SELECT genre FROM artiste GROUP BY genre ORDER BY genre DESC");
            while($row = $stmt->fetch()){
              echo "<option value='archives2.php?genre=" . $row['genre'] . "'>" . $row['genre'] . "</option>";
            }
            ?>
          </select>
        </p>
      </div>
    </div>
  </div>

</div>

</div>

<?php include "footer.php" ?>
