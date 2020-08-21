<?php
//include config
require_once('../includes/config.php');

include_once 'header.php';

//if not logged in redirect to login page
if($user->is_logged_in()){
  header('Location: index.php');
}
?>

<div class="container-fluid">
  <div class="container pt-3 pb-5">
    <div class="row text-center">
      <div class="col-md-4 offset-md-4 mt-5">
        <div class="card mt-5">
          <div class="card-body mt-1">
            <i class="fas fa-sign-in-alt fa-4x"></i>
            <div class="pb-3">
              <h4>Connexion Espace Admin</h4>
            </div>
            <form action="" method="post">
              <div class="form-group py-2 px-2">
                <label for="usernameInput">Pseudo</label>
                <input type="text" class="form-control" id="UsernameInput" aria-describedby="unsernameHelp" name="username" value="">
              </div>
              <div class="form-group">
                <label for="passwordInput">Mot de passe</label>
                <input type="password" class="form-control" id="passwordInput" name="password" value="">
              </div>
              <button type="submit" class="btn btn-primary btn-block" name="submit">Connexion</button>
            </form>
          </div>
          <div class="logi-forgot text-center mt-2 small">
						<a href="recup_pass.php">Mot de passe oublié ?</a></p>
					</div>
        </div>

<?php
//process login form if submitted
if(isset($_POST['submit'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if($user->login($username,$password)){

        //logged in return to index page
        header('Location: index.php');
        exit;

    } else {
        $message = '<div class="alert alert-danger text-center mt-3" role="alert">Mauvais identifiants ! :(</div>';
    }

}//end if submit

if(isset($message)){ echo $message; }
?>

</div>
</div>
</div>
</div>
</div>
</div>

<?php include_once 'footer.php'; ?>
