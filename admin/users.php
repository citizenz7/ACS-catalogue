<?php
include_once '../includes/config.php';
require_once 'header.php';

//if not logged in redirect to login page
if(!$user->is_logged_in()){
  header('Location: login.php');
}
?>

<div class="container pt-3 pb-5">
  <div class="row">
    <div class="col-sm-12 text-justify">
      <div class="pb-5">

      <?php include_once 'menu.php'; ?>

      <table class="table">
        <tr>
          <td><span class="lead font-weight-bold">Gestion des utilisateurs</span></td>
          <td class="text-right"><a href="add-user.php" class="mx-auto"><button type="button" class="btn btn-success btn-sm">Ajouter un utilisateur</button></a></td>
        </tr>
      </table>

      <table class="table table-sm">
        <tr>
          <th>ID</th>
          <th>Pseudo</th>
          <th>E-mail</th>
          <th>Action</th>
          </tr>

<?php
$stmt = $db->query('SELECT memberID, username, email FROM membres ORDER BY username');
while($row = $stmt->fetch()){
?>

<?php
    echo '<tr class="smalltext">';
    echo '<td>'.$row['memberID'].'</td>';
    echo '<td>'.$row['username'].'</td>';
    echo '<td>'.$row['email'].'</td>';
    ?>

    <td>
        <a class="btn btn-primary btn-sm" role="button" aria-pressed="true" title="Editer le projets" href="edit-user.php?id=<?php echo $row['memberID'];?>">Editer</a>
        <!-- On ne peut pas effacer le User N°1, l'admin -->
        <?php if($row['memberID'] != 1){?>
            | <a class="btn btn-danger btn-sm" role="button" aria-pressed="true" title="Supprimer le projet"href="javascript:deluser('<?php echo $row['memberID'];?>','<?php echo $row['username'];?>')">Supprimer</a>
        <?php } ?>
    </td>

    <?php
  }
  ?>

</tr>
</table>


<?php
if(isset($_GET['deluser'])){

    //if user id is 1 ignore
    if($_GET['deluser'] !=1){

        $stmt = $db->prepare('DELETE FROM membres WHERE memberID = :memberID') ;
        $stmt->execute(array(':memberID' => $_GET['deluser']));

        header('Location: users.php?action=deleted');
        exit;

    }
}
?>

</div>
</div>
</div>
</div>

<?php include_once 'footer.php'; ?>
