<?php
include_once './includes/config.php';
$pagetitle = 'Bienvenue sur le site de catalogue de musique de l\'ACS Nevers !';
include_once 'header.php';
?>

<!-- 5 derniers articles -->
<div class="container pt-3">
  <div class="row">
  <div class="table-responsive">
    <table class="table table-sm table-hover">
      <thead class="thead-dark">
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
            //pagination
            $pages = new Paginator('5','art');

            //on collecte tous les enregistrements de la fonction
            $stmt = $db->query('SELECT id FROM artiste');
            //On détermine le nombre total d'enregistrements
            $pages->set_total($stmt->rowCount());

		        $stmt = $db->query('SELECT * FROM artiste ORDER BY id DESC ' . $pages->get_limit());
            while($row = $stmt->fetch()) {
              ?>
              <tr>
                <td><a class="lead font-weight-bold" href="artiste.php?id=<?php echo html($row['id']); ?>"><?php echo html($row['nom']); ?></a></td>
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
  </div>

  <!-- Pagination -->
  <div class="row justify-content-center border mb-3">
    <div class="mx-auto py-2">
	     <?php
	     echo $pages->page_links();
	     ?>
    </div>
  </div>

<div class="row">

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
              $monthName = date_fr("F", mktime(0, 0, 0, html($row['Month']), 10));
              $year = date_fr(html($row['Year']));
              echo "<option value='archives.php?month=" . html($row['Month']) . "&year=" . html($row['Year']) . "'>" . html($monthName) . "-" . html($row['Year']) . "</option>";
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
              echo "<option value='archives2.php?genre=" . html($row['genre']) . "'>" . html($row['genre']) . "</option>";
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
